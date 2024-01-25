@extends('layouts.app_user_new')
@php
  $curRouteNm = Route::currentRouteName();
  $pageNm = 'Chat';
@endphp
@section('pageName', $pageNm)
@section('title', $pageNm)

@section('content')

<section class="chat-sec">
   <!--<div class="row chatList"></div>-->
     <!--<div class="bottom-chat divChat" data-action="{{ route('save_chat') }}" data-action_list="{{ route('get_chat') }}">
       <input type="text" class="chat_msg" placeholder="Type a message....">
       <button class="chat-btn btnSaveChat" type="button"> Send</button>
     </div>-->
     
     <div class="card">
     <div class="card-body pt-2">
 
         <div class="direct-chat-messages chatList">
 
             <div class="direct-chat-msg">
                 <div class="direct-chat-infos clearfix">
                 </div>
         
         <div class="sender-sec mb-2" style="display:flex;">
         <div class="chat-bg-sender">
                 <i class="fas fa-user"></i>
        </div>
                 <div class="direct-chat-text sender-chat">
                    <p class="mb-0"> Is this template really for free? That's unbelievable!</p>
                      <span class="direct-chat-timestamp " style="color:#fff;">23 Jan 2:00 pm</span>
                 </div>
 
             </div>
             </div>
 
 
             <div class="direct-chat-msg right">
                 <div class="direct-chat-infos clearfix">
                 </div>
 
  
                <div class="chat-sec">
                 <div class="direct-chat-text user-chat">
                    <p class="mb-0">You better believe it!</p>
                     <span class="direct-chat-timestamp" style="color:#fff">23 Jan 2:05 pm</span>
                 </div>
                  <div class="chat-bg">
                  <i class="fas fa-user"></i>
                </div>
              </div>
             </div>
 
 
         <div class="direct-chat-contacts">
         </div>
 
     </div>
 
 </div>
 <a href="#" class="emergency-call">
 <i class="fas fa-phone-alt"></i>
 </a>
     <div class="card-footer">
         <form action="#" method="post">
             <div class="input-group bottom-chat divChat" data-action="{{ route('save_chat') }}" data-action_list="{{ route('get_chat') }}">
                 <input type="text" name="message" placeholder="Type Message ..." class="form-control chat_msg">
                 <span class="input-group-append">
                     <button type="button" class="btn btn-primary chat-btn btnSaveChat">Send</button>
                 </span>
             </div>
         </form>
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
        if(status == '200'){
          status = 1;
          getChats();
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
///////////////////////////////////////////////////////////////////////
function getChats() {
  var div = $('.divChat');
  var url = div.attr('data-action_list');
  $.ajax({
    url: url,
    type: 'POST',
    data: { _token: "{{ csrf_token() }}" },
    success: function (response) {
      //console.log(response);
      var status  = response.status;
      var chatList = response.chatList;
      if(status == '200'){
        status = 1;
        $('.chatList').html(chatList);
        div.find('.chat_msg').val('');
      }else{
        status = 2;
      }
    },
    error: function (error) {
        console.log(error);
    }
  });
}
getChats();
</script>
@endsection
