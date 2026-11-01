<div class="course-card">
    <div class="box-img">
        <a href="{{ route('course-details', $courseItem['slug']) }}">
            <img src="{{ asset($courseItem['image']) }}" alt="{{ $courseItem['title'] }}">
        </a>
        @if (!empty($courseItem['success_badge']))
            <span class="course-success-badge">
                <i class="fa-solid fa-award" aria-hidden="true"></i>{{ $courseItem['success_badge'] }}
            </span>
        @endif
        <span class="box-price">
            {{ $courseItem['price'] }}
            @if (!empty($courseItem['original_price']))
                <del class="text-muted ms-1 small legacy-inline-c3b97501f8">{{ $courseItem['original_price'] }}</del>
            @endif
        </span>
    </div>
    <h3 class="box-title">
        <a href="{{ route('course-details', $courseItem['slug']) }}">{{ $courseItem['title'] }}</a>
    </h3>
    <div class="box-rating">
        <div class="star-rating" role="img" aria-label="Rated {{ $courseItem['rating'] }} out of 5">
            <span class="star-rating-full">
                Rated <strong class="rating">{{ $courseItem['rating'] }}</strong> out of 5
            </span>
        </div>
        <span class="ms-2">⭐ {{ $courseItem['rating'] }} ({{ $courseItem['rating_count'] ?? '1k+' }})</span>
    </div>
    <div class="box-content">
        <div class="course-info">
            <div class="box-icon"><i class="fal fa-file-lines"></i></div>
            <div class="course-info-details">
                <span class="course-info-title">Lessons:</span>
                <h4 class="course-info-text">{{ $courseItem['lessons'] }}</h4>
            </div>
        </div>
        <div class="course-info">
            <div class="box-icon"><i class="fal fa-users"></i></div>
            <div class="course-info-details">
                <span class="course-info-title">Students:</span>
                <h4 class="course-info-text">{{ $courseItem['students'] }}</h4>
            </div>
        </div>
    </div>
    <div class="btn-wrap">
        <div class="meta-box">
            <div class="meta-thumb">
                <img src="{{ asset($courseItem['instructor_image']) }}" alt="{{ $courseItem['instructor'] }}">
            </div>
            <div class="media-body">
                <h5 class="box-name"><a href="#">{{ $courseItem['instructor'] }}</a></h5>
            </div>
        </div>
        <a href="{{ route('course-details', $courseItem['slug']) }}" class="th-btn btn-sm style-border2">
            VIEW DETAILS
            <svg class="ms-2" width="16" height="14" viewBox="0 0 16 14" fill="none" xmlns="http://www.w3.org/2000/svg">
                <path d="M7.5264 0C7.5264 0.6962 8.21633 1.738 8.9138 2.61293C9.81193 3.7394 10.8838 4.72347 12.1137 5.4748C13.0351 6.0374 14.154 6.57747 15.0528 6.57747M7.5264 13.1712C7.5264 12.475 8.21633 11.4332 8.9138 10.5583C9.81193 9.43187 10.8838 8.44773 12.1137 7.6964C13.0351 7.1338 14.154 6.59373 15.0528 6.59373M15.0528 6.5856H0" stroke="currentColor" stroke-width="1.5"></path>
            </svg>
        </a>
    </div>
</div>
