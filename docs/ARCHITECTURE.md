# 🏗️ COLLABEE — Architecture Documentation

> **Platform Marketplace Brand & KOL — Laravel 12**
> Versi: 1.0.0 | Last Updated: Juni 2026

---

## 1. SYSTEM ARCHITECTURE

```
┌──────────────────────────────────────────────────────────────────┐
│                        CLIENT LAYER                              │
│                                                                  │
│  ┌──────────────────┐  ┌──────────────────┐  ┌───────────────┐  │
│  │  Browser (Web)   │  │    Mobile App    │  │  PWA (Future) │  │
│  │  Tailwind +      │  │  (Future: Flutter │  │               │  │
│  │  Alpine +        │  │   / React Native)│  │               │  │
│  │  Livewire        │  │                  │  │               │  │
│  └────────┬─────────┘  └────────┬─────────┘  └───────┬───────┘  │
└───────────┼──────────────────────┼──────────────────────┼────────┘
            │                      │                      │
            │         HTTPS        │      HTTPS           │
            ▼                      ▼                      ▼
┌──────────────────────────────────────────────────────────────────┐
│                      APPLICATION LAYER                            │
│                                                                  │
│  ┌────────────────────────────────────────────────────────────┐  │
│  │                   Laravel 12 (MVC)                         │  │
│  │                                                             │  │
│  │  ┌─────────────┐  ┌──────────────┐  ┌───────────────────┐  │  │
│  │  │   Web Routes│  │   API Routes  │  │  Livewire Comp.   │  │  │
│  │  │  (Blade)   │  │  (Sanctum)    │  │  (Reactive UI)   │  │  │
│  │  └──────┬──────┘  └──────┬───────┘  └────────┬──────────┘  │  │
│  │         │                │                    │              │  │
│  │  ┌──────┴────────────────┴────────────────────┴──────────┐  │  │
│  │  │                 SERVICE LAYER                          │  │  │
│  │  │  ┌────────────┐ ┌──────────┐ ┌──────────────────┐    │  │  │
│  │  │  │ Auth/Reg   │ │ Campaign │ │ Payment/Escrow   │    │  │  │
│  │  │  │ Service    │ │ Service  │ │ Service          │    │  │  │
│  │  │  ├────────────┤ ├──────────┤ ├──────────────────┤    │  │  │
│  │  │  │ Chat       │ │ Content  │ │ Notification     │    │  │  │
│  │  │  │ Service    │ │ Service  │ │ Service          │    │  │  │
│  │  │  ├────────────┤ ├──────────┤ ├──────────────────┤    │  │  │
│  │  │  │ Rating     │ │ Escrow   │ │ Invoice/Contract │    │  │  │
│  │  │  │ Service    │ │ Service  │ │ PDF Service      │    │  │  │
│  │  │  └────────────┘ └──────────┘ └──────────────────┘    │  │  │
│  │  └──────────────────────────────────────────────────────┘  │  │
│  │                                                             │  │
│  │  ┌──────────────────────────────────────────────────────┐  │  │
│  │  │              EVENT / BROADCAST LAYER                  │  │  │
│  │  │  ┌──────────┐ ┌───────────┐ ┌──────────────────┐    │  │  │
│  │  │  │ Events   │ │ Listeners │ │ Broadcasting     │    │  │  │
│  │  │  │ (6)      │ │ (4+)      │ │ (Reverb/Pusher)  │    │  │  │
│  │  │  └──────────┘ └───────────┘ └──────────────────┘    │  │  │
│  │  └──────────────────────────────────────────────────────┘  │  │
│  │                                                             │  │
│  │  ┌──────────────────────────────────────────────────────┐  │  │
│  │  │                 MIDDLEWARE LAYER                      │  │  │
│  │  │  CheckUserIsActive │ CheckProfileComplete             │  │  │
│  │  │  EnsureBrand │ EnsureKol │ LogUserActivity            │  │  │
│  │  │  Throttle │ VerifiedEmail │ ForceJson (API)          │  │  │
│  │  └──────────────────────────────────────────────────────┘  │  │
│  └────────────────────────────────────────────────────────────┘  │
└────────────────────────────┬─────────────────────────────────────┘
                             │
┌────────────────────────────▼─────────────────────────────────────┐
│                        DATA LAYER                                 │
│                                                                   │
│  ┌────────────────────┐  ┌────────────────┐  ┌───────────────┐   │
│  │   MySQL 8.0        │  │    Redis 7.x    │  │  Storage      │   │
│  │   - Primary DB     │  │   - Cache       │  │  - Local/S3   │   │
│  │   - All entities   │  │   - Queue       │  │  - Media      │   │
│  │   - Transactions   │  │   - Session     │  │  - Contracts  │   │
│  │                    │  │   - Rate Limit  │  │  - Invoices   │   │
│  └────────────────────┘  └────────────────┘  └───────────────┘   │
└────────────────────────────┬─────────────────────────────────────┘
                             │
┌────────────────────────────▼─────────────────────────────────────┐
│                       WORKER LAYER                                │
│                                                                   │
│  ┌───────────────────────────────────────────────────────────┐   │
│  │              Laravel Horizon (Queue Workers)               │   │
│  │                                                           │   │
│  │  High Queue:       Default Queue:       Low Queue:       │   │
│  │  - SendWelcomeEm   - SendHiringNotif    - SendWeeklyRpt  │   │
│  │  - ProcessEscrow   - NotifyContentRev   - CleanExpired   │   │
│  │  - ReleaseEscrow   - GenInvoicePDF      - BackupDB       │   │
│  │                    - GenContractPDF                       │   │
│  │                    - SendCampaignRem                      │   │
│  │                                                           │   │
│  │  Email Queue:                                            │   │
│  │  - SendEmailNotification                                 │   │
│  └───────────────────────────────────────────────────────────┘   │
└──────────────────────────────────────────────────────────────────┘
```

---

## 2. APPLICATION FLOW — End-to-End

### 2.1 User Registration Flow

```
User → /register/brand or /register/kol
  → Validate input (BrandRegisterRequest / KolRegisterRequest)
  → Create User record
  → Assign role (Brand/KOL)
  → SendEmailVerification (Job)
  → Redirect to "verify email" page
  → User verifies email
  → Redirect to profile completion
  → Profile complete → Redirect to Dashboard
```

### 2.2 Campaign & Hiring Flow

```
Brand creates Campaign (POST /campaigns)
  → Validate (StoreCampaignRequest)
  → Save as draft or publish
  → If published: appears in KOL explore
  → KOL applies (POST /hirings)
  
KOL browse / Brand outbound Hire
  → Hiring record created (status: pending)
  → Notify counterparty (Event + Job)
  → Counterparty accepts/rejects
  → If accepted: Chat room auto-created
  → Negotiation via chat (offer messages)
  → Both agree → Auto-generate Agreement
```

### 2.3 Payment Flow

```
Agreement signed by both parties
  → Brand notified: "Pay now"
  → Brand clicks pay → Xendit invoice created (POST /invoices)
  → Brand redirected to Xendit payment page
  → Xendit webhook: "PAID" (POST /api/v1/webhooks/xendit)
  → Payment marked as paid
  → Escrow held (funds locked)
  → KOL notified: "Start working!"
  
KOL uploads content → Brand approves
  → Escrow released to KOL wallet
  → Rating prompt for both parties
  
If Brand does not review in 7 days:
  → Auto-release escrow (scheduler command)

KOL requests withdrawal:
  → Admin approves → Option A: Xendit Disbursement (POST /disbursements)
                   → Option B: Manual transfer + upload proof
  → KOL notified: "Dana dicairkan"
```

### 2.4 Real-time Events Flow

```
Client subscribes to private channels via Laravel Echo:
  - `user.{userId}` — Notifications
  - `hiring.{hiringId}` — Chat messages

Backend broadcasts events via Laravel Reverb:
  - NewMessageSent → updates chat UI
  - NewNotification → updates bell badge
  - UserTyping → shows typing indicator
  - ContentStatusChanged → updates status badge
```

---

## 3. DIRECTORY STRUCTURE

```
collabee/
│
├── app/
│   ├── Console/
│   │   ├── Commands/              # Artisan commands (8 files)
│   │   └── Kernel.php             # Schedule definition
│   │
│   ├── Enums/                     # PHP 8 enums (8 files)
│   │   ├── UserRole.php           # BRAND, KOL, ADMIN, SUPER_ADMIN
│   │   ├── CampaignStatus.php     # OPEN, IN_PROGRESS, COMPLETED, etc
│   │   ├── HiringStatus.php       # PENDING, ACCEPTED, REJECTED, etc
│   │   ├── ContentStatus.php      # DRAFT, SUBMITTED, APPROVED, etc
│   │   ├── PaymentStatus.php      # PENDING, PAID, HELD, RELEASED, etc
│   │   ├── EscrowStatus.php       # HELD, PARTIALLY_RELEASED, RELEASED
│   │   ├── SocialPlatform.php     # INSTAGRAM, TIKTOK, YOUTUBE, etc
│   │   └── KolCategory.php        # BEAUTY, FASHION, TECH, FOOD, etc
│   │
│   ├── Events/                    # 6 broadcast events
│   │   ├── NewMessageSent.php
│   │   ├── CampaignStatusChanged.php
│   │   ├── ContentUploaded.php
│   │   ├── PaymentReleased.php
│   │   ├── HiringAccepted.php
│   │   └── NewNotification.php
│   │
│   ├── Exceptions/                # Custom exceptions
│   │   ├── PaymentException.php
│   │   ├── EscrowException.php
│   │   └── InsufficientBalanceException.php
│   │
│   ├── Http/
│   │   ├── Controllers/
│   │   │   ├── Auth/              # 5 controllers
│   │   │   ├── Brand/             # 6 controllers
│   │   │   ├── Kol/               # 5 controllers
│   │   │   ├── Shared/            # 4 controllers
│   │   │   ├── Admin/             # 6 controllers
│   │   │   └── Api/V1/            # 3 controllers
│   │   │
│   │   ├── Middleware/             # 5 custom middleware
│   │   └── Requests/              # 10 form requests
│   │
│   ├── Jobs/                      # 8 queued jobs
│   ├── Listeners/                 # 4 event listeners
│   ├── Models/                    # 22 Eloquent models
│   ├── Observers/                 # 3 model observers
│   ├── Policies/                  # 5 authorization policies
│   ├── Providers/                 # Service providers
│   └── Services/                  # Business logic services
│       ├── Auth/                  # RegistrationService
│       ├── Campaign/              # CampaignService, HiringMatchService
│       ├── Chat/                  # ChatService
│       ├── Content/               # ContentService, ContentUploadService
│       ├── Notification/          # NotificationService
│       ├── Payment/               # EscrowService, XenditService, InvoiceService, DisbursementService
│       └── Rating/                # RatingService
│
├── config/                        # Laravel config files
├── database/
│   ├── migrations/               # 25+ migration files
│   └── seeders/                  # 4 seeder files
│
├── resources/
│   ├── views/
│   │   ├── layouts/              # app, guest, admin layouts
│   │   ├── auth/                 # Login, register pages
│   │   ├── brand/                # Brand dashboard, campaigns
│   │   ├── kol/                  # KOL dashboard, profile, content
│   │   ├── shared/               # Chat, agreements, ratings
│   │   ├── admin/                # Admin panel views
│   │   ├── components/           # Blade components
│   │   └── pdfs/                 # PDF templates
│   ├── js/                       # Alpine.js, Echo, plugins
│   └── css/                      # Tailwind imports
│
├── routes/
│   ├── web.php                   # Public & auth web routes
│   ├── api.php                   # REST API v1 routes
│   ├── brand.php                 # Brand-specific routes
│   ├── kol.php                   # KOL-specific routes
│   └── admin.php                 # Admin panel routes
│
├── docs/                         # Documentation
│   ├── PROGRESS.md               # Progress tracker
│   ├── ARCHITECTURE.md           # This file
│   ├── DATABASE.md               # Database schema
│   └── ROADMAP.md                # Development roadmap
│
└── tests/
    ├── Feature/                  # Feature tests
    └── Unit/                     # Unit tests
```

---

## 4. TECHNOLOGY STACK

### 4.1 Backend Stack

| Component | Technology | Version | Purpose |
|-----------|-----------|---------|---------|
| Runtime | PHP | ^8.3 | Server-side language |
| Framework | Laravel | ^12.x | Fullstack MVC framework |
| Database | MySQL / PostgreSQL | 8.0+ / 15+ | Primary data store |
| Cache/Queue | Redis | ^7.x | Cache, queue, sessions |
| Auth | Laravel Sanctum | ^4.x | API token auth |
| Roles/Permissions | Spatie Permission | ^8.x | RBAC management |
| Media | Spatie MediaLibrary | ^11.x | File uploads |
| Activity Log | Spatie ActivityLog | ^4.x | Audit trail |
| PDF | DomPDF | ^3.x | Contract/invoice PDF |
| Excel | Maatwebsite Excel | ^3.x | Admin report export |
| Search | Laravel Scout | ^11.x | Full-text search |
| Queue Dashboard | Laravel Horizon | ^5.x | Queue monitoring |
| Debug | Laravel Telescope | ^5.x | Dev debugging |
| WebSocket | Laravel Reverb | ^1.x | Real-time events |

### 4.2 Frontend Stack

| Component | Technology | Version | Purpose |
|-----------|-----------|---------|---------|
| CSS | Tailwind CSS | ^4.x | Utility-first CSS (v4 CSS-based config) |
| JS Framework | Alpine.js | ^3.x | Reactive UI |
| UI Components | Flowbite | ^4.x | Pre-built components |
| Charts | ApexCharts | ^5.x | Dashboard charts |
| Rich Text | TipTap | ^3.x | Brief editor |
| Calendar | Flatpickr | ^4.x | Date picker |
| Upload | Dropzone | ^6.x | File upload |
| Alerts | SweetAlert2 | ^11.x | Confirmations/toasts |
| WebSocket Client | Laravel Echo | ^2.x | Real-time client |
| Asset Bundler | Vite | ^7.x | Build tool |

### 4.3 Third-Party Services

| Service | Purpose | Environment |
|---------|---------|-------------|
| Xendit | Payment gateway (VA, EWallet, QRIS) | Sandbox → Production |
| AWS S3 | File storage (media, contracts, invoices) | Production |
| Mailtrap/Mailgun | Email delivery | Dev → Production |
| Pusher/Reverb | WebSocket fallback | Optional |

---

## 5. KEY DESIGN PATTERNS

### 5.1 Service Layer Pattern

All business logic is encapsulated in Service classes, not in Controllers or Models:

```
Controller → FormRequest (validation) → Service (business logic) → Model (DB)
                                                                    ↓
                                                              Events/Jobs
```

### 5.2 Repository Pattern for Complex Queries

```php
// Example: CampaignService handles search/filter logic
class CampaignService {
    public function search(array $filters): LengthAwarePaginator
    public function create(array $data): Campaign
    public function update(Campaign $campaign, array $data): Campaign
}
```

### 5.3 Observer Pattern for Side Effects

```php
// Example: ContentObserver triggers escrow release
class ContentObserver {
    public function updated(Content $content): void {
        if ($content->wasChanged('status') && $content->status === 'approved') {
            EscrowService::releaseEscrow($content->agreement->escrowTransaction);
        }
    }
}
```

### 5.4 Event-Driven Architecture

```
Action performed → Event dispatched → Listeners handle side effects
                                         → Jobs queued for async work
                                         → Broadcasting for real-time updates
```

### 5.5 Database Transaction for Financial Operations

```php
DB::transaction(function () use ($payment, $payload) {
    $payment->update(['status' => 'paid', 'paid_at' => now()]);
    EscrowService::holdFunds($payment);
    NotificationService::notifyKolPaymentReceived($payment);
});
```

---

## 6. SECURITY ARCHITECTURE

```
Request → Rate Limiting (throttle:5,1)
        → CSRF Protection
        → Session Auth / Sanctum Token
        → Middleware Chain
            → CheckUserIsActive
            → EnsureEmailVerified
            → CheckProfileComplete
            → EnsureBrand / EnsureKol
        → Policy Authorization
        → FormRequest Validation
        → Controller → Service
            ↓
        Response ← Audit Log ← Activity Log
```

### Security Measures:

1. **Authentication**: Rate limiting (5 attempts/minute), bcrypt (cost 12), email verification
2. **Authorization**: Policies + Middleware + Spatie Permissions
3. **Input Validation**: FormRequest classes with strict rules
4. **File Upload**: MIME whitelist, size limits, scan before storage
5. **XSS**: Blade escaping, Content-Security-Policy headers
6. **CSRF**: All forms include `@csrf`
7. **Payment**: Webhook signature verification, idempotency keys
8. **Audit**: ActivityLog for all financial and critical actions

---

## 7. ERROR HANDLING STRATEGY

```
Exception Type          → HTTP Code → User Message
ValidationException     → 422       → "Field X is required"
AuthenticationException → 401       → "Silakan login terlebih dahulu"
AuthorizationException  → 403       → "Anda tidak memiliki akses"
ModelNotFoundException  → 404       → "Data tidak ditemukan"
PaymentException        → 500       → "Pembayaran gagal, hubungi support"
EscrowException         → 500       → "Gagal memproses escrow"
```

---

*© 2026 Collabee Platform — Architecture Documentation v1.0.0*
