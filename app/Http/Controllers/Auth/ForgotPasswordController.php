<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\SendsPasswordResetEmails;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Password;
use App\Models\User;
use Laravel\Sanctum\HasApiTokens; // Add this line

class ForgotPasswordController extends Controller
{
    use SendsPasswordResetEmails;

    /**
     * Send a reset link to the given user.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function sendResetLinkEmail(Request $request)
    {
        $this->validateEmail($request);

        $response = $this->broker()->sendResetLink(
            $request->only('email')
        );

        // If the password reset link was successfully sent
        if ($response === Password::RESET_LINK_SENT) {
            // Send SMS containing the reset link
            $this->sendResetLinkSMS($request->email);
        }

        return $response == Password::RESET_LINK_SENT
                    ? $this->sendResetLinkResponse($request, $response)
                    : $this->sendResetLinkFailedResponse($request, $response);
    }

    /**
     * Send the response after the reset link has been sent.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  string  $response
     * @return \Illuminate\Http\RedirectResponse
     */
    protected function sendResetLinkResponse(Request $request, $response)
    {
        // return back()->with('status', trans($response));
        return back()->with('status', 'Password reset link has been sent to your email and phone number.');
    }

    /**
     * Get the response for a failed password reset link.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  string  $response
     * @return \Illuminate\Http\RedirectResponse
     */
    protected function sendResetLinkFailedResponse(Request $request, $response)
    {
        return back()
            ->withInput($request->only('email'))
            ->withErrors(['email' => trans($response)]);
    }

    /**
     * Send an SMS containing the password reset link.
     *
     * @param string $email
     * @return void
     */
    protected function sendResetLinkSMS($email)
    {
        // Get the user by email
        $user = User::where('email', $email)->first();

        // Check if the user exists and has a phone number
        if ($user && $user->phone) {
            // Generate a password reset token
            $token = Password::getRepository()->create($user);

            // Generate the password reset link
            $resetLink = route('password.reset', ['token' => $token]);

            // Compose the SMS content with the password reset link
            $content = "Your password reset link: $resetLink";

            // Call the global function to send the SMS
            sendSms($user->phone, $content);
        }
    }

}
