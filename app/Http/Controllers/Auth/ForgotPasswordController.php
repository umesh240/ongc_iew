<?php

namespace App\Http\Controllers\Auth;

use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\SendsPasswordResetEmails;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Password;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class ForgotPasswordController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Password Reset Controller
    |--------------------------------------------------------------------------
    |
    | This controller is responsible for handling password reset emails and
    | includes a trait which assists in sending these notifications from
    | your application to your users. Feel free to explore this trait.
    |
    */

    use SendsPasswordResetEmails;
    public function sendResetLinkEmail(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'cpf_mob' => 'required',
        ], [
            'cpf_mob.required' => 'Please enter either CPF no. or Mobile Number.',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }
        $cpf_mob = $request->cpf_mob;
        $user = User::where(function ($query) use ($cpf_mob) {
                    $query->where('cpf_no', $cpf_mob)
                    ->when(strlen($cpf_mob) >= 10, function ($query) use ($cpf_mob) {
                        $query->orWhere('mobile', $cpf_mob);
                    });
                })->where('actv_status', 1)->first();
        $user_email = @$user->email;
        if($user_email == null || $user_email == ''){
            $sos_contact = DB::table('contactsos')->select('phone_no')->first();
            $phone_no = $sos_contact->phone_no;
            $message = "To reset password send a text message at mobile no. <b>".$phone_no."</b> [CPF/Mobile No Reset Password]";
            return redirect()->back()->withErrors(['cpf_mob' => $message])->withInput();

        }else{
            $response  = $this->broker()->sendResetLink(
                ['email' => $user_email]
            );
            /*
            if ($response === Password::RESET_LINK_SENT) {
                // Password reset link sent successfully
                return $this->sendResetLinkResponse($response);
            } elseif ($response === Password::INVALID_USER) {
                // User with the given email address not found
                return $this->sendResetLinkFailedResponse($request, $response);
            } elseif ($response === Password::RESET_THROTTLED) {
                // Throttled response, user can't request a new link yet
                return $this->sendResetLinkFailedResponse($request, $response);
            } else {
                // Handle other responses as needed
                return $this->sendResetLinkFailedResponse($request, $response);
            }*/
            if ($response === Password::RESET_LINK_SENT) {
                return redirect()->back()->with(['status' => 'Password reset link sent on your email.'])->withInput();
            } else {
                return redirect()->back()->with(['error' => 'Unable to send reset link. Please try again later.'])->withInput();
            }

        }

        return view('auth.passwords.email');
    }
}
