@extends('layouts.app')
@php
  $pageNm = 'Event-Hotel Wise Report';
  $hotel_cd = $emp_event_cd = '';
  
  if(@$eventcd > 0){
    $emp_event_cd = $eventcd;
    $hotel_cd = $hotelcd;
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
          <form action="{{ route('hotel_wise_search') }}" method="post" class="searchReport">
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
            <div class="col-sm-3">
              <label for="exampleInputEmail1">Hotel Name</label>
              <select class="form-control form-control-sm hotel_cd" name="hotel_cd" data-hotel_cd="{{ $hotel_cd }}"></select>
            </div>
            <div class="col-sm-3">
              <label for="withCkInOut"></label>
              <div class="form-group">
                <div class="custom-control custom-checkbox">
                  <input class="custom-control-input custom-control-input-success custom-control-input-outline with_ck_inout" type="checkbox" id="withCkInOut" value="1" name="with_ck_inout" {{ @$with_ck_inout==1?'checked':'' }}>
                  <label for="withCkInOut" class="custom-control-label">With Checked-In/Out</label>
                </div>
              </div>
            </div>
            <div class="col-sm-1">
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
        $hotel_name = @$report_data[0]->hotelDetails->hotel_name;
        $printnm = $pageNm." \n Event : ".$event_name;
        if($hotel_cd > 0){
          $printnm = $printnm." \n Hotel : ".$hotel_name;
        }
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
                <th>Share With</th>
                <th>Hotel Name</th>
                <th>Room Category</th>
                <th>Assigned Check-in</th>
                <th>Assigned Check-out</th>
                @if(@$with_ck_inout == 1)
                <th>Confirmed Check-in</th>
                <th>Confirmed Check-out</th>
                @endif
                <th>Last Update</th>
                <th>Status</th>
              </tr>
            </thead>
            <tbody>
              @php $keyy = 0; @endphp
              @for($i = 0; $i < 1; $i++)
              @foreach ($report_data as $key => $data)
                @php
                  $status_in_htl = $data->status_in_htl;
                  if($status_in_htl == 1){
                    $status_htl = 'Attending';
                  }else if($status_in_htl == 0){
                    $status_htl = 'Not Attending';
                  }else{
                    $status_htl = '';
                  }
                  $asn_checkin = $asn_checkout = '';
                  $assign_check_in = $data->assign_check_in;
                  $assign_check_out = $data->assign_check_out;
                  if($assign_check_in != null && strtotime($assign_check_in) > 0){
                    $asn_checkin = date('d/m/Y h:i A', strtotime($assign_check_in));
                  }
                  if($assign_check_out != null && strtotime($assign_check_out) > 0){
                    $asn_checkout = date('d/m/Y h:i A', strtotime($assign_check_out));
                  }

                  $checkin = $checkout = '';
                  $check_in = $data->check_in;
                  $check_out = $data->check_out;
                  if($assign_check_in != null && strtotime($check_in) > 0){
                    $checkin = date('d/m/Y h:i A', strtotime($check_in));
                  }
                  if($check_out != null && strtotime($check_out) > 0){
                    $checkout = date('d/m/Y h:i A', strtotime($check_out));
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
                  <td></td>
                  <td>{{ @$data->hotelDetails->hotel_name }}</td>
                  <td>{{ @$data->categoryDetails->hotel_category }}</td>
                  <td>{{ @$asn_checkin }}</td>
                  <td>{{ @$asn_checkout }}</td>
                  @if(@$with_ck_inout == 1)
                  <td>{{ @$checkin }}</td>
                  <td>{{ @$checkout }}</td>
                  @endif
                  <td>{{ @$lastUpdate }}</td>
                  <td>{{ @$status_htl }}</td>
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