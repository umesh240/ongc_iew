<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\API\Functions;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\URL;
use Maatwebsite\Excel\Facades\Excel;
use Maatwebsite\Excel\Validators\ValidationException;

use App\Http\Controllers\API\ApiUsersController;
use App\Http\Controllers\EventController;

class UserDashboardController extends Controller
{
    
    public function index()
    {
        $user = Auth()->user();
        $userId = $user->id;
        $token = $user->login_token;

        $emp_event_cd = $user->cur_event;
        $event = new EventController();
        $wheather = $event->eventWheather($emp_event_cd);

        $api = new ApiUsersController();
        $api_data = new Request([
            'id' => $userId,
            'auth' => $token
        ]);
        $resp = $api->eventDetails($api_data); 
       // echo '<pre>'; print_r($resp);
        $responseData = $resp->getData();
       //  echo '<pre>'; print_r($api_data); die;
        $status = $responseData->status;
        $userData = @$responseData->response;

        $event_cd = $emp_ev_book_id = 0;
        if($status == 200 && !empty($userData)){
            $emp_ev_book_id = $userData->emp_ev_book_id;
            $event_cd = $userData->emp_event_cd;
            $hotel_list = DB::table('hotels')->where('evv_id', $event_cd)->where('actv_hotel', 1)->select("htl_id", "hotel_name", "hotel_address", "evv_id")->get();
            $data['hotel_list'] = $hotel_list;
            $req_chng_hotel_cd      = $userData->req_chng_hotel_cd;
            $req_chng_hotel_cat_cd  = $userData->req_chng_hotel_cat_cd;
            $req_chng_status        = $userData->req_chng_status;
            if($req_chng_status == '1'){
                $chngHtlInfo = DB::table('event_books_emp')->where('event_books_emp.emp_ev_book_id', $emp_ev_book_id)
                                ->leftJoin('hotels', 'event_books_emp.req_chng_hotel_cd', '=', 'hotels.htl_id')
                                ->leftJoin('hotels_category', 'event_books_emp.req_chng_hotel_cat_cd', '=', 'hotels_category.htl_cat_id')
                                ->select("hotels.htl_id", "hotels.hotel_name", "hotels_category.htl_cat_id", "hotels_category.hotel_category", "hotels.hotel_address", "event_books_emp.req_chng_instraction", "event_books_emp.req_chng_status")->first();
                $data['changHtlInfo'] = $chngHtlInfo;
            }
        }else{
            $userData = $responseData->response;
            if($status == 500){
                $userData = $responseData->message;
            }
            if($status == 200 && empty($userData)){
                $status = 400;
            }
        }
        session(['emp_ev_book_id' => $emp_ev_book_id, 'event_cd' => $event_cd, 'userId' => $userId, 'token' => $token]);

        $data['status'] = $status;
        $data['userData'] = $userData;
        $sosApiData = new Request([
            'emp_ev_book_id' => $emp_ev_book_id
        ]);
        $sos_contact = $api->sosContactUs($sosApiData); 
        $sosData = $sos_contact->getData();
        $data['sos_contact'] = $sosData;
        //echo '<pre>'; print_r($data);  die;
        return view('user_dashboard', $data);
    }

    public function index2()
    {
        $user = Auth()->user();
        $userId = $user->id;
        $token = $user->login_token;

        $emp_event_cd = $user->cur_event;
        $event = new EventController();
        $wheather = $event->eventWheather($emp_event_cd);

        $api = new ApiUsersController();
        $api_data = new Request([
            'id' => $userId,
            'auth' => $token
        ]);
        $resp = $api->eventDetails($api_data); 

        $responseData = $resp->getData();
        $status = $responseData->status;
        $userData = @$responseData->response;

        $emp_ev_book_id = 0;
        if($status == 200 && !empty($userData)){
            $emp_ev_book_id = $responseData->response->emp_ev_book_id;
            $event_cd = $responseData->response->emp_event_cd;
            $hotel_list = DB::table('hotels')->where('evv_id', $event_cd)->where('actv_hotel', 1)->select("htl_id", "hotel_name", "hotel_address", "evv_id")->get();
            $data['hotel_list'] = $hotel_list;
            $req_chng_hotel_cd = $responseData->response->req_chng_hotel_cd;
            $req_chng_hotel_cat_cd = $responseData->response->req_chng_hotel_cat_cd;
            $req_chng_status = $responseData->response->req_chng_status;
            if($req_chng_status == '1'){
                $chngHtlInfo = DB::table('event_books_emp')->where('event_books_emp.emp_ev_book_id', $emp_ev_book_id)
                                ->leftJoin('hotels', 'event_books_emp.req_chng_hotel_cd', '=', 'hotels.htl_id')
                                ->leftJoin('hotels_category', 'event_books_emp.req_chng_hotel_cat_cd', '=', 'hotels_category.htl_cat_id')
                                ->select("hotels.htl_id", "hotels.hotel_name", "hotels_category.htl_cat_id", "hotels_category.hotel_category", "hotels.hotel_address", "event_books_emp.req_chng_instraction", "event_books_emp.req_chng_status")->first();
                $data['changHtlInfo'] = $chngHtlInfo;
            }
        }else{
            $userData = $responseData->response;
            if($status == 500){
                $userData = $responseData->message;
            }
            if($status == 200 && empty($userData)){
                $status = 400;
            }
        }
        $data['status'] = $status;
        $data['userData'] = $userData;
        $sosApiData = new Request([
            'emp_ev_book_id' => $emp_ev_book_id
        ]);
        $sos_contact = $api->sosContactUs($sosApiData); 
        $sosData = $sos_contact->getData();
        $data['sos_contact'] = $sosData;
        //echo '<pre>'; print_r($data);  die;
        return view('user_dashb_event', $data);
    }
    public function empCheckInOut(Request $request)
    {
        //print_r($request->all());
        $user = Auth()->user();
        $userId = $user->id;
        $token = $user->login_token;
        $api = new ApiUsersController();
        $api_data = new Request([
            'emp_ev_book_id' => $request->emp_event_id,
            'in_out' => $request->in_out,
            'id' => $userId,
            'auth' => $token
        ]);
        $resp = $api->employeeCheckInOut($api_data);
        $responseData = $resp->getData();
        return response()->json($responseData);
    }

    /////////////////// flight save //////////////////////////////////
    public function flightSave(Request $request)
    {
        //print_r($request->all()); die;
        $user = Auth()->user();
        $userId = $user->id;
        $token = $user->login_token;

        $flight_book_type = $request->flight_book_type;
        $emp_ev_book_id = $request->emp_ev_book_id;
        $flight_name = $request->flight_name;
        $flight_number = $request->flight_number;
        $date_time = date('Y-m-d H:i:s', strtotime($request->date_time));
        $location = $request->location;


        $api = new ApiUsersController();
        $api_data = new Request([
            'emp_ev_book_id' => $emp_ev_book_id,
            'book_type' => $flight_book_type,
            'flight_name' => $flight_name,
            'flight_number' => $flight_number,
            'flight_dt_tm' => $date_time,
            'flight_location' => $location,
            'id' => $userId,
            'auth' => $token
        ]);
        $resp = $api->flightSave($api_data);
        $responseData = $resp->getData();
        return response()->json($responseData);
    }

    public function getHtlCategory(Request $request)
    {
        
        $htl_cd = $request->hotel_cd;
        
        $hotels_category = DB::table('hotels_category')->where('soft_delete_yn', 0)->where('htl_idd', $htl_cd)->get();
        // ->where('vacent_rooms', '>', 0)
        $opts = '';
        if(count($hotels_category) > 1){
            $opts .= '<option value="">Select category</option>';
        }
        foreach ($hotels_category as $key => $category) {
            $htl_cat_id = $category->htl_cat_id;
            $hotel_category = $category->hotel_category;
            $total_rooms = $category->total_rooms;
            $vacent_rooms = $category->vacent_rooms;
            $opts .= '<option value="'.$htl_cat_id.'" data-ttl_room="'.$total_rooms.'" data-vacent="'.$vacent_rooms.'">'.$hotel_category.'</option>';
        }

        return response()->json(['category_list' => $opts]);
    }
    
    public function changeHtlReq(Request $request)
    {
        //print_r($request->all()); die;

        $emp_ev_book_id       = $request->emp_ev_book_id;
        $hotel_cd       = $request->hotel_cd;
        $room_type_cd   = $request->room_type_cd;
        $instructions   = $request->instructions;

        $user = Auth()->user();
        $userId = $user->id;
        $token = $user->login_token;
        $api = new ApiUsersController();

        $api_data = new Request([
            'emp_ev_book_id' => $emp_ev_book_id,
            'htl_id' => $hotel_cd,
            'htl_cat_id' => $room_type_cd,
            'instruction' => $instructions,
            'id' => $userId,
            'auth' => $token
        ]);

        $resp = $api->hotelChangeRequest($api_data);
        $responseData = $resp->getData();
        return response()->json($responseData);
    }
    
    public function changePassword(Request $request)
    {
        //print_r($request->all()); die;

        $old_password       = $request->old_password;
        $new_password       = $request->new_password;
        $confirm_password   = $request->confirm_password;

        $user = Auth()->user();
        $userId = $user->id;
        $token = $user->login_token;
        $api = new ApiUsersController();

        $api_data = new Request([
            'old_password' => $old_password,
            'new_password' => $new_password,
            'confirm_password' => $confirm_password,
            'id' => $userId,
            'auth' => $token
        ]);

        $resp = $api->changePassword($api_data);
        $responseData = $resp->getData();
        return response()->json($responseData);
    }
    
    public function userQuery(Request $request)
    {
        //print_r($request->all()); die;

        $emp_ev_book_id = $request->emp_ev_book_id;
        $query          = $request->input('query'); 

        $user = Auth()->user();
        $userId = $user->id;
        $token = $user->login_token;
        $api = new ApiUsersController();

        $api_data = new Request([
            'emp_ev_book_id' => @$emp_ev_book_id,
            'query' => $query,
            'id' => $userId,
            'auth' => $token
        ]);

        $resp = $api->userQuery($api_data);
        $responseData = $resp->getData();
        return response()->json($responseData);
    }
    
    public function eventCancel(Request $request)
    {
        //print_r($request->all()); die;

        $emp_ev_book_id = $request->emp_ev_book_id;
        $cancel_reason  = $request->input('cancel_reason'); 

        $user = Auth()->user();
        $userId = $user->id;
        $token = $user->login_token;
        $api = new ApiUsersController();

        $api_data = new Request([
            'emp_ev_book_id' => @$emp_ev_book_id,
            'cancel_reason' => $cancel_reason,
            'id' => $userId,
            'auth' => $token
        ]);

        $resp = $api->eventCancel($api_data);
        $responseData = $resp->getData();
        return response()->json($responseData);
    }

    public function pageIndex($page)
    {
        //session(['emp_ev_book_id' => $emp_ev_book_id, 'event_cd' => $event_cd, 'userId' => $userId, 'token' => $token]);
        $emp_ev_book_id = session('emp_ev_book_id');
        $userId         = session('userId');
        $event_cd       = session('event_cd');
        $apiData = new Request([
            'emp_ev_book_id' => $emp_ev_book_id,
            'id' => $userId
        ]);
        $api = new ApiUsersController();
        $pg = '';
        $data = [];
        
        $data['emp_ev_book_id'] = $emp_ev_book_id;
        $aboutDetails = DB::table('abouts')->first();
        switch ($page) {
            case 'participation':
                $pg = 'user_participation';
            break;
            case 'quiz':
                $quiz = $api->quizIndex($apiData); 
                $quizList = $quiz->getData();
                $data['quizList'] = $quizList;
                $pg = 'user_quiz';
            break;
            case 'faq':
                $faqsListQuery = $api->faqsList(); 
                $faqsList = $faqsListQuery->getData();
                $data['faqsList'] = $faqsList;
                $pg = 'user_faq';
            break;
            case 'feedback':
                $apiQuery = $api->feedbackIndex($apiData); 
                $feedbackList = $apiQuery->getData();
                $data['feedbackList'] = $feedbackList;
                $pg = 'user_feedback';
            break;
            case 'flight':
                $pg = 'user_flight';
            break;
            case 'helpdesk':
                $sos_contact = $api->sosContactUs($apiData); 
                $sosData = $sos_contact->getData();
                $data['sos_contact'] = $sosData;
                $pg = 'user_helpdesk';
            break;
            case 'local_area':
                $aboutLocal = $aboutDetails->about_local_event;
                $data['aboutLocal'] = $aboutLocal;
                $pg = 'user_local_area';
            break;
            case 'news':
                $pg = 'user_news';
            break;
            case 'change_password':
                $pg = 'user_change_password';
            break;
            case 'day_wise':
                $pg = 'user_day_wise';
            break;
            case 'date_wise':
                $pg = 'user_event_info';
            break;
            case 'about':
                $aboutIEW = $aboutDetails->about_iew;
                $data['aboutIEW'] = $aboutIEW;
                $pg = 'user_iew';
            break;
            case 'local_weather':
                $evnt = DB::table('events')->where('ev_id', $event_cd)->first();
                $weather_result = $evnt->weather_result;
                $weather_result = json_decode($weather_result);
                $data['weather_result'] = $weather_result;
                $pg = 'user_local_weather';
            break;
            case 'way_finder':
                $pg = 'user_way_finder';
            break;
            case 'chat':
                $pg = 'user_chat';
            break;

            default:
            // code...
            break;
        }
        return view($pg, $data);
    }

    public function menuPage()
    {
        return view("user_menus");
    }
    
    public function saveQuiz(Request $request)
    {
        //print_r($request->all()); die;
        $validator = Validator::make($request->all(), [
            'answer_id.*' => 'required',
        ], [
            'answer_id.*.required' => 'Please answer of the all questions.',
        ]);

        if ($validator->fails()) {
            //return redirect()->back()->withErrors($validator)->withInput();
            $allErrors = 'Please answer all questions.';
            return response()->json(['status' => 2, "message" => $allErrors, "url" => '']);
        }
        $emp_ev_book_id = session('emp_ev_book_id');
        $userId         = session('userId');
        $event_cd       = session('event_cd');

        $answers = [];
        $questions = $request->question_id;
        foreach ($questions as $key => $val) {
            $question_id = $request->input('question_id.'.$key);
            $answer_id   = $request->input('answer_id.'.$key);
            $answers[] = array('question_id' => $question_id, 'answer_id' => $answer_id);

        }

        $apiData = new Request([
            'emp_ev_book_id' => $emp_ev_book_id,
            'user_id' => $userId,
            'quiz_completed' => $answers
        ]);
        $api = new ApiUsersController();
        
        $quiz_save = $api->quizSave($apiData); 
        $qData = $quiz_save->getData();
        $status = $qData->status;
        if($status == 200){
            $status = 1;
            $message = $qData->message;
            $ttl_question = $qData->ttl_question;
            $right_question = $qData->right_question;
            $wrong_question = $qData->wrong_question;

            $msg = "You have successfully attempt the question.";
            $data = [];
            $data['quiz_message'] = $msg;
            $data['ttl_question'] = $ttl_question;
            $data['right_question'] = $right_question;
            $data['wrong_question'] = $wrong_question;
            $message = 'You have successfully attempt the question.';
            $message .= '<p class="mt-2 mb-0">Attempt Questions '.$ttl_question.'</p>';
            $message .= '<p class="text-success mb-0">Right Questions '.$right_question.'</p>';
            $message .= '<p class="text-danger mb-0">Wrong Questions '.$wrong_question.'</p>';
            $url = route('my.page', ['page'=>'quiz']);
        }else{
            $status = 2;
            $message = "Your quiz not saved. Try again.";
            $url = '';
        }
        return response()->json(['status' => $status, "message" => $message, "url" => $url]);
        
        //return view('user_quiz_response', $data);
    }
    
    public function saveFeedBack(Request $request)
    {
        //print_r($request->all()); die;
        $validator = Validator::make($request->all(), [
            'rating' => ['required', 'array'],
            'rating.*' => ['required', 'numeric', 'min:0.5'],
        ]);

        if ($validator->fails()) {
            //return redirect()->back()->withErrors($validator)->withInput();
            $allErrors = 'Please rate the all feedbacks.';
            return response()->json(['status' => 2, "message" => $allErrors, "url" => '']);
        }

        $user_id = $request->user_id;
        $event_id = $request->event_id;
        $suggestion = $request->suggestion;
        $rating = $request->rating;
        $feedbacks = [];
        foreach ($rating as $key => $rate) {
            $rating         = $request->input('rating.'.$key);
            $feedback_id    = $request->input('feedback_id.'.$key);
            $feedbacks[]    = array('fb_id' => $feedback_id, 'rating' => $rating);
        }

        $apiData = new Request([
            'emp_ev_book_id' => $event_id,
            'id' => $user_id,
            'feedbacks' => $feedbacks,
            'suggestion' => $suggestion
        ]);
        $api = new ApiUsersController();
        
        $quiz_save = $api->feedbackSave($apiData); 
        $qData = $quiz_save->getData();

        $url = '';
        $message = $qData->message;
        $status = $qData->status;
        if($status == 200){
            $status = 1;
            $url = route('my.page', ['page'=>'feedback']);
        }else{
            $status = 2;
        }
        return response()->json(['status' => $status, "message" => $message, "url" => $url]);
    }
}
