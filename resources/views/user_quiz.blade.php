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
.trQes:not(:first-child), .btnPrevious, .btnQuiz{ display:none;  }
</style>
<section class="banner-inner">
  <div class="bg-img"> </div>
	<div class="container">
		<h2><i>"Test your knowledge with our engaging quizzes! Challenge yourself<br> and discover something new every day. Join the fun now!"</i></h2>
	</div>
</section>
<section class="quiz">
  <div class="">
    <div class="row">
      <div class="col-sm-1 col-0 up-image"></div>
      <div class="col-sm-10">
        <form action="{{ route('save_quiz') }}" method="post" class="frmQuiz">
          @csrf
        <table class="tBodyQuiz" style="width:100%;">
          @php
            $srNo = 0;
            $allQuiz = $quizList->response;
            $status = $quizList->status;
            $optionSr = array(0 => 'A', 1 => 'B', 2 => 'C', 3 => 'D');
          @endphp
          @foreach($allQuiz as $key => $quiz)
          <tr class="trQes active">
            <td style="width:100%;">
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
                <div class="col-sm-12 col-12">
                  <button class="edit-btn btnPrevious" type="button" > Previous</button>
                  <button class="edit-btn btnNext" type="button" > Next</button>
                  <button class="edit-btn btnQuiz float-right" type="button" > Submit</button>
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
/////////////////////////////////////////////////////////////
$('.btnNext').on('click', function(){
  showQuiz('N');
});
$('.btnPrevious').on('click', function(){
  showQuiz('P');
});
////////////////////////////////////////////////////////////////////////////////
function showQuiz(btn_act) {
  var ansQuiz = $('.tBodyQuiz .active ').find('.selectedAns').length;
  if(parseInt(ansQuiz) < 1 && btn_act == 'N'){
    show_msgT(2, "Please select answer of the question.");
    return false;
  }
  var trLen = $('.tBodyQuiz').find('.trQes').length - 1;
  var trIndx = $('.tBodyQuiz').find('.active').index();
  if(btn_act == 'N'){
    var trIndxNew = parseInt(trIndx) + 1;
  }else{
    var trIndxNew = parseInt(trIndx) - 1;
  }
  $('.tBodyQuiz').find('.trQes').css('display', 'none').removeClass('active');
  $('.tBodyQuiz').find('.trQes:eq('+trIndxNew+')').css('display', 'table-row').addClass('active');

  //console.log('trIndx-'+trIndxNew+', trLen-'+trLen);
  if(parseInt(trIndxNew) > 0){
    $('.btnPrevious').css('display', 'inline-block');
  }else{
    $('.btnPrevious').css('display', 'none');
  }
  if(parseInt(trIndxNew) == parseInt(trLen)){
    $('.btnQuiz').css('display', 'inline-block');
    $('.btnNext').css('display', 'none');
  }else{
    $('.btnQuiz').css('display', 'none');
    $('.btnNext').css('display', 'inline-block');
  }
}
</script>

@endsection
