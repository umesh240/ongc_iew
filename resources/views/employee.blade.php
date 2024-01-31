@extends('layouts.app')
@php
  $curRouteNm = Route::currentRouteName();
  $pageNm = 'Employee Master ';
@endphp
@section('title', $pageNm)
@section('content')

<!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1 class="m-0">{{ $pageNm }}<font class="activePg">List</font></h1>
          </div><!-- /.col -->
          <div class="col-sm-6">
            <button onclick="window.location='{{ route("employee.ae", ["ae" => "add"]) }}';" class="btn btn-sm btn-success float-right mr-1"><i class="fa fa-plus"></i> Add New User</button>
            <button onclick="window.location='{{ route("employee.ae", ["ae" => "event"]) }}';" class="btn btn-sm btn-success float-right mr-1"><i class="fa fa-address-card"></i> Add New Event</button>
          </div><!-- /.col -->
        </div><!-- /.row -->
      </div><!-- /.container-fluid -->
    </div>
    <hr class="w-100 mt-0">
    <!-- /.content-header -->

    <!-- Main content -->
    <div class="content">
      <div class="container-fluid">
      <div class="row">
          <div class="col-lg-12">
             {{ $employee_list->links('vendor.pagination.search', ['routename' => "employee", 'list_length' => $list_length, 'list_search' => $list_search, 'events_list' => @$events_list, 'event_cd' => $event_code, 'level_list' => @$level_list, 'level_code' => $level_code, 'hotel_list' => @$hotel_list, 'hotel_code' => $hotel_code]) }}
          </div>
          <div class="col-lg-12">
            <table class="table table-bordered" width="100%" style="min-width: 100%;">
              <thead>
                <tr>
                  <th>CPF No.</th>
                  <th>Name</th>
                  <th>Email</th>
                  <th>Mobile</th>
                  <th>Level</th>
                  <th>Designation</th>
                  <th style="width:15%;">Action</th>
                </tr>
              </thead>
              <tbody>
              @php $cnt = 0; @endphp 
              @foreach ($employee_list as $employee) 
              @php 
                //echo '<pre>'; print_r($employee_list); die;
                $cnt++; 
                $ttlActvUsrRecord = @$employee->total_active_records;
                $active_hotel_name = @$employee->active_hotel_names;
                $status_in_htl = @$employee->status_in_htl;
                $title = $bkColor = '';
                if(@$event_code > 0 && $status_in_htl == 0){
                  $bkColor = 'background-color: #ffd7d7;';
                  $title = "Remove from hotel";
                }
                if($ttlActvUsrRecord > 0){
                  $title = "Assigned to hotal : <br>*".$active_hotel_name;
                }
                $userInfo = $employee->cpf_no.' - '.$employee->name;
              @endphp 
              <tr style="{{ $bkColor }}" title="{{ $title }}" data-toggle="tooltip" data-html="true">
                <td style="padding-top: 2px; padding-bottom: 2px;">{{ $employee->cpf_no; }}</td>
                <td style="padding-top: 2px; padding-bottom: 2px;">{{ $employee->name; }}</td>
                <td style="padding-top: 2px; padding-bottom: 2px;">{{ $employee->email; }}</td>
                <td style="padding-top: 2px; padding-bottom: 2px;">{{ $employee->mobile; }}</td>
                <td style="padding-top: 2px; padding-bottom: 2px;">{{ $employee->level; }}</td>
                <td style="padding-top: 2px; padding-bottom: 2px;">{{ $employee->designation; }}</td>
                <td style="padding-top: 2px; padding-bottom: 2px;">
                  @if(@$event_code > 0 && @$status_in_htl == 0)
                    @if($ttlActvUsrRecord > 0)
                      Assign Other Hotel
                    @else
                      <button type="button" class="btn btn-xs btn-warning" onclick="window.location='{{ route("employee.ae", ["id" => $employee->id, "event_id" => @$employee->emp_ev_book_id, "ae" => "event"]) }}';" title="Re-assign Event"><i class="fa fa-pencil-alt"></i> Re-assign</button>
                    @endif
                  @else
                    
                      <button type="button" class="btn btn-xs btn-success" onclick="window.location='{{ route("employee.ae", ["id" => $employee->id, "event_id" => @$employee->emp_ev_book_id, "ae" => "event"]) }}';" title="View/Edit User's Event"><i class="fa fa-pencil-alt"></i></i></button>
                    
 
                      
                    <button type="button" class="btn btn-xs btn-danger" data-link="{{ route('employee.delete') }}" onclick="recordsDelete(this, '{{$employee->id}}', '{{ @$employee->emp_ev_book_id }}');" title="Delete"><i class="fa fa-trash"></i></button>
                  @endif
                  <button type="button" class="btn btn-xs btn-info" onclick="passwordReset(this, '{{$employee->id}}', '{{ $userInfo }}');" title="Password Change"><i class="fa fa-unlock-alt"></i></button>
                </td>
              </tr>
              @endforeach
              @php if($cnt == 0){
                echo '<tr><td colspan="5">No record found.</td></tr>';
              } 
              @endphp 
              </tbody>
            </table>
          </div>
          <div class="col-lg-12">
            {{ $employee_list->links('vendor.pagination.bootstrap-4', ['routename' => "employee", 'event_cd' => $event_code, 'level_code' => $level_code, 'hotel_code' => $hotel_code, 'list_length' => $list_length, 'list_search' => $list_search]) }}
          </div>
        </div>
        <!-- /.row -->
      </div>
      <!-- /.container-fluid -->
    </div>
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->

  <!-- Password Modal -->
<div id="mdlPwdChange" class="modal fade" role="dialog">
  <div class="modal-dialog">
    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header bg-primary">
        <h5 class="modal-title">Change Password</h5>
        <button type="button" class="close" data-dismiss="modal">&times;</button>
      </div>
      <div class="modal-body">
        <form action="{{ route('password.change') }}" method="post" class="frmPwdUpdt">
          @csrf
          <input type="hidden" name="emp_id" class="emp_id" value="0">
          <div class="row">
            <div class="col-sm-12 form-group mb-0">
              <label for="exampleInputEmail1">Employee : </label>
              <span><font class="fntUserInfo"></font></span>
            </div>
            <div class="col-sm-6 form-group mb-0">
              <label for="exampleInputEmail1">New Password</label>
              <input type="password" class="form-control form-control-sm new_password" name="new_password" id="new_password" placeholder="Enter new password">
            </div>
            <div class="col-sm-6 form-group mb-0">
              <label for="exampleInputEmail1">Confirm Password</label>
              <input type="password" class="form-control form-control-sm confirm_password" name="confirm_password" id="confirm_password" placeholder="Enter new password">
            </div>
          </div>
        </form>
      </div>
      <div class="modal-footer" style="display:block;">
        <button type="button" class="btn btn-sm btn-success float-left btnPwdUpdt">Update Password</button>
        <button type="button" class="btn btn-sm btn-danger float-right" data-dismiss="modal">Close</button>
      </div>
    </div>

  </div>
</div>
@endsection

@section('javascript')
<script type="text/javascript">
function passwordReset(thiss, idd, userInfo){
  $('.fntUserInfo').text(userInfo);
  $('.emp_id').attr('value', idd).val(idd);
  $('#mdlPwdChange').modal('show');
}
$('.btnPwdUpdt').on('click', function(){
  var urlPath = $('.frmPwdUpdt').attr('action');
  var allData = $('.frmPwdUpdt').serialize();
  $.ajax({
    url: urlPath,
    type: 'POST',
    data: allData,
    success: function(response) {
      //console.log(response);
      var status = response.status;
      var message = response.message;
      show_msgT(status, message);
      if(status == '1'){
        $('#mdlPwdChange').find('.emp_id').val(0);
        $('#mdlPwdChange').find('.confirm_password').val('');
        $('#mdlPwdChange').find('.new_password').val('');
        $('#mdlPwdChange').modal('hide');
      }
    },
    error: function(xhr) {
        // Handle errors
    }
  });
});
</script>
@endsection