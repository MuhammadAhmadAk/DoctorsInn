@extends('frontend.layouts.main')
@section('title', 'Notifications | DoctorsInnElite')
@section('meta_description', 'Stay updated with your latest notifications on DoctorsInnElite — course updates, new resources, announcements and more.')
@section('meta_keywords', 'DoctorsInnElite notifications, course updates, student alerts')
@section('content')

    <div class="breadcumb-wrapper">
        <div class="container">
            <div class="row">
                <div class="col-lg-7">
                    <div class="breadcumb-content">
                        <h1 class="breadcumb-title">Notifications</h1>
                        <ul class="breadcumb-menu">
                            <li><a href="{{ route('home') }}">Home</a></li>
                            <li>Notifications</li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Notifications Area -->
    <section class="space-top space-bottom overflow-hidden bg-color" id="notification-section">
        <div class="container">
            <div class="row gy-40">
                <!-- Left Navigation Column -->
                <div class="col-lg-4">
                    <div class="notification-sidebar-menu">
                        <a href="javascript:void(0)" class="notification-nav-link active" data-filter="all">
                            <span><i class="fal fa-list-ul"></i>All Notifications</span>
                            <span class="notification-count" id="count-all">5</span>
                        </a>
                        <a href="javascript:void(0)" class="notification-nav-link" data-filter="unread">
                            <span><i class="fal fa-envelope"></i>Unread</span>
                            <span class="notification-count" id="count-unread">3</span>
                        </a>
                        <a href="javascript:void(0)" class="notification-nav-link" data-filter="announcement">
                            <span><i class="fal fa-bullhorn"></i>Announcements</span>
                            <span class="notification-count" id="count-announcement">2</span>
                        </a>
                        <a href="javascript:void(0)" class="notification-nav-link" data-filter="system">
                            <span><i class="fal fa-exclamation-triangle"></i>System Alerts</span>
                            <span class="notification-count" id="count-system">1</span>
                        </a>
                    </div>
                </div>

                <!-- Right Content Column -->
                <div class="col-lg-8">
                    <div class="notification-card">
                        <div class="notification-header">
                            <h3 id="panel-title">All Notifications</h3>
                            <button class="mark-read-btn" id="markAllReadBtn">Mark all as read</button>
                        </div>

                        <div class="notification-list">
                            <!-- Notification 1 -->
                            <div class="notification-item unread announcement-item" data-id="1">
                                <div class="notification-icon-wrap icon-announcement">
                                    <i class="fa-regular fa-bullhorn"></i>
                                </div>
                                <div class="notification-body">
                                    <h4 class="notification-title">
                                        <span>MDCAT 2026 Batch: Registrations Open!</span>
                                        <span class="unread-indicator"></span>
                                    </h4>
                                    <p class="notification-text">Get 30% discount on early registration for
                                        doctors prep course. Enroll today to access pre-recorded lectures and
                                        diagnostic mock tests.</p>
                                    <p class="notification-time"><i class="fal fa-clock"></i>2 hours ago</p>
                                </div>
                                <button class="dismiss-notification-btn" title="Dismiss"><i
                                        class="fal fa-times"></i></button>
                            </div>

                            <!-- Notification 2 -->
                            <div class="notification-item unread course-item" data-id="2">
                                <div class="notification-icon-wrap icon-course">
                                    <i class="fa-regular fa-book"></i>
                                </div>
                                <div class="notification-body">
                                    <h4 class="notification-title">
                                        <span>New Chemistry Quiz Uploaded</span>
                                        <span class="unread-indicator"></span>
                                    </h4>
                                    <p class="notification-text">Instructor Sarah Lee uploaded "Module 3:
                                        Chemical Equilibrium Practice MCQ Quiz". Test your chemistry skills now!
                                    </p>
                                    <p class="notification-time"><i class="fal fa-clock"></i>Yesterday</p>
                                </div>
                                <button class="dismiss-notification-btn" title="Dismiss"><i
                                        class="fal fa-times"></i></button>
                            </div>

                            <!-- Notification 3 -->
                            <div class="notification-item system-item" data-id="3">
                                <div class="notification-icon-wrap icon-alert">
                                    <i class="fa-regular fa-triangle-exclamation"></i>
                                </div>
                                <div class="notification-body">
                                    <h4 class="notification-title">Password Changed Successfully</h4>
                                    <p class="notification-text">Your student account password was updated. If
                                        you did not perform this change, please contact student support
                                        immediately.
                                    </p>
                                    <p class="notification-time"><i class="fal fa-clock"></i>3 days ago</p>
                                </div>
                                <button class="dismiss-notification-btn" title="Dismiss"><i
                                        class="fal fa-times"></i></button>
                            </div>

                            <!-- Notification 4 -->
                            <div class="notification-item unread course-item" data-id="4">
                                <div class="notification-icon-wrap icon-success">
                                    <i class="fa-regular fa-circle-check"></i>
                                </div>
                                <div class="notification-body">
                                    <h4 class="notification-title">
                                        <span>Mock Test Scored: 95% Correct</span>
                                        <span class="unread-indicator"></span>
                                    </h4>
                                    <p class="notification-text">Congratulations Ahmed! You completed MDCAT
                                        Biology Practice Test 2 and scored 190/200 marks. Outstanding
                                        performance!
                                    </p>
                                    <p class="notification-time"><i class="fal fa-clock"></i>4 days ago</p>
                                </div>
                                <button class="dismiss-notification-btn" title="Dismiss"><i
                                        class="fal fa-times"></i></button>
                            </div>

                            <!-- Notification 5 -->
                            <div class="notification-item announcement-item" data-id="5">
                                <div class="notification-icon-wrap icon-announcement">
                                    <i class="fa-regular fa-bullhorn"></i>
                                </div>
                                <div class="notification-body">
                                    <h4 class="notification-title">PMDC Syllabus Guidelines Updated</h4>
                                    <p class="notification-text">The official PMDC MDCAT prep guidelines have
                                        been released. We have updated all lesson modules to conform with the
                                        revised curriculum.</p>
                                    <p class="notification-time"><i class="fal fa-clock"></i>1 week ago</p>
                                </div>
                                <button class="dismiss-notification-btn" title="Dismiss"><i
                                        class="fal fa-times"></i></button>
                            </div>
                        </div>

                        <!-- Empty State -->
                        <div class="empty-notifications-state" id="emptyState">
                            <i class="fal fa-bell-slash"></i>
                            <h4>No notifications found</h4>
                            <p>You have cleared all alerts in this folder.</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

@endsection
