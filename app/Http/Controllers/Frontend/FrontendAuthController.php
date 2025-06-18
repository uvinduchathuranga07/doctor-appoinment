<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Mail\EnrollToAffiliate;
use App\Models\Customer;
use App\Models\FrontendUser;
use Carbon\Carbon;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Validator;
use Inertia\Inertia;
use Illuminate\Support\Str;
use Laravel\Socialite\Facades\Socialite;

use function Laravel\Prompts\error;

class FrontendAuthController extends Controller
{
    protected $providers = [
        'facebook',
        'google'
    ];

    public function login()
    {
        return Inertia::render('Auth/Login');
    }

    public function makeLogin(Request $request)
    {
        // dd($request);
        $request->validate([
            'username' => 'required',
            'password' => 'required',
        ]);

        // $fieldType = filter_var($request->username, FILTER_VALIDATE_EMAIL) ? 'email' : 'phone';
        // request()->merge([$fieldType => $request->username]);

        // $credentials = $request->only($fieldType, 'password');
        $credentials = [
            'email' => $request->username,
            'password' => $request->password,
        ];
        if (Auth::guard('customer')->attempt($credentials)) {
            return redirect()->intended(route('index'))
                ->withSuccess('Signed in');
        } else {
            return redirect()->back()
                ->withInput()
                ->withErrors([
                    'username' => 'These credentials do not match our records.',
                ]);
        }
    }

    public function register()
    {
        return Inertia::render('Auth/Register');
    }

    public function makeRegister(Request $request)
    {
        // request()->merge(['phone' =>$request->countryCode.$request->phone ]);
        // dd($request);

        $request->validate([
            'name' => 'required',
            'email' => 'required|unique:customers,email',
            'phone' => 'required|unique:customers,phone',
            // 'countryCode' => 'required',
            // 'password' => 'required|min:8:confirm',
            'password' => 'required',
        ]);

        // dd($request->all());
        // Customer::create([
        //     'name' => $request->name,
        //     'email' => $request->email,
        //     'phone' => $request->phone,
        //     'password' => Hash::make($request->password),
        // ]);
        // dd($request->all());

        try {
            DB::beginTransaction();

            $customer = new Customer();
            $customer->name = $request->name;
            $customer->email = $request->email;
            $customer->phone = $request->phone;
            $customer->password = Hash::make($request->password);
            $customer->save();


            DB::commit();

            return redirect()->route('user.login');
        } catch (Exception $ex) {
            // dd($ex);
            DB::rollBack();
            return abort(500);
        }


        // return redirect()->route('home');
    }

    public function makeLogout()
    {
        Auth::guard('customer')->logout();

        return redirect()->route('index');
    }
    public function otp()
    {
        $countryCode = '94';
        $phoneNumber = '0770435878';

        return Inertia::render('Auth/Otp', ['countryCode' => $countryCode, 'phoneNumber' => $phoneNumber]);
    }

    public function forgotPassword()
    {
        return Inertia::render('Auth/ForgotPassword');
    }
    public function forgotPasswordSubmit(Request $request)
    {
        $request->validate([
            'email' => 'required|email|exists:customers',
        ]);

        $token = Str::random(64);

        DB::table('password_resets')->insert([
            'email' => $request->email,
            'token' => $token,
            'created_at' => Carbon::now()
        ]);

        Mail::send('emails.forgetPassword', ['token' => $token], function ($message) use ($request) {
            $message->to($request->email);
            $message->subject('Reset Password');
        });

        return back()->with('message', 'We have e-mailed your password reset link!');
    }

    public function newPassword(Request $request)
    {

        $request->validate([
            'email' => 'required|email|exists:customers',
            'password' => 'required|string|min:8|confirmed',
            'password_confirmation' => 'required'
        ]);
        $passwordReset = DB::table('password_resets')
            ->where('email', $request->email)
            ->where('token', $request->token)
            ->first();

        if (!$passwordReset) {
            return back()->withInput()->with('error', 'Invalid token!');
        }

        $user = Customer::where('email', $request->email)->first();

        if ($user) {

            $hashedPassword = Hash::make($request->password);


            $user->password = $hashedPassword;
            $user->save();


            DB::table('password_resets')
                ->where('email', $request->email)
                ->delete();

            return redirect(route('user.login'))->with('message', 'Your password has been changed!');
        }

        return back()->with('error', 'User not found!');
    }
    public function resetPassword()
    {
        return Inertia::render('Auth/ResetPassword');
    }

    public function redirectToProvider($driver)
    {
        if (!$this->isProviderAllowed($driver)) {
            Log::error("{$driver} is not currently supported");
            // dd("{$driver} is not currently supported");
        }

        try {
            return Socialite::driver($driver)->redirect();
        } catch (Exception $e) {
            // You should show something simple fail message
            Log::error($e);
            // dd($e->getMessage());
            return redirect()->back();
        }
    }

    public function handleProviderCallback($driver)
    {
        try {
            $user = Socialite::driver($driver)->stateless()->user();
        } catch (Exception $e) {
            Log::error($e);
            // dd($e);
            // dd($e->getMessage());
            return redirect()->route('user.login');
        }

        // check for email in returned user
        return empty($user->email)
            ? Log::error("No email id returned from {$driver} provider.")
            : $this->loginOrCreateAccount($user, $driver);
    }
    protected function loginOrCreateAccount($providerUser, $driver)
    {
        // check for already has account
        $user = Customer::where('email', $providerUser->getEmail())->first();

        // if user already found
        if ($user) {
            // update the avatar and provider that might have changed
            $user->update([
                'avatar' => $providerUser->avatar,
                'provider' => $driver,
                'provider_id' => $providerUser->id,
                'access_token' => $providerUser->token
            ]);
        } else {
            if ($providerUser->getEmail()) { //Check email exists or not. If exists create a new user
                // create a new user
                $user = Customer::create([
                    'name' => $providerUser->getName(),
                    'email' => $providerUser->getEmail(),
                    'avatar' => $providerUser->getAvatar(),
                    'provider' => $driver,
                    'provider_id' => $providerUser->getId(),
                    'access_token' => $providerUser->token,
                    // user can use reset password to create a password
                    'password' => ''
                ]);
            } else {
                Log::error('no email address');
                // dd('no email address');
            }
        }

        // login the user
        Auth::guard('customer')->login($user, true);
        return redirect()->intended(route('profile'));
        // dd('user created');
    }
    private function isProviderAllowed($driver)
    {
        return in_array($driver, $this->providers) && config()->has("services.{$driver}");
    }

    public function profileUpdate(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'email' => 'required|email',
            'phone' => 'required',
            'address' => 'nullable'
        ]);

        try {
            $user = Auth::guard('customer')->user();

            $user = Customer::find($user->id);
            $user->name = $request->name;
            $user->email = $request->email;
            $user->phone = $request->phone;
            // $user->address=;
            $user->save();

            return redirect()->back();
        } catch (\Throwable $th) {
            Log::error($th);
            // return redirect()->back();
        }
    }

    public function profilePasswordUpdate(Request $request)
    {

        $user = Auth::guard('customer')->user();

        Validator::make($request->all(), [
            'current_password' => 'required',
            'password' => 'required|confirmed',
            'password_confirmation' => 'required',
        ])->after(function ($validator) use ($request, $user) {
            if (!isset($request['current_password']) || !Hash::check($request['current_password'], $user->password)) {
                $validator->errors()->add('current_password', __('The provided password does not match your current password.'));
            }
        })->validateWithBag('password-reset');

        try {
            $user = Auth::guard('customer')->user();

            $user = Customer::find($user->id);
            $user->password = Hash::make($request->password);
            $user->save();

            return redirect()->back();
        } catch (\Throwable $th) {
            Log::error($th);
            // return redirect()->back();
        }
    }

    public function enrollToAffiliate(Request $request)
    {
        $user = Auth::guard('customer')->user();
        DB::beginTransaction();
        try {
            $user = Customer::find($user->id);
            $user->enrolled_affiliate = 1;
            $user->save();

            // Mail::send();
            Mail::to($user->email)->cc(['info@nikoba.com', 'wijitha@nikoba.com'])->bcc('hushantha@weblook.com', 'chathuranga@weblook.com')->send(new EnrollToAffiliate($user));
            
            DB::commit();
            return redirect()->back();
        } catch (\Throwable $th) {
            Log::error($th);
            DB::rollBack();
            return redirect()->back();
        }
    }
}
