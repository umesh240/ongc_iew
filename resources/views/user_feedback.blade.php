@extends('layouts.app_user_new')
@php
  $curRouteNm = Route::currentRouteName();
  $pageNm = 'FAQs';
  $user_id    = @$feedbackList->response->user_id;
  $event_id   = @$feedbackList->response->emp_event_id;
  $status     = @$feedbackList->status;
  $feedbacks  = @$feedbackList->response->feedback_list;
  //echo '<pre>'; print_r($feedbackList); die;
@endphp
@section('pageName', 'Feedback')
@section('title', $pageNm)
@section('content')
<style type="text/css">
.inner-banner {
  background: url(pages/images/feedback.jpg) no-repeat 0% 50%;
    background-attachment: scroll;
  min-height: 200px;
  background-size: cover;
  background-attachment: fixed;
  position: relative;  
}
#breadcrumb_wrapper {
    width: 100%;
    text-align: center;
    color: #fff;
    background-color: rgba(0, 0, 0, 0.62);
    position: absolute;
    height: 100%;
    top: 0;
    display: flex;
    align-items: center;
}

div#breadcrumb_wrapper h2 {
    text-transform: uppercase;
    font-size: 33px;
    margin-bottom: 10px;
    color: #fff;
}

div#breadcrumb_wrapper h6 {
    color: #fff;
    font-size: 15px;
    font-weight: 400;
}
</style>
<!--<section class="content">
  <div class="">
    <div class="inner-banner demo-2 text-center">
      <div id="breadcrumb_wrapper">
        <div class="container">
          <h2>Feedback</h2>
          <h6>Your feedback is important for us</h6>
        </div>
      </div>
    </div>
  </div>
</section>-->

<section class="w3l-faq" id="faq">
<div class="container">
  <div class="row d-flex align-items-center justify-content-center">
    @if($status == 200)
    <form class="feedback-frm" action="{{ route('save_feedback') }}" method="post">
      @csrf
      <input type="hidden" name="user_id" class="user_id" value="{{ $user_id }}">
      <input type="hidden" name="event_id" class="event_id" value="{{ $event_id }}">
    <div class="col-sm-10">
      @foreach($feedbacks as $key => $fdb)
      <div class="text-content">
      <p class="mb-3  text-center">{{ $key+1 }}. {{ $fdb->feedback }}</p>
      <p class="rating_p text-center">
        <i class="faRate fa fa-regular fa-star text-orange fa-2x"></i>
        <i class="faRate fa fa-regular fa-star text-orange fa-2x"></i>
        <i class="faRate fa fa-regular fa-star text-orange fa-2x"></i>
        <i class="faRate fa fa-regular fa-star text-orange fa-2x"></i>
        <i class="faRate fa fa-regular fa-star text-orange fa-2x"></i>
        <input type="hidden" name="feedback_id[]" class="feedback_id" value="{{ $fdb->fb_id }}">
        <input type="hidden" name="rating[]" class="rating" value="{{ $fdb->rating > 0 ? $fdb->rating:0 }}">
      </p>
      </div>
      @endforeach
      <textarea rows="4" name="suggestion" placeholder="Enter your suggestion here" style="width:100%;"></textarea>
      <button class="edit-btn btnSubmitFeedback" type="button"> Submit</button>
    </div>
    </form>
    @endif
  </div>
  </div>
</section>
@endsection

@section('javascript')
<script type="text/javascript">
$('.faRate').on('click', function(){
  var ppp = $(this).closest('.rating_p');
  var rating_prv = ppp.find('.rating').val();
  var rating_index = $(this).index() + 1;
  console.log('rating_index-'+rating_index);
  var rate_add = 0.5;
  var new_index = parseInt(rating_index) - parseFloat(rate_add);
  new_index = new_index.toFixed(1);
  ppp.find('.fa').removeClass('fa-regular fa-star fa-star-half-alt ').addClass('fa-regular fa-star');
  for (var i = 0; i < parseInt(rating_index) - 1; i++) {
    ppp.find('.fa:eq('+i+')').removeClass('fa-regular').addClass('fa-star');
  }
  $(this).removeClass('fa-regular fa-star fa-star-half-alt ');
  var icon = 'fa-star-half-alt';
  //var new_index = parseFloat(new_index) + 1;
  if(parseFloat(new_index) == parseFloat(rating_prv)){
    var new_index = parseInt(rating_index);
    new_index = new_index.toFixed(1);
    icon = 'fa-star';
  }
  //var new_index = parseInt(new_index) - 1;
  ppp.find('.rating').val(new_index);
  $(this).addClass(icon);
  //console.log(new_index);
});
///////////////////////////////////////////////////////////////////////////////
/////////////////////////////////////////////////////////////////////////////////
$('.btnSubmitFeedback').click(function () {
  var thiss = this;
  var formData = new FormData($('.feedback-frm')[0]);
  var url = $('.feedback-frm').attr('action');
  $.ajax({
      url: url,
      type: 'POST',
      data: formData,
      processData: false,
      contentType: false,
      beforeSend: function() {
          show_msg(3, '', '<b>Please wait...<br>Saving in progress.</b>', 4);
      },
      success: function (response) {
          console.log(response);
          var status  = response.status;
          var message = response.message;
          var url     = response.url;
          if(status == '1'){
            show_msg(status, url, message, status);
          }else{
            show_msgT(status, message);
            Swal.close();
          }
      },
      error: function (error) {
          console.log(error);
      }
  });
});
</script>
@endsection
