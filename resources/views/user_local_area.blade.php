@extends('layouts.app_user_new')
@php
  $curRouteNm = Route::currentRouteName();
  $pageNm = 'Local Area';
@endphp
@section('pageName', 'Local Area')
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

<section class="local-area">
    <div class="container">
      <div class="row" style="justify-content: center;">
        <div class="col-md-10">
          <div class="about-goa pt-4">
            @php
            echo $aboutLocal;
            @endphp
          </div>
        </div>
      </div>
    </div>
</scetion>
@endsection
