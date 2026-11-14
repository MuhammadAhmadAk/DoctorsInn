<?php

namespace Database\Seeders;

use App\Models\SiteContent;
use App\Services\SiteContentService;
use Illuminate\Database\Seeder;

class SiteCmsSeeder extends Seeder
{
    public function run(): void
    {
        $this->seedSiteContents();

        SiteContentService::flushCache();
    }

    protected function seedSiteContents(): void
    {
        $schema = [
            // General & Branding
            ['general', 'site_name', 'Platform Name', 'text', 1],
            ['general', 'site_tagline', 'Site Tagline / SEO Title', 'text', 2],
            ['general', 'site_logo', 'Header Light Logo', 'image', 3],
            ['general', 'site_logo_white', 'Footer / Dark Logo', 'image', 4],
            ['general', 'site_favicon', 'Site Favicon', 'image', 5],

            // Contact & Social
            ['contact', 'contact_email_1', 'Primary Email Address', 'text', 1],
            ['contact', 'contact_email_2', 'Support Email Address', 'text', 2],
            ['contact', 'contact_phone_1', 'Primary Phone / Helpline', 'text', 3],
            ['contact', 'contact_phone_2', 'Secondary Phone', 'text', 4],
            ['contact', 'whatsapp_number', 'WhatsApp Number (digits only)', 'text', 5],
            ['contact', 'contact_address', 'Campus Address', 'textarea', 6],
            ['contact', 'facebook_url', 'Facebook URL', 'url', 7],
            ['contact', 'twitter_url', 'Twitter / X URL', 'url', 8],
            ['contact', 'linkedin_url', 'LinkedIn URL', 'url', 9],
            ['contact', 'youtube_url', 'YouTube URL', 'url', 10],
            ['contact', 'instagram_url', 'Instagram URL', 'url', 11],

            // Hero Section
            ['hero', 'hero_subtitle', 'Hero Top Badge', 'text', 1],
            ['hero', 'hero_title_1', 'Hero Title Line 1', 'text', 2],
            ['hero', 'hero_title_2', 'Hero Title Line 2', 'text', 3],
            ['hero', 'hero_description', 'Hero Description', 'textarea', 4],
            ['hero', 'hero_btn_1_text', 'Primary Button Text', 'text', 5],
            ['hero', 'hero_btn_2_text', 'Secondary Button Text', 'text', 6],

            // About Section
            ['about', 'about_subtitle', 'About Section Subtitle', 'text', 1],
            ['about', 'about_title', 'About Main Heading', 'text', 2],
            ['about', 'about_description', 'About Description', 'textarea', 3],
            ['about', 'about_mission_title', 'Mission Heading', 'text', 4],
            ['about', 'about_mission_text', 'Mission Statement', 'textarea', 5],
            ['about', 'about_vision_title', 'Vision Heading', 'text', 6],
            ['about', 'about_vision_text', 'Vision Statement', 'textarea', 7],
            ['about', 'about_image_1', 'About Main Photo 1', 'image', 8],
            ['about', 'about_image_2', 'About Secondary Photo 2', 'image', 9],

            // Features Strip
            ['features', 'feature_1_title', 'Feature 1 Title', 'text', 1],
            ['features', 'feature_1_icon', 'Feature 1 Icon/Image', 'image', 2],
            ['features', 'feature_2_title', 'Feature 2 Title', 'text', 3],
            ['features', 'feature_2_icon', 'Feature 2 Icon/Image', 'image', 4],
            ['features', 'feature_3_title', 'Feature 3 Title', 'text', 5],
            ['features', 'feature_3_icon', 'Feature 3 Icon/Image', 'image', 6],
            ['features', 'feature_4_title', 'Feature 4 Title', 'text', 7],
            ['features', 'feature_4_icon', 'Feature 4 Icon/Image', 'image', 8],
            ['features', 'feature_5_title', 'Feature 5 Title', 'text', 9],
            ['features', 'feature_5_icon', 'Feature 5 Icon/Image', 'image', 10],

            // Work Process Section
            ['process', 'process_subtitle', 'Process Subtitle', 'text', 1],
            ['process', 'process_title', 'Process Heading', 'text', 2],
            ['process', 'process_image', 'Process Right Showcase Image', 'image', 3],
            ['process', 'process_step1_title', 'Step 01 Title', 'text', 4],
            ['process', 'process_step1_text', 'Step 01 Description', 'textarea', 5],
            ['process', 'process_step2_title', 'Step 02 Title', 'text', 6],
            ['process', 'process_step2_text', 'Step 02 Description', 'textarea', 7],
            ['process', 'process_step3_title', 'Step 03 Title', 'text', 8],
            ['process', 'process_step3_text', 'Step 03 Description', 'textarea', 9],

            // Promo CTA Cards
            ['promo', 'promo_1_badge', 'Promo Card 1 Badge', 'text', 1],
            ['promo', 'promo_1_title', 'Promo Card 1 Headline', 'text', 2],
            ['promo', 'promo_1_btn', 'Promo Card 1 Button Text', 'text', 3],
            ['promo', 'promo_1_image', 'Promo Card 1 Image', 'image', 4],
            ['promo', 'promo_2_badge', 'Promo Card 2 Badge', 'text', 5],
            ['promo', 'promo_2_title', 'Promo Card 2 Headline', 'text', 6],
            ['promo', 'promo_2_btn', 'Promo Card 2 Button Text', 'text', 7],
            ['promo', 'promo_2_image', 'Promo Card 2 Image', 'image', 8],

            // FAQ, Team & Footer
            ['sections', 'team_subtitle', 'Teachers Section Subtitle', 'text', 1],
            ['sections', 'team_title', 'Teachers Section Heading', 'text', 2],
            ['sections', 'testi_subtitle', 'Testimonials Subtitle', 'text', 3],
            ['sections', 'testi_title', 'Testimonials Heading', 'text', 4],
            ['sections', 'faq_subtitle', 'FAQ Subtitle', 'text', 5],
            ['sections', 'faq_title', 'FAQ Heading', 'text', 6],
            ['sections', 'faq_image_1', 'FAQ Showcase Photo 1', 'image', 7],
            ['sections', 'faq_image_2', 'FAQ Showcase Photo 2', 'image', 8],
            ['sections', 'faq_counter_image', 'FAQ Counter Group Image', 'image', 9],
            ['sections', 'faq_counter_number', 'FAQ Counter Number', 'text', 10],
            ['sections', 'faq_counter_label', 'FAQ Counter Label', 'text', 11],
            ['footer', 'footer_about_text', 'Footer About Paragraph', 'textarea', 1],
            ['footer', 'footer_copyright', 'Footer Copyright Notice', 'text', 2],
        ];

        $defaults = SiteContentService::defaultSiteContentMap();

        foreach ($schema as [$section, $key, $label, $type, $order]) {
            SiteContent::firstOrCreate(
                ['key' => $key],
                [
                    'section' => $section,
                    'label' => $label,
                    'type' => $type,
                    'value' => $defaults[$key] ?? '',
                    'sort_order' => $order,
                ]
            );
        }
    }
}
