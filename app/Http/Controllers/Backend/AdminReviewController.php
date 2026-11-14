<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\Course;
use App\Models\CourseReview;
use App\Services\SiteContentService;
use Illuminate\Http\Request;

class AdminReviewController extends Controller
{
    public function index(Request $request)
    {
        // 1. Courses breakdown: each course with its review count and average rating
        $courses = Course::query()
            ->withCount(['reviewsList as total_reviews_count'])
            ->withCount(['reviewsList as approved_reviews_count' => fn ($q) => $q->where('status', 'approved')])
            ->withAvg(['reviewsList as avg_rating' => fn ($q) => $q->where('status', 'approved')], 'rating')
            ->orderBy('sort_order')
            ->orderBy('title')
            ->get();

        $selectedCourseId = $request->query('course_id');
        $selectedStatus   = $request->query('status');
        $searchQuery      = trim((string) $request->query('q'));

        // 2. Reviews query with filters
        $query = CourseReview::with(['course', 'user'])->latest();

        if ($selectedCourseId) {
            $query->where('course_id', $selectedCourseId);
        }

        if ($selectedStatus && in_array($selectedStatus, ['approved', 'pending', 'rejected'], true)) {
            $query->where('status', $selectedStatus);
        }

        if ($searchQuery !== '') {
            $query->where(function ($q) use ($searchQuery) {
                $q->where('name', 'like', "%{$searchQuery}%")
                  ->orWhere('email', 'like', "%{$searchQuery}%")
                  ->orWhere('comment', 'like', "%{$searchQuery}%");
            });
        }

        $reviews = $query->paginate(15)->withQueryString();

        // 3. Overall KPI stats
        $totalReviews     = CourseReview::count();
        $approvedReviews  = CourseReview::where('status', 'approved')->count();
        $overallAvgRating = CourseReview::where('status', 'approved')->avg('rating') ?: 5.0;
        $fiveStarCount    = CourseReview::where('rating', 5)->count();

        return view('backend.reviews.index', compact(
            'courses',
            'reviews',
            'selectedCourseId',
            'selectedStatus',
            'searchQuery',
            'totalReviews',
            'approvedReviews',
            'overallAvgRating',
            'fiveStarCount'
        ));
    }

    public function toggleStatus(CourseReview $review)
    {
        $newStatus = $review->status === 'approved' ? 'rejected' : 'approved';
        $review->update(['status' => $newStatus]);

        $this->recalculateCourseRating($review->course);
        SiteContentService::flushCache();

        return redirect()->back()->with('success', "Review marked as {$newStatus}.");
    }

    public function destroy(CourseReview $review)
    {
        $course = $review->course;
        $review->delete();

        if ($course) {
            $this->recalculateCourseRating($course);
        }
        SiteContentService::flushCache();

        return redirect()->back()->with('success', 'Review deleted successfully.');
    }

    protected function recalculateCourseRating(?Course $course): void
    {
        if (! $course) {
            return;
        }

        $approved = $course->reviewsList()->where('status', 'approved')->get();
        if ($approved->isNotEmpty()) {
            $avgRating = round($approved->avg('rating'), 1);
            $count = $approved->count();
            $course->update([
                'rating'       => (string) $avgRating,
                'rating_count' => $count >= 1000 ? (round($count / 1000, 1) . 'k+') : (string) $count,
            ]);
        } else {
            $course->update([
                'rating'       => '5.0',
                'rating_count' => '0',
            ]);
        }
    }
}
