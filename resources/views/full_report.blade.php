@extends('layouts.app')
@php
  $pageNm = 'Full Report';
  $hotel_cd = $emp_event_cd = '';
  
  if(@$eventcd > 0){
    $emp_event_cd = $eventcd;
   
    //echo '<pre>';  print_r($report_data); die;
  }
  
@endphp
@section('title', $pageNm)
@section('content')

  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1>{{ $pageNm }}</h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item active">{{ $pageNm }}</li>
            </ol>
          </div>
        </div>
      </div><!-- /.container-fluid -->
    </section>

    <!-- Main content -->
    <section class="content">

      <!-- Default box -->
      <div class="card card-primary">
        <div class="card-header">
          <h3 class="card-title">{{ $pageNm }}</h3>
        </div>
        <div class="card-body p-2">
          <form action="{{ route('full_report_search') }}" method="post" class="searchReport">
            @csrf
          <div class="row">
            <div class="col-sm-3">
              <label for="exampleInputEmail1">Event Name</label>
              <select class="form-control form-control-sm eventcd" name="eventcd" onchange="rpt.getHotels(this);" data-link="{{ route('get_hotel') }}" required>
                @if(!empty($event_list))
                  @if(count($event_list) > 1)
                    <option value="">Select event</option>
                  @endif
                  @foreach($event_list as $event)
                    <option value="{{ $event->ev_id }}" {{ $emp_event_cd == $event->ev_id?'selected':''  }}>
                    {{ $event->event_name.' ('.date('d/m/Y', strtotime($event->event_datefr)).' - '.date('d/m/Y', strtotime($event->event_dateto)).')' }}
                    </option>
                  @endforeach
                @endif
              </select>
              <script> $('.eventcd').val('{{ old("eventcd")?old("eventcd"):$emp_event_cd }}'); </script>
            </div>
         
             
            <div class="col-sm-2">
              <label for="exampleInputEmail1">From Date</label>
               <input type="date" class="form-control form-control-sm" name="datefrom" value="{{ @$datefrom ??'' }}">
             
            </div>
            <div class="col-sm-2">
              <label for="exampleInputEmail1">End Date</label>
             <input type="date" class="form-control form-control-sm" name="dateto" value="{{ @$dateto ?? '' }}">
            </div>
            <div class="col-sm-2">
              <label for="exampleInputEmail1">&nbsp;</label>
            <button type="submit" name="submit_btn" value="submit" class="btn btn-sm btn-block btn-success"><i class="fa fa-search"></i> Filter</button>
            </div>

            <div class="col-sm-2">
              <label for="exampleInputEmail1">&nbsp;</label>
              <div id="export-button-container"></div>
            </div>
          </div>
          </form>
        </div>
        @if($emp_event_cd > 0)
        @php
        
        $event_name = @$report_data[0]->eventDetails->event_name;
        
        $printnm = $pageNm." \n Flight Report : ".$event_name;
        
        $printnm = $printnm." \n Print Date : ".date('d-m-Y h i s A');
        @endphp
        <div class="card-footer exportData" id="exportData" >
          <table class="table table-bordred tableExport" width="100%" data-pgNam="{{ $printnm }}" style="font-size:14px;">
            <thead>
              <tr>
                <th>Sr.No.</th>
                <th>CPF No.</th>
                <th>Emp. Name</th>
                <th>Designation</th>
                <th>Level</th>
                <th>Email Id</th>
<th>Mobile No.</th>

<th>Location</th>
<th>CATEGORY</th>

<th>Pass</th>
<th>From</th>
<th>To</th>
<th>Checkin Confirm</th>
<th>Checkout Confirm</th>

<th>Hotel</th>
<th>Room Category</th>
<th>Sharing with cpf no.</th>

<th>Arrival Airport</th>
<th>Arrival Airline</th>
<th>Date of Arrival at Destination</th>
<th>Time of Arrival at Destination</th>
<th>Fight number</th>

<th>Departue Airport</th>
<th>Departure Airline</th>
<th>Date of Departure From Destination</th>
<th>Time of Departure From Destination</th>
 
<th>Dep Flight no.</th>


<th>Driver Name</th>
<th>Driver Number</th>
<th>Vehicle Type</th>
<th>Vehicle Details</th>

<th>Trip ID</th>



              </tr>
            </thead>
            <tbody>
              @php $keyy = 0; @endphp
              @for($i = 0; $i < 1; $i++)
              @foreach ($report_data as $key => $data)
                @php
                   $checkin = $checkout = '';
                  $check_in = $data->check_in;
                  $check_out = $data->check_out;
                  if($check_in != null && strtotime($check_in) > 0){
                    $checkin = date('d/m/Y h:i A', strtotime($check_in));
                  }
                  if($check_out != null && strtotime($check_out) > 0){
                    $checkout = date('d/m/Y h:i A', strtotime($check_out));
                  }
                 
                 
                 
                  $asn_checkin = $asn_checkout = '';
                  $asn_checkin = $data->assign_check_in;
                  $asn_checkout = $data->assign_check_out;
                  if($asn_checkin != null && strtotime($asn_checkin) > 0){
                    $asn_checkin = date('d/m/Y ', strtotime($asn_checkin));
                  }
                  if($asn_checkout != null && strtotime($asn_checkout) > 0){
                    $asn_checkout = date('d/m/Y', strtotime($asn_checkout));
                  }




                  $created_at = $data->created_at;
                  $updated_at = $data->updated_at;
                  $lastUpdate = '';
                  if($updated_at != null && strtotime($updated_at) > 0){
                    $lastUpdate = date('d/m/Y h:i A', strtotime($updated_at));
                  }else{
                    $lastUpdate = date('d/m/Y h:i A', strtotime($created_at));
                  }
                @endphp
                <tr>
                  <td>{{ ($key+1) }}</td>
                  <td>{{ @$data->userDetails->cpf_no }}</td>
                  <td>{{ @$data->userDetails->name }}</td>
             
                
                 

                  <td>{{ @$data->userDetails->designation }}</td>
                  <td>{{ @$data->userDetails->level }}</td>
                  <td>{{ @$data->userDetails->email }}</td>
                  <td>{{ @$data->userDetails->mobile }}</td>
  
  <td>{{ @$data->user_location}}</td>
  <td>{{ @$data->user_category }}</td>
  
  <td>{{ @$data->user_pass}}</td>
  <td>{{ @$asn_checkin }}</td>
  <td>{{ @$asn_checkout }}</td>
  <td>{{ @$checkin }}</td>
  <td>{{ @$checkout }}</td>

  <td>{{ @$data->hotelDetails->hotel_name }}</td>
  <td>{{ @$data->categoryDetails->hotel_category }}</td>
  <td>{{ @$data->share_room_with_cpfno }}</td>
  
  <td>{{ @$data->arv_location}}</td>
  <td>{{ @$data->arv_flight_name}}</td>
 
  <td>{{ date('d/m/Y', strtotime(@$data->arv_date_time))}}</td>
  <td>{{ date('h:i A', strtotime(@$data->arv_date_time))  }}</td>
  <td>{{ @$data->arv_flight_no}}</td>
  
  <td>{{ @$data->dptr_location}}</td>
  <td>{{ @$data->dptr_flight_name}}</td>
  <td>{{ date('d/m/Y', strtotime(@$data->dptr_date_time))}}</td>
  <td>{{ date('h:i A', strtotime(@$data->dptr_date_time))  }}</td>
  <td>{{ @$data->dptr_flight_no}}</td>
  
  
  <td>{{ @$data->drvr_name}}</td>
  <td>{{ @$data->drvr_number}}</td>
  <td>{{ @$data->drvr_veh_details}}</td>
  <td>{{ @$data->vehicle_type}}</td>
   
  
  <td>{{ @$data->user_trip_id }}</td>
  







 
                   
                
                </tr>
              @endforeach
              @endfor
            </tbody>
          </table>
        </div>
        <!-- /.card-footer-->
        @endif
      </div>
      <!-- /.card -->

    </section>
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->
@endsection
@section('javascript')
<script src="{{ asset('pages/others/reports.js') }}"></script>
<script type="text/javascript">

</script>
@endsection