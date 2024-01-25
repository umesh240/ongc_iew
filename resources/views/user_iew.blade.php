@extends('layouts.app_user_new')
@php
  $curRouteNm = Route::currentRouteName();
  $pageNm = 'IEW';
 
  @endphp
  @section('pageName', 'About Iew')
@section('title', $pageNm)
@section('content')
<style type="text/css">
figure img{
  width: 100%;
}
</style>
<!--<section class="local-bg">
 <div class="local-inner-bg"></div>
 <div class="container">
 <h2><i>
"Fueling progress in Your Local Areas – where the pulse of innovation meets the heart of the oil and gas industry, driving economic growth and energy excellence."</i></h2>
 </div>
</section>-->

<section class="about-iew">
    <div class="container">
      <div class="row" style="justify-content: center;">
        <div class="col-md-10">
          <div class="indian-energy pt-4 pb-5">
            @php
            echo $aboutIEW;
            @endphp
          </div>
        </div>
      </div>
    </div>
</scetion>
@endsection
 
@section('javascript')



@endsection
