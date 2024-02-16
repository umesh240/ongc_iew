<?php

namespace App\Http\Controllers;

use App\Models\Event;
use App\Models\Users;
use App\Models\EventBook;
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
//use PDF;
//use Dompdf\Dompdf; 


class ReportsController extends Controller
{
    /**
     * Display a listing of the resource.
     */

    public function eventList($active = 0)
    {
        $event_list = DB::table('events')
            ->when($active == 1, function ($query) use ($active) {
                return $query->where('actv_event', $active);
            })->get();
        return $event_list;
    }

    public function indexHW()
    {
        $event_list = $this->eventList();
        //$event_list = DB::table('events')->where('actv_event', 1)->get();
        $data['event_list'] = $event_list;
        return view('hotel_wise', $data);
    }


    public function indexFD()
    {
        $event_list = $this->eventList();
        //$event_list = 
        $data['event_list'] = $event_list;
        $data['flight_report'] = DB::table('events')->where('actv_event', 1)->get();
        return view('flight_report', $data);
    }
    public function indexFR()
    {
        $event_list = $this->eventList();
        //$event_list = 
        $data['event_list'] = $event_list;
        $data['full_report'] = DB::table('events')->where('actv_event', 1)->get();
        return view('full_report', $data);
    }
    /**
     * Display the specified resource.
     */
    public function showHW(Request $request)
    {
        //print_r($request->all()); die;
        $submit_btn = $request->submit_btn;
        $eventcd = $request->eventcd;
        $hotel_cd = $request->hotel_cd;
        $with_ck_inout = @$request->with_ck_inout;
        $data = [];

        //$event_list = DB::table('events')->where('actv_event', 1)->get();
        $event_list = $this->eventList();
        $data['event_list'] = $event_list;
        $data['with_ck_inout'] = $with_ck_inout;

        $emp1 = DB::table('event_books_emp')->where('emp_event_cd', $eventcd)
            ->when($hotel_cd > 0, function ($query) use ($hotel_cd) {
                $query->where('emp_hotel_cd', $hotel_cd);
            })->where('status_in_htl', 1)->distinct()
            ->orderBy('updated_at', 'desc')->select('emp_ev_book_id', 'emp_cd', 'updated_at')->get();

        $emp2 = DB::table('event_books_emp')->where('emp_event_cd', $eventcd)
            ->when($hotel_cd > 0, function ($query) use ($hotel_cd) {
                $query->where('emp_hotel_cd', $hotel_cd);
            })->where('status_in_htl', 0)->distinct()
            ->orderBy('updated_at', 'desc')->select('emp_ev_book_id', 'emp_cd', 'updated_at')->get();

        $empArr = [];
        foreach ($emp1 as $key => $emp1Val) {
            $keyAr = 'emp_cd_' . $emp1Val->emp_cd;
            $empArr[$keyAr] = $emp1Val->emp_ev_book_id;
        }
        foreach ($emp2 as $key => $emp2Val) {
            $keyAr = 'emp_cd_' . $emp2Val->emp_cd;
            if (!array_key_exists($keyAr, $empArr)) {
                $empArr[$keyAr] = $emp2Val->emp_ev_book_id;
            }
        }
        $evEmpIds = implode(',', $empArr);
        $report_data = EventBook::where('emp_event_cd', $eventcd)->whereIn('emp_ev_book_id', $empArr)
            ->when($hotel_cd > 0, function ($query) use ($hotel_cd) {
                $query->where('emp_hotel_cd', $hotel_cd);
            })
            ->with(['userDetails', 'eventDetails', 'hotelDetails', 'categoryDetails', 'shareUserDetails'])
            ->orderBy('event_books_emp.updated_at', 'desc')
            ->get();

        foreach ($report_data as $key => $value) {
            // Fetch additional information for each event and add it to the event data
            if (!empty($value->share_room_with_empcd)) {
                $report_data[$key]->shareUserDetails = DB::table('event_books_emp')
                    ->where('emp_cd', $value->share_room_with_empcd)
                    ->where('emp_cd', '!=', $value->emp_cd)
                    ->first();
            }
        }
        $data['report_data'] = $report_data;
        //print_r($report_data); die;
        $data['report_data'] = $report_data;
        $data['eventcd'] = $eventcd;
        $data['hotelcd'] = $hotel_cd;
        return view('hotel_wise', $data);
        //return redirect()->route('hotel_wise', $data);
    }


    public function showFD(Request $request)
    {
        //print_r($request->all()); die;
        $submit_btn = $request->submit_btn;
        $eventcd = $request->eventcd;
        $datefrom = $request->datefrom;
        $dateto = $request->dateto;

        $data = [];

        //$event_list = DB::table('events')->where('actv_event', 1)->get();
        $event_list = $this->eventList();
        $data['event_list'] = $event_list;

        $report_data = EventBook::where('emp_event_cd', $eventcd)->where('status_in_htl', 1)->where('flight_status', 1);

        if (!empty($datefrom)) {
            $data['datefrom'] = date('Y-m-d', strtotime($datefrom)); //$datefrom;
            $report_data = $report_data->whereDate('event_books_emp.flight_create_date', '>=', $datefrom);
        }

        if (!empty($dateto)) {
            $report_data = $report_data->whereDate('event_books_emp.flight_create_date', '<=', $dateto);
            $data['dateto'] =  date('Y-m-d', strtotime($dateto)); // $dateto;
        }

        $report_data = $report_data->orderBy('event_books_emp.updated_at', 'desc')->get();

        //print_r($report_data); die;
        $data['report_data'] = $report_data;
        $data['eventcd'] = $eventcd;


        return view('flight_report', $data);
        //return redirect()->route('hotel_wise', $data);
    }


    public function showFR(Request $request)
    {
        //print_r($request->all()); die;
        $submit_btn = $request->submit_btn;
        $eventcd = $request->eventcd;
        $datefrom = $request->datefrom;
        $dateto = $request->dateto;
         
        $data = [];
        $with_ck_inout = @$request->with_ck_inout;
        $hotel_cd = 0;
        $data['with_ck_inout'] = $with_ck_inout;
        //$event_list = DB::table('events')->where('actv_event', 1)->get();
        $event_list = $this->eventList();
        $data['event_list'] = $event_list;
        $emp1 = DB::table('event_books_emp')->where('emp_event_cd', $eventcd)
            ->when($hotel_cd > 0, function ($query) use ($hotel_cd) {
                $query->where('emp_hotel_cd', $hotel_cd);
            })->where('status_in_htl', 1)->distinct()
            ->orderBy('updated_at', 'desc')->select('emp_ev_book_id', 'emp_cd', 'updated_at')->get();

        $emp2 = DB::table('event_books_emp')->where('emp_event_cd', $eventcd)
            ->when($hotel_cd > 0, function ($query) use ($hotel_cd) {
                $query->where('emp_hotel_cd', $hotel_cd);
            })->where('status_in_htl', 0)->distinct()
            ->orderBy('updated_at', 'desc')->select('emp_ev_book_id', 'emp_cd', 'updated_at')->get();

        $empArr = [];
        foreach ($emp1 as $key => $emp1Val) {
            $keyAr = 'emp_cd_' . $emp1Val->emp_cd;
            $empArr[$keyAr] = $emp1Val->emp_ev_book_id;
        }
        foreach ($emp2 as $key => $emp2Val) {
            $keyAr = 'emp_cd_' . $emp2Val->emp_cd;
            if (!array_key_exists($keyAr, $empArr)) {
                $empArr[$keyAr] = $emp2Val->emp_ev_book_id;
            }
        }
        $evEmpIds = implode(',', $empArr);


        $report_data = EventBook::where('emp_event_cd', $eventcd)->whereIn('emp_ev_book_id', $empArr)
            ->when($hotel_cd > 0, function ($query) use ($hotel_cd) {
                $query->where('emp_hotel_cd', $hotel_cd);
            })
            ->with(['userDetails', 'eventDetails', 'hotelDetails', 'categoryDetails', 'shareUserDetails']);


        if (!empty($datefrom)) {
            $data['datefrom'] = date('Y-m-d', strtotime($datefrom)); //$datefrom;
            $report_data = $report_data->whereDate('event_books_emp.flight_create_date', '>=', $datefrom);
        }

        if (!empty($dateto)) {
            $report_data = $report_data->whereDate('event_books_emp.flight_create_date', '<=', $dateto);
            $data['dateto'] =  date('Y-m-d', strtotime($dateto)); // $dateto;
        }

       

        //print_r($report_data); die;

        $data['eventcd'] = $eventcd;
       
        if (!empty($request->with_ck_inout)) {
            $report_data->where('share_room_with_empcd', '!=', '0')
            ->whereNotNull('share_room_with_empcd');

           
        }  

        $report_data = $report_data->orderBy('event_books_emp.updated_at', 'desc')->get();

        foreach ($report_data as $key => $value) {
            // Fetch additional information for each event and add it to the event data
            $report_data[$key]->share_room_with = DB::table('event_books_emp')
                ->where('emp_cd', $value->share_room_with_empcd)
                ->where('emp_cd', '!=', $value->emp_cd)
                ->first();
        }
        $data['report_data'] = $report_data;
        //echo "<pre>";print_r($data); 
        return view('full_report', $data);
        //return redirect()->route('hotel_wise', $data);
    }







    /**
     * Show the form for creating a new resource.
     */
    public function hotelList(Request $request)
    {
        $eventcd = $request->eventcd;
        $htl_list = DB::table('event_books_emp')->select('event_books_emp.emp_event_cd', 'hotels.*')
            ->leftJoin('hotels', 'hotels.htl_id', '=', 'event_books_emp.emp_hotel_cd')
            ->where('event_books_emp.emp_event_cd', $eventcd)->distinct()->get();
        $opts = '';
        if (count($htl_list) > 0) {
            $opts = '<option value="">Select All</option>';
            foreach ($htl_list as $key => $value) {
                $htl_id = $htl_list[$key]->htl_id;
                $hotel_name = $htl_list[$key]->hotel_name;
                $opts .= '<option value="' . $htl_id . '">' . $hotel_name . '</option>';
            }
        } else {
            $opts = '<option>No record found.</option>';
        }
        return response()->json(['opts' => $opts]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Event $event)
    {
        //
    }
    public function generatePDF(Request $request)
    {
        $htmlContent = $request->input('htmlContent');

        // Create a PDF instance and add the text content
        $pdf = PDF::loadHTML($htmlContent);

        // Save or download the PDF
        return $pdf->download('exported.pdf');
    }
}
