<?php

namespace App\Http\Controllers\Auth;

use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Http\RedirectResponse;
use App\Providers\RouteServiceProvider;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Carbon\Carbon;
use App\Models\LoginAttempt;
use Illuminate\Support\Facades\DB;

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
    /*public function loginold(Request $request): RedirectResponse
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
    }*/
    
    public function login(Request $request): RedirectResponse
    {
    $input = $request->all();

    $request->validate([
        'email' => 'required|email',
        'password' => 'required',
    ]);

    $ipAddress = $request->ip();
    $email = $input['email'];
    
    $maxAttempts = 3;
    $lockoutTime = 300; // 5 minutes en secondes

    $key = 'login_attempts_' . $request->ip();

    if (cache()->has($key) && cache()->get($key) >= $maxAttempts) {
        return redirect()->back()->with('error', 'Trop de tentatives échouées. Veuillez réessayer dans quelques minutes.');
    }
    // Compter les tentatives échouées des dernières 15 minutes
    $failedAttemptsCount = LoginAttempt::where('email', $email)
        ->where('successful', false)
        ->where('attempted_at', '>=', Carbon::now()->subMinutes(15))
        ->count();

    // Si plus de 3 tentatives échouées dans les 15 dernières minutes, bloquer la connexion
    if ($failedAttemptsCount >= 3) {
        return redirect()->back()->with('error', "Vous avez dépassé 3 tentatives de connexion échouées. Veuillez réessayer dans 15 minutes.");
    }

    if (auth()->attempt(['email' => $email, 'password' => $input['password']])) {
        cache()->forget($key); // Reset les tentatives en cas de succès
        // Enregistrer une tentative réussie
        LoginAttempt::create([
            'email' => $email,
            'ip_address' => $ipAddress,
            'attempted_at' => now(),
            'successful' => true,
        ]);

        $user = auth()->user();

        User::where('uuid', $user->uuid)->update(['last_connection' => Carbon::now()]);

        switch ($user->type) {
            case User::TYPE_ADMIN:
                return redirect()->route('admin.home');
            case User::TYPE_MANAGER:
                return redirect()->route('manager.home');
            case User::TYPE_TRANSPORTEUR:
                return redirect()->route('transporteur.index');
            default:
                return redirect()->route('user.home');
        }
    } else {
        // Enregistrer la tentative échouée
        LoginAttempt::create([
            'email' => $email,
            'ip_address' => $ipAddress,
            'attempted_at' => now(),
            'successful' => false,
        ]);

        cache()->increment($key);
        cache()->put($key, cache()->get($key, 1), now()->addSeconds($lockoutTime));

        $remaining = $maxAttempts - cache()->get($key);
        $message = $remaining > 0
            ? "Email ou mot de passe incorrect. Il vous reste $remaining tentative(s)."
            : "Trop de tentatives échouées. Veuillez réessayer dans 5 minutes.";

        return redirect()->back()->with('error', $message);
    }

 }

}
