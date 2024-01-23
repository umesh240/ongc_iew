@extends('layouts.app_user_new')
@php
  $curRouteNm = Route::currentRouteName();
  $pageNm = 'Chat';
@endphp
@section('pageName', $pageNm)
@section('title', $pageNm)

@section('content')

<section class="chat-sec">
 <div class="container">
  <div class="row chatList">
    <div class="col-md-12">
     <div class="chat-bg">
      <div class="user-chat">
       <p>Hye! how are you?</p>
       <span>6:15:51 PM</span>
      </div>
      <i class="fas fa-user"></i>
     </div>
    </div>

    <div class="col-md-12">
      <div class="chat-bg-sender">
       <i class="fas fa-user"></i>
       <div class="sender-chat">
        <p>Hye! I'm doing fine.</p>
        <span>6:16:51 PM</span>
       </div>
      </div>
    </div>
  </div>
  <div class="row">
    <div class="bottom-chat divChat" data-action="{{ route('save_chat') }}">
      <input type="text" class="chat_msg" placeholder="Type a message....">
      <button class="chat-btn btnSaveChat" type="button"> Send</button>
    </div>

  </div>
 </div>

</section>
@endsection

@section('javascript')
<script type="text/javascript">
///////////////////////////////////////////////////////////////////////////////
/////////////////////////////////////////////////////////////////////////////////
$('.btnSaveChat').click(function () {
  var div = $(this).closest('.divChat');
  var thiss = this;
  var chat_msg = div.find('.chat_msg').val();
  var url = div.attr('data-action');
  $.ajax({
      url: url,
      type: 'POST',
      data: {chat_msg:chat_msg , _token: "{{ csrf_token() }}" },
      success: function (response) {
          console.log(response);
          var status  = response.status;
          var message = response.message;
          var chatList = response.chatList;
          if(status == '200'){
            status = 1;
            $('.chatList').html(chatList);
            div.find('.chat_msg').val('');
          }else{
            status = 2;
          }
          show_msgT(status, message);
      },
      error: function (error) {
          console.log(error);
      }
  });
});
</script>
@endsection