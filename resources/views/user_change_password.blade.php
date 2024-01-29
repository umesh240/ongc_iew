@extends('layouts.app_user_new')
@php
  $curRouteNm = Route::currentRouteName();
  $pageNm = 'FAQs';
@endphp
@section('pageName', 'Change Password')
@section('title', $pageNm)
@section('content')


<!-- <section class="password-banner">
  <div class="pswd-bg"></div>
   <div class="container">
     <h2><i>
"Enhance your security: Change your password regularly to safeguard your account and ensure continued protection."</i></h2>  
   </div>
</section> -->

<section class="change-password" style="background-color: #EFF7FF;">
  <div class="content-colour">
    <div class="container">
      <div class="row d-flex align-items-center justify-content-center">
        <div class="col-md-8">
          <div class="form" id="hotelName">
            <form class="form-password" action="{{ route('change_password') }}" method="post">
              @csrf				
              <div class="form-group">
                <label for="exampleInputCRF" class="label-pswd mb-2">Old Password</label>
                <input type="password" class="form-control" name="old_password" value="" placeholder=" Enter old password"><i class="fas fa-lock"></i>
                 <div class="eye-icon">
                   <i class="fas fa-eye"></i>
                 </div>
              </div>

              <div class="form-group">
                <label for="exampleInputName" class="label-pswd mb-2">New Password</label>
                <input type="password" class="form-control" name="new_password" value="" placeholder=" Enter new password"><i class="fas fa-lock"></i>
                  <div class="eye-icon">
                   <i class="fas fa-eye"></i>
                 </div>
              </div>

              <div class="form-group ">
                <label for="exampleInputnumber" class="label-pswd mb-2">Confirm Password</label>
                 <input type="password" class="form-control" name="confirm_password" value="" placeholder="Enter confirm password"> <i class="fas fa-lock"></i>
                   <div class="eye-icon">
                   <i class="fas fa-eye"></i>
                 </div>
              </div>
              <div id="button">
                <button type="button" class="checkinbtn" id="submitRequest" name="button" onclick="ud.password(this)">Change Password</button>
              </div>
            </form>
          </div>
        </div>
      </div>
    </div>
  </div>
</section>
@endsection

@section('javascript')
<script>
ud = {
  password: function(thiss){
    var form = $('.form-password');
    var formData = form.serialize();
    var route = form.attr('action');
    $.ajax({
      type: "POST",
      url: route,
      data: formData,
      beforeSend: function(){
        $('.loading-container').css('display', 'flex');
      },
      success:function(response){
       // console.log(response);
       var status = response.status;
        var message = response.message;
        var type = 2;
        if(status == '200'){
          type = 1;
          setTimeout(function() {  location = "{{ route('my.dashboard') }}"; }, 2000);
        }
        show_msgT(type, message);
        $('.loading-container').css('display', 'none');
      }
    });
  }
}
</script>
@endsection