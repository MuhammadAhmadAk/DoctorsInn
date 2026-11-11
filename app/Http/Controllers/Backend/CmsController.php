<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\Faq;
use App\Models\Instructor;
use App\Models\SiteContent;
use App\Models\Testimonial;
use App\Services\SiteContentService;
use Illuminate\Http\Request;

class CmsController extends Controller
{
    /**
     * Website Content & Images Manager (Sections, Texts, Branding, Media)
     */
    public function index(Request $request)
    {
        $activeTab = $request->query('tab', 'hero');
        $items = SiteContent::query()
            ->orderBy('section')
            ->orderBy('sort_order')
            ->get()
            ->groupBy('section');

        $sectionsMeta = [
            'hero' => ['label' => 'Hero Banner', 'icon' => 'fa-solid fa-wand-magic-sparkles'],
            'about' => ['label' => 'About & Mission', 'icon' => 'fa-solid fa-circle-info'],
            'features' => ['label' => 'Feature Strip', 'icon' => 'fa-solid fa-bolt'],
            'process' => ['label' => 'How It Works', 'icon' => 'fa-solid fa-diagram-project'],
            'promo' => ['label' => 'Promo CTA Cards', 'icon' => 'fa-solid fa-bullhorn'],
            'sections' => ['label' => 'FAQ & Team Media', 'icon' => 'fa-solid fa-images'],
            'general' => ['label' => 'Logos & Branding', 'icon' => 'fa-solid fa-palette'],
            'contact' => ['label' => 'Contact & Social', 'icon' => 'fa-solid fa-address-book'],
            'footer' => ['label' => 'Footer & Copyright', 'icon' => 'fa-solid fa-shoe-prints'],
        ];

        $instructors = Instructor::orderBy('sort_order')->get();
        $testimonials = Testimonial::orderBy('sort_order')->get();
        $faqs = Faq::orderBy('sort_order')->get();

        return view('backend.cms.index', compact(
            'activeTab',
            'items',
            'sectionsMeta',
            'instructors',
            'testimonials',
            'faqs'
        ));
    }

    /**
     * Bulk save texts and image uploads for a CMS section
     */
    public function updateSection(Request $request)
    {
        $section = $request->input('section', 'hero');
        $values = $request->input('values', []);
        $files = $request->file('images', []);

        foreach ($values as $key => $val) {
            SiteContent::where('key', $key)->update([
                'value' => is_string($val) ? trim($val) : $val,
            ]);
        }

        foreach ($files as $key => $file) {
            if ($file && $file->isValid()) {
                $request->validate([
                    "images.{$key}" => 'image|mimes:jpeg,png,jpg,webp,avif,svg,gif|max:8192',
                ]);
                $uploadedPath = SiteContentService::uploadImage($file, 'cms');
                if ($uploadedPath) {
                    SiteContent::where('key', $key)->update(['value' => $uploadedPath]);
                }
            }
        }

        SiteContentService::flushCache();

        return redirect()->route('admin.cms', ['tab' => $section])
            ->with('success', 'Website section updated and published live instantaneously!');
    }

    /**
     * Save or update a Faculty / Instructor card
     */
    public function saveInstructor(Request $request)
    {
        $data = $request->validate([
            'id' => 'nullable|integer',
            'name' => 'required|string|max:120',
            'designation' => 'required|string|max:120',
            'rating' => 'nullable|string|max:12',
            'facebook_url' => 'nullable|string|max:255',
            'twitter_url' => 'nullable|string|max:255',
            'linkedin_url' => 'nullable|string|max:255',
            'instagram_url' => 'nullable|string|max:255',
            'image_file' => 'nullable|image|mimes:jpeg,png,jpg,webp,avif,gif|max:8192',
            'image' => 'nullable|string|max:255',
        ]);

        if ($request->hasFile('image_file')) {
            $data['image'] = SiteContentService::uploadImage($request->file('image_file'), 'instructors');
        }

        $payload = [
            'name' => $data['name'],
            'designation' => $data['designation'],
            'rating' => $data['rating'] ?: '4.9',
            'facebook_url' => $data['facebook_url'] ?? 'https://facebook.com/',
            'twitter_url' => $data['twitter_url'] ?? 'https://twitter.com/',
            'linkedin_url' => $data['linkedin_url'] ?? 'https://linkedin.com/',
            'instagram_url' => $data['instagram_url'] ?? 'https://instagram.com/',
            'is_active' => true,
        ];
        if (!empty($data['image'])) {
            $payload['image'] = $data['image'];
        }

        if (!empty($data['id'])) {
            Instructor::where('id', $data['id'])->update($payload);
            SiteContentService::flushCache();
            return back()->with('success', 'Instructor updated successfully!');
        }

        $payload['image'] = $payload['image'] ?? 'frontend/img/team/team_2_1.jpg';
        $payload['sort_order'] = (Instructor::max('sort_order') ?? 0) + 1;
        Instructor::create($payload);

        return redirect()->route('admin.cms', ['tab' => 'instructors'])
            ->with('success', 'New instructor added to Faculty section!');
    }

    public function deleteInstructor($id)
    {
        Instructor::where('id', $id)->delete();
        return redirect()->route('admin.cms', ['tab' => 'instructors'])
            ->with('success', 'Instructor removed.');
    }

    /**
     * Save or update a Student Testimonial
     */
    public function saveTestimonial(Request $request)
    {
        $data = $request->validate([
            'id' => 'nullable|integer',
            'headline' => 'required|string|max:255',
            'quote' => 'required|string',
            'student_name' => 'required|string|max:120',
            'student_batch' => 'nullable|string|max:150',
            'rating' => 'nullable|string|max:10',
            'avatar_file' => 'nullable|image|mimes:jpeg,png,jpg,webp,avif,gif|max:8192',
            'avatar' => 'nullable|string|max:255',
        ]);

        if ($request->hasFile('avatar_file')) {
            $data['avatar'] = SiteContentService::uploadImage($request->file('avatar_file'), 'testimonials');
        }

        $payload = [
            'headline' => $data['headline'],
            'quote' => $data['quote'],
            'student_name' => $data['student_name'],
            'student_batch' => $data['student_batch'] ?? 'MDCAT Student',
            'rating' => $data['rating'] ?: '5.0',
            'is_active' => true,
        ];
        if (!empty($data['avatar'])) {
            $payload['avatar'] = $data['avatar'];
        }

        if (!empty($data['id'])) {
            Testimonial::where('id', $data['id'])->update($payload);
            SiteContentService::flushCache();
            return redirect()->route('admin.cms', ['tab' => 'testimonials'])
                ->with('success', 'Testimonial updated!');
        }

        $payload['avatar'] = $payload['avatar'] ?? 'frontend/img/testimonial/testi_2_1.png';
        $payload['sort_order'] = (Testimonial::max('sort_order') ?? 0) + 1;
        Testimonial::create($payload);

        return redirect()->route('admin.cms', ['tab' => 'testimonials'])
            ->with('success', 'New student testimonial published!');
    }

    public function deleteTestimonial($id)
    {
        Testimonial::where('id', $id)->delete();
        return redirect()->route('admin.cms', ['tab' => 'testimonials'])
            ->with('success', 'Testimonial removed.');
    }

    /**
     * Save or update FAQ
     */
    public function saveFaq(Request $request)
    {
        $data = $request->validate([
            'id' => 'nullable|integer',
            'question' => 'required|string|max:255',
            'answer' => 'required|string',
            'category' => 'nullable|string|max:60',
            'show_on_home' => 'nullable|boolean',
        ]);

        $payload = [
            'question' => $data['question'],
            'answer' => $data['answer'],
            'category' => $data['category'] ?? 'general',
            'show_on_home' => $request->boolean('show_on_home', true),
            'is_active' => true,
        ];

        if (!empty($data['id'])) {
            Faq::where('id', $data['id'])->update($payload);
            SiteContentService::flushCache();
            return redirect()->route('admin.cms', ['tab' => 'faqs'])
                ->with('success', 'FAQ updated!');
        }

        $payload['sort_order'] = (Faq::max('sort_order') ?? 0) + 1;
        Faq::create($payload);

        return redirect()->route('admin.cms', ['tab' => 'faqs'])
            ->with('success', 'New FAQ published!');
    }

    public function deleteFaq($id)
    {
        Faq::where('id', $id)->delete();
        return redirect()->route('admin.cms', ['tab' => 'faqs'])
            ->with('success', 'FAQ deleted.');
    }
}
