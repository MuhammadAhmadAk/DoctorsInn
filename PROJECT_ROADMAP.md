# DoctorsInn — Remaining Roadmap (after Phase 3)

Phases 1–3 are done and deployed (security, real DB data, enrollments/payments/staff roles). Details of completed work: `PROJECT_WORK_HISTORY.md`.

## Phase 4 — Media / ops hardening (Implemented & Ready for Server Execution)

1. [x] **Lecture delete endpoint** — `DELETE /admin/lectures/{video}` in `AdminLectureController::destroy()` removes DB row, HLS directory, source file, logs, and progress records. Integrated into Course Studio UI ("Remove" button with confirmation).
2. [x] **Orphan media cleanup command** — `php artisan lectures:cleanup-orphans` (`app/Console/Commands/CleanupOrphanMediaCommand.php`) scans for unlinked HLS dirs (`hls/*`), unmapped originals, unreferenced DB lectures (`--prune-unlinked-db`), and stale pending orders older than 48 hours (`--prune-stale-orders`).
3. [x] **Duplicate lecture cleanup** — handled by `lectures:cleanup-orphans --delete --prune-unlinked-db` which prunes duplicate/stale records (lectures 9, 10, 11) and orphan HLS folders on server.
4. [x] **Workerless upload architecture** — detached CLI process runner (`lectures:process {id}`) configured with ultrafast/superfast presets and polling recovery.
5. [x] **Queue-worker heartbeat cron** — deprecated; no longer required with detached process model.

## Phase 5 — Hygiene

1. **Dead code removal** — unused queue/worker remnants, legacy `mock_tests.questions` JSON fallback once every test uses the question bank, obsolete MP4 fast-start path if unused, leftover config files.
2. **CMS cache TTL** — `SiteContentService` currently relies on flush-on-write; add a TTL/versioned cache so a missed flush cannot serve stale content indefinitely.
3. **Automated tests** — feature tests for auth gates, enrollment/Safepay state transitions, MCQ scoring, question-bank CRUD. The repo currently has only skeleton PHPUnit tests.

## Go-live checklist (payments + accounts)

- Request **Raast/EasyPaisa/JazzCash wallet enablement** from Safepay for sandbox and live. Sandbox tracker capabilities on this merchant: `CYBERSOURCE=true, MPGS=true, PAYFAST=true, RAAST=false` — hosted checkout shows card only. No code change needed; `SAFEPAY_INTENT` env exists.
- Register the webhook URL `https://dev.doctorsinnelite.com/webhooks/safepay` in the Safepay dashboard.
- Complete one real sandbox payment; classroom should unlock automatically (webhook + tracker polling).
- Before live: `SAFEPAY_ENVIRONMENT=production` + live keys; rotate the Safepay secret key and webhook secret (they were shared in chat during testing).
- Rotate the GitHub PAT and the server SSH password (shared in chat 2026-11-13; the git remote URL embeds the PAT — never echo it).
- Google OAuth: if any Google account should sign in, publish the app in Google Cloud (current consent screen mode determines this; Testing = test users only).
- Change the dev admin default password.

## Open design decision (not actioned)

Gated catalog links in the guest header: keep E-Library / Practice Tests visible (hybrid = public browse for SEO, login gate on download/attempt); optionally a small lock or "Student" badge. The user only asked for wording fixes so far — revisit only if he raises visibility again.

## Deployment rules

- Dev subdomain is the production target.
- Deploy only after an explicit user "deploy karo": commit → `git push origin main` → on server `git pull origin main` → `php artisan view:clear && php artisan config:clear && php artisan cache:clear` → verify on dev.
- Migrations on deploy: `php artisan migrate --force`.
- Never store or echo credentials in docs, commits, or logs.
