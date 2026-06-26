<?php

use App\Enums\HiringStatus;
use App\Events\MessageSent;
use App\Models\BrandProfile;
use App\Models\Campaign;
use App\Models\ChatMessage;
use App\Models\ChatRoom;
use App\Models\Hiring;
use App\Models\KolProfile;
use App\Models\User;
use App\Services\Campaign\HiringService;
use App\Services\Chat\ChatService;
use Illuminate\Support\Facades\Event;
use Illuminate\Support\Facades\Gate;

beforeEach(function () {
    $this->brandUser = User::factory()->create(['user_type' => 'brand']);
    $this->kolUser = User::factory()->create(['user_type' => 'kol']);
    $this->brandProfile = BrandProfile::factory()->create(['user_id' => $this->brandUser->id]);
    $this->kolProfile = KolProfile::factory()->create(['user_id' => $this->kolUser->id]);
    $this->campaign = Campaign::factory()->create([
        'brand_profile_id' => $this->brandProfile->id,
        'status' => 'open',
    ]);
    $this->hiring = Hiring::factory()->create([
        'campaign_id' => $this->campaign->id,
        'brand_profile_id' => $this->brandProfile->id,
        'kol_profile_id' => $this->kolProfile->id,
        'status' => HiringStatus::PENDING,
    ]);
    $this->chatService = app(ChatService::class);
});

test('chat room can be created for a hiring', function () {
    $room = $this->chatService->createRoom($this->hiring);

    expect($room)->toBeInstanceOf(ChatRoom::class)
        ->and($room->hiring_id)->toBe($this->hiring->id)
        ->and($room->brand_user_id)->toBe($this->brandUser->id)
        ->and($room->kol_user_id)->toBe($this->kolUser->id);
});

test('chat room creation is idempotent', function () {
    $room1 = $this->chatService->createRoom($this->hiring);
    $room2 = $this->chatService->createRoom($this->hiring);

    expect($room1->id)->toBe($room2->id);
});

test('message can be sent in a chat room', function () {
    $room = $this->chatService->createRoom($this->hiring);

    $message = $this->chatService->sendMessage($room, $this->brandUser, [
        'body' => 'Hello, interested in collaborating!',
        'type' => 'text',
    ]);

    expect($message)->toBeInstanceOf(ChatMessage::class)
        ->and($message->chat_room_id)->toBe($room->id)
        ->and($message->sender_id)->toBe($this->brandUser->id)
        ->and($message->body)->toBe('Hello, interested in collaborating!')
        ->and($message->type)->toBe('text');

    $this->assertDatabaseHas('chat_messages', [
        'chat_room_id' => $room->id,
        'body' => 'Hello, interested in collaborating!',
    ]);
});

test('sending message updates last_message_at and unread counter', function () {
    $room = $this->chatService->createRoom($this->hiring);

    $this->chatService->sendMessage($room, $this->brandUser, [
        'body' => 'Hello!',
        'type' => 'text',
    ]);

    $room->refresh();
    expect($room->last_message_at)->not->toBeNull()
        ->and($room->kol_unread)->toBe(1)
        ->and($room->brand_unread)->toBe(0);
});

test('message sent event is dispatched', function () {
    Event::fake([MessageSent::class]);

    $room = $this->chatService->createRoom($this->hiring);
    $this->chatService->sendMessage($room, $this->brandUser, [
        'body' => 'Test message',
        'type' => 'text',
    ]);

    Event::assertDispatched(MessageSent::class);
});

test('mark as read resets unread counters', function () {
    $room = $this->chatService->createRoom($this->hiring);

    $this->chatService->sendMessage($room, $this->brandUser, ['body' => 'Hello', 'type' => 'text']);
    $this->chatService->sendMessage($room, $this->kolUser, ['body' => 'Hi', 'type' => 'text']);

    $this->chatService->markAsRead($room, $this->brandUser);
    $room->refresh();
    expect($room->brand_unread)->toBe(0);

    $this->chatService->markAsRead($room, $this->kolUser);
    $room->refresh();
    expect($room->kol_unread)->toBe(0);
});

test('offer message can be sent', function () {
    $room = $this->chatService->createRoom($this->hiring);

    $message = $this->chatService->sendMessage($room, $this->brandUser, [
        'type' => 'offer',
        'body' => 'Budget offer: Rp 500,000',
        'offer_data' => ['budget' => 500000],
    ]);

    expect($message->type)->toBe('offer')
        ->and($message->offer_status)->toBe('pending')
        ->and($message->offer_data)->toBe(['budget' => 500000]);
});

test('offer can be accepted', function () {
    $room = $this->chatService->createRoom($this->hiring);
    $message = $this->chatService->sendMessage($room, $this->brandUser, [
        'type' => 'offer',
        'body' => 'Budget offer: Rp 500,000',
        'offer_data' => ['budget' => 500000],
    ]);

    $this->chatService->handleOfferAccept($message);
    $message->refresh();

    expect($message->offer_status)->toBe('accepted');
    $this->hiring->refresh();
    expect($this->hiring->status)->toBe(HiringStatus::ACCEPTED);
});

test('offer can be rejected', function () {
    $room = $this->chatService->createRoom($this->hiring);
    $message = $this->chatService->sendMessage($room, $this->brandUser, [
        'type' => 'offer',
        'body' => 'Budget offer: Rp 500,000',
        'offer_data' => ['budget' => 500000],
    ]);

    $this->chatService->handleOfferReject($message);
    $message->refresh();

    expect($message->offer_status)->toBe('rejected');
});

test('get chat rooms returns user rooms with latest message', function () {
    $room = $this->chatService->createRoom($this->hiring);
    $this->chatService->sendMessage($room, $this->brandUser, [
        'body' => 'Hello!',
        'type' => 'text',
    ]);

    $brandRooms = $this->chatService->getChatRooms($this->brandUser);
    $kolRooms = $this->chatService->getChatRooms($this->kolUser);

    expect($brandRooms)->toHaveCount(1);
    expect($kolRooms)->toHaveCount(1);
});

test('unread count returns correct value', function () {
    $room = $this->chatService->createRoom($this->hiring);
    $this->chatService->sendMessage($room, $this->brandUser, ['body' => 'Hello', 'type' => 'text']);

    expect($this->chatService->getUnreadCount($this->kolUser))->toBe(1);
    expect($this->chatService->getUnreadCount($this->brandUser))->toBe(0);
});

test('chat room auto-created when hiring is accepted', function () {
    $this->hiring->update(['status' => HiringStatus::PENDING]);

    $hiringService = app(HiringService::class);
    $hiringService->accept($this->hiring);

    $this->assertDatabaseHas('chat_rooms', [
        'hiring_id' => $this->hiring->id,
        'brand_user_id' => $this->brandUser->id,
        'kol_user_id' => $this->kolUser->id,
    ]);
});

test('chat policy allows room participants', function () {
    $room = $this->chatService->createRoom($this->hiring);

    expect(auth()->login($this->brandUser))
        ->and(Gate::allows('view', $room))->toBeTrue()
        ->and(Gate::allows('send', $room))->toBeTrue();

    expect(auth()->login($this->kolUser))
        ->and(Gate::allows('view', $room))->toBeTrue()
        ->and(Gate::allows('send', $room))->toBeTrue();
});

test('chat policy denies non-participants', function () {
    $room = $this->chatService->createRoom($this->hiring);
    $otherUser = User::factory()->create(['user_type' => 'brand']);

    auth()->login($otherUser);
    expect(Gate::allows('view', $room))->toBeFalse()
        ->and(Gate::allows('send', $room))->toBeFalse();
});
