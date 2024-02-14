@extends('layouts.app_user_new')
@php
  $first_login = @session('first_login');
  $embedded = session()->get('embedded'); 
  @$curRouteNm = Route::currentRouteName();
  @$pageNm = 'Dashboard';
  @$boardDirectors = @$hotel_imageAll = [];
 // echo '<pre>'; print_r(@$sos_contact); die;


	$sos_info = $sos_phone = $sos_email = '';
	$status_sos = @$sos_contact->status;
	if($status_sos === 200){
		$sos_info = @$sos_contact->response->sos_info;
		$sos_phone = @$sos_contact->response->phone_no;
		$sos_email = @$sos_contact->response->email_id;
	}
	
 


  $hotel_imageAll = [];
  $hotel_imageAll[] = 'default.png';
  $image_path = asset('/storage/app/hotel_image').'/';
  $hotel_imageCnt = 1;
  $emp_ev_book_id = @$event_pdf_file = '';
  $flight_status = $cod = 0;
  $all_hotels = [];
  $user_name = '';  
  $user_code = 0;
  if(@$status == 200){  
    $user_code = @$userData->emp_cd;
    $all_hotels = @$userData->all_hotels;
    $user_name = @$userData->user_name;
    $emp_ev_book_id = @$userData->emp_ev_book_id;
    $boardDirectors = @$userData->boardDirectors;
    $hotel_image = @$userData->hotel_details->hotel_image;
    $image_path = @$userData->hotel_details->image_path;


 
    if(@$hotel_image !==null  ){
      $hotel_imageAll = explode('||', @$hotel_image); 
    }
   
    

    $event_datefr = @$userData->event_datefr;
    $event_datefr1 = date('d/m/Y', strtotime(@$event_datefr));
    $event_dateto = @$userData->event_dateto;
    $event_dateto1 = date('d/m/Y', strtotime(@$event_dateto));
    $event_name = @$userData->event_name;
    $event_mapurl = @$userData->event_mapurl;
    $event_details = @$userData->event_details;


    $hotel_name         = @$userData->hotel_details->hotel_name;
    $hotel_address      = @$userData->hotel_details->hotel_address;
    $hotel_geolocation  = @$userData->hotel_details->hotel_geolocation;
    $fpr_name           = @$userData->hotel_details->fpr_name;
    $fpr_mob_no         = @$userData->hotel_details->fpr_mob_no;
    $hosp_fpr_name      = @$userData->hotel_details->hosp_fpr_name;
    $hosp_fpr_mob_no    = @$userData->hotel_details->hosp_fpr_mob_no;

    $logisticFPR    = @$fpr_name.', '.@$fpr_mob_no;
    $hospitalityFPR = @$hosp_fpr_name.', '.@$hosp_fpr_mob_no;


    $flight_status      = @$userData->flight_status;
    $arv_flight_name    = @$userData->arv_flight_name;
    $arv_flight_no      = @$userData->arv_flight_no;
    $arv_date_time      = @$userData->arv_date_time;
    $arv_date_time1     = date('d/m/Y h:i A', strtotime(@$arv_date_time));
    $arv_location       = @$userData->arv_location;
    $dptr_flight_name   = @$userData->dptr_flight_name;
    $dptr_flight_no     = @$userData->dptr_flight_no;
    $dptr_date_time     = @$userData->dptr_date_time;
    $dptr_date_time1    = date('d/m/Y h:i A', strtotime(@$dptr_date_time));
    $dptr_location      = @$userData->dptr_location;

    $arv_flightInfo = [];
    $arv_flightInfo[] = "Flight no.: <b>".@$arv_flight_no."</b><br>";
    if(trim(@$arv_flight_name) != ''){
      @$arv_flightInfo[] = " (<b>".@$arv_flight_name."</b>)";
    }
    $arv_flightInfo[] = " date of <b>".@$arv_date_time1."</b>";
    if(trim(@$arv_location) != ''){
      @$arv_flightInfo[] = " on <b>".@$arv_location."</b> airport";
    }
    $arv_flightInfo = implode(' ', @$arv_flightInfo);


    $dptr_flightInfo = [];
    $dptr_flightInfo[] = "Flight no.: <b>".@$dptr_flight_no."</b>";
    if(trim(@$dptr_flight_name) != ''){
      @$dptr_flightInfo[] = " (<b>".@$dptr_flight_name."</b>)";
    }
    @$dptr_flightInfo[] = " date of <b>".@$dptr_date_time1."</b>";
    if(trim(@$dptr_location) != ''){
      @$dptr_flightInfo[] = " on <b>".@$dptr_location."</b> airport";
    }
    @$dptr_flightInfo = implode(' ', @$dptr_flightInfo);

    @$drvr_name     = @$userData->drvr_name;
    @$drvr_number   = @$userData->drvr_number;
    @$veh_details   = @$userData->drvr_veh_details;
   
  }
 @$actv_event = @$userData->actv_event;


@endphp
@section('title', @$pageNm)
@section('content')
<style>
.toolbar{ display:none !important;  }	
.eventPdf #viewerContainer{ inset: 0 !important;  }	
.owl-carousel .owl-item img { 
    height: 300px; 
}
</style>
 <!--Main slider-->
<section class="slider-main mt-2">
  <div class="carousel" data-flickity>
    @foreach(@$hotel_imageAll as $image)
      
      @php @$image_path = asset('/storage/app/hotel_image').'/'; @endphp


    <div class="carousel-cell">
      <img src="{{ @$image_path.$image }}" alt="{{ @$image }}">
           <!-- <img src="{{ asset('/pages/images/hotel_.jpg') }}"> -->
    </div>
    @endforeach
   <!-- <ol class="flickity-page-dots">e
    <li class="dot"></li>
    <li class="dot"></li>
    <li class="dot"></li>
    <li class="dot"></li>
    <li class="dot is-selected"></li>
    <li class="dot"></li>
    <li class="dot"></li>
    <li class="dot"></li>
    <li class="dot"></li>
    </ol>-->
	</div>
</section>


  <section class="content">
    <div class="container">

      <div class="event-content">
        <div class="row pt-2 pb-2">

          <div class="col-md-10 col-10 " >
           <!-- <p class="text-light event-text">Event Name<br>From: {{@$event_datefr1.' - '.@$event_dateto1}} ({{ @$event_name }})</p> -->
           
            <p class="mb-0 text-white" style="font-size: 17px;">
            <b> Accomodation :<br> {{ @$hotel_name }}</b><!--{{ @$hotel_address }}-->
          </p>
          </div>
          <div class="col-md-2 col-2 text-center" style="align-items: center; display: flex;">
            <a href="{{ @$event_mapurl }}" target="_blank"  title="Event Map Location">
              <div class="icon-event">
                <i class="fa-solid fa-location-dot"></i>
              </div>
            </a>
          </div>

        </div>
      </div>
    </div>
  </section>


<section class="hotel-event">
 <div class="container">
    <div class="row hotel-bg">
      <div class="col-md-12 col-12 event-bg">
       <p class="text-light event-text" style="display:flex; justify-content: space-between;">Venue : {{ @$event_name }}<br><!--From: {{@$event_datefr1.' To '.@$event_dateto1}}--><span> 06-09 Feb 2024</span></p>
       </div>
        <div  style="align-items: center; display: flex;">
           <a href="{{ @$event_mapurl }}" target="_blank"  title="Event Map Location">
              <div class="icon-event details-icon text-center">
                <i class="fa-solid fa-location-dot"></i>
              </div>
          </a>
        </div>
     </div>
</div>
</section>


  <div class="container ">
    <div class="row pt-5 ">
      <div class="col-md-12 col-lg-8 mx-auto fpr-content">
       <h3 class="fpr-detail" style="color: #fff;background-color: #457CB2;padding: 10px 10px 10px 30px;border-radius: 10px 10px 0px 0px;">FPR Detail:-</h3>
       
       @if(isset($fpr_name) && !empty($fpr_name))
      <div class="user-details p-4">
          <p class="mb-0"><i class="fas fa-user"></i> {{ @$logisticFPR }}</p>
          <div class="fpr-icon" onclick="openDialPad('{{ @$fpr_mob_no }}')" >
           <i class="fas fa-phone-alt"></i>
          </div>
      </div>
      @endif
       <hr style="width: 92%;border-color: #E8E8E8;margin: 0px;margin: 0 auto;">
      @if(isset($hosp_fpr_name) && !empty($hosp_fpr_name))
          <div class="user-details p-4">
              <p class="mb-0"><i class="fas fa-user"></i> {{ @$hospitalityFPR }}</p>
              <div class="fpr-icon " onclick="openDialPad('{{ @$$hosp_fpr_mob_no }}')" >
               <i class="fas fa-phone-alt"></i>
              </div>
          </div>
      @endif
      </div>
      <div class="col-lg-10 col-md-12  ml-auto col-xl-12 mr-auto">
        <!-- Nav tabs -->
        <div class=" card-tabs">
          <div class="card-header nav-header">
            <ul class="nav nav-tabs desktop-tabs " role="tablist">
              <li class="nav-item">
                <a class="nav-link active" data-toggle="tab" href="#checkInOut" role="tab" id="check-card" aria-selected="true"><i class="fa-solid fa-hotel"></i><br>Check-in/out</a>
              </li>
              <li class="nav-item">
               <a class="nav-link" data-toggle="tab" href="#flightDetails" role="tab" id="flight-card" aria-selected="false"> <i class="fa-solid fa-plane"></i><br>Flight Details</a>
              </li>
              <li class="nav-item">
               <a class="nav-link" data-toggle="tab" href="#travelSchedule" role="tab" id="travel-card" aria-selected="false"><i class="fa-solid fa-bus-simple"></i><br>Transportation</a>
              </li>
            </ul>
          </div>
          <div class="card-body">
            <!-- Tab panes -->
           
            <div class="tab-content text-center"> 
              <div class="tab-pane active" id="checkInOut" role="tabpanel">
                @foreach($all_hotels as $htl)
                @php
                  $checkOutCls = $checkInCls = 'check-grey';
                  $checkInTxt = 'Check-in';
                  $checkOutTxt = 'Check-out';
                  $today              = strtotime(date('Y-m-d'));
                  $assign_check_in    = @$htl->assign_check_in;
                  $assign_check_in    = date('Y-m-d', strtotime($assign_check_in));
                  $assign_checkInMili = strtotime($assign_check_in);
                  $cInD               = date('d', $assign_checkInMili);
                  $cInM               = date('M', $assign_checkInMili);
                  $cInDN              = date('l', $assign_checkInMili);
                  $assign_check_out   = @$htl->assign_check_out;
                  $assign_check_out   = date('Y-m-d', strtotime($assign_check_out));
                  $assign_checkOtMili = strtotime($assign_check_out);
                  $cOtD               = date('d', $assign_checkOtMili);
                  $cOtM               = date('M', $assign_checkOtMili);
                  $cOtDN              = date('l', $assign_checkOtMili);

                  $user_check_in      = $user_check_in2      = @$htl->check_in;
                  $user_check_out     = $user_check_out2     = @$htl->check_out;
                  $user_check_in      = date('Y-m-d', strtotime($user_check_in));
                  $userCheckInMili    = strtotime($user_check_in);
                  $user_check_out     = date('Y-m-d', strtotime($user_check_out));
                  $userCheckOutMili   = strtotime($user_check_out);
                  $checkOutDis = $checkInDis = 'disabled';
                  if($assign_checkInMili <= $today){
                    $checkInCls = 'cnfCkInOut';
                    $checkInTxt = 'Confirm Check-in';
                    $checkInDis = '';
                    if($userCheckInMili > 0 && $user_check_out2 == null){
                      $checkOutDis = '';
                      $checkOutCls = 'cnfCkInOut';
                      $checkOutTxt = 'Confirm Check-out';
                    }
                  }
                  if($userCheckInMili > 0 && $user_check_in2 != '' && $assign_checkInMili <= $today){
                    $cInD               = date('d', $userCheckInMili);
                    $cInM               = date('M', $userCheckInMili);
                    $cInDN              = date('l', $userCheckInMili);
                    $checkInCls = 'check-green';
                    $checkInTxt = 'Check-in Confirmed';
                    $checkInDis = 'disabled';
                    if($userCheckOutMili > 0 && $userCheckOutMili >= $userCheckInMili){
                      $checkOutDis = 'disabled';
                      $checkOutCls = 'check-green';
                      $checkOutTxt = 'Check-out Confirmed';

                      $cOtD               = date('d', $userCheckOutMili);
                      $cOtM               = date('M', $userCheckOutMili);
                      $cOtDN              = date('l', $userCheckOutMili);
                    }
                  }

                  $hotel_name = @$htl->hotel_name;
                  $hotel_map  = @$htl->hotel_geolocation;
                  $emp_ev_book_id  = @$htl->emp_ev_book_id;
                @endphp
                <div class="row user-inOut checkinOutdates" data-route="{{ route('check_in_out') }}"
                  data-emp-ev-book-id="{{ $emp_ev_book_id }}" data-csrf-token="{{ csrf_token() }}">
                  <div class="user-inner"></div>
                  <!--<div class="hotel-name">
                               <h4>{{ @$hotel_address }}</h4>
                             <i class="fas fa-map-marker-alt"></i>
                              </div>-->
                  <div class="col-md-6 col-6" style="border-right: 1px solid #F07E29;">
                    <div class="check-time check-tab">
                      <h4>{{ $cInD }}<span>{{ $cInM }}</span></h4>
                      <h5>{{ $cInDN }}</h5>
                      <!--<b><p class="mb-0">{{ @$assign_check_in1 }}</p></b>
                                      <p class="text-success">{{ @$assign_check_in1 }}</p>-->
                      <div class="tab-btn mt-3">
                        <button class="edit-btn {{ $checkInCls }}" type="button" value="in" {{ $checkInDis }}> {{ $checkInTxt
                          }}</button>
                      </div>
                    </div>
                  </div>
                  <div class="col-md-6 col-6">
                    <div class="check-time check-tab">
                      <h4>{{ $cOtD }}<span>{{ $cOtM }}</span></h4>
                      <h5>{{ $cOtDN }}</h5>
                      <!--<b><p class="mb-0">{{ @$assign_check_out1 }}</p></b>
                                      <p class="text-success">{{ @$assign_check_out1 }}</p>-->
                      <div class="tab-btn mt-3">
                        <button class="edit-btn {{ $checkOutCls }} " type="button" value="out" {{ $checkOutDis }}> {{ $checkOutTxt
                          }}</button>
                      </div>
                    </div>
                  </div>

                </div>
                <div class="row down-bg  mb-3">
                  <div class="col-md-10 col-9" style="align-items:center; display:flex;">
                    <h4 class="text-left mb-0">{{ @$hotel_name }}</h4>
                  </div>
                  <div class="col-md-2 col-3">
                    <a href="{{ @$hotel_map }}" target="_blank" title="Event Map Location">
                      <i class="fas fa-map-marker-alt"></i>
                    </a>
                  </div>
                </div>
                @if(@$actv_event !=2)
                <div class="row down mb-3 align-center">
                  <button type="submit" class="edit-btn" style="margin: auto;"><a href="{{ route('checkInOut_index', ['id' => $user_code]) }}" target="_blank" style="text-decoration: none; color:white;">Edit Check-in/Out Details</a></button>
                </div>
                @endif
                @endforeach
              </div>
              
              
                  <div class="tab-pane" id="flightDetails" role="tabpanel">
                   <div class="row vehicle-bg" style= "align-items: center;">
                      @if($flight_status == 1)
                      <div class="col-md-6 col-sm-6 pr-1 pl-1 text-white" style="color: #457CB2;">
                        <h5 class="mb-3 desktop-left">Arrival</h5>
                           <h3>{{ @$arv_flight_no }}</h3>
                           <ul>
                            <li><i class="fas fa-fighter-jet"></i>{{ @$arv_flight_name }}</li>
                            
                            <li><i class="fas fa-map-marker-alt"></i>{{ @$arv_location }}</li>
                   
                             <li><i class="fas fa-calendar-alt"></i>{{ @$arv_date_time1 }}</li>

                           </ul>
                      </div>
                      <div class="col-md-6 col-sm-6 pr-1 pl-1 mt-1 text-white" style="color: #457CB2;">
                        <h5 class="mb-3 desktop-right">Departure</h5>
                           <h3>{{ @$dptr_flight_no }}</h3>
                           <ul >
                            <li><i class="fas fa-fighter-jet"></i>{{ @$dptr_flight_name }}</li>

                            <li><i class="fas fa-map-marker-alt"></i>{{ @$dptr_location }}</li>
                         
                          <li> <i class="fas fa-calendar-alt"></i>{{ @$dptr_date_time1 }}</li>
                            
                           </ul>
                      </div>
                      
                      <div class="col-md-12 h-10">
                      @if(@$actv_event !=2)
                        <div class="tab-btn pt-3">
                          <a href="{{ route('my.page', ['page'=>'flight']) }}"><button class=" edit-btn" type="submit">Edit Details</button></a>
                        </div>
                          @endif
                      </div>
                      @else
                      <div class="col-md-12">
                        <h4 class="text-white">Not Available</h4>
                      </div>
                      @endif
                   
                    </div>
                 <div class="row flight-mobile">
               <div class="center-plane">
                <i class="fas fa-plane"></i>
               </div>
                    @if($flight_status == 1)
                    <div class="col-md-6 col-6 text-white pr-2" >
                      <div class="check-time check-tab">
                        <h5 class="mb-3 text-left left-sde">Arrival</h5>
                           <h3 class="text-left">{{ @$arv_flight_no }}</h3>
                          <ul>
                            <li> <i class="fas fa-fighter-jet"></i>{{ @$arv_flight_name }}</li>
                           
                            <li> <i class="fas fa-map-marker-alt"></i>{{ @$arv_location }}</li>
                            
                             <li><i class="fas fa-calendar-alt"></i>{{ @$arv_date_time1 }}</li>
                           </ul>
                      </div>
                    </div>
                    <div class="col-md-6 col-6 text-white pr-2" style="justify-content: end; display: flex;">
                      <div class="check-time check-tab">
                        <h5 class="mb-3 text-left right-sde">Departure</h5>
                           <h3 class="text-left">{{ @$dptr_flight_no }}</h3>
                         <ul>
                          <li> <i class="fas fa-fighter-jet"></i>{{ @$dptr_flight_name }}</li>
                         
                          <li> <i class="fas fa-map-marker-alt"></i>{{ @$dptr_location }}</li>
                          
                           <li><i class="fas fa-calendar-alt"></i>{{ @$dptr_date_time1 }}</li>
                         </ul>
                      </div>
                    </div>
                    <div class="tab-btn pt-3" style="margin: 0 auto">
                      <a href="{{ route('my.page', ['page'=>'flight']) }}"><button class=" edit-btn" type="submit">Edit Details</button></a>
                    </div>
                    @else
                    <div class="col-md-12 h-10">
                      <h4 class="text-white">Not Available</h4>
                    </div>
                    @endif
                    </div>
                    
                      </div>
                  
                 
                  <div class="tab-pane" id="travelSchedule" role="tabpanel">
                   <div class="user-vehicle">
                    <div class="row" style ="align-items: center;">
                      @php
                      $drvr_veh_details = $drvr_number = $drvr_name = "Not Applicable";
                      $vehicle_type = @$userData->vehicle_type;
                      if($vehicle_type == 'LIGHT-VEHICLE'){
                        $drvr_name = @$userData->drvr_name;
                        $drvr_number = @$userData->drvr_number;
                        $drvr_veh_details = @$userData->drvr_veh_details;
                      }else{
                        $vehicle_type = "Not Applicable";
                      }
                      $shuttle_timing = @$userData->shuttle_timing;
                      @endphp
                      
                                  <div class="col-md-8 col-8 text-left" style="color: #457CB2;">
                                    <div class="vehicle-shape">
                                      <h3>Vehicle Type: {{ $vehicle_type }}</h3>
                                      <h3>Vehicle Details: {{ $drvr_veh_details }}</h3>
                                      <h3>Driver Name: {{ $drvr_name }}</h3>
                                      <h3>Driver Number: {{ $drvr_number }}</h3>
                                      
                                    </div>
                                  </div>
                                  <div class="col-md-4 col-4 ">
                                    <!-- <img src="{{ asset('/pages/images/taxi-driver.png') }}" id="driver-img"> -->
                                    <div class="transport-icon">
                                     <i class="fas fa-phone-alt"></i> 
                                     <p class="mt-2">Call Now</p>
                                    </div>
                                     
                                 </div>
                                  <!-- <div class="col-md-12 col-12 ">
                                    <div class="shuttle-time" style="display:flex; align-items:center;">
                                      <h3>Detail:</h3>
                                      <a href="{{ $shuttle_timing }}" target="_blank" style="text-decoration: none;">Press Here</a>
                                    </div>
                                 </div> -->
                    </div>
                               
                             </div>
                    </div>
                  </div>
                </div>
            </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>


<!-- shuttle timmings -->
<section class="time-sec">
  <div class="container">
    <div class="row mt-5 shuttle-service">

     <div class="col-md-9 col-7">
        <div class="time-service">
          <h3 class="mb-0">For Shuttle Service</h3>
        </div>
        </div>
        <div class="col-md-3 col-5" style="justify-content:end; display:flex; align-items:center;">
          <div class="time-btn">
            <a href="{{ $shuttle_timing }}" target="_blank">Click Here</a>
          </div>
        </div>             
      
    </div>
  </div>
</section>


  <!------minsters----->
  <div class="container-fluid">
    <div class="row">
      <div class="carousel-wrap">
        <h3 class="pb-4">ONGC's Board of Directors</h3>
        <div class="owl-carousel ">
          @foreach(@$boardDirectors as $leader)
          <div class="item">
            <img src="{{ @$leader->l_photo }}">
            <div class="ministers-head">
              <h5 class="text-center pt-2">{{ @$leader->l_name }}<br>{{ @$leader->l_post }}</h5>
            </div>
          </div>
          @endforeach
        </div>
      </div>
    </div>
  </div>




  <!-- about-local -->
 <section class="locals">
  <div class="container">
    <div class="row d-flex align-items-center justify-content-center">
      <div class="col-md-12 pb-4">
        <div class="local-head">
          <h3>About Local</h3>
        </div>
      </div>
      @if($embedded == 1)
      <div class="col-4 col-md-2  text-center">
        <div class="local-menus">
          <div class="icon-finder">
           <a href="{{ route('my.page', ['page'=>'way_finder']) }}"> <i class="fas fa-map"></i></a>
          </div>
          <div class="local-content about-local">
            <b><p>Way Finder</p></b>
          </div>
        </div>
      </div>

      <div class="col-4 col-md-2  text-center">
        <div class="local-menus">
          <div class="icon-day">
           <a href="{{ route('my.page', ['page'=>'day_wise']) }}"> <i class="fas fa-calendar-week"></i></a>
          </div>
          <div class="local-content about-local">
            <b><p>Event Details</p></b>
          </div>
        </div>
      </div>

      <div class="col-4 col-md-2  text-center">
        <div class="local-menus">
          <div class="icon-chat">
           <a href="{{ route('my.page', ['page'=>'chat']) }}"><i class="far fa-comments"></i></a>
          </div>
          <div class="local-content about-local">
            <b><p>chat</p></b>
          </div>
        </div>
      </div>
      @endif

      <div class="col-4 col-md-2 text-center">
        <div class="local-menus">
          <div class="icon-local">
           <a href="{{ route('my.page', ['page'=>'local_area']) }}"> <i class="fa-solid fa-location-dot"></i></a>
          </div>
          <div class="local-content">
            <b><p>About Goa</p></b>
          </div>
        </div>
      </div>
      
       <div class="col-4 col-md-2 text-center">
        <div class="local-menus">
          <div class="icon-Quiz">
           <a href="{{ route('my.page', ['page'=>'quiz']) }}"> <i class="far fa-edit"></i></a>
          </div>
          <div class="local-content">
            <b><p>Quiz</p></b>
          </div>
        </div>
      </div>
      
       <div class="col-4 col-md-2  text-center">
        <div class="local-menus">
          <div class="icon-weather">
           <a href="{{ route('my.page', ['page'=>'local_weather']) }}"><i class="fas fa-cloud-rain"></i></a>
          </div>
          <div class="local-content">
            <b><p>Goa Weather</p></b>
          </div>
        </div>
      </div>

      <div class="col-4 col-md-2  text-center">
        <div class="local-menus">
          <div class="icon-about">
           <a href="{{ route('my.page', ['page'=>'about']) }}"><i class="fas fa-burn"></i></a>
          </div>
          <div class="local-content about-local">
            <b><p>About IEW</p></b>
          </div>
        </div>
      </div>


      <!-- <div class="col-4 col-md-2  text-center">
        <div class="local-menus">
          <div class="icon-news">
           <a href="{{ route('my.page', ['page'=>'news']) }}"> <i class="fa-solid fa-video"></i></a>
          </div>
          <div class="local-content about-local">
            <b><p>Latest News</p></b>
          </div>
        </div>
      
      </div> -->

      <div class="col-4 col-md-2  text-center" id="last-col">
      </div>
    </div>
  </div>
</section>




  <!----social wall---->
  <section class="wall">
    <div class="container">
      <div class="row pt-5 pb-5">
        <div class="col-md-12 pb-3">
          <div class="wall-head">
            <h3>Social Wall</h3>
          </div>
        </div>
        <div class="wall-content">
          <a class="twitter-timeline" id="twitter-btn" data-theme="light" href="https://twitter.com/IndiaEnergyWeek?ref_src=twsrc%5Etfw"></a>
        </div>
      </div>
    </div>
  </section>



<!----airport destails

<section class="details">
 <div class="container">
   <h3>Airport Details</h3>
    <div class="airport-details" >
      <div class="row ">
      <div class="col-md-6 col-6">
        <img src="{{ asset('/pages/images/airport1.jpg') }}">
        <h5 class="airport-text">Dabolim Airport, Goa</h5>
      </div>
      <div class="col-md-6 col-6">
        <img src="{{ asset('/pages/images/airport2.jpg') }}">
        <h5 class="airport-text">Manohar International Airport, Mopa, Goa</h5>
      </div>
    </div>
  </div>
 </div>
 </section>--->

<section class="app-buttons">
     <div class="container">
          <div class="download-help-btn">
               <div class="row" style="justify-content: center;">
               
                    <div class="col-md-4 col-4">
                         <div class="btnApp">
                              <div class="download-app">
                                   <img src="{{ asset('/pages/images/play22.png') }}">
                                   <h3 style="font-size: 25px; color: #457CB2; padding-top: 10px;">Get IEW App</h3>
                              </div>
                         </div>
                    </div>
                    <div class="col-md-4 col-4" style="justify-content:center; display:flex;">
                       <div class="sos-img" onclick="openDialPad('{{ $sos_phone }}')">
                       <i class="fas fa-phone-volume"></i>
                       <h3 style="font-size: 25px; color: #457CB2; padding-top: 10px;">SOS</h3>
                      </div><br clear="all">
                     
                      <!-- <div class="sos-btn">
                        <a href="#">SOS</a>
                        </div> -->
                    </div>
                    <div class="col-md-4 col-4" >
                         <div class="contactUs">
                              <img src="{{ asset('/pages/images/customer-service.png') }}" id="contact-img">
                              <a href="{{ route('my.page', ['page'=>'chat']) }}"  style="color: #fff; margin-left: 12px;  font-size: 20px;">Contact Us</a>
                         </div>
                         <h3 class="contact-text text-center" style="font-size: 25px; color: #457CB2; padding-top: 10px;">May I Help You</h3>
                    </div>
               </div>
             </div>
           </div>

</section>
 
<div id="mdlWelCome" class="modal fade" role="dialog" data-backdrop="static" data-keyboard="false" data-cpg="{{ route('my.page', ['page'=>'change_password']) }}" data-flg="{{ $first_login }}">
  <div class="modal-dialog" style="margin: auto auto; width: 90%;" >
    <div class="modal-content" style="border-radius: 20px; box-shadow: 0px 6px 20px -5px #457cb26b;  border: none;">
      <div class="modal-body" style="text-align: center;">
      <div class="user-img" style="justify-content: center; display: flex;">
       <img src="{{ asset('/pages/images/user-img.png') }}">
      </div>
        <h4 class="modal-title mb-3" style="color:#457CB2;">Welcome To IEW</h4>
        <div class="ongc-user">
          <h5 class="mb-4" style="color:#457CB2;">{{ $user_name }}</h5>
        </div>
        <button type="button" class="btn welcome-button mdlWelComeClose" >Get Started<i class="fa fa-long-arrow-right" aria-hidden="true"></i></button>
      </div>
    </div>

  </div>
</div>

@endsection

@section('javascript')
<script src="{{ asset('pages/userdashboardNew.js') }}"></script>
<script>
</script>
@endsection
