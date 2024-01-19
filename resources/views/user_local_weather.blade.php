@extends('layouts.app_user_new')
@php
  $curRouteNm = Route::currentRouteName();
  $pageNm = 'Weather';
 

	//echo "<pre>"; print_r($weather_result); die;
	$location_name = @$weather_result->name;
	$date_time = @$weather_result->dt;
	$date_time = date('h:i A - l, j F Y', $date_time);
	$temperature = $weather_result->main->temp;
	$temp = ($temperature - 273.15).'°c';
	$pressure = $weather_result->main->pressure / 100;
	$humidity = $weather_result->main->humidity;
	$description= $weather_result->weather[0]->description;
	$windSpeed = $weather_result->wind->speed;

	$icon = $weather_result->weather[0]->icon;
	$main = $weather_result->weather[0]->main;
	$cod = $weather_result->cod;
  @endphp
  @section('pageName', 'Local Weather')
@section('title', $pageNm)
@section('content')	
<div class="div_weather">
 <div class="weather-inner"></div>
 <div class="container">
  <div class="row">
   <div class="col-md-12">
    <b><h3 class="text-white">{{ $location_name }}</h3></b>
    <b><p class="text-white">{{ $date_time }}</p></b>
    <div class="weatherIcon">
			<!--<img src="http://openweathermap.org/img/wn/10d@4x.png" />-->
			<img src="{{ asset('pages/weather-images/'.$icon.'@4x.png') }}" />
			<div class="temperature text-white text-center">
				<h2 class="text-white">{{ strtoupper($description) }}</h2>
				<span >{{@$temp}}</span>
			</div>
    </div>
    
    <hr style="width:80%; border-color:#fff;">
    
  <div class="row" style="justify-content: center;">
  
    <div class="col-md-4 col-4">
      <h5 class="text-white">Wind</h5>
      <h4 class="text-white">{{ $windSpeed }}</h4>
      <h5 class="text-white">Km/h</h5>
    </div>
    
    <div class="col-md-4 col-4">
      <h5 class="text-white">Pressure</h5>
      <h4 class="text-white">{{ $pressure }}</h4>
      <h5 class="text-white">hPa</h5>
    </div>
    
     <div class="col-md-4 col-4">
       <h5 class="text-white">Humidity</h5>
       <h4 class="text-white">{{ $humidity }}</h4>
       <h5 class="text-white">%</h5>
    </div>
   </div>
   </div>
  </div>
 </div>
	
</div>

@endsection
 
@section('javascript')



@endsection
