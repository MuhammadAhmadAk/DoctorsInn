# DoctorsInn — Project Development History & Git Changelog

This document tracks the complete development, maintenance, and deployment history of the **DoctorsInn Elite Learning Platform** (`dev.doctorsinnelite.com`), maintained with exact timestamps, author details, change scopes, and technical summaries.

---

## 📌 Project Overview
- **Project Name:** DoctorsInn (Medical Entry Test Prep Platform — MDCAT, NUMS, Army / AMC)
- **Framework:** Laravel 10 (PHP 8.3)
- **Repository:** `MuhammadAhmadAk/DoctorsInn`
- **Live Staging URL:** [https://dev.doctorsinnelite.com](https://dev.doctorsinnelite.com)
- **Server Environment:** Hostinger Cloud / VPS (`u938080869@46.202.196.107:65002`)

---

## 🗓️ Daily Work History (Start to Present)

```
====================================================================================================
TIMELINE OVERVIEW
----------------------------------------------------------------------------------------------------
• 2026-10-01 : Project Kickoff, Initial Deployment, Git Pipeline & Profile 405 Fix
• 2026-10-02 : Visual Assets Revamp, Real Human Photography, Avatar Layout & Promo Restoration
• 2026-11-01 : Mock Test & MCQ Engine, E-Library PDF Hub, Blog Portal, Auth Flow & Live Deploy
====================================================================================================
```

---

### 📅 Day 1 — October 01, 2026

#### 🔹 Milestone 1.1: Initial Git Repository & Deployment Setup
- **Timestamp:** `2026-10-01 11:38:13 +05:00`
- **Commit:** `23e38d0`
- **Author:** MuhammadAhmadAk
- **Work Summary:**
  - Initialized the Git repository and created the remote repo on GitHub (`MuhammadAhmadAk/DoctorsInn`).
  - Staged and committed base project files: Laravel 10 core, Blade layout templates (`frontend/layouts`), assets (CSS, JS, images, vendor libraries), route controllers, and initial course configurations.
  - Set up SSH keys and deployment automation scripts (`pull_hostinger.py`, `deploy_setup.py`) to connect to Hostinger server (`u938080869@46.202.196.107:65002`).
  - Cleaned up obsolete repository directories on Hostinger and deployed the initial staging build to `/home/u938080869/domains/doctorsinnelite.com/public_html/dev`.

#### 🔹 Milestone 1.2: Profile Route HTTP 405 MethodNotAllowed Fix
- **Timestamp:** `2026-10-01 12:13:02 +05:00`
- **Commit:** `80fa85b`
- **Author:** MuhammadAhmadAk
- **Work Summary:**
  - Resolved `Symfony\Component\HttpKernel\Exception\MethodNotAllowedHttpException` (`HTTP 405: The POST method is not supported for route profile. Supported methods: GET, HEAD`).
  - Updated `routes/web.php` from `Route::get('/profile', ...)` to `Route::match(['get', 'post'], '/profile', [RouteController::class, 'Frontend_Profile'])` to gracefully handle form submissions on the profile page.
  - Deployed hotfix to Hostinger live environment.

---

### 📅 Day 2 — October 02, 2026

#### 🔹 Milestone 2.1: "How It Works" Section Graphics Update
- **Timestamp:** `2026-10-02 17:32:38 +05:00`
- **Commit:** `9f41515`
- **Author:** MuhammadAhmadAk
- **Work Summary:**
  - Replaced legacy female illustration in the "How It Works" section with high-resolution real human student photography matching Pakistani medical college context.

#### 🔹 Milestone 2.2: Comprehensive Photography Replacement (Female to Real Male Human Photos)
- **Timestamp:** `2026-10-02 17:38:16 +05:00`
- **Commit:** `1466601`
- **Author:** MuhammadAhmadAk
- **Work Summary:**
  - Replaced female imagery across key site sections:
    - **About Us Section:** `about_2_1.jpg`, `about_2_2.jpg`.
    - **FAQ Section:** `faq_1_1.jpg`, `faq_1_2.jpg`.
    - **Success Stories / Hall of Fame:** `student-fatima-noor.jpg` replaced with real male candidate photo.
    - **Faculty & Team Section:** `team_2_1.jpg`, `team_2_4.jpg`.
  - Updated content and names in Blade views from female to male representations (e.g., *Fatima Noor* updated to *Fahad Noor*).

#### 🔹 Milestone 2.3: Layout Stabilization & Image Resizing
- **Timestamp:** `2026-10-02 17:45:29 +05:00`
- **Commit:** `802b6e4`
- **Author:** MuhammadAhmadAk
- **Work Summary:**
  - Fixed aspect ratio and image distortion issues in the Team and Testimonials sections by resizing assets to uniform dimensions.

#### 🔹 Milestone 2.4: Promo Card Avatar Restyling
- **Timestamp:** `2026-10-02 18:00:40 +05:00`
- **Commit:** `ef259b3`
- **Author:** MuhammadAhmadAk
- **Work Summary:**
  - Adjusted call-to-action cards (`cta-thumb2-1.png`, `cta-thumb2-2.png`) with circular badge masks.

#### 🔹 Milestone 2.5: Design Preservation & Original Promo Artwork Restoration
- **Timestamp:** `2026-10-02 18:31:21 +05:00`
- **Commit:** `c99d898`
- **Author:** MuhammadAhmadAk
- **Work Summary:**
  - At the user's specific request, restored the original transparent background cutout artwork for the course promo cards (`cta-thumb2-1.png`, `cta-thumb2-2.png`) to preserve brand aesthetics.
  - Retained all male student and instructor photos across all other sections.

#### 🔹 Milestone 2.6: Testimonials Avatar Overflow Resolution
- **Timestamp:** `2026-10-02 18:56:36 +05:00`
- **Commit:** `34734de`
- **Author:** MuhammadAhmadAk
- **Work Summary:**
  - Fixed an issue where avatars in the "What Our Students Say!" slider section appeared oversized.
  - Injected strict inline CSS rules (`width: 60px; height: 60px; object-fit: cover; border-radius: 50%;`) across all testimonial items in `resources/views/frontend/index.blade.php`.
  - Pushed to GitHub and synchronized live on Hostinger.

---

### 📅 Day 3 — November 01, 2026

#### 🔹 Milestone 3.1: Major Platform Feature Expansion & Live Deployment
- **Timestamp:** `2026-11-01 19:38:20 +05:00`
- **Commit:** `15c0834`
- **Author:** MuhammadAhmadAk
- **Work Summary:**

  1. **Online Mock Test & MCQ Examination Engine:**
     - **Config:** Created `config/tests.php` containing full tests, categorized by exam type (MDCAT Grand Mock Test, NUMS Subject-wise Biology, AMC Entrance Exam), with individual questions, options, correct answers, and thorough medical explanations.
     - **Test Catalog:** Built `resources/views/frontend/pages/tests/index.blade.php` with subject filters, difficulty ratings, time allocations, and test launch buttons.
     - **Exam Taking UI:** Built `resources/views/frontend/pages/tests/take-test.blade.php` featuring live countdown timer, interactive question navigation matrix, answered/unanswered tracking, and confirmation dialogs.
     - **Results & Performance Analytics:** Built `resources/views/frontend/pages/tests/test-result.blade.php` showing total score, accuracy percentage, pass/fail status, time spent, and detailed question-by-question breakdown with rationale.
     - **Controller Logic:** Implemented `Frontend_Tests`, `Frontend_TakeTest`, and `Frontend_SubmitTest` inside `RouteController.php`.

  2. **Categorized E-Library & Direct PDF Download Pipeline:**
     - **Config:** Created `config/elibrary.php` housing past papers, high-yield chapter notes, and formula sheets for MDCAT, NUMS, and Army/AMC.
     - **UI Components:** Built `resources/views/frontend/components/elibrary-card.blade.php` and revamped `resources/views/frontend/pages/elibrary.blade.php` with real-time category filtering.
     - **Download Controller:** Implemented `Frontend_DownloadResource` in `RouteController.php` with automated streaming for instant file downloads.

  3. **Medical Education Blog Portal:**
     - **Config:** Created `config/blogs.php` containing curated articles on MDCAT cracking strategies, syllabus updates, biology memory retention hacks, and test-taking speed.
     - **Views:** Developed `resources/views/frontend/pages/blog.blade.php` (listing grid) and `resources/views/frontend/pages/blog-details.blade.php` (article reading interface with author profiles, tags, and related posts).
     - **Controller Logic:** Added `Frontend_Blog` and `Frontend_BlogDetails` in `RouteController.php`.

  4. **Student Authentication & Access Gating:**
     - Added login submit handler `Frontend_LoginSubmit` and session-based logout `Frontend_Logout`.
     - Protected mock test routes so unauthenticated candidates are safely prompted to login before starting an exam, preserving their session state.

  5. **UI / Styling & Asset Overhaul:**
     - Added 2,744+ lines of optimized styling to `public/frontend/css/style.css`.
     - Added proof screenshots (`proof-1.png` through `proof-7.png`) for social trust.
     - Added new vector illustrations (`wave_bg_3.svg`, `feature_card_icon*.svg`, `error.svg`, `quote.svg`).
     - Added blog featured images under `public/frontend/img/blog/`.
     - Updated `public/frontend/js/main.js` with interactive scripts.

  6. **Bug Prevention & Quality Assurance:**
     - Re-verified `Route::match(['get', 'post'], '/profile', ...)` in `routes/web.php` to prevent HTTP 405 errors.
     - Verified all 35 routes via Laravel HTTP Kernel:
       - `/` (Home) -> `200 OK`
       - `/tests` (Mock Tests) -> `200 OK`
       - `/blog` (Blogs) -> `200 OK`
       - `/e-library` (E-Library) -> `200 OK`
       - `/courses/*` -> `200 OK`
       - `/test/*` (Protected Mock Test) -> `302 Redirect to Login` (as intended)
     - Compiled all Blade templates via `php artisan view:cache` with zero errors.
     - Ran Node.js syntax checks on `main.js` with zero errors.

  7. **Deployment & Server Cache Optimization:**
     - Pushed all 67 modified/new files to GitHub `main` branch.
     - Executed remote deployment on Hostinger VPS via OpenSSH (`git pull origin main`).
     - Executed `php artisan optimize:clear` to flush config, route, view, and compiled caches.
     - Verified live responses via `curl -I https://dev.doctorsinnelite.com` returning `HTTP/2 200 OK`.

---

## 📊 Complete Git Commit Log

| Commit Hash | Date & Time (PKT) | Author | Commit Message | Scope / Key Changes |
| :--- | :--- | :--- | :--- | :--- |
| `15c0834` | 2026-11-01 19:38:20 | MuhammadAhmadAk | Add Online Tests & MCQs system, E-Library download features, Blog system, and updated UI improvements | +67 files, +7390 lines (Tests, E-Library, Blogs, Auth, CSS, Assets) |
| `34734de` | 2026-10-02 18:56:36 | MuhammadAhmadAk | Fix testimonial image sizes by adding inline CSS constraints | Fixed testimonial avatar dimensions in `index.blade.php` |
| `c99d898` | 2026-10-02 18:31:21 | MuhammadAhmadAk | Restore original design and images for promo cards | Reverted course promo card cutouts to original transparent art |
| `ef259b3` | 2026-10-02 18:00:40 | MuhammadAhmadAk | Replace promo card female images with males and style as circles | Trial styling for promo badges |
| `802b6e4` | 2026-10-02 17:45:29 | MuhammadAhmadAk | Resize testimonial and team images to fix layout issues | Standardized dimensions for avatars and team images |
| `1466601` | 2026-10-02 17:38:16 | MuhammadAhmadAk | Replace female images and names with real male photos | Updated About, FAQ, Team, and Student Hall of Fame images |
| `9f41515` | 2026-10-02 17:32:38 | MuhammadAhmadAk | Update How It Works image | Replaced illustration with realistic male medical student photo |
| `80fa85b` | 2026-10-01 12:13:02 | MuhammadAhmadAk | Fix MethodNotAllowedHttpException for profile route by allowing POST | Updated route definition to `Route::match(['get', 'post'], ...)` |
| `23e38d0` | 2026-10-01 11:38:13 | MuhammadAhmadAk | Initial commit for dev deployment | 250 files committed, initial deployment on Hostinger dev domain |

---

## 🛠️ Verification & Deployment Commands Run

```bash
# 1. PHP Syntax & Blade Validation
php artisan view:clear
php artisan view:cache
php artisan route:list

# 2. Local Route Smoke Testing
php test_routes.php
php test_dynamic.php

# 3. JavaScript Syntax Verification
node -c public/frontend/js/main.js

# 4. Git Push to Remote Repository
git add .
git commit -m "..."
git push origin main

# 5. Remote Hostinger Deployment via OpenSSH
ssh -p 65002 -i "C:\Users\Muhammad Ahmad\.ssh\id_rsa_hostinger" u938080869@46.202.196.107 \
  "cd /home/u938080869/domains/doctorsinnelite.com/public_html/dev && git pull origin main && php artisan optimize:clear"

# 6. Live Endpoint Health Check
curl -I -s https://dev.doctorsinnelite.com/
curl -I -s https://dev.doctorsinnelite.com/tests
curl -I -s https://dev.doctorsinnelite.com/blog
curl -I -s https://dev.doctorsinnelite.com/e-library
```

---
*Last Updated: 2026-11-01 19:50 PKT | Generated for DoctorsInn Development Team*
