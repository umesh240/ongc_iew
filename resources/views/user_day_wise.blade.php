@extends('layouts.app_user_new')
@php
  $curRouteNm = Route::currentRouteName();
  $pageNm = 'Day Wise';
@endphp
@section('pageName', 'Day Wise Event')
@section('title', $pageNm)

@section('content')

<section class="day-wise">
  <div class="container">
    <div class="row">
      <div class="col-md-6 col-12 cards-section">
        <div class="event-button">
          <div class="card event-card">
            <img class="card-img-top" src="{{ asset('/pages/images/strategy.jpg') }}" alt="Card image cap">
            <div class="card-body">
              <h5 class="card-title">STRATEGIC CONFERENCE SESSIONS</h5>
              <p class="card-text">Developed in line with India’s global priorities and net-zero vision, the Strategic Conference will invite global energy ministers, CEOs, policymakers and business leaders to contemplate, deliberate and take decisive steps to navigate the ever-evolving energy landscape across a wide range of ministerial, leadership and spotlight sessions, delegates will hear vital insights into the trends, challenges and opportunities shaping the energy sector</p>
              <a href="https://www.indiaenergyweek.com/event/2fe24000-628c-4f45-a85e-4e8ed44d433c/websitePage:f3232517-a1a4-4fcc-9a80-6dc1a33f8dcf" target="_blank" class="btn btn-primary">Find Out More</a>
            </div>
          </div>
        </div>
      </div>
      <div class="col-md-6 col-12 cards-section">
        <div class="event-button technical-conf">
          <div class="card event-card">
            <img class="card-img-top" src="{{ asset('/pages/images/technology.jpg') }}" alt="Card image cap">
            <div class="card-body">
              <h5 class="card-title">Technical Conference</h5>
              <p class="card-text">Offering invaluable technical expertise for the engineers,
project managers and innovators driving India’s energy transition.</p>
              <a href="https://www.indiaenergyweek.com/event/2fe24000-628c-4f45-a85e-4e8ed44d433c/websitePage:9d927ad6-b4c7-43b1-9aa6-e850811a5e68" target="_blank" class="btn btn-primary">Find Out More</a>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</section>
    
@endsection

