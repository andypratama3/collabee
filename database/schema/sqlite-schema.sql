CREATE TABLE IF NOT EXISTS "migrations"(
  "id" integer primary key autoincrement not null,
  "migration" varchar not null,
  "batch" integer not null
);
CREATE TABLE IF NOT EXISTS "users"(
  "id" integer primary key autoincrement not null,
  "name" varchar not null,
  "email" varchar not null,
  "phone" varchar,
  "email_verified_at" datetime,
  "password" varchar not null,
  "user_type" varchar not null,
  "avatar" varchar,
  "is_active" tinyint(1) not null default '1',
  "is_verified" tinyint(1) not null default '0',
  "last_login_at" datetime,
  "last_login_ip" varchar,
  "remember_token" varchar,
  "deleted_at" datetime,
  "created_at" datetime,
  "updated_at" datetime
);
CREATE INDEX "users_user_type_is_active_index" on "users"(
  "user_type",
  "is_active"
);
CREATE UNIQUE INDEX "users_email_unique" on "users"("email");
CREATE TABLE IF NOT EXISTS "password_reset_tokens"(
  "email" varchar not null,
  "token" varchar not null,
  "created_at" datetime,
  primary key("email")
);
CREATE TABLE IF NOT EXISTS "sessions"(
  "id" varchar not null,
  "user_id" integer,
  "ip_address" varchar,
  "user_agent" text,
  "payload" text not null,
  "last_activity" integer not null,
  primary key("id")
);
CREATE INDEX "sessions_user_id_index" on "sessions"("user_id");
CREATE INDEX "sessions_last_activity_index" on "sessions"("last_activity");
CREATE TABLE IF NOT EXISTS "cache"(
  "key" varchar not null,
  "value" text not null,
  "expiration" integer not null,
  primary key("key")
);
CREATE INDEX "cache_expiration_index" on "cache"("expiration");
CREATE TABLE IF NOT EXISTS "cache_locks"(
  "key" varchar not null,
  "owner" varchar not null,
  "expiration" integer not null,
  primary key("key")
);
CREATE INDEX "cache_locks_expiration_index" on "cache_locks"("expiration");
CREATE TABLE IF NOT EXISTS "jobs"(
  "id" integer primary key autoincrement not null,
  "queue" varchar not null,
  "payload" text not null,
  "attempts" integer not null,
  "reserved_at" integer,
  "available_at" integer not null,
  "created_at" integer not null
);
CREATE INDEX "jobs_queue_index" on "jobs"("queue");
CREATE TABLE IF NOT EXISTS "job_batches"(
  "id" varchar not null,
  "name" varchar not null,
  "total_jobs" integer not null,
  "pending_jobs" integer not null,
  "failed_jobs" integer not null,
  "failed_job_ids" text not null,
  "options" text,
  "cancelled_at" integer,
  "created_at" integer not null,
  "finished_at" integer,
  primary key("id")
);
CREATE TABLE IF NOT EXISTS "failed_jobs"(
  "id" integer primary key autoincrement not null,
  "uuid" varchar not null,
  "connection" text not null,
  "queue" text not null,
  "payload" text not null,
  "exception" text not null,
  "failed_at" datetime not null default CURRENT_TIMESTAMP
);
CREATE UNIQUE INDEX "failed_jobs_uuid_unique" on "failed_jobs"("uuid");
CREATE TABLE IF NOT EXISTS "settings"(
  "id" integer primary key autoincrement not null,
  "group" varchar not null,
  "name" varchar not null,
  "locked" tinyint(1) not null default '0',
  "payload" text not null,
  "created_at" datetime,
  "updated_at" datetime
);
CREATE UNIQUE INDEX "settings_group_name_unique" on "settings"(
  "group",
  "name"
);
CREATE TABLE IF NOT EXISTS "media"(
  "id" integer primary key autoincrement not null,
  "model_type" varchar not null,
  "model_id" integer not null,
  "uuid" varchar,
  "collection_name" varchar not null,
  "name" varchar not null,
  "file_name" varchar not null,
  "mime_type" varchar,
  "disk" varchar not null,
  "conversions_disk" varchar,
  "size" integer not null,
  "manipulations" text not null,
  "custom_properties" text not null,
  "generated_conversions" text not null,
  "responsive_images" text not null,
  "order_column" integer,
  "created_at" datetime,
  "updated_at" datetime
);
CREATE INDEX "media_model_type_model_id_index" on "media"(
  "model_type",
  "model_id"
);
CREATE UNIQUE INDEX "media_uuid_unique" on "media"("uuid");
CREATE INDEX "media_order_column_index" on "media"("order_column");
CREATE TABLE IF NOT EXISTS "activity_log"(
  "id" integer primary key autoincrement not null,
  "log_name" varchar,
  "description" text not null,
  "subject_type" varchar,
  "subject_id" integer,
  "causer_type" varchar,
  "causer_id" integer,
  "properties" text,
  "created_at" datetime,
  "updated_at" datetime,
  "event" varchar,
  "batch_uuid" varchar
);
CREATE INDEX "subject" on "activity_log"("subject_type", "subject_id");
CREATE INDEX "causer" on "activity_log"("causer_type", "causer_id");
CREATE INDEX "activity_log_log_name_index" on "activity_log"("log_name");
CREATE TABLE IF NOT EXISTS "telescope_entries"(
  "sequence" integer primary key autoincrement not null,
  "uuid" varchar not null,
  "batch_id" varchar not null,
  "family_hash" varchar,
  "should_display_on_index" tinyint(1) not null default '1',
  "type" varchar not null,
  "content" text not null,
  "created_at" datetime
);
CREATE UNIQUE INDEX "telescope_entries_uuid_unique" on "telescope_entries"(
  "uuid"
);
CREATE INDEX "telescope_entries_batch_id_index" on "telescope_entries"(
  "batch_id"
);
CREATE INDEX "telescope_entries_family_hash_index" on "telescope_entries"(
  "family_hash"
);
CREATE INDEX "telescope_entries_created_at_index" on "telescope_entries"(
  "created_at"
);
CREATE INDEX "telescope_entries_type_should_display_on_index_index" on "telescope_entries"(
  "type",
  "should_display_on_index"
);
CREATE TABLE IF NOT EXISTS "telescope_entries_tags"(
  "entry_uuid" varchar not null,
  "tag" varchar not null,
  foreign key("entry_uuid") references "telescope_entries"("uuid") on delete cascade,
  primary key("entry_uuid", "tag")
);
CREATE INDEX "telescope_entries_tags_tag_index" on "telescope_entries_tags"(
  "tag"
);
CREATE TABLE IF NOT EXISTS "telescope_monitoring"(
  "tag" varchar not null,
  primary key("tag")
);
CREATE TABLE IF NOT EXISTS "personal_access_tokens"(
  "id" integer primary key autoincrement not null,
  "tokenable_type" varchar not null,
  "tokenable_id" integer not null,
  "name" text not null,
  "token" varchar not null,
  "abilities" text,
  "last_used_at" datetime,
  "expires_at" datetime,
  "created_at" datetime,
  "updated_at" datetime
);
CREATE INDEX "personal_access_tokens_tokenable_type_tokenable_id_index" on "personal_access_tokens"(
  "tokenable_type",
  "tokenable_id"
);
CREATE UNIQUE INDEX "personal_access_tokens_token_unique" on "personal_access_tokens"(
  "token"
);
CREATE INDEX "personal_access_tokens_expires_at_index" on "personal_access_tokens"(
  "expires_at"
);
CREATE TABLE IF NOT EXISTS "permissions"(
  "id" integer primary key autoincrement not null,
  "name" varchar not null,
  "guard_name" varchar not null,
  "created_at" datetime,
  "updated_at" datetime
);
CREATE UNIQUE INDEX "permissions_name_guard_name_unique" on "permissions"(
  "name",
  "guard_name"
);
CREATE TABLE IF NOT EXISTS "roles"(
  "id" integer primary key autoincrement not null,
  "name" varchar not null,
  "guard_name" varchar not null,
  "created_at" datetime,
  "updated_at" datetime
);
CREATE UNIQUE INDEX "roles_name_guard_name_unique" on "roles"(
  "name",
  "guard_name"
);
CREATE TABLE IF NOT EXISTS "model_has_permissions"(
  "permission_id" integer not null,
  "model_type" varchar not null,
  "model_id" integer not null,
  foreign key("permission_id") references "permissions"("id") on delete cascade,
  primary key("permission_id", "model_id", "model_type")
);
CREATE INDEX "model_has_permissions_model_id_model_type_index" on "model_has_permissions"(
  "model_id",
  "model_type"
);
CREATE TABLE IF NOT EXISTS "model_has_roles"(
  "role_id" integer not null,
  "model_type" varchar not null,
  "model_id" integer not null,
  foreign key("role_id") references "roles"("id") on delete cascade,
  primary key("role_id", "model_id", "model_type")
);
CREATE INDEX "model_has_roles_model_id_model_type_index" on "model_has_roles"(
  "model_id",
  "model_type"
);
CREATE TABLE IF NOT EXISTS "role_has_permissions"(
  "permission_id" integer not null,
  "role_id" integer not null,
  foreign key("permission_id") references "permissions"("id") on delete cascade,
  foreign key("role_id") references "roles"("id") on delete cascade,
  primary key("permission_id", "role_id")
);
CREATE TABLE IF NOT EXISTS "brand_profiles"(
  "id" integer primary key autoincrement not null,
  "user_id" integer not null,
  "brand_name" varchar not null,
  "slug" varchar not null,
  "description" text,
  "industry" varchar not null,
  "website" varchar,
  "target_market" text,
  "location" varchar,
  "logo" varchar,
  "banner" varchar,
  "total_campaigns" integer not null default '0',
  "total_spent" numeric not null default '0',
  "rating_avg" numeric not null default '0',
  "rating_count" integer not null default '0',
  "profile_completed_at" datetime,
  "created_at" datetime,
  "updated_at" datetime,
  foreign key("user_id") references "users"("id") on delete cascade
);
CREATE INDEX "brand_profiles_industry_index" on "brand_profiles"("industry");
CREATE UNIQUE INDEX "brand_profiles_user_id_unique" on "brand_profiles"(
  "user_id"
);
CREATE UNIQUE INDEX "brand_profiles_slug_unique" on "brand_profiles"("slug");
CREATE TABLE IF NOT EXISTS "kol_profiles"(
  "id" integer primary key autoincrement not null,
  "user_id" integer not null,
  "slug" varchar not null,
  "display_name" varchar not null,
  "bio" text,
  "category" varchar not null,
  "sub_categories" text,
  "location" varchar,
  "gender" varchar,
  "date_of_birth" date,
  "languages" text,
  "total_followers" integer not null default '0',
  "avg_engagement_rate" numeric not null default '0',
  "total_campaigns_done" integer not null default '0',
  "total_earned" numeric not null default '0',
  "wallet_balance" numeric not null default '0',
  "pending_balance" numeric not null default '0',
  "rating_avg" numeric not null default '0',
  "rating_count" integer not null default '0',
  "is_open_for_work" tinyint(1) not null default '1',
  "min_budget" numeric,
  "profile_completed_at" datetime,
  "created_at" datetime,
  "updated_at" datetime,
  foreign key("user_id") references "users"("id") on delete cascade
);
CREATE UNIQUE INDEX "kol_profiles_user_id_unique" on "kol_profiles"("user_id");
CREATE UNIQUE INDEX "kol_profiles_slug_unique" on "kol_profiles"("slug");
CREATE TABLE IF NOT EXISTS "kol_social_accounts"(
  "id" integer primary key autoincrement not null,
  "kol_profile_id" integer not null,
  "platform" varchar not null,
  "username" varchar not null,
  "profile_url" varchar not null,
  "followers_count" integer not null default '0',
  "following_count" integer,
  "engagement_rate" numeric,
  "avg_likes" integer,
  "avg_comments" integer,
  "avg_views" integer,
  "is_verified" tinyint(1) not null default '0',
  "is_primary" tinyint(1) not null default '0',
  "last_synced_at" datetime,
  "created_at" datetime,
  "updated_at" datetime,
  foreign key("kol_profile_id") references "kol_profiles"("id") on delete cascade
);
CREATE TABLE IF NOT EXISTS "kol_portfolios"(
  "id" integer primary key autoincrement not null,
  "kol_profile_id" integer not null,
  "title" varchar not null,
  "description" text,
  "media_type" varchar not null,
  "media_url" varchar,
  "external_link" varchar,
  "sort_order" integer not null default '0',
  "created_at" datetime,
  "updated_at" datetime,
  foreign key("kol_profile_id") references "kol_profiles"("id") on delete cascade
);
CREATE TABLE IF NOT EXISTS "kol_rate_cards"(
  "id" integer primary key autoincrement not null,
  "kol_profile_id" integer not null,
  "platform" varchar not null,
  "content_type" varchar not null,
  "price" numeric not null,
  "description" text,
  "is_active" tinyint(1) not null default '1',
  "created_at" datetime,
  "updated_at" datetime,
  foreign key("kol_profile_id") references "kol_profiles"("id") on delete cascade
);
CREATE TABLE IF NOT EXISTS "campaigns"(
  "id" integer primary key autoincrement not null,
  "brand_profile_id" integer not null,
  "slug" varchar not null,
  "title" varchar not null,
  "description" text not null,
  "brief" text,
  "objectives" text,
  "platforms" text not null,
  "content_types" text not null,
  "kol_category" varchar,
  "min_followers" integer,
  "max_followers" integer,
  "min_engagement" numeric,
  "target_gender" varchar not null default 'all',
  "location" varchar,
  "budget_total" numeric not null,
  "budget_per_kol" numeric,
  "kol_slots" integer not null default '1',
  "kol_filled" integer not null default '0',
  "start_date" date not null,
  "end_date" date not null,
  "deadline_apply" date not null,
  "status" varchar not null default 'draft',
  "is_featured" tinyint(1) not null default '0',
  "views_count" integer not null default '0',
  "applications_count" integer not null default '0',
  "created_at" datetime,
  "updated_at" datetime,
  foreign key("brand_profile_id") references "brand_profiles"("id") on delete cascade
);
CREATE INDEX "campaigns_brand_profile_id_status_index" on "campaigns"(
  "brand_profile_id",
  "status"
);
CREATE INDEX "campaigns_status_deadline_apply_index" on "campaigns"(
  "status",
  "deadline_apply"
);
CREATE INDEX "campaigns_kol_category_min_followers_index" on "campaigns"(
  "kol_category",
  "min_followers"
);
CREATE UNIQUE INDEX "campaigns_slug_unique" on "campaigns"("slug");
CREATE TABLE IF NOT EXISTS "hirings"(
  "id" integer primary key autoincrement not null,
  "campaign_id" integer not null,
  "brand_profile_id" integer not null,
  "kol_profile_id" integer not null,
  "initiated_by" varchar not null,
  "status" varchar not null default 'pending',
  "message" text,
  "proposed_budget" numeric,
  "agreed_budget" numeric,
  "note" text,
  "rejected_reason" text,
  "accepted_at" datetime,
  "expires_at" datetime,
  "created_at" datetime,
  "updated_at" datetime,
  foreign key("campaign_id") references "campaigns"("id") on delete cascade,
  foreign key("brand_profile_id") references "brand_profiles"("id") on delete cascade,
  foreign key("kol_profile_id") references "kol_profiles"("id") on delete cascade
);
CREATE INDEX "hirings_campaign_id_kol_profile_id_index" on "hirings"(
  "campaign_id",
  "kol_profile_id"
);
CREATE INDEX "hirings_kol_profile_id_index" on "hirings"("kol_profile_id");
CREATE INDEX "hirings_status_index" on "hirings"("status");
CREATE TABLE IF NOT EXISTS "hiring_applications"(
  "id" integer primary key autoincrement not null,
  "campaign_id" integer not null,
  "kol_profile_id" integer not null,
  "proposed_budget" numeric,
  "message" text,
  "status" varchar not null default 'pending',
  "created_at" datetime,
  "updated_at" datetime,
  foreign key("campaign_id") references "campaigns"("id") on delete cascade,
  foreign key("kol_profile_id") references "kol_profiles"("id") on delete cascade
);
CREATE UNIQUE INDEX "hiring_applications_campaign_id_kol_profile_id_unique" on "hiring_applications"(
  "campaign_id",
  "kol_profile_id"
);
CREATE TABLE IF NOT EXISTS "chat_rooms"(
  "id" integer primary key autoincrement not null,
  "hiring_id" integer not null,
  "brand_user_id" integer not null,
  "kol_user_id" integer not null,
  "last_message_at" datetime,
  "brand_unread" integer not null default '0',
  "kol_unread" integer not null default '0',
  "created_at" datetime,
  "updated_at" datetime,
  foreign key("hiring_id") references "hirings"("id") on delete cascade,
  foreign key("brand_user_id") references "users"("id") on delete cascade,
  foreign key("kol_user_id") references "users"("id") on delete cascade
);
CREATE UNIQUE INDEX "chat_rooms_hiring_id_unique" on "chat_rooms"("hiring_id");
CREATE TABLE IF NOT EXISTS "chat_messages"(
  "id" integer primary key autoincrement not null,
  "chat_room_id" integer not null,
  "sender_id" integer not null,
  "body" text,
  "type" varchar not null default 'text',
  "attachments" text,
  "offer_data" text,
  "offer_status" varchar,
  "is_read" tinyint(1) not null default '0',
  "created_at" datetime,
  "updated_at" datetime,
  foreign key("chat_room_id") references "chat_rooms"("id") on delete cascade,
  foreign key("sender_id") references "users"("id") on delete cascade
);
CREATE INDEX "chat_messages_chat_room_id_created_at_index" on "chat_messages"(
  "chat_room_id",
  "created_at"
);
CREATE TABLE IF NOT EXISTS "agreements"(
  "id" integer primary key autoincrement not null,
  "hiring_id" integer not null,
  "agreement_number" varchar not null,
  "total_amount" numeric not null,
  "platform_fee_percent" numeric not null default '5',
  "terms" text,
  "status" varchar not null default 'pending',
  "brand_signed_at" datetime,
  "brand_signed_ip" varchar,
  "kol_signed_at" datetime,
  "kol_signed_ip" varchar,
  "signed_at" datetime,
  "expires_at" datetime,
  "pdf_path" varchar,
  "created_at" datetime,
  "updated_at" datetime,
  foreign key("hiring_id") references "hirings"("id") on delete cascade
);
CREATE UNIQUE INDEX "agreements_agreement_number_unique" on "agreements"(
  "agreement_number"
);
CREATE TABLE IF NOT EXISTS "contents"(
  "id" integer primary key autoincrement not null,
  "agreement_id" integer not null,
  "kol_profile_id" integer not null,
  "brand_profile_id" integer not null,
  "title" varchar not null,
  "caption" text,
  "media_files" text,
  "notes" text,
  "status" varchar not null default 'draft',
  "submitted_at" datetime,
  "approved_at" datetime,
  "deadline_at" datetime,
  "post_url" varchar,
  "posted_at" datetime,
  "created_at" datetime,
  "updated_at" datetime,
  "tracking_code" varchar,
  "click_count" integer not null default '0',
  foreign key("agreement_id") references "agreements"("id") on delete cascade,
  foreign key("kol_profile_id") references "kol_profiles"("id") on delete cascade,
  foreign key("brand_profile_id") references "brand_profiles"("id") on delete cascade
);
CREATE TABLE IF NOT EXISTS "content_revisions"(
  "id" integer primary key autoincrement not null,
  "content_id" integer not null,
  "requested_by" integer not null,
  "note" text not null,
  "attachments" text,
  "status" varchar not null default 'pending',
  "resolved_at" datetime,
  "created_at" datetime,
  "updated_at" datetime,
  foreign key("content_id") references "contents"("id") on delete cascade,
  foreign key("requested_by") references "users"("id") on delete cascade
);
CREATE TABLE IF NOT EXISTS "payments"(
  "id" integer primary key autoincrement not null,
  "agreement_id" integer not null,
  "invoice_number" varchar not null,
  "amount" numeric not null,
  "platform_fee" numeric not null,
  "total_amount" numeric not null,
  "gateway" varchar not null default 'xendit',
  "gateway_payment_id" varchar,
  "gateway_invoice_url" varchar,
  "status" varchar not null default 'pending',
  "paid_at" datetime,
  "created_at" datetime,
  "updated_at" datetime,
  foreign key("agreement_id") references "agreements"("id") on delete cascade
);
CREATE UNIQUE INDEX "payments_agreement_id_unique" on "payments"(
  "agreement_id"
);
CREATE UNIQUE INDEX "payments_invoice_number_unique" on "payments"(
  "invoice_number"
);
CREATE TABLE IF NOT EXISTS "escrow_transactions"(
  "id" integer primary key autoincrement not null,
  "payment_id" integer not null,
  "amount_held" numeric not null,
  "platform_fee" numeric not null,
  "kol_amount" numeric not null,
  "status" varchar not null default 'held',
  "release_trigger" varchar,
  "held_at" datetime,
  "released_at" datetime,
  "created_at" datetime,
  "updated_at" datetime,
  foreign key("payment_id") references "payments"("id") on delete cascade
);
CREATE UNIQUE INDEX "escrow_transactions_payment_id_unique" on "escrow_transactions"(
  "payment_id"
);
CREATE TABLE IF NOT EXISTS "kol_withdrawals"(
  "id" integer primary key autoincrement not null,
  "kol_profile_id" integer not null,
  "amount" numeric not null,
  "admin_fee" numeric not null default '0',
  "net_amount" numeric not null,
  "bank_name" varchar not null,
  "bank_account_number" varchar not null,
  "bank_account_name" varchar not null,
  "status" varchar not null default 'pending',
  "admin_note" text,
  "processed_at" datetime,
  "created_at" datetime,
  "updated_at" datetime,
  "proof_path" varchar,
  "notes" text,
  foreign key("kol_profile_id") references "kol_profiles"("id") on delete cascade
);
CREATE TABLE IF NOT EXISTS "ratings"(
  "id" integer primary key autoincrement not null,
  "hiring_id" integer not null,
  "rater_id" integer not null,
  "rated_id" integer not null,
  "type" varchar not null,
  "communication" integer not null default '0',
  "professionalism" integer not null default '0',
  "quality" integer not null default '0',
  "timeliness" integer not null default '0',
  "overall" numeric not null default '0',
  "review" text,
  "created_at" datetime,
  "updated_at" datetime,
  foreign key("hiring_id") references "hirings"("id") on delete cascade,
  foreign key("rater_id") references "users"("id") on delete cascade,
  foreign key("rated_id") references "users"("id") on delete cascade
);
CREATE UNIQUE INDEX "ratings_hiring_id_rater_id_unique" on "ratings"(
  "hiring_id",
  "rater_id"
);
CREATE TABLE IF NOT EXISTS "platform_reviews"(
  "id" integer primary key autoincrement not null,
  "user_id" integer not null,
  "rating" integer not null,
  "review" text,
  "created_at" datetime,
  "updated_at" datetime,
  foreign key("user_id") references "users"("id") on delete cascade
);
CREATE TABLE IF NOT EXISTS "notifications"(
  "id" integer primary key autoincrement not null,
  "user_id" integer not null,
  "type" varchar not null,
  "title" varchar not null,
  "body" text,
  "data" text,
  "action_url" varchar,
  "is_read" tinyint(1) not null default '0',
  "read_at" datetime,
  "created_at" datetime,
  "updated_at" datetime,
  foreign key("user_id") references "users"("id") on delete cascade
);
CREATE INDEX "notifications_user_id_is_read_index" on "notifications"(
  "user_id",
  "is_read"
);
CREATE TABLE IF NOT EXISTS "disputes"(
  "id" integer primary key autoincrement not null,
  "hiring_id" integer not null,
  "raised_by" integer not null,
  "against_id" integer not null,
  "subject" varchar not null,
  "description" text not null,
  "attachments" text,
  "status" varchar not null default 'open',
  "severity" varchar not null default 'medium',
  "admin_notes" text,
  "resolved_at" datetime,
  "created_at" datetime,
  "updated_at" datetime,
  foreign key("hiring_id") references "hirings"("id") on delete cascade,
  foreign key("raised_by") references "users"("id") on delete cascade,
  foreign key("against_id") references "users"("id") on delete cascade
);
CREATE TABLE IF NOT EXISTS "app_settings"(
  "id" integer primary key autoincrement not null,
  "key" varchar not null,
  "value" text,
  "group" varchar not null default 'general',
  "type" varchar not null default 'string',
  "description" text,
  "created_at" datetime,
  "updated_at" datetime
);
CREATE UNIQUE INDEX "app_settings_key_unique" on "app_settings"("key");
CREATE TABLE IF NOT EXISTS "kol_bank_accounts"(
  "id" integer primary key autoincrement not null,
  "kol_profile_id" integer not null,
  "bank_name" varchar not null,
  "account_name" varchar not null,
  "account_number" varchar not null,
  "bank_code" varchar,
  "branch" varchar,
  "is_verified" tinyint(1) not null default '0',
  "verified_at" datetime,
  "created_at" datetime,
  "updated_at" datetime,
  foreign key("kol_profile_id") references "kol_profiles"("id") on delete cascade
);
CREATE UNIQUE INDEX "contents_tracking_code_unique" on "contents"(
  "tracking_code"
);

INSERT INTO migrations VALUES(1,'0001_01_01_000000_create_users_table',1);
INSERT INTO migrations VALUES(2,'0001_01_01_000001_create_cache_table',1);
INSERT INTO migrations VALUES(3,'0001_01_01_000002_create_jobs_table',1);
INSERT INTO migrations VALUES(4,'2022_12_14_083707_create_settings_table',1);
INSERT INTO migrations VALUES(5,'2026_06_05_133756_create_media_table',1);
INSERT INTO migrations VALUES(6,'2026_06_05_133757_create_activity_log_table',1);
INSERT INTO migrations VALUES(7,'2026_06_05_133757_create_telescope_entries_table',1);
INSERT INTO migrations VALUES(8,'2026_06_05_133758_add_event_column_to_activity_log_table',1);
INSERT INTO migrations VALUES(9,'2026_06_05_133758_create_personal_access_tokens_table',1);
INSERT INTO migrations VALUES(10,'2026_06_05_133759_add_batch_uuid_column_to_activity_log_table',1);
INSERT INTO migrations VALUES(11,'2026_06_05_134338_create_permission_tables',1);
INSERT INTO migrations VALUES(12,'2026_06_05_150001_create_brand_profiles_table',1);
INSERT INTO migrations VALUES(13,'2026_06_05_150002_create_kol_profiles_table',1);
INSERT INTO migrations VALUES(14,'2026_06_05_150003_create_kol_social_accounts_table',1);
INSERT INTO migrations VALUES(15,'2026_06_05_150004_create_kol_portfolios_table',1);
INSERT INTO migrations VALUES(16,'2026_06_05_150005_create_kol_rate_cards_table',1);
INSERT INTO migrations VALUES(17,'2026_06_05_150006_create_campaigns_table',1);
INSERT INTO migrations VALUES(18,'2026_06_05_150007_create_hirings_table',1);
INSERT INTO migrations VALUES(19,'2026_06_05_150008_create_hiring_applications_table',1);
INSERT INTO migrations VALUES(20,'2026_06_05_150009_create_chat_rooms_table',1);
INSERT INTO migrations VALUES(21,'2026_06_05_150010_create_chat_messages_table',1);
INSERT INTO migrations VALUES(22,'2026_06_05_150011_create_agreements_table',1);
INSERT INTO migrations VALUES(23,'2026_06_05_150012_create_contents_table',1);
INSERT INTO migrations VALUES(24,'2026_06_05_150013_create_content_revisions_table',1);
INSERT INTO migrations VALUES(25,'2026_06_05_150014_create_payments_table',1);
INSERT INTO migrations VALUES(26,'2026_06_05_150015_create_escrow_transactions_table',1);
INSERT INTO migrations VALUES(27,'2026_06_05_150016_create_kol_withdrawals_table',1);
INSERT INTO migrations VALUES(28,'2026_06_05_150017_create_ratings_table',1);
INSERT INTO migrations VALUES(29,'2026_06_05_150018_create_platform_reviews_table',1);
INSERT INTO migrations VALUES(30,'2026_06_05_150019_create_notifications_table',1);
INSERT INTO migrations VALUES(31,'2026_06_05_150020_create_disputes_table',1);
INSERT INTO migrations VALUES(32,'2026_06_05_150021_create_app_settings_table',1);
INSERT INTO migrations VALUES(33,'2026_06_05_150022_add_proof_path_to_kol_withdrawals_table',1);
INSERT INTO migrations VALUES(34,'2026_06_05_150022_create_kol_bank_accounts_table',1);
INSERT INTO migrations VALUES(35,'2026_06_05_161000_add_tracking_fields_to_contents_table',1);
INSERT INTO migrations VALUES(36,'2026_06_08_190702_add_notes_to_kol_withdrawals_table',2);
