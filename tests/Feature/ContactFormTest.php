<?php

namespace Tests\Feature;

use App\Mail\ContactInquiryMail;
use Illuminate\Support\Facades\Mail;
use Tests\TestCase;

class ContactFormTest extends TestCase
{
    public function test_contact_page_renders(): void
    {
        $this->get('/contact')
            ->assertOk()
            ->assertSee('How can we help you today?')
            ->assertSee('Send us a message');
    }

    public function test_contact_form_sends_inquiry_email(): void
    {
        Mail::fake();

        $response = $this->post('/contact', [
            'first_name' => 'Ali',
            'last_name' => 'Khan',
            'email' => 'ali@example.com',
            'phone' => '+92 300 1234567',
            'subject' => 'Course & admissions',
            'message' => "Please share the fee structure.\nThanks!",
            'consent' => '1',
        ]);

        $response->assertRedirect();
        $response->assertSessionHas('contact_success');

        Mail::assertSent(ContactInquiryMail::class, function (ContactInquiryMail $mail) {
            $mail->build();

            return $mail->hasTo('info@doctorsinnelite.com')
                && $mail->senderName === 'Ali Khan'
                && $mail->hasReplyTo('ali@example.com');
        });
    }

    public function test_contact_form_rejects_invalid_input(): void
    {
        Mail::fake();

        $this->from('/contact')
            ->post('/contact', ['email' => 'not-an-email'])
            ->assertRedirect('/contact')
            ->assertSessionHasErrors(['first_name', 'last_name', 'email', 'message', 'consent']);

        Mail::assertNothingSent();
    }

    public function test_contact_form_rejects_unknown_subjects(): void
    {
        Mail::fake();

        $this->from('/contact')
            ->post('/contact', [
                'first_name' => 'Ali',
                'last_name' => 'Khan',
                'email' => 'ali@example.com',
                'subject' => 'Made up topic',
                'message' => 'Hi',
                'consent' => '1',
            ])
            ->assertRedirect('/contact')
            ->assertSessionHasErrors(['subject']);

        Mail::assertNothingSent();
    }

    public function test_honeypot_submissions_are_silently_accepted(): void
    {
        Mail::fake();

        $this->post('/contact', ['website' => 'https://spam.example'])
            ->assertRedirect()
            ->assertSessionHas('contact_success');

        Mail::assertNothingSent();
    }
}
