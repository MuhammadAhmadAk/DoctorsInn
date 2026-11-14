<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\Course;
use App\Models\Enrollment;
use App\Models\Order;
use App\Models\User;
use App\Services\EnrollmentService;
use Illuminate\Http\Request;

class AdminEnrollmentController extends Controller
{
    public function __construct(protected EnrollmentService $enrollments)
    {
    }

    public function index(Request $request)
    {
        $search = trim((string) $request->query('search', ''));
        $status = in_array($request->query('status'), ['active', 'revoked'], true)
            ? $request->query('status')
            : '';

        $query = Enrollment::query()->with(['user', 'course', 'order'])->latest('enrolled_at');

        if ($search !== '') {
            $query->where(function ($q) use ($search) {
                $q->whereHas('user', function ($u) use ($search) {
                    $u->where('name', 'like', '%' . $search . '%')
                        ->orWhere('email', 'like', '%' . $search . '%');
                })->orWhereHas('course', function ($c) use ($search) {
                    $c->where('title', 'like', '%' . $search . '%');
                });
            });
        }

        if ($status === 'active') {
            $query->active();
        } elseif ($status === 'revoked') {
            $query->where('status', Enrollment::STATUS_REVOKED);
        }

        $enrollments = $query->paginate(15)->withQueryString();

        $stats = [
            'active' => Enrollment::active()->count(),
            'revoked' => Enrollment::where('status', Enrollment::STATUS_REVOKED)->count(),
            'paid_total' => (int) Order::where('status', Order::STATUS_PAID)->sum('amount'),
            'pending_orders' => Order::where('status', Order::STATUS_PENDING)->count(),
        ];

        $orders = Order::query()->with(['user', 'course'])->latest()->limit(12)->get();

        $courses = Course::query()
            ->where('is_active', true)
            ->orderBy('title')
            ->get(['id', 'title', 'price']);

        return view('backend.enrollments.index', compact(
            'enrollments',
            'orders',
            'courses',
            'stats',
            'search',
            'status'
        ));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'email' => 'required|email',
            'course_id' => 'required|integer|exists:courses,id',
            'notes' => 'nullable|string|max:255',
        ]);

        $user = User::query()->where('email', strtolower(trim($data['email'])))->first();

        if (! $user) {
            return back()->withInput()->with('error', 'No account found with that email. Ask the student to register first.');
        }

        $course = Course::findOrFail($data['course_id']);

        if ($user->hasAccessToCourse($course->id)) {
            return back()->with('warning', $user->name . ' already has active access to ' . $course->title . '.');
        }

        $this->enrollments->enroll($user, $course, 'manual', null, $data['notes'] ?? null);

        return back()->with('success', $user->name . ' enrolled in ' . $course->title . '.');
    }

    public function revoke(Enrollment $enrollment)
    {
        if (! $enrollment->isActive()) {
            return back()->with('warning', 'This enrollment is already inactive.');
        }

        $this->enrollments->revoke($enrollment);

        return back()->with('success', 'Enrollment revoked. The student can no longer open this classroom.');
    }

    public function restore(Enrollment $enrollment)
    {
        $user = $enrollment->user;
        $course = $enrollment->course;

        if (! $user || ! $course) {
            return back()->with('error', 'The student or course linked to this enrollment no longer exists.');
        }

        $this->enrollments->enroll($user, $course, 'manual', $enrollment->order, $enrollment->notes);

        return back()->with('success', 'Enrollment restored for ' . $user->name . '.');
    }
}
