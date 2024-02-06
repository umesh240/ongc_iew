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
use Illuminate\Database\QueryException;
use DateTime;
use Carbon\Carbon;


use App\Http\Controllers\EmailController;
class ImportCheckInOutController extends Controller
{
    public function importCheckInOut()
    {
        $event_list = DB::table('events')->where('actv_event', 1)->get();
        $data['event_list'] = $event_list;
        $data['showlist'] = 0; 
        return view('import_checkinout', $data);
    }
    public function importCheckInOutExcel(Request $request)
    {
        // Validate the uploaded file
        $validator = Validator::make($request->all(), [
            'excel_file' => 'required|file|max:2048', // Adjust the validation rules as needed
        ]);
        /// 'excel_file' => 'required|mimes:xlsx,xls,csv|max:2048', 
        // Check file extension manually
        if ($request->hasFile('excel_file')) {
            $file = $request->file('excel_file');
            $extension = strtolower($file->getClientOriginalExtension());
            if (!in_array($extension, ['csv', 'xls', 'xlsx'])) {
                $validator->errors()->add('excel_file', 'The excel file must be a file of type: csv, xlsx, xls');
            }
        }
        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }
        $event_list = DB::table('events')->where('actv_event', 1)->get();
        $data['event_list'] = $event_list;
        $eventcd = $request->eventcd;
        $event_info = DB::table('events')->where('actv_event', 1)->where('ev_id', $eventcd)->first();
        $data['eventcd'] = $eventcd; 
        $data['event_info'] = $event_info; 
        try {
            $invalidRows = $excelRows = [];
            $file = $request->file('excel_file');
            // Define your custom validation logic here
            $excelData = Excel::toArray([], $file)[0]; // Load Excel data into an array
            // Perform custom validation on $excelData
            foreach ($excelData as $key => $row) {
                // Perform validation on each row
                $lastRow = count($row);
                if($key > 0){
                    //echo '<pre>'; print_r($row);
                    $sno                = $row[0];
                    $cpfno              = $row[1];
                    $hotel_id               = $row[2];
                    $checkin               = $row[3];
                    $checkout              = $row[4];
                }
            }
            $data['invalidRows'] = $invalidRows;
            $data['excelRows'] = $excelRows; 
            $data['showlist'] = 1; 
            $data['lastRow'] = $lastRow;
            return view('import_checkinout', $data);
        } catch (ValidationException $e) {
            return redirect()->back()->withErrors($e->failures())->withInput();
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Error processing Excel data: ' . $e->getMessage());
        }
    }
    ////////////////////    save execl   /////////////////////////////////////////
    public function importCheckInOutSave(Request $request)
    {
        try {
            //print_r($request->all());
            $info = $request->info;
            $event_id = $request->bok_ev_id;
            //echo $info."<br>";
            $row = explode(',', $info);
            //echo '<pre>'; print_r($row); die;
            $sno                = $row[0];
            $cpfno              = $row[1];
            $name               = ucwords(trim($row[2]));
            $level              = ucwords(trim($row[3]));
            $designation        = ucwords(trim($row[4]));
            $email              = trim($row[5]);
            $mobile             = $row[6];
            $location           = ucwords(trim($row[7]));
            $category           = ucwords(trim($row[8]));
            $pass               = $row[9];
            $from_dt            = $row[10];
            $to_dt              = $row[11];
            $hotel_nm           = ucwords(trim($row[12]));
            $category_room      = ucwords(trim($row[13]));
            $share_room_info    = trim($row[14]);
            $arrival_airport    = trim($row[15]);
            $arrival_airline    = trim($row[16]);
            $arrival_dt         = trim($row[17]);
            $arrival_tm         = trim($row[18]);
            $arrival_flightno   = trim($row[19]);
            $depart_airport     = trim($row[20]);
            $depart_airline     = trim($row[21]);
            $depart_dt          = trim($row[22]);
            $depart_tm          = trim($row[23]);
            $depart_flightno    = trim($row[24]);
            $driver_name        = $row[25];
            $driver_number      = $row[26];
            $vehicle_type       = $row[27];
            $vehicle_details    = $row[28];
            $trip_id            = $row[29];
            /*
            $arrival_dt         = $row[14];
            $arrival_tm         = $row[15];
            $arrival_flightno   = $row[16];
            $depart_dt          = $row[17];
            $depart_tm          = $row[18];
            $depart_flightno    = $row[19];
            $vehile_details     = $row[20];
            $driver_no          = $row[21];
            */
            $present_in_hotel   = $row[30];
            $row_status         = $row[31];
            $user = Auth()->user();
            $userId = $user->id;
            $today = date('Y-m-d H:i:s');
            $password = 'admin123';
            if($email == '' || empty($email)){
                $email = null;
            }
            $email = strtolower($email);
            
            $row_data = [];
            $row_data['name']        = ucwords(@$name);
            $row_data['email']       = @$email;
            $row_data['mobile']      = @$mobile;
            $row_data['level']       = ucwords(@$level);
           

            $userFind = DB::table('users')->where('cpf_no', $cpfno)->first();
            $userIdd = @$userFind->id;
           
            //$status_in_htl = $present_in_hotel == 'NO'?0:1;
            $row_data = [];   /// book event
            
        
            $row_data['assign_check_in']        = $from_dt;
            $row_data['assign_check_out']       = $to_dt;
         
            $dataMsg = [];
            //print_r($row_data);
         
            // $updateEvent = DB::table('event_books_emp')->where('emp_event_cd', $event_id)->where('emp_cd', $emp_id)
            //                 ->update(['status_in_htl' => 0, 'updated_at' => $today]);

          
            return response()->json($dataMsg);
        }catch (QueryException $e) {
            $errorMessage = $e->getMessage();
            \Log::error("Exception: " . $errorMessage);
            return response()->json(['status' => 2, 'message' => 'An error occurred while submitting the form.^'.$errorMessage]);

        } catch (\Exception $e) {
            $errorMessage = $e->getMessage();
            \Log::error("Exception: " . $e->getMessage());
            return response()->json(['status' => 2, 'message' => 'An unexpected error occurred. %^'.$errorMessage]);
        }
    }
}