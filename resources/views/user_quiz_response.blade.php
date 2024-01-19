@extends('layouts.app_user_new')
@php
  $curRouteNm = Route::currentRouteName();
  $pageNm = 'Quiz';
  //echo '<pre>'; print_r($quizList); die;
@endphp
@section('pageName', 'Quiz')
@section('title', $pageNm)
@section('content')

<style type="text/css">
.selectedAns{
  background-color: #F07E29 !important;
  color: #FFFFFF !important;
}
</style>
<section class="banner-inner">
  <div class="bg-img"> </div>
	<div class="container">
		<h2><i>"Test your knowledge with our engaging quizzes! Challenge yourself<br> and discover something new every day. Join the fun now!"</i></h2>
	</div>
</section>
<section class="quiz">
  <div class="conatiner">
    <div class="row">
      <div class="col-sm-1 col-0 up-image"></div>
      <div class="col-sm-10">
        <h4 class="text-white">{{ @$quiz_message }}</h4>
        <table class="table w-100" style="width:100%;">
          <tr>
            <td>Attempt Questions</td>
            <td> {{ @$ttl_question }}</td>
          </tr>
          <tr class="text-danger">
            <td>Wrong Questions</td>
            <td> {{ @$wrong_question }}</td>
          </tr>
          <tr class="text-purple">
            <td>Right Questions</td>
            <td> {{ @$right_question }}</td>
          </tr>
        </table>
        <button type="button"  class="edit-btn"><a href="{{ route('my.page', ['page'=>'quiz']) }}" style="color:#fff; text-decoration: none;"> Re-attempt</a></button>
      </div>
      <div class="col-sm-1  col-0 down-image"></div>
      
      <div></div>
      <div></div>
    </div>
  </div>
</section>

@endsection
 
@section('javascript')

@endsection
