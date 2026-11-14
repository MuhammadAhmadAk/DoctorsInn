# DoctorsInn — Work History (13–14 Nov 2026)

Mirror of the agent memory file `project-work-history.md`. Use this to brief a new developer/agent. Everything below is implemented, committed and deployed to the dev subdomain unless stated otherwise. Working tree is clean except untracked `public/uploads/` (local artifacts, do not commit).

> Dev subdomain **is** the production target: `https://dev.doctorsinnelite.com`
> App dir on Hostinger: `~/domains/doctorsinnelite.com/public_html/dev`
> Deploy: commit → `git push origin main` → `ssh hostinger_server` pull + `php artisan view:clear config:clear cache:clear` — only after the user explicitly says "deploy karo".

## Current state (end of 2026-11-14)

- Latest commit: `2e59037` — enrollment success popup. Branch `main`.
- Dev admin account seeded on 2026-11-14 (admin only, no CMS/testimonial seeding). Login verified (`/admin/login` → 302 → `/admin`, dashboard 200). Default seeded password must be changed by the user.
- Dev DB: demo content wiped (backups: `storage/app/demo-content-backup-20261114-*.json`), 6 testimonials re-seeded, 4 backfilled enrollments, Safepay sandbox keys in dev `.env`, Google OAuth configured.
- Only course slug on dev is misspelled: `mdcat-prepration`.
- Local XAMPP has almost no data; dev is the acceptance environment.

## 2026-11-13 — commits in order

### Student classroom curriculum
- `9a59747` interactive Quiz Studio (late 12 Nov)
- `e70a3af` 3-tier hierarchy: Modules → Chapters → Topics & Quizzes
- `825f112` cache-busting query params for classroom data
- `0500d95` flat tree outline, no heavy tabs
- `7145fa0` ultra-clean single-line topic rows
- `c5be235` collapsible modules, module 1 open by default

### Admin course builder studio
- `29ad4bc` 3-tier curriculum builder matching student classroom
- `48287ea` courses + curriculum moved to DB; direct video/PDF upload with progress bars
- `a55fc8d` public course details supports both 3-tier and legacy curriculum
- `5394708` removed auto course-sync + config fallback; admin CRUD is the single source
- `7e018e5` removed useless static JS/setup files
- `b424549`, `2253959`, `64ad1a0`, `791c7c4`, `b31829d` studio/player UI cleanup, 8px radii, 26px buttons

### Staff access module
- `bb697ce` admin staff access management + sidebar labels
- `d5c7cae`, `2e6bcf4` permissions table UI refinements

### Lecture video pipeline (HLS)
- `395365b` topic video uploads with signed direct playback + HLS
- `ea84172` transcoding survives the HTTP request (shared hosting)
- `bad75b1` x264 thread cap so encoding starts
- `f8b64ce` multi-hour lecture support
- `f034f8f` 3 s segments + 360p first rung
- `b014240` HLS branding hidden, `2253959` player cleanup
- `6be99fc` EBU R128 loudness normalization (−16 LUFS)
- `096f2bf` quiet buffering feedback, `1eb4df5` rendition cap above 1× speed
- `5604e92` final ladder: 6 s segments + 240/360/480/720/1080p (reprocessed lectures 5–7, verified)

### MP4 fast-start (direct non-HLS uploads)
- `ef58a30` pure-PHP moov-atom relocator
- `197f85b` / `af45ac1` / `2ec3779` runs after the HTTP response via `terminating()`
- `0e8f92b` upload cancellation + state-overlap fix
- Note: HLS pipeline above is the real delivery path; this was a speed experiment.

### Misc
- `db9c85a` removed leftover course-builder tags
- Recurring pain: the persistent queue worker died repeatedly on dev (details in memory `project-video-streaming-ops.md`).

## 2026-11-14 — commits in order

1. `e12a840` topic duration auto-filled from uploaded video; curriculum builder UI cleaned.
2. `528fc9a` **Phase 1 security** — removed hardcoded login fallbacks, DB-only auth, admin role check, `throttle:5,1` on login/register, Auth-only authorization, `session('user')` demoted to display cache.
3. `d6be5c5` mobile hamburger moved into header right cluster.
4. `bc16e9a` **Phase 2 real data** — `test_attempts` + notifications tables, `StudentMetricsService`, real student/admin KPIs + history, real E-Library upload + download counter, code-based password reset, navbar bell/streak. Gotchas: config tests had fake ids (resolve by slug); `elibrary_resources.downloads` normalized to INT; legacy migrations need `hasTable` guards.
5. `5322f83` E-Library upload metadata autofill from selected file.
6. `9c52fa6` **hybrid access gating** — public `/e-library` and `/tests` catalogs stay for SEO; downloads and test take/submit/result require student login (`?redirect=`), guest notices + "LOGIN TO DOWNLOAD".
7. `8f56aeb` **demo content removed** — deleted `config/blogs.php`, courses/tests/elibrary demo datasets, `courses_curriculum.json`, `courses:sync-db`, demo methods in `SiteCmsSeeder`, hardcoded Blade/`SiteContentService` fallbacks; empty home sections hidden; DB demo rows backed up then wiped.
8. `0a08116` six realistic home-page testimonials re-seeded (user does not accept an empty home page).
9. `4bf842e` + `05ee2d2` public naming "Mock Tests" → "Practice Tests" (header/footer/tests page). Student LMS still says Mock Test.
10. `4bd9861` admin upload progress polling survives tab throttling/JS errors (`visibilitychange`, `no-store`).
11. `9d5a821` x264 presets ultrafast/superfast (~30% faster; clean remeasure pending).
12. `c69b855` + `ef72946` **workerless lecture processing** — admin controller spawns detached `php artisan lectures:process {id}`; single-command nohup only (compound commands block the upload response); queue remains a fallback.
13. `643a379` **MCQ question bank** — `mock_test_questions` table, `MockTestQuestion`, admin add/edit/delete UI, student engine reads the same shape, `total_questions` auto-syncs, empty tests hidden from the public catalog.
14. `b7d1d86` + `cc88f87` **Phase 3** — orders/enrollments + backfill, Safepay hosted checkout, webhook + tracker polling, enrollment required for classroom/streaming (admin bypass), admin Enrollments page, staff roles (`config/staff.php` + `admin.permission:{perm}`), real student progress. Safepay metadata sends only `order_id`.
15. `0604cda` professional checkout redesign (steps bar, billing form, order summary, trust row; wallet badges removed) + `SAFEPAY_INTENT` env (default `CYBERSOURCE`).
16. `2e59037` enrollment success modal on student dashboard after paid/free enrollment ("Start Learning" → classroom). Verified end-to-end.

## 2026-11-15 — Phase 4 & Course Reviews

1. **Phase 4 Media / Ops Hardening**:
   - `AdminLectureController::destroy()` endpoint (`DELETE /admin/lectures/{video}`) for permanent removal of DB row, HLS directory, source file, progress records, and log files.
   - Course Studio UI integration: "Remove" button confirms permanent server storage deletion vs simple detach.
   - `CleanupOrphanMediaCommand` (`php artisan lectures:cleanup-orphans`): Artisan command to scan and purge unlinked HLS folders (`hls/*`), unmapped original video files, unreferenced DB lecture rows (`--prune-unlinked-db`), and abandoned pending orders older than 48h (`--prune-stale-orders`).
2. **Course Reviews System & Admin Module**:
   - Migration `create_course_reviews_table`, `CourseReview` model with relation to `Course` and `User`.
   - `CourseReviewController::store` with validation, rate-limiting (`throttle:6,1`), and dynamic updates to course aggregate rating.
   - Admin Reviews management module (`/admin/reviews`) with KPI summary cards, course quick-filter breakdown pills with review counts & average ratings, search, status toggles (Approve/Reject), and delete.
   - Sidebar updated with "Student Reviews" navigation item and live badge.
   - Course details page redesign: price formatting (`Rs. 300` / `Rs. 1,500`), button heights/alignment, compact modern card styling, and interactive 5-star review submission form.

See `PROJECT_ROADMAP.md` for the remaining phases and the go-live checklist.
