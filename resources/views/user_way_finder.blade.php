@extends('layouts.app_user_new')
@php
  $curRouteNm = Route::currentRouteName();
  $pageNm = 'Way_Finder';
@endphp
@section('pageName', 'Way Finder')
@section('title', $pageNm)
@section('content')

<section class="way_finder">
     <iframe src="https://route.heliware.co.in" style="width: 100%; height: 90vh; border: 0;"></iframe>

</section>
    
@endsection
@section('javascript')
  <script>
    </script>
@endsection
