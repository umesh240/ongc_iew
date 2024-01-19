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
        <form action="{{ route('save_quiz') }}" method="post" class="frmQuiz">
          @csrf
        <table>
          @php
            $srNo = 0;
            $allQuiz = $quizList->response;
            $status = $quizList->status;
            $optionSr = array(0 => 'A', 1 => 'B', 2 => 'C', 3 => 'D');
          @endphp
          @foreach($allQuiz as $key => $quiz)
          <tr>
            <td>
              <div class="row">
                <div class="col-sm-12 col-12 p-0 pl-2">Q{{ ++$srNo }}. {{ $quiz->question }}</div>
                @foreach($quiz->options as $op => $opt)
                  <div class=" p-2 bg-white options" onclick="checkAnswer(this, '{{ $op+1 }}')">
                    {{ $optionSr[$op] }}. {{ $opt }}
                  </div>
                @endforeach
                <input type="hidden" name="question_id[]" class="question_id" value="{{ $quiz->qz_id }}">
                <input type="hidden" name="answer_id[]" class="answer_id" value="">
              </div>
            </td>
          </tr>
          @endforeach
          <tr>
            <td>
              <div class="row">
                <div class="col-sm-12 col-12 p-0 pl-2">
                  <button class="edit-btn btnQuiz" type="button" > Submit</button>
                </div>
              </div>
            </td>
          </tr>
        </table>
        </form>
      </div>
      <div class="col-sm-1  col-0 down-image"></div>
      
      <div></div>
      <div></div>
    </div>
  </div>
</section>

@endsection
 
@section('javascript')

<script>
function checkAnswer(element, ansNumber) {
  var trr = $(element).closest('tr');
  trr.find('.options').removeClass('selectedAns');
  $(element).addClass('selectedAns');
  trr.find('.answer_id').attr('value', ansNumber).val(ansNumber);
}
/////////////////////////////////////////////////////////////////////////////////
$('.btnQuiz').click(function () {
  var thiss = this;
  var formData = new FormData($('.frmQuiz')[0]);
  var url = $('.frmQuiz').attr('action');
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
