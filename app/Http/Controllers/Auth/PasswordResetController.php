<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Schema;

class PasswordResetController extends Controller
{
    protected const CODE_TTL_MINUTES = 15;

    public function showForgotForm()
    {
        return view('frontend.pages.authentication.forgot-password');
    }

    public function sendCode(Request $request)
    {
        $request->validate([
            'email' => 'required|email|max:150',
        ]);

        $email = strtolower(trim($request->email));
        $user = User::whereRaw('LOWER(email) = ?', [$email])->first();

        if (! $user) {
            return back()->withInput()->with('error', 'No account was found with this email address.');
        }

        if (! Schema::hasTable('password_reset_tokens')) {
            return back()->withInput()->with('error', 'Password reset is temporarily unavailable. Please try again later.');
        }

        $code = (string) random_int(100000, 999999);

        DB::table('password_reset_tokens')->updateOrInsert(
            ['email' => $email],
            ['token' => Hash::make($code), 'created_at' => now()]
        );

        $delivered = $this->sendResetMail($user, $code);

        $request->session()->put('password_reset_email', $email);
        $request->session()->forget('password_reset_verified');

        $redirect = redirect()->route('verify-code')
            ->with('success', 'A 6-digit verification code has been generated for ' . $email . '.');

        if (! $delivered) {
            // Dev mailers (mailpit/log) never reach a real inbox, so surface the
            // code on screen instead of leaving the flow unusable.
            $redirect->with('dev_code', $code);
        }

        return $redirect;
    }

    public function showVerifyForm(Request $request)
    {
        if (! $request->session()->has('password_reset_email')) {
            return redirect()->route('forgot-password')
                ->with('error', 'Please enter your email address first.');
        }

        return view('frontend.pages.authentication.verify-code', [
            'email' => $request->session()->get('password_reset_email'),
        ]);
    }

    public function verifyCode(Request $request)
    {
        $request->validate([
            'code' => 'required|digits:6',
        ]);

        $email = $request->session()->get('password_reset_email');
        if (! $email) {
            return redirect()->route('forgot-password')
                ->with('error', 'Please enter your email address first.');
        }

        $row = DB::table('password_reset_tokens')->where('email', $email)->first();
        if (! $row) {
            return redirect()->route('forgot-password')
                ->with('error', 'No reset request is pending for this email. Please request a new code.');
        }

        if (Carbon::parse($row->created_at)->addMinutes(self::CODE_TTL_MINUTES)->isPast()) {
            DB::table('password_reset_tokens')->where('email', $email)->delete();

            return redirect()->route('forgot-password')
                ->with('error', 'This code has expired. Please request a new one.');
        }

        if (! Hash::check($request->code, $row->token)) {
            return back()->with('error', 'The verification code you entered is incorrect.');
        }

        $request->session()->put('password_reset_verified', true);

        return redirect()->route('reset-password');
    }

    public function showResetForm(Request $request)
    {
        if (! $request->session()->has('password_reset_email') || ! $request->session()->get('password_reset_verified')) {
            return redirect()->route('forgot-password')
                ->with('error', 'Please verify your email address before resetting the password.');
        }

        return view('frontend.pages.authentication.reset-password');
    }

    public function resetPassword(Request $request)
    {
        $request->validate([
            'password' => 'required|string|min:8|confirmed',
        ]);

        $email = $request->session()->get('password_reset_email');
        $verified = $request->session()->get('password_reset_verified');

        if (! $email || ! $verified) {
            return redirect()->route('forgot-password')
                ->with('error', 'Your reset session has expired. Please start again.');
        }

        $row = DB::table('password_reset_tokens')->where('email', $email)->first();
        if (! $row || Carbon::parse($row->created_at)->addMinutes(self::CODE_TTL_MINUTES)->isPast()) {
            DB::table('password_reset_tokens')->where('email', $email)->delete();
            $request->session()->forget(['password_reset_email', 'password_reset_verified']);

            return redirect()->route('forgot-password')
                ->with('error', 'This reset request has expired. Please request a new code.');
        }

        $user = User::whereRaw('LOWER(email) = ?', [$email])->first();
        if (! $user) {
            return redirect()->route('forgot-password')
                ->with('error', 'No account was found with this email address.');
        }

        $user->password = Hash::make($request->password);
        $user->save();

        DB::table('password_reset_tokens')->where('email', $email)->delete();
        $request->session()->forget(['password_reset_email', 'password_reset_verified']);

        return redirect()->route('login')
            ->with('success', 'Your password has been updated. Please sign in with your new password.');
    }

    protected function sendResetMail(User $user, string $code): bool
    {
        try {
            Mail::raw(
                "Hello {$user->name},\n\n"
                . "Your DoctorsInn password reset code is: {$code}\n\n"
                . 'This code expires in ' . self::CODE_TTL_MINUTES . " minutes.\n"
                . "If you did not request this, you can safely ignore this email.",
                function ($message) use ($user) {
                    $message->to($user->email)->subject('DoctorsInn — Password Reset Code');
                }
            );
        } catch (\Throwable $e) {
            report($e);

            return false;
        }

        $host = (string) config('mail.mailers.smtp.host', '');
        $mailer = (string) config('mail.default', '');
        $devMailers = ['log', 'array'];
        $devHosts = ['mailpit', '127.0.0.1', 'localhost'];

        return ! in_array($mailer, $devMailers, true) && ! in_array($host, $devHosts, true);
    }
}
