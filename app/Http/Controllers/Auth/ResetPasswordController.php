<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use Illuminate\Foundation\Auth\ResetsPasswords;
use Illuminate\Http\Request;
use App\Models\User;

class ResetPasswordController extends Controller
{
    use ResetsPasswords;

    protected $request;

    public function __construct(Request $request)
    {
        $this->request = $request;
    }

    /**
     * Where to redirect users after resetting their password.
     *
     * @var string
     */
    /**
     * Where to redirect users after resetting their password.
     *
     * @return string
     */
    protected function redirectPath()
    {
        $email = $this->request->input('email'); // Assuming email is the identifier for the user

        $user = User::where('email', $email)->first(); // Retrieve the user by email

        if ($user && $user->type === 'client') {
            return route('customer.login'); // Redirect customer users to customer login page
        } else {
            return route('login'); // Redirect other users to the default login page
        }
    }

    /**
     * Reset the given user's password.
     *
     * @param  \Illuminate\Contracts\Auth\CanResetPassword  $user
     * @param  string  $password
     * @return void
     */
    protected function resetPassword($user, $password)
    {
        // For client users, don't hash the password since it's handled in their model
        if ($user->type === 'client') {
            $user->password = $password;
            $user->text_pass = $password;
            $user->save();
        } else {
            $user->password = bcrypt($password);
            $user->save();
        }

        return $user;
    }
}
