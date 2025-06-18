<?php

namespace App\Http\Controllers;

use App\Models\Meta;
use App\Models\Settings;
use App\Models\User;
use App\Services\ApiClient\ApiClient;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Inertia\Inertia;

class SettingsController extends Controller
{
    public function generalSettings()
    {
        $year = array_reverse(range(1910, date("Y")));

        $years = [];
        foreach ($year as $key => $value) {
            // dd($value);
            $y['key'] = $value;
            $y['name'] = $value;

            array_push($years, $y);
        }

        // $manufcturesQuery = "SELECT DISTINCT marka_name FROM main ORDER BY marka_name ASC";;
        // $all_manufactures = ApiClient::callAuctionApi($manufcturesQuery, true);

        // $manufactures = [];
        // foreach ($all_manufactures as $k => $value) {
        //     $m['id'] = $value['MARKA_NAME'];
        //     $m['name'] = $value['MARKA_NAME'];

        //     array_push($manufactures, $m);
        // }

        // $modelQuery = "SELECT DISTINCT MODEL_NAME FROM main ORDER BY MODEL_NAME ASC";
        // $all_models = ApiClient::callAuctionApi($modelQuery, true);

        // $models = [];
        // foreach ($all_models as $k => $value) {
        //     $m['id'] = $value['MODEL_NAME'];
        //     $m['name'] = $value['MODEL_NAME'];

        //     array_push($models, $m);
        // }

        $settings = [
            'app_name' => Settings::where(['key' => 'app_name'])->first()->value,
            'app_description' => Settings::where(['key' => 'app_description'])->first()->value,
            'app_keywords' => '',
            'app_author' => '',
            'app_favicon' => Settings::where(['key' => 'app_favicon'])->first()->value,
            'app_logo' => Settings::where(['key' => 'app_logo'])->first()->value,
            'manufactures' => Settings::where(['key' => 'manufactures'])->first()->value ?? '',
            'models' => Settings::where(['key' => 'models'])->first()->value ?? '',
            'year_from' => Settings::where(['key' => 'year_from'])->first()->value ?? '',
            'year_to' => Settings::where(['key' => 'year_to'])->first()->value ?? '',
            'affilate_point_value' => Settings::where(['key' => 'affilate_point_value'])->first()->value ?? '',
            'redeem_point_value' => Settings::where(['key' => 'redeem_point_value'])->first()->value ?? '',
        ];
        // dd($settings);
        return Inertia::render('Settings/General', ['settings' => $settings]);
    }

    public function generalSettingsUpdate(Request $request)
    {
        // dd($request->all());
        $request->validate([
            'app_name' => ['required'],
            'app_description' => ['nullable'],
            'app_keywords' => ['nullable'],
            'app_author' => ['nullable'],
            'app_favicon' => ['nullable', 'mimes:ico,png', 'max:200'],
            'app_logo' => ['nullable', 'mimes:jpeg,jpg,png', 'max:5000'],
            'manufactures' => ['nullable'],
            'models' => ['nullable'],
            'year_from' => ['nullable'],
            'year_to' => ['nullable'],
            'affilate_point_value' => ['nullable'],
            'redeem_point_value' => ['nullable'],
        ]);

        if ($request->app_favicon == null) {
            $request->request->remove('app_favicon');
        }
        if ($request->app_logo == null) {
            $request->request->remove('app_logo');
        }

        $requestVarArr = $request->all();

        // dd(request()->allFiles());
        if (count(request()->allFiles()) > 0) {
            $user = User::find(auth()->user()->id);
            foreach (request()->allFiles() as $key => $value) {
                $file = $user->addMedia($value)->toMediaCollection('site icons');
                $imagePath = str_replace(config('app.url'), '', $file->getUrl());
                $requestVarArr[$key] = $imagePath;
            }
        }
        // dd($requestVarArr);

        try {
            $settings = [];
            $i = 0;
            foreach ($requestVarArr as $key => $value) {
                $settings[$i]['key'] = $key;
                $settings[$i]['value'] = $value;
                $i++;
            }

            DB::beginTransaction();

            foreach ($settings as $s) {

                // dd($s['key']);
                $setting = Settings::where('key', $s['key'])->first();

                if ($setting !== null) {
                    $setting->update(['value' => $s['value']]);
                } else {
                    if ($s['key'] == 'manufactures' || $s['key'] == 'models') {
                        $setting = Settings::create([
                            'key' => $s['key'],
                            'value' => json_encode($s['value']),
                        ]);
                    } else {
                        $setting = Settings::create([
                            'key' => $s['key'],
                            'value' => $s['value'],
                        ]);
                    }
                }
            }
            DB::commit();
            return back();
        } catch (Exception $ex) {
            dd($ex);
            DB::rollBack();
            return abort(500);
        }
    }

    public function mailSettings()
    {
        $mailMethods = [['id' => 'smtp', 'name' => 'SMTP']];
        $mailEncryprions = [['id' => 'tls', 'name' => 'TLS'], ['id' => 'ssl', 'name' => 'SSL']];
        $mailSettings = [
            'from_address' => env('MAIL_FROM_ADDRESS'),
            'from_name' => env('MAIL_FROM_NAME'),
            'method' => env('MAIL_MAILER'),
            'host' => env('MAIL_HOST'),
            'port' => env('MAIL_PORT'),
            'username' => env('MAIL_USERNAME'),
            'password' => env('MAIL_PASSWORD'),
            'encryption' => env('MAIL_ENCRYPTION'),
        ];
        return Inertia::render('Settings/Mail', ['mailMethods' => $mailMethods, 'mailEncryprions' => $mailEncryprions, 'mailSettings' => $mailSettings]);
    }

    public function mailSettingsUpdate(Request $request)
    {
        $types = [
            'from_address' => 'MAIL_FROM_ADDRESS',
            'from_name' => 'MAIL_FROM_NAME',
            'method' => 'MAIL_MAILER',
            'host' => 'MAIL_HOST',
            'port' => 'MAIL_PORT',
            'username' => 'MAIL_USERNAME',
            'password' => 'MAIL_PASSWORD',
            'encryption' => 'MAIL_ENCRYPTION',
        ];

        $request->validate([
            'method' => ['required'],
            'host' => ['required'],
            'port' => ['required'],
            'username' => ['required'],
            'password' => ['required'],
            'encryption' => ['required'],
            'from_address' => ['required'],
            'from_name' => ['required'],
        ]);
        try {
            foreach ($types as $key => $type) {
                overWriteEnvFile($type, $request[$key]);
            }
            return redirect()->route('settings.mail');
        } catch (Exception $ex) {
            dd($request);
            Log::error($ex);
            return abort(500);
        }
    }

    public function socialAuthSettings()
    {
        $settings = [
            'facebook_id' => env('AUTH_FACEBOOK_ID'),
            'facebook_secret' => env('AUTH_FACEBOOK_SECRET'),
            'google_id' => env('AUTH_GOOGLE_CLIENT_ID'),
            'google_secret' => env('AUTH_GOOGLE_CLIENT_SECRET'),
        ];

        return Inertia::render('Settings/SocialAuth', ['settings' => $settings]);
    }

    public function socialAuthSettingsUpdate(Request $request)
    {
        $types = [
            'facebook_id' => 'AUTH_FACEBOOK_ID',
            'facebook_secret' => 'AUTH_FACEBOOK_SECRET',
            'google_id' => 'AUTH_GOOGLE_CLIENT_ID',
            'google_secret' => 'AUTH_GOOGLE_CLIENT_SECRET',
        ];

        if ($request->facebook_id) {
            $request->validate([
                'facebook_id' => ['required'],
                'facebook_secret' => ['required'],
            ]);
        }

        if ($request->google_id) {
            $request->validate([
                'google_id' => ['required'],
                'google_secret' => ['required'],
            ]);
        }

        try {
            foreach ($types as $key => $type) {
                overWriteEnvFile($type, $request[$key]);
            }
            return redirect()->route('settings.social-auth');
        } catch (Exception $ex) {
            Log::error($ex);
            return abort(500);
        }
    }

    public function affiliateSettings(){
    
        $settings = [
            'app_name' => Settings::where(['key' => 'app_name'])->first()->value,
            'app_description' => Settings::where(['key' => 'app_description'])->first()->value,
            'app_keywords' => '',
            'app_author' => '',
            'app_favicon' => Settings::where(['key' => 'app_favicon'])->first()->value,
            'app_logo' => '',
            'manufactures' => Settings::where(['key' => 'manufactures'])->first()->value ?? '',
            'models' => Settings::where(['key' => 'models'])->first()->value ?? '',
            'year_from' => Settings::where(['key' => 'year_from'])->first()->value ?? '',
            'year_to' => Settings::where(['key' => 'year_to'])->first()->value ?? '',
            'affilate_point_value' => Settings::where(['key' => 'affilate_point_value'])->first()->value ?? '',
            'redeem_point_value' => Settings::where(['key' => 'redeem_point_value'])->first()->value ?? '',
        ];
        return Inertia::render('Settings/affiliate', ['settings' => $settings]);
    }

    public function affiliateSettingsUpdate(Request $request){
        // dd($request->all());
        $request->validate([
            'affilate_point_value' => ['nullable'],
            'redeem_point_value' => ['nullable'],
        ]);

       
        $requestVarArr = $request->all();

        try {
            $settings = [];
            $i = 0;
            foreach ($requestVarArr as $key => $value) {
                $settings[$i]['key'] = $key;
                $settings[$i]['value'] = $value;
                $i++;
            }

            DB::beginTransaction();

            foreach ($settings as $s) {

                // dd($s['key']);
                $setting = Settings::where('key', $s['key'])->first();
                if ($setting !== null) {
                    $setting->update(['value' => $s['value']]);
                } else {
                    if ($s['key'] == 'manufactures' || $s['key'] == 'models') {
                        $setting = Settings::create([
                            'key' => $s['key'],
                            'value' => json_encode($s['value']),
                        ]);
                    } else {
                        $setting = Settings::create([
                            'key' => $s['key'],
                            'value' => $s['value'],
                        ]);
                    }
                }
            }
            DB::commit();
            return back();
        } catch (Exception $ex) {
            dd($ex);
            DB::rollBack();
            return abort(500);
        }
    }
}
