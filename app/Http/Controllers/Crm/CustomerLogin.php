<?php
/*
 * Rose Business Suite - Accounting, CRM and POS Software
 * Copyright (c) UltimateKode.com. All Rights Reserved
 * ***********************************************************************
 *
 *  Email: support@ultimatekode.com
 *  Website: https://www.ultimatekode.com
 *
 *  ************************************************************************
 *  * This software is furnished under a license and may be used and copied
 *  * only  in  accordance  with  the  terms  of such  license and with the
 *  * inclusion of the above copyright notice.
 *  * If you Purchased from Codecanyon, Please read the full License from
 *  * here- http://codecanyon.net/licenses/standard/
 * ***********************************************************************
 */
namespace App\Http\Controllers\Crm;

use App\Http\Responses\RedirectResponse;
use App\Models\Company\Company;
use App\Models\Company\ConfigMeta;
use App\Models\customer\Customer;
use App\Models\template\Template;
use App\Repositories\Focus\general\RosemailerRepository;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Str;

class CustomerLogin extends Controller
{
    use AuthenticatesUsers;

    protected $redirectTo = '/crm/home';

    /**
     **_ Create a new controller instance.
     * _**
     **_ @return void
     * _**/
    public function __construct()
    {
        if (!session()->has('theme')) {
            session(['theme' => 'ltr']);
        }

        $this->middleware('guest')->except('logout');
        Auth::logout();

    }

    /**
     * _
     * _ @return property guard use for login
     * _
     * _&*/
    public function guard()
    {

        return Auth::guard('crm');
    }

    protected function authenticated(Request $request, $user)
    {


    }

    // login from for customer
    public function showLoginForm()
    {

        if (Auth::guard('crm')->check()) {

            return new RedirectResponse(route('crm.invoices.index'), ['']);

        }
        return view('crm.login');
    }

    protected function validateLogin(Request $request)
    {

        if(config('no-captcha.captcha')){

            $this->validate($request, [
                'email' => 'required|string',
                'password' => 'required|string',
                'g-recaptcha-response' => 'required|captcha',
            ], ['g-recaptcha-response.required' => 'Captcha Error']);
        } else {
            $this->validate($request, [
                    'email' => 'required|string',
                    'password' => 'required|string']
            );
        }
    }


    public function login(Request $request)
    {

        $this->validateLogin($request);


        // If the class is using the ThrottlesLogins trait, we can automatically throttle
        // the login attempts for this application. We'll key this by the username and
        // the IP address of the client making these requests into this application.
        if (method_exists($this, 'hasTooManyLoginAttempts') &&
            $this->hasTooManyLoginAttempts($request)) {
            $this->fireLockoutEvent($request);

            return $this->sendLockoutResponse($request);
        }

        if ($this->attemptLogin($request)) {
            if(auth('crm')->user()->active) {
                $u = ConfigMeta::withoutGlobalScopes()->where('ins', '=', auth('crm')->user()->ins)->where('feature_id', '=', 15)->first('value1')->value1;
                $login = ConfigMeta::withoutGlobalScopes()->where('feature_id', '=', 18)->first('value2')->value2;
                session(['theme' => $u]);
                if (!$login) return $this->disabled($request);

                return $this->sendLoginResponse($request);
            } else {
                Auth::guard('crm')->logout();
                return new RedirectResponse(route('crm.login'), ['flash_error' => trans('customers.login_not_active')]);
            }


        }

        $this->incrementLoginAttempts($request);

        return $this->sendFailedLoginResponse($request);
    }


    protected function sendLoginResponse(Request $request)
    {

        $request->session()->regenerate();

        $this->clearLoginAttempts($request);

        return new RedirectResponse(route('crm.invoices.index'), ['']);
    }


    public function logout(Request $request)
    {
        Auth::guard('crm')->logout();
        return new RedirectResponse(route('crm.login'), ['flash_success' => trans('customers.logout_success')]);
    }

    public function disabled(Request $request)
    {
        Auth::guard('crm')->logout();
        return new RedirectResponse(route('crm.login'), ['flash_error' => trans('customers.login_is_suspended')]);
    }

    public function register(Request $request)
    {
        if (Auth::guard('crm')->check()) {

            return new RedirectResponse(route('crm.invoices.index'), ['']);

        }
        if($request->post()){

            $request->validate([
                'name' => 'required|string|min:3|max:30',
                'phone' => 'required|string|min:6|max:15',
                'company' =>'required|string|min:3|max:35',
                'address' =>'required|string|min:6|max:35',
                'city' =>'required|string|min:3|max:15',
                'region' =>'required|string|min:3|max:15',
                'country' => 'required|string|min:3|max:15',
                'password' => 'required|confirmed|min:6|max:15',
                'password_confirmation' => 'required|string|min:6|max:15',


            ]);

            $ins=1;
            $flag=true;
            if(config('standard.type')){
                $flag=false;
               $ins= $request->reg_id;
               $ins=substr($ins,2);
               if(strlen($ins)==8){
                   $cmp= Company::where('identy',$ins)->first();
                   if($cmp->id){
                       $ins= $cmp->id;
                       $flag=true;
                   }
               }

            } else {
                $config = feature_dedicated(6,$ins);
                if(!$config->value1){
                    $flag=false;
                    return new RedirectResponse(route('crm.register'), ['flash_error' => trans('customers.register_disabled')]);
                }
            }


            if($flag)
            {
                //$request->email=rand(9,999).$request->email;
                $find=Customer::withoutGlobalScopes()->where('ins',$ins)->where('email',$request->email)->first();

                if(isset($find->id)){
                    return new RedirectResponse(route('crm.register'), ['flash_error' => trans('customers.duplicate_email')]);
                }

                $str=strtolower(Str::random());

                Customer::create(
                    array(
                        'name' => $request->name,
                        'phone' => $request->phone,
                        'company' => $request->company,
                        'address' => $request->address,
                        'city' => $request->city,
                        'region' => $request->region,
                        'country' => $request->country,
                        'postbox' => $request->postbox,
                        'taxid' => $request->taxid,
                        'email' => $request->email,
                        'password' => $request->password,
                        'active' => 0,
                        'ins' => $ins,
                        'remember_token'=>$str
                    )
                );

                $template = Template::withoutGlobalScopes()->where('ins',$ins)->where('category', '=', 1)->where('other', '=', 18)->first();

                $url=route('crm.accountVerify',[$str]);

                $body=str_replace('{URL}','<a href="'.$url.'">'.$url.'</a>',$template->body);
                $input['mail_to']=$request->email;
                $input['subject']=$template->title;
                $mailer = new RosemailerRepository($ins);
                $mailer->send($body, $input);



                return new RedirectResponse(route('crm.login'), ['flash_success' => trans('customers.success')]);

            } else {
                return new RedirectResponse(route('crm.register'), ['flash_error' => trans('customers.reg_id_error')]);
            }

        }
        return view('crm.user.register');

        return new RedirectResponse(route('crm.login'), ['flash_error' => trans('customers.login_is_suspended')]);
    }


    public function accountVerify(Request $request){
       if($request->token && strlen($request->token)==16){
           $find=Customer::withoutGlobalScopes()->where('remember_token',$request->token)->first();
           if(isset($find->id)){
               $find->active=1;
               $find->save();
               return new RedirectResponse(route('crm.login'), ['flash_success' => trans('customers.confirm_success')]);
           }
       }
    }


}
