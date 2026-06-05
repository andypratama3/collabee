<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Services\Payment\XenditService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class XenditWebhookController extends Controller
{
    public function handle(Request $request, XenditService $xenditService): \Illuminate\Http\JsonResponse
    {
        $payloadBody = $request->getContent();
        $signature = $request->header('x-callback-token', '');

        if (!$xenditService->isValidWebhook($payloadBody, $signature)) {
            Log::warning('Invalid Xendit webhook signature');
            return response()->json(['error' => 'Invalid signature'], 401);
        }

        try {
            $xenditService->handleWebhook($request->all());
            return response()->json(['status' => 'ok']);
        } catch (\Exception $e) {
            Log::error('Xendit webhook processing failed', [
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString(),
            ]);
            return response()->json(['status' => 'error', 'message' => $e->getMessage()], 500);
        }
    }
}
