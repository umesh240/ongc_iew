<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\API\Functions;
use Illuminate\Support\Facades\Http;

use App\Http\Controllers\EmailController;

class CheckinupdateController extends Controller
{
    public function index($id=0){
        $data = [];
        if($id > 0){
            try {
                $user = DB::table('event_books_emp')->select('event_books_emp.*','events.*','users.*')
                            ->leftJoin('users', 'users.id', '=', 'event_books_emp.emp_cd')
                            ->leftJoin('events', 'events.ev_id', '=', 'event_books_emp.emp_event_cd')
                            ->where('event_books_emp.emp_ev_book_id', $id)
                            ->first();
            } catch (\Exception $e) {
                // Handle the exception
                dd($e->getMessage()); // or log the error, or return a response with an error message
            }
            
            $cpf_no = $user->cpf_no;
            $mobile = $user->mobile;
            $data['cpf_no'] = $cpf_no;
            $data['mobile'] = $mobile;
        }
        $data['user_id'] = $user->id;
        $data['event_logo_1'] = $user->event_logo_1;
        $data['id'] = $id;
        return view('changevisitingdetails', $data);
    }

    public function checkInOutUpdate(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'cpf' => 'required',
            'phoneno' => 'required',
            'checkin' => 'required|date',
            'checkout' => 'required|date'
        ], [
            'cpf.required' => 'CPF No. is required field.',
            'phoneno.required' => 'CPF No. is required field.',
            'checkin.required' => 'CPF No. is required field.',
            'checkout.required' => 'CPF No. is required field.',
            'checkin.date' => 'Check-in must be a valid date.', 
            'checkout.date' => 'Check-out must be a valid date.'
        ]);

        if ($validator->fails()) {
            $allErrors = $validator->errors()->all();
            $allErrors = implode('<br>', $allErrors);
            return back()->with(['status' => 2, 'message' => $allErrors]);
        }
        // $cpfno      = $request->cpf;
        // $phoneno    = $request->phoneno;
        $checkin    = $request->checkin;
        $checkout   = $request->checkout;
        //$recipient  = env('ADMIN_EMAIL'); 
        
        $updated =  DB::table('event_books_emp')
                ->where('emp_ev_book_id', $request->id)
                ->update(['check_in' => $checkin, 'check_out' => $checkout]);
        if ($updated) {
                    $msg = "Your rescheduled dates is updated successfully.";
                    return back()->with(['status' => 1, 'message' => $msg]);
                } else {
                    $msg = "Some problem occured. Try again later.";
                    return back()->with(['status' => 2, 'message' => $msg]);
                }
        // $subject = 'Check-In/Out details change request';
        // $content = '<html><body>';
        // $content .= "<p>A user change their check-in/out detals. Their details is below.<br>";
        // $content .= "<p><b>CPF : </b>$cpfno</p>";
        // $content .= "<p><b>Phone : </b>$phoneno</p>";
        // $content .= "<p><b>CheckIn : </b>$checkin</p>";
        // $content .= "<p><b>CheckOut : </b>$checkout</p>";
        // $content .= '</body></html>';

        // $mail       = new EmailController();
        // $mailSent   = $mail->sendMail($content, $subject, $recipient);
        
        // if ($mailSent) {
        //     $msg = "Your rescheduled dates are shared with the helpdesk team, it'll get updated soon.";
        //     return back()->with(['status' => 1, 'message' => $msg]);
        // } else {
        //     $msg = "Some problem occured. Try again later.";
        //     return back()->with(['status' => 2, 'message' => $msg]);
        // }
    }
}
