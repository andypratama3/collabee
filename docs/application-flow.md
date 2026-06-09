# Collabee - Application Flow Documentation

**Platform:** Brand & KOL Collaboration Marketplace
**Tech Stack:** Laravel 12, Livewire 3, Blade, Tailwind CSS, SQLite, Xendit (Payment Gateway)

---

## Table of Contents

1. [System Architecture](#1-system-architecture)
2. [Authentication & Authorization](#2-authentication--authorization)
3. [Role-Based Flows](#3-role-based-flows)
   - [Guest / Public Flow](#31-guest--public-flow)
   - [Brand Flow](#32-brand-flow)
   - [KOL Flow](#33-kol-flow)
   - [Admin Flow](#34-admin-flow)
4. [Campaign Lifecycle](#4-campaign-lifecycle)
5. [Hiring & Agreement Flow](#5-hiring--agreement-flow)
6. [Payment & Escrow Flow](#6-payment--escrow-flow)
7. [Content Workflow](#7-content-workflow)
8. [Withdrawal Flow](#8-withdrawal-flow)
9. [Chat & Notification System](#9-chat--notification-system)
10. [Dispute Resolution](#10-dispute-resolution)
11. [API Endpoints](#11-api-endpoints)
12. [Database Schema Overview](#12-database-schema-overview)

---

## 1. System Architecture

### Tech Stack

| Layer | Technology |
|-------|-----------|
| Backend | Laravel 12.61.1 (PHP 8.x) |
| Frontend | Livewire 3 + Blade + Tailwind CSS |
| Database | SQLite (development) / MySQL (production) |
| Authentication | Laravel Sanctum (API) + Session-based (Web) |
| Payments | Xendit (Invoice, Disbursement, Webhook) |
| Search | Laravel Scout (Meilisearch) |
| File Storage | Laravel Media Library / Public Disk |
| Real-time | Laravel Broadcasting + Reverb |
| Queue | Laravel Queue (Database) |
| Schedule | Laravel Cron (daily content deadline checks) |
| SEO | Spatie Laravel Sluggable |
| Roles | Spatie Laravel Permission |

### Key Models & Relationships

```
User (1) ── (1) BrandProfile ── (n) Campaign
User (1) ── (1) KolProfile ── (n) KolSocialAccount
                              ── (1) KolBankAccount
                              ── (n) KolWithdrawal

Campaign (1) ── (n) Hiring ── (1) Agreement ── (1) Payment ── (1) EscrowTransaction
Campaign (1) ── (n) HiringApplication

Hiring (1) ── (n) Content
            ── (1) ChatRoom ── (n) ChatMessage
            ── (1) Dispute
            ── (n) Rating
```

---

## 2. Authentication & Authorization

### Registration Flow

```
Public User
    ├── Register as Brand ──→ POST /register/brand
    │                           → User (user_type: 'brand')
    │                           → Redirect to /brand/profile/create
    │                           → Must complete brand profile
    │
    └── Register as KOL ───→ POST /register/kol
                              → User (user_type: 'kol')
                              → Redirect to /kol/profile/create
                              → Must complete KOL profile (social accounts, bank account)
```

### Login Flow

```
POST /login
    → Validate email + password
    → Auth::attempt()
    → Update last_login_at + last_login_ip
    → Redirect based on role:
        - Brand → /brand/dashboard
        - KOL   → /kol/dashboard
        - Admin → /admin/dashboard
    → Fail → back with error
```

### Role-Based Access Control

| Role | Middleware | Permissions |
|------|-----------|-------------|
| `super_admin` | `role:super_admin` | Full access: view/create/edit/delete/feature/suspend campaigns |
| `admin` | `role:admin` | View, feature, suspend campaigns; manage users, payments, withdrawals |
| `brand` | `brand` + `profile.complete` | Create/edit/delete own campaigns; hire KOLs; manage payments |
| `kol` | `kol` + `profile.complete` | View campaigns; apply; manage content; withdrawal |

### Impersonation (Admin)

```
POST /admin/users/{user}/impersonate
    → Stores original_admin_id in session
    → Logs in as target user
    → "Anda sekarang login sebagai {user}"
    → POST /admin/users/stop-impersonate to return
```

---

## 3. Role-Based Flows

### 3.1 Guest / Public Flow

```
Landing Page (/)
    ├── Stats (brands, KOLs, campaigns, total transactions)
    ├── Featured Open Campaigns (max 6)
    ├── Top-Rated KOLs (max 8)
    └── Random Brands (max 6)

Explore Campaigns (/campaigns)
    ├── Filters: platform, KOL category, budget range, search
    ├── Paginated list of OPEN campaigns
    └── Click → Campaign Detail

Campaign Detail (/campaigns/{campaign})
    ├── Brand info + campaign brief
    ├── Requirements (followers, engagement, location)
    ├── Budget + timeline
    └── CTA: "Apply Now" (redirects to login if not authenticated)
```

### 3.2 Brand Flow

#### Dashboard (/brand/dashboard)
```
Overview Cards:
    ├── Total Campaigns
    ├── Active Hirings
    ├── Total Spent
    └── Pending Reviews

Charts:
    ├── Campaign Performance (line chart)
    └── Recent Activity
```

#### Campaign Management

```
Campaign List (/brand/campaigns)
    ├── Filter by status (all/draft/open/in_progress/completed/cancelled/paused)
    ├── Actions: Edit, Publish, Pause, Cancel, Delete
    └── Stats: applications count, hirings count

Create Campaign (/brand/campaign/create)
    ├── Title, Description, Brief
    ├── Platforms (Instagram, TikTok, YouTube, Twitter, Podcast, Blog)
    ├── Content Types (Photo, Video, Story, Reels)
    ├── KOL Requirements (category, followers, engagement, gender, location)
    ├── Budget (total + per KOL) + KOL Slots
    └── Timeline (start date, end date, deadline apply)
    → Creates campaign with status DRAFT
    → Can publish later from campaign list

Edit Campaign (/brand/campaign/{campaign}/edit)
    └── Same fields as create, pre-populated
```

#### Browse & Hire KOLs

```
Browse KOLs (/brand/browse-kol)
    ├── Filters: category, location, followers range, engagement, budget
    ├── Search by name/bio
    ├── Sort by followers, engagement, rating, campaigns done
    └── Each KOL card: profile, stats, "Hire" button

Hire KOL
    → Opens hire modal/flow
    → Select campaign
    → Set proposed budget + message
    → Creates Hiring record (status: pending)
    → Notification sent to KOL
```

#### Hiring Management

```
Hiring List (/brand/hirings)
    ├── Filter by status (pending/accepted/rejected/cancelled)
    ├── Each hiring shows: campaign, KOL, status, budget
    └── Actions depend on status:
        - Pending: Cancel
        - Accepted: View agreement, upload content request
```

#### Agreement Flow

```
Agreement List (/brand/agreements)
    ├── All agreements for brand's campaigns
    ├── Status: draft / signed
    └── Actions: View, Sign

Agreement Detail (/brand/agreements/{agreement})
    ├── Agreement number, total amount, platform fee %
    ├── Signature status (brand + KOL)
    ├── Terms & conditions
    ├── Sign button (if not yet signed by brand)
    └── After fully signed → redirect to payment
```

#### Payment Flow

```
Payment List (/brand/payments)
    ├── "Menunggu Pembayaran" section:
    │   └── Signed agreements without payment
    │       └── "Simulasikan Pembayaran" button (demo)
    │       └── "Bayar Sekarang" button (production → Xendit invoice)
    │
    ├── Payments table:
    │   ├── Invoice number, campaign, KOL, amount, status, date
    │   ├── Statuses: Pending → Paid → Held → Released → Refunded
    │   └── Filters by status
    │
    └── Payment Flow:
        1. Click "Bayar" → XenditService::createInvoice()
        2. Demo: Payment created → marked PAID → funds HELD in escrow
        3. Production: Redirected to Xendit invoice URL
        4. Xendit webhook → Payment marked PAID → funds HELD in escrow
        5. KOL notified: "Pembayaran diterima, dana diamankan di escrow"
```

#### Content Review

```
Content List (/brand/contents)
    ├── All content submitted by hired KOLs
    ├── Filter by status (pending/approved/rejected)
    └── Actions: View, Approve, Reject

Content Detail (/brand/contents/{content})
    ├── Media preview (image/video)
    ├── Caption + platform info
    ├── Approve → triggers escrow release ("content_approved")
    │   → KOL wallet credited
    │   → Notification sent
    └── Reject → KOL notified to revise
```

#### Chat

```
Chat List (/brand/chat)
    └── All active conversations with KOLs

Chat Room (/brand/chat/{chatRoom})
    └── Real-time messaging with hired KOLs
```

### 3.3 KOL Flow

#### Dashboard (/kol/dashboard)
```
Overview Cards:
    ├── Wallet Balance
    ├── Pending Balance
    ├── Total Earned
    └── Campaigns Done

Recent Activity:
    └── Hirings, content deadlines, payments
```

#### Explore & Apply Campaigns

```
Explore Campaigns (/campaigns) [Public]
    ├── Browse open campaigns with filters
    ├── Click → Campaign Detail
    └── Apply → POST application with proposed budget + message

Campaign Detail (/campaigns/{campaign})
    ├── Full campaign brief
    ├── Brand profile
    ├── Requirements + timeline
    └── "Apply Now" button → application form
```

#### Hiring Management

```
Hiring List (/kol/hirings)
    ├── Incoming hire requests from brands
    ├── Statuses: Pending / Negotiating / Accepted / Rejected / Cancelled
    └── Actions:
        - Pending: Accept / Reject (with reason)
        - Negotiating: Counter-offer / Accept / Reject
        - Accepted: View agreement
```

#### Agreement Flow

```
Agreement List (/kol/agreements)
Agreement Detail (/kol/agreements/{agreement})
    ├── Same as brand view
    └── Sign button (if not yet signed by KOL)
    → After both parties sign → agreement status becomes "signed"
    → Brand proceeds to payment
```

#### Content Submission

```
Content List (/kol/contents)
    ├── All content for accepted hirings
    └── Actions: Upload, Edit, View

Create Content (/kol/contents/create/{agreement?})
    ├── Upload media (image/video)
    ├── Enter caption
    ├── Select platform
    └── Submit → status: "pending_review"

Edit Content (/kol/contents/{content}/edit)
    └── Revise if rejected by brand
```

#### Withdrawal Flow

```
Withdrawal Page (/kol/withdrawals)
    ├── Stats Cards:
    │   ├── Wallet Balance (available for withdrawal)
    │   ├── Pending Balance (in-progress withdrawals)
    │   └── Minimum Withdrawal (Rp 100.000)
    │
    ├── Withdrawal Form:
    │   ├── Amount (min Rp 100.000)
    │   ├── Bank Account (from saved bank accounts)
    │   └── Notes (optional)
    │   → Validates balance + min amount
    │   → Decrements wallet_balance
    │   → Increments pending_balance
    │   → Creates KolWithdrawal (status: pending)
    │   → Admin reviews and processes
    │
    └── Withdrawal History Table:
        ├── Amount, Bank, Status, Date
        └── Statuses: Pending → Approved → Completed / Rejected
```

#### Chat

```
Chat List (/kol/chat)
Chat Room (/kol/chat/{chatRoom})
    └── Same as brand chat, but from KOL perspective
```

### 3.4 Admin Flow

#### Dashboard (/admin/dashboard)
```
Stats:
    ├── Total Users, Total Brands, Total KOLs
    ├── Total Campaigns, Active Campaigns
    ├── Total Payments Volume
    └── Pending Withdrawals

Charts:
    ├── Users Growth
    ├── Campaigns Overview
    └── Revenue Overview
```

#### User Management (/admin/users)
```
    ├── All users with roles
    ├── Search, filter by role/status
    ├── Actions: Edit, Impersonate, Activate/Deactivate
    └── Impersonate → login as user for support
```

#### Campaign Management (/admin/campaigns)
```
    ├── All campaigns across all brands
    ├── Filter by status, search by title
    ├── Actions: Feature, Unfeature, Suspend, Activate
    └── View campaign details
```

#### Payment Management (/admin/payments)
```
    ├── All payments across platform
    ├── Filter by status
    ├── Export to Excel
    └── View invoice, brand, campaign, amount, fee, total
```

#### Withdrawal Management (/admin/withdrawals)
```
    ├── All KOL withdrawal requests
    ├── Filter by status
    ├── Actions per status:
    │   Pending → Approve / Reject (with reason)
    │   Approved → Kirim via Xendit / Upload Manual
    │   Completed → View proof
    └── Xendit Disbursement flow:
        1. Click "Kirim via Xendit"
        2. DisbursementService::createDisbursement()
        3. Demo: status langsung "completed", pending_balance deducted
        4. Production: status "processing", webhook confirms completion
```

#### Dispute Management (/admin/disputes)
```
    ├── All disputes raised by brand/KOL
    ├── Status: Open / Resolved
    ├── Actions: Add admin notes, Resolve with resolution
    └── Severity: Low / Medium / High
```

#### Settings (/admin/settings)
```
    ├── Platform Fee Percentage
    ├── Min/Max Withdrawal Amount
    └── Other platform-wide settings
```

#### Activity Log (/admin/activity-log)
```
    └── All platform activities with timestamps
```

---

## 4. Campaign Lifecycle

```
  DRAFT
   │
   │ (Brand publishes)
   ▼
  OPEN ──────────────────────────────────┐
   │                                      │
   │ (KOLs apply / Brand hires)           │
   ▼                                      │
  IN_PROGRESS                             │
   │                                      │
   │ (Hirings accepted, content created)  │
   ▼                                      │
  COMPLETED ←─────────────────────────────┘
   │
   │ (All hirings completed / cancelled)
   ▼
  [Archived]

  Other states:
  PAUSED    → Brand temporarily stops campaign
  CANCELLED → Brand cancels campaign entirely
```

### State Transitions

| From | To | Trigger |
|------|----|---------|
| DRAFT | OPEN | Brand clicks "Publish" |
| OPEN | IN_PROGRESS | First hiring accepted |
| OPEN | PAUSED | Brand pauses |
| OPEN | CANCELLED | Brand cancels (no hirings yet) |
| PAUSED | OPEN | Brand resumes |
| IN_PROGRESS | COMPLETED | All hirings completed |
| IN_PROGRESS | CANCELLED | Brand cancels (with active hirings) |

---

## 5. Hiring & Agreement Flow

```
Brand browses KOL → Clicks "Hire"
    │
    ├──→ Hiring created (status: PENDING)
    │     ├── campaign_id, brand_profile_id, kol_profile_id
    │     ├── proposed_budget, message
    │     └── expires_at (7 days)
    │
    ▼
KOL receives notification
    │
    ├──→ Accept → Hiring status: ACCEPTED
    │     ├── agreed_budget set
    │     ├── accepted_at timestamp
    │     ├── Campaign kol_filled incremented
    │     ├── ChatRoom created (brand + KOL)
    │     └── Agreement auto-generated via AgreementService
    │
    ├──→ Reject → Hiring status: REJECTED
    │     └── rejected_reason stored
    │
    └──→ Ignore → Expires after 7 days
    │
    ▼
Agreement (status: DRAFT)
    ├── agreement_number (AGR-SPK-YYYY-XXXXX)
    ├── total_amount, platform_fee_percent
    ├── terms (SOW from campaign brief)
    │
    ├──→ Brand signs → brand_signed_at + brand_signed_ip
    ├──→ KOL signs → kol_signed_at + kol_signed_ip
    │
    └──→ Both signed → Agreement status: SIGNED
          → Payment flow begins
```

### Agreement Terms (SOW Examples)

**Teras Dimsum Mentai:**
1. 1x Instagram Reels / TikTok Video
2. 1x Instagram Story
3. Menampilkan menu yang dicoba
4. Menandai akun media sosial Teras Dimsum Mentai
5. Menyebutkan nama brand dan lokasi outlet

**Soto Mie Bogor:**
1. 1x Instagram Reels / TikTok Video
2. 1x Instagram Story
3. Menandai akun brand @sotomiebogor
4. Menyebutkan nama dan lokasi Soto Mie Bogor
5. Menyebutkan cita rasa khas, porsi mengenyangkan, dan harga terjangkau

---

## 6. Payment & Escrow Flow

```
Agreement SIGNED by both parties
    │
    ▼
Brand visits Payment Page (/brand/payments)
    │
    ├── "Menunggu Pembayaran" section
    │   └── Signed agreements without payment
    │
    ├──→ "Simulasikan Pembayaran" (Demo Mode)
    │     ├── InvoiceService::createPayment()
    │     │   ├── Generates invoice number (INV-2026-00001)
    │     │   ├── Calculates: amount, platform_fee, total_amount
    │     │   └── Creates Payment (status: PENDING, gateway: xendit)
    │     │
    │     ├── InvoiceService::markAsPaid()
    │     │   ├── Status → PAID
    │     │   ├── paid_at → now()
    │     │   └── gateway_payment_id → XENDIT-SIM-XXXX
    │     │
    │     └── EscrowService::holdFunds()
    │         ├── Creates EscrowTransaction
    │         │   ├── amount_held = total_amount
    │         │   ├── platform_fee = total_amount * (fee_percent / 100)
    │         │   ├── kol_amount = amount_held - platform_fee
    │         │   └── status → HELD, held_at → now()
    │         │
    │         ├── Payment status → HELD
    │         └── Notification → KOL: "Pembayaran diterima, dana diamankan di escrow"
    │
    └──→ "Bayar Sekarang" (Production Mode)
          ├── XenditService::createInvoice()
          ├── Redirect to Xendit invoice URL
          ├── KOL pays via Xendit
          ├── Xendit sends webhook → POST /api/v1/webhooks/xendit
          │   ├── Validates x-callback-token
          │   ├── markAsPaid() + holdFunds()
          │   └── Returns 200 OK
          └── Same escrow flow as demo

    ESCROW STATE: PENDING ──→ PAID ──→ HELD
```

### Escrow Release Triggers

| Trigger | Source | Description |
|---------|--------|-------------|
| `content_approved` | Brand approves content | Brand reviews and approves KOL's content |
| `auto_release` | Cron job (7 days) | Auto-release if content approved and held > 7 days |

```
ESCROW STATE: HELD
    │
    ├──→ Brand approves content
    │     └── ContentService::approve()
    │           └── EscrowService::releaseEscrow(trigger: 'content_approved')
    │                 ├── Escrow status → RELEASED
    │                 ├── released_at → now()
    │                 ├── KOL wallet_balance += kol_amount
    │                 ├── KOL total_earned += kol_amount
    │                 ├── KOL total_campaigns_done++
    │                 └── Payment status → RELEASED
    │
    ├──→ Auto-release after 7 days (with approved content)
    │     └── Same as above, trigger: 'auto_release'
    │
    └──→ Refund (dispute resolution)
          └── EscrowService::refundEscrow()
                ├── Escrow status → REFUNDED
                └── Payment status → REFUNDED

    ESCROW STATE: HELD ──→ RELEASED
                         └──→ REFUNDED
```

---

## 7. Content Workflow

```
KOL submits content (/kol/contents/create)
    ├── Upload media (image/video)
    ├── Caption
    ├── Platform selection
    ├── Agreement reference
    └── Status: pending_review

Brand reviews (/brand/contents/{content})
    ├── View media + caption
    │
    ├──→ Approve
    │     ├── Content status → approved
    │     ├── EscrowService::releaseEscrow('content_approved')
    │     └── KOL notified
    │
    └──→ Reject
          ├── Content status → rejected
          └── KOL notified to revise

KOL revises → re-submits → brand re-reviews
```

---

## 8. Withdrawal Flow

```
KOL requests withdrawal (/kol/withdrawals)
    ├── Amount (min Rp 100.000)
    ├── Bank account selection
    ├── Notes (optional)
    │
    ├── Validates: amount >= 100000
    ├── Validates: wallet_balance >= amount
    ├── Validates: bank account belongs to KOL
    │
    ├── wallet_balance -= amount
    ├── pending_balance += amount
    └── KolWithdrawal created (status: pending)

Admin reviews (/admin/withdrawals)
    │
    ├──→ Approve
    │     └── Status → approved
    │
    ├──→ Reject (with reason)
    │     ├── Status → rejected
    │     ├── wallet_balance += amount (refund)
    │     └── pending_balance -= amount
    │
    └──→ Disburse
          │
          ├──→ Kirim via Xendit (Demo Mode)
          │     ├── DisbursementService::simulateDisbursement()
          │     ├── Status → completed
          │     ├── pending_balance -= amount
          │     └── Notification to KOL
          │
          ├──→ Kirim via Xendit (Production Mode)
          │     ├── POST /disbursements to Xendit API
          │     ├── Status → processing
          │     ├── Xendit webhook confirms:
          │     │   ├── Completed → pending_balance -= amount
          │     │   └── Failed → wallet refunded, pending_balance -= amount
          │     └── Idempotency key prevents duplicate payouts
          │
          └──→ Upload Manual Proof
                ├── Upload file (JPG, PNG, PDF, max 2MB)
                ├── Status → completed
                └── proof_path stored
```

---

## 9. Chat & Notification System

### Chat

```
Chat Room created when:
    ├── Brand hires KOL → Hiring ACCEPTED
    └── Auto-generated via firstOrCreate

Features:
    ├── Real-time messaging via Laravel Reverb
    ├── Brand ↔ KOL direct communication
    ├── Message history
    └── Notification on new messages
```

### Notifications

```
NotificationService::send(
    user: User,           // recipient
    type: string,         // hiring | payment | content | system
    title: string,        // short title
    message: string,      // notification body
    data: array,          // related model data
    actionUrl: string,    // deep link URL
)

Triggered by:
    ├── New hiring offer (brand → KOL)
    ├── Hiring accepted (KOL → brand notification)
    ├── Hiring rejected (KOL → brand notification)
    ├── New application (KOL → brand notification)
    ├── Payment received (system → KOL)
    ├── Escrow released (system → KOL)
    ├── New content submitted (KOL → brand)
    ├── Content approved (brand → KOL)
    └── Content rejected (brand → KOL)

Types:
    ├── In-app notification (database)
    ├── Broadcast event (Reverb)
    └── Email (queued via NotificationService)
```

---

## 10. Dispute Resolution

```
User raises dispute (linked to Hiring)
    ├── Subject + Description
    ├── Attachments (optional)
    ├── Severity: Low / Medium / High
    └── Status: Open

Admin manages (/admin/disputes)
    ├── View all open/resolved disputes
    ├── Add admin notes (appended to JSON array)
    ├── Resolve with resolution notes
    └── Status: Resolved
```

---

## 11. API Endpoints

All API endpoints are prefixed with `/api/v1`.

### Public Endpoints

| Method | Endpoint | Description |
|--------|----------|-------------|
| POST | `/auth/register` | Register new user |
| POST | `/auth/login` | Login |
| POST | `/auth/forgot-password` | Request password reset |
| POST | `/auth/reset-password` | Reset password |
| GET | `/kols` | List KOLs (with filters) |
| GET | `/kols/{id}` | KOL detail |
| GET | `/kols/{id}/portfolio` | KOL portfolio |
| GET | `/campaigns` | List open campaigns |
| GET | `/campaigns/{id}` | Campaign detail |
| POST | `/webhooks/xendit` | Xendit payment webhook |

### Authenticated Endpoints (Sanctum)

| Method | Endpoint | Description |
|--------|----------|-------------|
| POST | `/auth/logout` | Logout |
| GET | `/auth/me` | Current user info |
| POST | `/campaigns` | Create campaign (brand only) |
| PUT | `/campaigns/{id}` | Update campaign (brand only) |
| POST | `/campaigns/{id}/apply` | Apply to campaign (KOL only) |
| GET | `/hirings` | List hirings |
| POST | `/hirings` | Create hiring (brand only) |
| POST | `/hirings/{id}/accept` | Accept hiring (KOL only) |
| POST | `/hirings/{id}/reject` | Reject hiring (KOL only) |
| GET | `/chat/rooms` | List chat rooms |
| GET | `/chat/rooms/{id}` | Chat messages |
| POST | `/chat/rooms/{id}/messages` | Send message |
| GET | `/notifications` | List notifications |
| POST | `/notifications/{id}/read` | Mark as read |
| POST | `/notifications/read-all` | Mark all as read |

---

## 12. Database Schema Overview

### Core Tables

| Table | Key Fields |
|-------|-----------|
| `users` | id, name, email, password, user_type (brand/kol/admin/super_admin), is_verified, is_active, last_login_at, last_login_ip |
| `brand_profiles` | id, user_id, brand_name, slug, description, industry, location, total_campaigns, total_spent, rating_avg, rating_count |
| `kol_profiles` | id, user_id, display_name, bio, category, location, gender, total_followers, avg_engagement_rate, total_campaigns_done, total_earned, wallet_balance, pending_balance, is_open_for_work, min_budget |
| `kol_social_accounts` | id, kol_profile_id, platform, username, profile_url, followers_count, engagement_rate |
| `kol_bank_accounts` | id, kol_profile_id, bank_name, account_name, account_number, bank_code, is_verified |
| `campaigns` | id, brand_profile_id, slug, title, description, brief, objectives (JSON), platforms (JSON), content_types (JSON), kol_category, min/max_followers, min_engagement, target_gender, location, budget_total, budget_per_kol, kol_slots, kol_filled, start/end_date, deadline_apply, status, is_featured, views_count, applications_count |
| `hirings` | id, campaign_id, brand_profile_id, kol_profile_id, initiated_by, status, message, proposed_budget, agreed_budget, note, rejected_reason, accepted_at, expires_at |
| `hiring_applications` | id, campaign_id, kol_profile_id, proposed_budget, message, status |
| `agreements` | id, hiring_id, agreement_number, total_amount, platform_fee_percent, status, terms, pdf_path, brand_signed_at, brand_signed_ip, kol_signed_at, kol_signed_ip, signed_at, expires_at |
| `payments` | id, agreement_id, invoice_number (unique), amount, platform_fee, total_amount, gateway, gateway_payment_id, gateway_invoice_url, status, paid_at |
| `escrow_transactions` | id, payment_id (unique), amount_held, platform_fee, kol_amount, status, release_trigger, held_at, released_at |
| `kol_withdrawals` | id, kol_profile_id, amount, admin_fee, net_amount, bank_name, bank_account_number, bank_account_name, notes, status, admin_note, proof_path, processed_at |
| `contents` | id, agreement_id, kol_profile_id, brand_profile_id, type, media_path, caption, platform, status, published_at |
| `chat_rooms` | id, hiring_id (unique), brand_user_id, kol_user_id, last_message_at |
| `chat_messages` | id, chat_room_id, user_id, message, read_at |
| `disputes` | id, hiring_id, raised_by, against_id, subject, description, attachments (JSON), status, severity, admin_notes (JSON), resolved_at |
| `ratings` | id, hiring_id, rater_id, ratee_id, rating, review |
| `notifications` | id, user_id, type, title, message, data (JSON), action_url, read_at |
| `app_settings` | id, key (unique), value |

### Important Constraints

- `hirings`: Unique constraint on `(campaign_id, kol_profile_id)` (a KOL can't be hired twice for same campaign)
- `payments`: Unique `agreement_id` (one payment per agreement)
- `payments`: Unique `invoice_number`
- `escrow_transactions`: Unique `payment_id` (one escrow per payment)
- `chat_rooms`: Unique `hiring_id` (one chat room per hiring)

---

## End-to-End Flow Summary

```
1. Brand registers → completes profile → creates campaign (DRAFT → OPEN)
2. KOL browses campaigns → applies (or brand hires KOL directly)
3. Brand reviews applications → accepts → Hiring ACCEPTED
4. Agreement auto-generated → both parties sign → SIGNED
5. Brand pays → Payment → Escrow HELD
6. KOL creates content → submits for review
7. Brand reviews → approves → Escrow RELEASED → KOL wallet credited
8. KOL requests withdrawal → Admin processes → funds disbursed
9. Both parties rate each other → Campaign COMPLETED
```
