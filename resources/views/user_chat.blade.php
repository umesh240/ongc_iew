@extends('layouts.app_user_new')
@php
  $curRouteNm = Route::currentRouteName();
  $pageNm = 'Day Wise';
@endphp
@section('pageName', 'chat')
@section('title', $pageNm)

@section('content')

<section class="chat-sec">
 <div class="container">
   <div class="row">
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

    <div class="bottom-chat">
      <input type="text" placeholder="Type a message....">
     <button class="chat-btn" type="button"> Send</button>
    </div>

   </div>
 </div>

</section>
@endsection

