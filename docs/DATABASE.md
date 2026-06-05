# 🗄️ COLLABEE — Database Schema Documentation

> **Platform Marketplace Brand & KOL — Laravel 12**
> Versi: 1.0.0 | Engine: MySQL 8.0+ / PostgreSQL 15+

---

## 1. ENTITY RELATIONSHIP DIAGRAM

```
┌──────────────┐          ┌──────────────────┐          ┌─────────────────┐
│    User      │1──1      │  BrandProfile    │1──N      │    Campaign     │
│  (polymorph) │──────────│                  │──────────│                 │
│              │          │ id, brand_name,  │          │ id, title,      │
│ id, name,    │          │ industry, logo,  │          │ budget, status  │
│ email,       │          │ rating_avg       │          │ start_date,     │
│ user_type,   │          └──────────────────┘          │ end_date        │
│ is_active    │                                         └────────┬────────┘
└──────┬───────┘                                                   │
       │1                                                          │N
       │                                                           │
       │1                    ┌──────────────┐                      │
       ├────────────────────│  KolProfile  │1──────────────────────┘
       │                    │              │
       │                    │ id,          │
       │                    │ display_name,│
       │                    │ category,    │
       │                    │ wallet_bal,  │
       │                    │ rating_avg   │
       │                    └──────┬───────┘
       │                           │
       │                           │1
       │                    ┌──────┴───────┐
       │                    │  Hiring      │
       │                    │              │
       │                    │ id,          │
       │                    │ status,      │
       │                    │ proposed_    │
       │                    │ budget       │
       │                    └──────┬───────┘
       │                           │
       │                           │1
       │                    ┌──────┴───────┐
       │                    │  Agreement   │
       │                    │              │
       │                    │ id,          │
       │                    │ total_amount,│
       │                    │ status       │
       │                    └──────┬───────┘
       │                           │
       │                    ┌──────┴───────┐
       │                    │   Payment    │
       │                    │              │
       │                    │ id,          │
       │                    │ amount,      │
       │                    │ status       │
       │                    └──────┬───────┘
       │                           │
       │                    ┌──────┴───────┐
       │                    │    Escrow    │
       │                    │              │
       │                    │ amount_held  │
       │                    │ status       │
       │                    └──────────────┘
       │
       │                    ┌──────────────────┐
       ├────────────────────│  ChatRoom        │
       │                    │ (brand_user_id + │
       │                    │  kol_user_id)    │
       │                    └────────┬─────────┘
       │                             │1
       │                    ┌────────┴─────────┐
       │                    │  ChatMessage     │
       │                    │ (sender_id)      │
       │                    └──────────────────┘
       │
       │                    ┌──────────────────┐
       │                    │  Notification    │
       │                    │ (user_id)        │
       │                    └──────────────────┘
       │
       │                    ┌──────────────────┐
       ├────────────────────│  Content         │
       │                    │                  │
       │                    │ (kol_profile_id, │
       │                    │  brand_profile)  │
       │                    └────────┬─────────┘
       │                             │
       │                    ┌────────┴─────────┐
       │                    │  ContentRevision  │
       │                    │ (requested_by)   │
       │                    └──────────────────┘
       │
       │                    ┌──────────────────┐
       │                    │  Rating          │
       │                    │ (rater_id,        │
       │                    │  rated_id)        │
       │                    └──────────────────┘
       │
       │                    ┌──────────────────┐
       │                    │  PlatformReview   │
       │                    │ (user_id)        │
       │                    └──────────────────┘
       │
       │                    ┌──────────────────┐
       └────────────────────│  Dispute         │
                            │ (raised_by,       │
                            │  against)         │
                            └──────────────────┘

Additional relations (not shown):
- KolProfile 1──N KolSocialAccount
- KolProfile 1──N KolPortfolio
- KolProfile 1──N KolRateCard
- KolProfile 1──N KolWithdrawal
- Campaign 1──N Hiring
- Hiring 1──1 ChatRoom
- Agreement 1──1 Payment
- Payment 1──1 EscrowTransaction
- Content 1──N ContentRevision
```

---

## 2. FULL TABLE SPECIFICATIONS

### 2.1 `users` — User Accounts

| Column | Type | Constraints | Description |
|--------|------|-------------|-------------|
| id | BIGINT UNSIGNED | PK, AUTO_INCREMENT | Primary key |
| name | VARCHAR(255) | NOT NULL | Full name |
| email | VARCHAR(255) | UNIQUE, NOT NULL | Email login |
| phone | VARCHAR(20) | NULL | Phone number |
| email_verified_at | TIMESTAMP | NULL | Email verification timestamp |
| password | VARCHAR(255) | NOT NULL | Bcrypt hashed password |
| user_type | ENUM('brand','kol','admin','super_admin') | NOT NULL | User role type |
| avatar | VARCHAR(255) | NULL | Avatar URL/path |
| is_active | BOOLEAN | DEFAULT TRUE | Account active status |
| is_verified | BOOLEAN | DEFAULT FALSE | Verified badge |
| last_login_at | TIMESTAMP | NULL | Last login timestamp |
| last_login_ip | VARCHAR(45) | NULL | Last login IP |
| remember_token | VARCHAR(100) | NULL | Remember me token |
| deleted_at | TIMESTAMP | NULL | Soft delete |
| created_at | TIMESTAMP | NULL | Laravel timestamp |
| updated_at | TIMESTAMP | NULL | Laravel timestamp |

**Indexes:** PRIMARY(id), UNIQUE(email), INDEX(user_type), INDEX(is_active)

---

### 2.2 `brand_profiles` — Brand Company Profiles

| Column | Type | Constraints | Description |
|--------|------|-------------|-------------|
| id | BIGINT UNSIGNED | PK, AUTO_INCREMENT | Primary key |
| user_id | BIGINT UNSIGNED | UNIQUE, FK→users.id | Owner user |
| brand_name | VARCHAR(255) | NOT NULL | Brand/company name |
| slug | VARCHAR(255) | UNIQUE, NOT NULL | URL slug |
| description | TEXT | NULL | About the brand |
| industry | VARCHAR(100) | NOT NULL | e.g. Fashion, Food, Tech |
| website | VARCHAR(255) | NULL | Company website |
| target_market | JSON | NULL | Age groups, gender, location |
| location | VARCHAR(255) | NULL | City/region |
| logo | VARCHAR(255) | NULL | Logo path |
| banner | VARCHAR(255) | NULL | Cover photo path |
| total_campaigns | INT | DEFAULT 0 | Campaign count |
| total_spent | DECIMAL(15,2) | DEFAULT 0 | Total spending |
| rating_avg | DECIMAL(3,2) | DEFAULT 0 | Average rating |
| rating_count | INT | DEFAULT 0 | Rating count |
| profile_completed_at | TIMESTAMP | NULL | When profile was completed |

**Indexes:** PRIMARY(id), UNIQUE(user_id), UNIQUE(slug), INDEX(industry)

---

### 2.3 `kol_profiles` — KOL/Influencer Profiles

| Column | Type | Constraints | Description |
|--------|------|-------------|-------------|
| id | BIGINT UNSIGNED | PK, AUTO_INCREMENT | Primary key |
| user_id | BIGINT UNSIGNED | UNIQUE, FK→users.id | Owner user |
| slug | VARCHAR(255) | UNIQUE, NOT NULL | URL slug |
| display_name | VARCHAR(255) | NOT NULL | Public display name |
| bio | TEXT | NULL | Bio (max 500 chars) |
| category | VARCHAR(100) | NOT NULL | Main category |
| sub_categories | JSON | NULL | Sub-categories array |
| location | VARCHAR(255) | NULL | City/region |
| gender | ENUM('male','female','other') | NULL | Gender |
| date_of_birth | DATE | NULL | DOB |
| languages | JSON | NULL | Languages array |
| total_followers | INT | DEFAULT 0 | Aggregated followers |
| avg_engagement_rate | DECIMAL(5,2) | DEFAULT 0 | Avg engagement rate |
| total_campaigns_done | INT | DEFAULT 0 | Completed campaigns |
| total_earned | DECIMAL(15,2) | DEFAULT 0 | Total earnings |
| wallet_balance | DECIMAL(15,2) | DEFAULT 0 | Available balance |
| pending_balance | DECIMAL(15,2) | DEFAULT 0 | Escrow pending |
| rating_avg | DECIMAL(3,2) | DEFAULT 0 | Average rating |
| rating_count | INT | DEFAULT 0 | Rating count |
| is_open_for_work | BOOLEAN | DEFAULT TRUE | Available status |
| min_budget | DECIMAL(12,2) | NULL | Minimum budget |
| profile_completed_at | TIMESTAMP | NULL | Completion timestamp |

---

### 2.4 `kol_social_accounts` — KOL Social Media Accounts

| Column | Type | Constraints | Description |
|--------|------|-------------|-------------|
| id | BIGINT UNSIGNED | PK, AUTO_INCREMENT | Primary key |
| kol_profile_id | BIGINT UNSIGNED | FK→kol_profiles.id | Owner KOL |
| platform | ENUM(...) | NOT NULL | Instagram, TikTok, YouTube, etc |
| username | VARCHAR(255) | NOT NULL | Platform username |
| profile_url | VARCHAR(500) | NOT NULL | Profile URL |
| followers_count | INT | DEFAULT 0 | Follower count |
| following_count | INT | NULL | Following count |
| engagement_rate | DECIMAL(5,2) | NULL | Engagement rate % |
| avg_likes | INT | NULL | Average likes per post |
| avg_comments | INT | NULL | Average comments per post |
| avg_views | INT | NULL | Average views per video |
| is_verified | BOOLEAN | DEFAULT FALSE | Verified badge |
| is_primary | BOOLEAN | DEFAULT FALSE | Main account |
| last_synced_at | TIMESTAMP | NULL | Last data sync |

---

### 2.5 `campaigns` — Brand Campaign Posts

| Column | Type | Constraints | Description |
|--------|------|-------------|-------------|
| id | BIGINT UNSIGNED | PK, AUTO_INCREMENT | Primary key |
| brand_profile_id | BIGINT UNSIGNED | FK→brand_profiles.id | Owner brand |
| slug | VARCHAR(255) | UNIQUE, NOT NULL | URL slug |
| title | VARCHAR(500) | NOT NULL | Campaign title |
| description | LONGTEXT | NOT NULL | Campaign description |
| brief | LONGTEXT | NULL | Detailed creative brief |
| objectives | JSON | NULL | Campaign goals array |
| platforms | JSON | NOT NULL | Target platforms |
| content_types | JSON | NOT NULL | Content types per platform |
| kol_category | VARCHAR(100) | NULL | Required KOL category |
| min_followers | INT | NULL | Minimum follower count |
| max_followers | INT | NULL | Maximum follower count |
| min_engagement | DECIMAL(5,2) | NULL | Min engagement rate |
| target_gender | ENUM('all','male','female') | DEFAULT 'all' | Target gender |
| location | VARCHAR(255) | NULL | Target location |
| budget_total | DECIMAL(15,2) | NOT NULL | Total campaign budget |
| budget_per_kol | DECIMAL(12,2) | NULL | Budget per KOL |
| kol_slots | INT | DEFAULT 1 | Number of KOLs needed |
| kol_filled | INT | DEFAULT 0 | KOLs accepted |
| start_date | DATE | NOT NULL | Campaign start |
| end_date | DATE | NOT NULL | Campaign end |
| deadline_apply | DATE | NOT NULL | Application deadline |
| status | ENUM(...) | DEFAULT 'draft' | Campaign status |
| is_featured | BOOLEAN | DEFAULT FALSE | Featured campaign |
| views_count | INT | DEFAULT 0 | Page views |
| applications_count | INT | DEFAULT 0 | Total applications |

---

### 2.6 `hirings` — Brand-KOL Matching

| Column | Type | Constraints | Description |
|--------|------|-------------|-------------|
| id | BIGINT UNSIGNED | PK, AUTO_INCREMENT | Primary key |
| campaign_id | BIGINT UNSIGNED | FK→campaigns.id | Related campaign |
| brand_profile_id | BIGINT UNSIGNED | FK→brand_profiles.id | Brand |
| kol_profile_id | BIGINT UNSIGNED | FK→kol_profiles.id | KOL |
| initiated_by | ENUM('brand','kol') | NOT NULL | Who started |
| status | ENUM(...) | DEFAULT 'pending' | Current status |
| message | TEXT | NULL | Opening message |
| proposed_budget | DECIMAL(12,2) | NULL | Initial proposal |
| agreed_budget | DECIMAL(12,2) | NULL | Final agreed amount |
| note | TEXT | NULL | Internal note |
| rejected_reason | TEXT | NULL | Rejection reason |
| accepted_at | TIMESTAMP | NULL | Acceptance timestamp |
| expires_at | TIMESTAMP | NULL | Auto-expiry |

**Indexes:** INDEX(campaign_id), INDEX(kol_profile_id), INDEX(status)

---

### 2.7 `chat_rooms` & `chat_messages` — Real-time Chat

**Chat Rooms:**
| Column | Type | Constraints | Description |
|--------|------|-------------|-------------|
| id | BIGINT UNSIGNED | PK | Primary key |
| hiring_id | BIGINT UNSIGNED | UNIQUE, FK→hirings.id | Related hiring |
| brand_user_id | BIGINT UNSIGNED | FK→users.id | Brand user |
| kol_user_id | BIGINT UNSIGNED | FK→users.id | KOL user |
| last_message_at | TIMESTAMP | NULL | Most recent message |
| brand_unread | INT | DEFAULT 0 | Brand unread count |
| kol_unread | INT | DEFAULT 0 | KOL unread count |

**Chat Messages:**
| Column | Type | Constraints | Description |
|--------|------|-------------|-------------|
| id | BIGINT UNSIGNED | PK | Primary key |
| chat_room_id | BIGINT UNSIGNED | FK→chat_rooms.id | Room |
| sender_id | BIGINT UNSIGNED | FK→users.id | Message sender |
| body | TEXT | NULL | Message text |
| type | ENUM('text','file','image','system','offer') | DEFAULT 'text' | Message type |
| attachments | JSON | NULL | File references |
| offer_data | JSON | NULL | Budget proposal data |
| offer_status | ENUM('pending','accepted','rejected') | NULL | Offer response |
| is_read | BOOLEAN | DEFAULT FALSE | Read status |

---

### 2.8 `payments` & `escrow_transactions` — Financial Core

**Payments:**
| Column | Type | Constraints | Description |
|--------|------|-------------|-------------|
| id | BIGINT UNSIGNED | PK | Primary key |
| agreement_id | BIGINT UNSIGNED | FK→agreements.id | Related agreement |
| invoice_number | VARCHAR(50) | UNIQUE, NOT NULL | INV-2026-XXXXX |
| amount | DECIMAL(15,2) | NOT NULL | Base amount |
| platform_fee | DECIMAL(12,2) | NOT NULL | Platform fee (5%) |
| total_amount | DECIMAL(15,2) | NOT NULL | Total charged |
| gateway | ENUM('xendit','midtrans','manual') | DEFAULT 'xendit' | Payment gateway |
| gateway_payment_id | VARCHAR(255) | NULL | Gateway reference |
| status | ENUM('pending','paid','expired','failed','refunded') | DEFAULT 'pending' | Payment status |

**Escrow Transactions:**
| Column | Type | Constraints | Description |
|--------|------|-------------|-------------|
| id | BIGINT UNSIGNED | PK | Primary key |
| payment_id | BIGINT UNSIGNED | FK→payments.id | Source payment |
| amount_held | DECIMAL(15,2) | NOT NULL | Amount in escrow |
| platform_fee | DECIMAL(12,2) | NOT NULL | Platform revenue |
| kol_amount | DECIMAL(12,2) | NOT NULL | Net to KOL |
| status | ENUM('held','partially_released','released','refunded','disputed') | DEFAULT 'held' | Escrow status |
| release_trigger | ENUM(...) | NULL | How it was released |

---

## 3. ENUM DEFINITIONS

```php
// app/Enums/UserRole.php
enum UserRole: string {
    case BRAND = 'brand';
    case KOL = 'kol';
    case ADMIN = 'admin';
    case SUPER_ADMIN = 'super_admin';
}

// app/Enums/CampaignStatus.php
enum CampaignStatus: string {
    case DRAFT = 'draft';
    case OPEN = 'open';
    case IN_PROGRESS = 'in_progress';
    case COMPLETED = 'completed';
    case CANCELLED = 'cancelled';
    case PAUSED = 'paused';
}

// app/Enums/HiringStatus.php
enum HiringStatus: string {
    case PENDING = 'pending';
    case NEGOTIATING = 'negotiating';
    case ACCEPTED = 'accepted';
    case REJECTED = 'rejected';
    case CANCELLED = 'cancelled';
    case COMPLETED = 'completed';
}

// app/Enums/ContentStatus.php
enum ContentStatus: string {
    case DRAFT = 'draft';
    case SUBMITTED = 'submitted';
    case UNDER_REVIEW = 'under_review';
    case REVISION_REQUESTED = 'revision_requested';
    case APPROVED = 'approved';
    case POSTED = 'posted';
    case REJECTED = 'rejected';
}

// app/Enums/PaymentStatus.php
enum PaymentStatus: string {
    case PENDING = 'pending';
    case PAID = 'paid';
    case HELD = 'held';
    case RELEASED = 'released';
    case REFUNDED = 'refunded';
    case EXPIRED = 'expired';
    case FAILED = 'failed';
}

// app/Enums/SocialPlatform.php
enum SocialPlatform: string {
    case INSTAGRAM = 'instagram';
    case TIKTOK = 'tiktok';
    case YOUTUBE = 'youtube';
    case TWITTER = 'twitter';
    case FACEBOOK = 'facebook';
    case LINKEDIN = 'linkedin';
}
```

---

## 4. INDEXES & PERFORMANCE

| Table | Index | Type | Purpose |
|-------|-------|------|---------|
| users | user_type + is_active | COMPOSITE | Filter active users by role |
| campaigns | brand_profile_id + status | COMPOSITE | Brand campaign list |
| campaigns | status + deadline_apply | COMPOSITE | Open campaigns for KOL |
| campaigns | kol_category + min_followers | COMPOSITE | KOL search filters |
| hirings | kol_profile_id + status | COMPOSITE | KOL hiring list |
| hirings | campaign_id + kol_profile_id | UNIQUE | Prevent duplicate hiring |
| chat_messages | chat_room_id + created_at | COMPOSITE | Message history |
| payments | agreement_id | UNIQUE | One payment per agreement |
| escrow_transactions | payment_id | UNIQUE | One escrow per payment |
| ratings | hiring_id + rater_id | UNIQUE | One rating per user per hiring |
| notifications | user_id + is_read | COMPOSITE | Unread notifications |

---

## 5. CASCADE RULES

| Foreign Key | On Delete | On Update |
|-------------|-----------|-----------|
| brand_profiles.user_id → users.id | CASCADE | CASCADE |
| kol_profiles.user_id → users.id | CASCADE | CASCADE |
| kol_social_accounts.kol_profile_id → kol_profiles.id | CASCADE | CASCADE |
| kol_portfolios.kol_profile_id → kol_profiles.id | CASCADE | CASCADE |
| kol_rate_cards.kol_profile_id → kol_profiles.id | CASCADE | CASCADE |
| campaigns.brand_profile_id → brand_profiles.id | CASCADE | CASCADE |
| hirings.campaign_id → campaigns.id | CASCADE | CASCADE |
| hirings.brand_profile_id → brand_profiles.id | CASCADE | CASCADE |
| hirings.kol_profile_id → kol_profiles.id | CASCADE | CASCADE |
| chat_rooms.hiring_id → hirings.id | CASCADE | CASCADE |
| chat_messages.chat_room_id → chat_rooms.id | CASCADE | CASCADE |
| agreements.hiring_id → hirings.id | CASCADE | CASCADE |
| contents.agreement_id → agreements.id | CASCADE | CASCADE |
| payments.agreement_id → agreements.id | CASCADE | CASCADE |
| escrow_transactions.payment_id → payments.id | CASCADE | CASCADE |
| kol_withdrawals.kol_profile_id → kol_profiles.id | CASCADE | CASCADE |
| ratings.hiring_id → hirings.id | CASCADE | CASCADE |
| disputes.hiring_id → hirings.id | CASCADE | CASCADE |

---

## 6. MIGRATION EXECUTION ORDER

```
01. 2026_06_05_000001_create_users_table.php
02. 2026_06_05_000002_create_brand_profiles_table.php
03. 2026_06_05_000003_create_kol_profiles_table.php
04. 2026_06_05_000004_create_kol_social_accounts_table.php
05. 2026_06_05_000005_create_kol_portfolios_table.php
06. 2026_06_05_000006_create_kol_rate_cards_table.php
07. 2026_06_05_000007_create_campaigns_table.php
08. 2026_06_05_000008_create_hirings_table.php
09. 2026_06_05_000009_create_hiring_applications_table.php
10. 2026_06_05_000010_create_chat_rooms_table.php
11. 2026_06_05_000011_create_chat_messages_table.php
12. 2026_06_05_000012_create_agreements_table.php
13. 2026_06_05_000013_create_contents_table.php
14. 2026_06_05_000014_create_content_revisions_table.php
15. 2026_06_05_000015_create_payments_table.php
16. 2026_06_05_000016_create_escrow_transactions_table.php
17. 2026_06_05_000017_create_kol_withdrawals_table.php
18. 2026_06_05_000018_create_ratings_table.php
19. 2026_06_05_000019_create_platform_reviews_table.php
20. 2026_06_05_000020_create_notifications_table.php
21. 2026_06_05_000021_create_disputes_table.php
22. 2026_06_05_000022_create_app_settings_table.php
23. 2026_06_05_000023_create_media_table.php          (Spatie)
24. 2026_06_05_000024_create_activity_log_table.php    (Spatie)
25. 2026_06_05_000025_create_settings_table.php        (Spatie)
26. 2026_06_05_000026_create_permission_tables.php     (Spatie)
27. 2026_06_05_000027_create_personal_access_tokens_table.php (Sanctum)
```

---

*© 2026 Collabee Platform — Database Schema v1.0.0*
