<?php 
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Redirect;


if (! function_exists('dd')) {
    function dd($data, $de=0) {
        echo '<pre>';
        print_r($data);
        echo '</pre>';
        die;
    }
}
if (! function_exists('cacheClear')) {
    function cacheClear() {
        Artisan::call('cache:clear');
        Artisan::call('route:clear');
        Artisan::call('config:clear');
        Cache::flush();
    }
}
if (! function_exists('dateConvert')) {
    function dateConvert($formet, $date) {
        return date($formet, strtotime($date));
    }
}
if (! function_exists('timeDifference')) {
    function timeDifference($startDate, $endDate = '') {
        if(empty($endDate) || $endDate == null){
            $endDate = date('Y-m-d h:i:s');
        }
        $startTimestamp = strtotime($startDate);
        $endTimestamp = strtotime($endDate);

        // Calculate the difference in seconds
        $difference = $endTimestamp - $startTimestamp;

        // Calculate the difference in days, hours, and minutes
        $days = floor($difference / (60 * 60 * 24));
        $difference -= $days * 60 * 60 * 24;
        $hours = floor($difference / (60 * 60));
        $difference -= $hours * 60 * 60;
        $minutes = floor($difference / 60);

        $dayDiff = '';
        if($days > 0){
            $dayDiff .= $days.($days > 1?' days':'day');
        }
        if($hours > 0){
            $dayDiff .= $hours.($hours > 1?' hrs':'hr');
        }
        $dayDiff .= $minutes.($minutes > 1?' mins':'mins');
        return $dayDiff;
    }
}
if (! function_exists('vacentRoomCalculation')) {
    function vacentRoomCalculation() {
        
        $roomCatList = DB::table('hotels_category')->where('soft_delete_yn', 0)->orderBy('htl_cat_id')->get();
        foreach ($roomCatList as $key => $roomCat) {
            $htl_cat_id = $roomCat->htl_cat_id;
            $htl_idd = $roomCat->htl_idd;
            $total_rooms = $roomCat->total_rooms;
            $occupied_rooms = $roomCat->occupied_rooms;
            $vacent_rooms = $roomCat->vacent_rooms;

            $occupiedRooms = DB::table('event_books_emp')->where('emp_hotel_cd', $htl_idd)->where('emp_hotel_cat_cd', $htl_cat_id)
                            ->where('status_in_htl', 1)->count();
            //echo '>>|'.$roomCatList.'-'.$htl_cat_id.'-'.$htl_idd;
            $vacent_rooms = $total_rooms - $occupiedRooms;               
            DB::table('hotels_category')->where('htl_cat_id', $htl_cat_id)->update(['occupied_rooms' => $occupiedRooms, 'vacent_rooms' => $vacent_rooms]);
        }
        return 1;
    }
}
?>