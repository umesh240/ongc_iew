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
use App\Http\Controllers\ReportsController;

class CheckInOutSummeryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $rpt = new ReportsController();
        $event_list = $rpt->eventList();
        $data['event_list'] = $event_list;
        return view('check_inout_summery', $data);
    }

    /**
     * Display the specified resource.
     */
    public function show(Request $request)
    {
        $eventcd = $request->eventcd;
        $hotel_cd = @$request->hotel_cd;
        $data = [];
        // ->where('emp_hotel_cd', $hotel_cd)
        $report_data = EventBook::where('emp_event_cd', $eventcd)->where('status_in_htl', 1)
                    ->when($hotel_cd > 0, function ($query) use ($hotel_cd) {
                        $query->where('emp_hotel_cd', $hotel_cd);
                    })
                    ->with(['eventDetails', 'hotelDetails', 'categoryDetails'])
                    ->orderBy('check_in', 'asc')->get();
        $data['report_data'] = $report_data;
        $data['eventcd'] = $eventcd;
        $data['hotelcd'] = $hotel_cd;

        $rpt = new ReportsController();
        $event_list = $rpt->eventList();
        $data['event_list'] = $event_list;

        return view('check_inout_summery', $data);
    }
    public function indexRMA()
    {
        $rpt = new ReportsController();
        $event_list = $rpt->eventList();
        $data['event_list'] = $event_list;
        vacentRoomCalculation();
        return view('room_availability', $data);
    }
    public function room_available(Request $request)
    {
        $eventcd = $request->eventcd;
        $hotel_cd = @$request->hotel_cd;
        $fr_date = $request->fr_date;
        $fr_date = date('Y-m-d', strtotime($fr_date));
        $to_date = $request->to_date;
        $to_date = date('Y-m-d', strtotime($to_date));

        $data = [];

        $report_data = DB::table('hotels_category')
            ->leftJoin('hotels', 'hotels_category.htl_idd', '=', 'hotels.htl_id')
            ->leftJoin('event_books_emp', function ($join) use ($fr_date, $to_date) {
                $join->on('hotels_category.htl_cat_id', '=', 'event_books_emp.emp_hotel_cat_cd')
                    ->where('event_books_emp.status_in_htl', '=', 1)
                    ->where(function ($query) use ($fr_date, $to_date) {
                        $query->whereNull('event_books_emp.check_in')
                            ->whereNull('event_books_emp.check_out')
                            ->orWhere(function ($query) use ($fr_date, $to_date) {
                                $query->whereNotNull('event_books_emp.check_in')
                                    ->whereNotNull('event_books_emp.check_out')
                                    ->where(function ($query) use ($fr_date, $to_date) {
                                        $query->where('event_books_emp.check_out', '<', "$fr_date")
                                            ->orWhere('event_books_emp.check_in', '>', "$to_date");
                                    });
                            })
                            ->orWhere(function ($query) use ($fr_date, $to_date) {
                                $query->whereNull('event_books_emp.check_in')
                                    ->whereNotNull('event_books_emp.check_out')
                                    ->where('event_books_emp.check_out', '<', "$fr_date");
                            })
                            ->orWhere(function ($query) use ($fr_date, $to_date) {
                                $query->whereNotNull('event_books_emp.check_in')
                                    ->whereNull('event_books_emp.check_out')
                                    ->where('event_books_emp.check_in', '>', "$to_date");
                            });
                    });
            })
            ->when($hotel_cd > 0, function ($query) use ($hotel_cd) {
                $query->where('hotels_category.htl_idd', $hotel_cd);
            })
            ->where('hotels_category.total_rooms', '>', 0)
            ->groupBy(DB::raw("IF(event_books_emp.share_room_with_empcd IS NOT NULL, event_books_emp.share_room_with_empcd, event_books_emp.emp_hotel_cat_cd)"))
            ->orderBy('hotels.hotel_name')
            ->select(
                'hotels.hotel_name',
                'hotels_category.hotel_category',
                'hotels_category.total_rooms',
                'hotels_category.htl_cat_id',
                'hotels_category.htl_idd',
                'event_books_emp.emp_hotel_cat_cd',
                'event_books_emp.emp_hotel_cd',
                DB::raw('count(event_books_emp.emp_hotel_cd) as occupied_room'),
                DB::raw('(hotels_category.total_rooms - count(event_books_emp.emp_hotel_cd)) as vacent_room')
            )
            ->get();


                    
        $data['report_data'] = $report_data;
        $data['eventcd'] = $eventcd;
        $data['hotelcd'] = $hotel_cd;
        $data['frdate'] = $fr_date;
        $data['todate'] = $to_date;

        $rpt = new ReportsController();
        $event_list = $rpt->eventList();
        $data['event_list'] = $event_list;

        return view('room_availability', $data);
    }

    
}
