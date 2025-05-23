<?php

namespace App\Http\Controllers\Auth;

use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Http\RedirectResponse;
use App\Providers\RouteServiceProvider;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Carbon\Carbon;

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
    // protected $redirectTo = RouteServiceProvider::HOME;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }


    /**
     * Create a new controller instance.
     *
     * @return RedirectResponse
     */
    public function login(Request $request): RedirectResponse
    {
        $input = $request->all();

        $this->validate($request, [
            'email' => 'required|email',
            'password' => 'required',
        ]);

        if (auth()->attempt(array('email' => $input['email'], 'password' => $input['password']))) {
            $user = auth()->user();
            // User::where('uuid', $user->uuid)->update(['last_connection' => now()->toDateTimeString()]);
            switch ($user->type) {
                case User::TYPE_ADMIN:
                    return redirect()->route('admin.home');
                    break;
                case User::TYPE_MANAGER:
                    return redirect()->route('manager.home');
                    break;
                case User::TYPE_TRANSPORTEUR:
                    return redirect()->route('transporteur.index');
                    break;
                default:
                    return redirect()->route('user.home');
                    break;
            }

            User::where('uuid', $user->uuid)->update(['last_connection' => Carbon::now()]);

            // auth()->user()->save();
        } else {
            return redirect()->back()->with('error', 'Email-Address And Password Are Wrong.');
        }
    }

}
