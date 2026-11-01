<div class="course-card">
    <div class="box-img">
        <a href="{{ route('e-library.download', $resource['slug']) }}" target="_blank" title="Download {{ $resource['title'] }}">
            <img src="{{ asset($resource['image']) }}" alt="{{ $resource['title'] }}">
        </a>
        @if (!empty($resource['badge']))
            <span class="course-success-badge">
                <i class="fa-solid fa-award" aria-hidden="true"></i>{{ $resource['badge'] }}
            </span>
        @endif
        <span class="box-price">FREE</span>
    </div>

    <h3 class="box-title">
        <a href="{{ route('e-library.download', $resource['slug']) }}" target="_blank" title="{{ $resource['title'] }}">
            {{ $resource['title'] }}
        </a>
    </h3>

    <div class="box-rating">
        <div class="star-rating" role="img" aria-label="Rated {{ $resource['rating'] }} out of 5">
            <span class="star-rating-full">
                Rated <strong class="rating">{{ $resource['rating'] }}</strong> out of 5
            </span>
        </div>
        <span class="ms-2">⭐ {{ $resource['rating'] }} ({{ $resource['downloads'] }} downloads)</span>
    </div>

    <div class="box-content">
        <div class="course-info">
            <div class="box-icon"><i class="fal fa-file-pdf"></i></div>
            <div class="course-info-details">
                <span class="course-info-title">Length:</span>
                <h4 class="course-info-text">{{ $resource['pages'] }}</h4>
            </div>
        </div>
        <div class="course-info">
            <div class="box-icon"><i class="fal fa-hard-drive"></i></div>
            <div class="course-info-details">
                <span class="course-info-title">File Size:</span>
                <h4 class="course-info-text">{{ $resource['size'] }}</h4>
            </div>
        </div>
    </div>

    <div class="btn-wrap">
        <div class="meta-box">
            <div class="meta-thumb elib-card-thumb-badge">
                <i class="fa-solid fa-file-pdf"></i>
            </div>
            <div class="media-body">
                <h5 class="box-name"><a href="#">{{ $resource['subject'] }}</a></h5>
            </div>
        </div>
        <a href="{{ route('e-library.download', $resource['slug']) }}" class="th-btn btn-sm style-border2" title="Download Free PDF">
            DOWNLOAD PDF
            <svg class="ms-2" width="16" height="14" viewBox="0 0 16 14" fill="none" xmlns="http://www.w3.org/2000/svg">
                <path d="M7.5264 0C7.5264 0.6962 8.21633 1.738 8.9138 2.61293C9.81193 3.7394 10.8838 4.72347 12.1137 5.4748C13.0351 6.0374 14.154 6.57747 15.0528 6.57747M7.5264 13.1712C7.5264 12.475 8.21633 11.4332 8.9138 10.5583C9.81193 9.43187 10.8838 8.44773 12.1137 7.6964C13.0351 7.1338 14.154 6.59373 15.0528 6.59373M15.0528 6.5856H0" stroke="currentColor" stroke-width="1.5"></path>
            </svg>
        </a>
    </div>
</div>
