<?php
 
namespace App\Http\Controllers\Auth;
 
use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;
 
class LoginController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles authenticating users for the application and
    | redirecting them to your home screen. The controller uses a trait
    | to conveniently provide its functionality to your applications.
    |
    */
 
    use AuthenticatesUsers;
 
    /**
     * Where to redirect users after login.
     *
     * @var string
     */
    protected $redirectTo = '/dashboard';
 
    /**
     * Login username to be used by the controller.
     *
     * @var string
     */
    protected $username;
 
    /**
     * Create a new controller instance.
     */
    public function __construct()
    {
        $this->middleware('guest')->except('logout');
 
        $this->username = $this->findUsername();
    }
 
    /**
     * Get the login username to be used by the controller.
     *
     * @return string
     */
    public function findUsername()
    {
        $login = request()->input('login');
 
        $fieldType = filter_var($login, FILTER_VALIDATE_EMAIL) ? 'email' : 'username';
 
        request()->merge([$fieldType => $login]);
 
        return $fieldType;
    }
 
    /**
     * Get username property.
     *
     * @return string
     */
    public function username()
    {
        return $this->username;
    }

    protected function attemptLogin(Request $request)
    {
        $credentials = $this->credentials($request);

        // Attempt to authenticate the user
        $authenticated = $this->guard()->attempt(
            $credentials, $request->filled('remember')
        );

        if ($authenticated) {
            // Get the authenticated user
            $user = $this->guard()->user();

            // Check if user type is 'client'
            if ($user->type == 'client') {
                // Invalidate session
                $this->guard()->logout();
                $request->session()->invalidate();

                // Throw validation exception
                throw ValidationException::withMessages([
                    $this->username() => 'We cant find a user with provided credentials',
                ]);
            }
        }

        return $authenticated;
    }

     /**
     * Handle the user authenticated logic.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  mixed  $user
     * @return \Illuminate\Http\Response
     */
    protected function authenticated(Request $request, $user)
    {
        $mode = getMode(); // Assuming setting('mode') gets the current mode setting

        if ($mode == 'hotspot') {
            return redirect()->route('hotspot.index');
        } else {
            return redirect()->route('dashboard'); // Default redirect
        }
    }

}