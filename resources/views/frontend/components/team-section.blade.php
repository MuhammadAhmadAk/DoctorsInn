@php
    $teamList = !empty($instructors) ? $instructors : [
        ['name' => 'Dr. Salman Tariq', 'designation' => 'Biology Lead Instructor', 'image' => 'frontend/img/team/team_2_1.jpg', 'rating' => '4.9', 'facebook_url' => 'https://facebook.com/', 'twitter_url' => 'https://twitter.com/', 'linkedin_url' => 'https://linkedin.com/', 'instagram_url' => 'https://instagram.com/'],
        ['name' => 'Prof. Michel Jemison', 'designation' => 'Chemistry Specialist', 'image' => 'frontend/img/team/team_2_2.jpg', 'rating' => '4.9', 'facebook_url' => 'https://facebook.com/', 'twitter_url' => 'https://twitter.com/', 'linkedin_url' => 'https://linkedin.com/', 'instagram_url' => 'https://instagram.com/'],
        ['name' => 'Prof. Jacob Jones', 'designation' => 'Physics & Numericals Expert', 'image' => 'frontend/img/team/team_2_3.jpg', 'rating' => '4.9', 'facebook_url' => 'https://facebook.com/', 'twitter_url' => 'https://twitter.com/', 'linkedin_url' => 'https://linkedin.com/', 'instagram_url' => 'https://instagram.com/'],
        ['name' => 'Dr. Hamza Malik', 'designation' => 'AMC & Logical Mentor', 'image' => 'frontend/img/team/team_2_4.jpg', 'rating' => '4.9', 'facebook_url' => 'https://facebook.com/', 'twitter_url' => 'https://twitter.com/', 'linkedin_url' => 'https://linkedin.com/', 'instagram_url' => 'https://instagram.com/'],
    ];
@endphp
<section class="overflow-hidden bg-color" id="team-sec">
    <div class="team-wrap2 space overflow-hidden">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-xl-6">
                    <div class="title-area text-center">
                        <span class="sub-title text-theme th_fade_anim">
                            <img src="{{ asset('frontend/img/logo/logo-icon.svg') }}" alt="img">{{ $cms['team_subtitle'] ?? 'Our Teachers' }}
                        </span>
                        <h2 class="sec-title th_fade_anim"><span class="th-text-perspective">{{ $cms['team_title'] ?? 'Meet Our Professional Teachers' }}</span></h2>
                    </div>
                </div>
            </div>
            <div class="slider-area">
                <div class="swiper th-slider has-shadow team-slider2" id="teamSlider2"
                    data-slider-options='{"breakpoints":{"0":{"slidesPerView":1},"576":{"slidesPerView":"1"},"768":{"slidesPerView":"2"},"992":{"slidesPerView":"3"},"1200":{"slidesPerView":"4"}}}'>
                    <div class="swiper-wrapper">
                        @foreach($teamList as $member)
                        <div class="swiper-slide">
                            <div class="team-card2 th_fade_anim">
                                <div class="box-img">
                                    <img src="{{ asset($member['image'] ?: 'frontend/img/team/team_2_1.jpg') }}" alt="{{ $member['name'] }}" loading="lazy" decoding="async">
                                    <div class="th-social">
                                        @if(!empty($member['facebook_url']))<a target="_blank" href="{{ $member['facebook_url'] }}" rel="noopener"><i class="fab fa-facebook-f"></i></a>@endif
                                        @if(!empty($member['twitter_url']))<a target="_blank" href="{{ $member['twitter_url'] }}" rel="noopener"><i class="fab fa-twitter"></i></a>@endif
                                        @if(!empty($member['linkedin_url']))<a target="_blank" href="{{ $member['linkedin_url'] }}" rel="noopener"><i class="fab fa-linkedin-in"></i></a>@endif
                                        @if(!empty($member['instagram_url']))<a target="_blank" href="{{ $member['instagram_url'] }}" rel="noopener"><i class="fab fa-instagram"></i></a>@endif
                                    </div>
                                </div>
                                <div class="box-content">
                                    <h3 class="box-title">{{ $member['name'] }}</h3>
                                    <p class="box-text">{{ $member['designation'] ?? 'Instructor' }}</p>
                                    <div class="box-rating">
                                        <i class="fas fa-star"></i> <i class="fas fa-star"></i>
                                        <i class="fas fa-star"></i> <i class="fas fa-star"></i> <i class="fas fa-star"></i>
                                        <span class="ms-2">({{ $member['rating'] ?? '4.9' }})</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
