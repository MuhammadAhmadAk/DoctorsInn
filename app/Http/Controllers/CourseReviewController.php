<?php

namespace App\Http\Controllers;

use App\Models\Course;
use App\Models\CourseReview;
use App\Services\SiteContentService;
use Illuminate\Http\Request;

class CourseReviewController extends Controller
{
    public function store(Request $request, string $slug)
    {
        $course = Course::where('slug', $slug)
            ->orWhere('id', $slug)
            ->firstOrFail();

        $rules = [
            'rating'  => ['required', 'integer', 'between:1,5'],
            'comment' => ['required', 'string', 'min:5', 'max:2000'],
        ];

        if (! auth()->check()) {
            $rules['name']  = ['required', 'string', 'max:120'];
            $rules['email'] = ['nullable', 'email', 'max:150'];
        }

        $validated = $request->validate($rules, [
            'rating.required'  => 'Please select a star rating (1 to 5 stars).',
            'rating.between'   => 'Rating must be between 1 and 5.',
            'comment.required' => 'Please write your review message.',
            'comment.min'      => 'Your review must be at least 5 characters.',
            'name.required'    => 'Please enter your name.',
        ]);

        $user  = auth()->user();
        $name  = $user ? $user->name : trim($validated['name']);
        $email = $user ? $user->email : (isset($validated['email']) ? trim($validated['email']) : null);

        $review = CourseReview::create([
            'course_id' => $course->id,
            'user_id'   => $user?->id,
            'name'      => $name,
            'email'     => $email,
            'rating'    => (int) $validated['rating'],
            'comment'   => trim($validated['comment']),
            'status'    => 'approved',
        ]);

        // Dynamically update course aggregate rating & count
        $approvedReviews = $course->reviewsList()->where('status', 'approved')->get();
        if ($approvedReviews->isNotEmpty()) {
            $avgRating = round($approvedReviews->avg('rating'), 1);
            $count = $approvedReviews->count();
            $course->update([
                'rating'       => (string) $avgRating,
                'rating_count' => $count >= 1000 ? (round($count / 1000, 1) . 'k+') : (string) $count,
            ]);
        }

        SiteContentService::flushCache();

        if ($request->wantsJson()) {
            return response()->json([
                'success' => true,
                'message' => 'Thank you! Your review has been posted successfully.',
                'review'  => $review,
            ]);
        }

        return redirect()->to(route('course-details', $course->slug) . '#reviews')
            ->with('review_success', 'Thank you! Your review has been posted successfully.');
    }
}
