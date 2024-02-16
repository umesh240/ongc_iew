 <!doctype html>
 <html lang="en">

 <head>
     <meta charset="utf-8">
     <meta name="viewport" content="width=device-width, initial-scale=1">

     <!-- CSRF Token -->
     <meta name="csrf-token" content="mQ2N9odf46abAjHLsCii4HP2uzl8waz3Z2pJAMnR">

     <title>Hotel Occopancy | ONGC</title>

     <link rel="shortcut icon" href="{{ asset('images/logo.png') }}" type="image/x-icon" />
     <!-- Fonts -->
     <link rel="dns-prefetch" href="//fonts.bunny.net">
     <link href="https://fonts.bunny.net/css?family=Nunito" rel="stylesheet">
     <!-- Theme style -->
     <link rel="stylesheet" href="{{ asset('pages/dist/css/adminlte.min.css') }}">

     <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
     <!-- Font Awesome -->
     <link rel="stylesheet" href="{{ asset('pages/plugins/fontawesome-free/css/all.min.css') }}">
     <link rel="stylesheet" href="{{ asset('pages/login.css') }}">
     <style>
         .form-control.is-invalid {
             background-image: none;
         }

         .form-control[readonly]:focus {
             background-color: #e9ecef;
             opacity: 3;
         }

         .alert {
             width: 100%;
         }

         .login-logo img {
    top: 0 !important;
         }
.occupancy{
    padding: 20px;
}


     </style>
 
</head>
 <!--<body class="control-sidebar-slide-open sidebar-collapse layout-navbar-fixed layout-fixed sidebar-mini ">-->

 <body class="sidebar-mini layout-fixed">
 <link rel="stylesheet" href="https://cdn.datatables.net/1.13.7/css/jquery.dataTables.min.css" >   
 <div class="loading-container">
         <div class="logo">

             <img src="https://ongcevents.co.in/images/logo.png" alt="Logo">
         </div>
         <div class="loading"></div>
     </div>

 
     <!-- Site wrapper -->
     <div class="wrapper">

         <section  >
         <a style="
    padding: 16px;"  class="navbar-brand" href="#">
          <img width="60" height="60" src="{{ asset('/pages/images/ongc-red-logo.png') }}" alt="ONGC" id="ongc-red">
          <img width="86" height="55" src="{{asset('/storage/app/event_logo/'.$report_data[0]->eventDetails->event_logo_1)}}"  >
          <img width="78" height="59" src="{{asset('/storage/app/event_logo/'.$report_data[0]->eventDetails->event_logo_2)}}"   >
        </a>
             
             
            <br/>
              <div class="occupancy">
                     <h2  >{{@$report_data[0]->eventDetails->event_name }} &nbsp; Hotel Occupancy</h2>
                     
                             <div class="table-responsive " >
                                 <table id="example" class="table table-bordred  " width="100%" style="font-size:14px;" >
                                     <thead>
                                         <tr>
                                             <th scope="col">S. No</th>
                                             <th scope="col">CPF No</th>
                                             <th scope="col">CPF Name</th>
                                             <th scope="col">Hotel Name</th>
                                             <th scope="col">Check In</th>
                                             <th scope="col">Checkout</th>
                                             <th scope="col">Hotel Map Link </th>
                                             <th scope="col">Sharing/Single</th>
                                         </tr>
                                     </thead>
                                    
                                     <tbody>
                                         @php $keyy = 0; @endphp
                                         @for($i = 0; $i < 1; $i++) @foreach ($report_data as $key=> $data)
                                             @php

                                             $asn_checkin = $asn_checkout = '';
                                             $assign_check_in = $data->assign_check_in;
                                             $assign_check_out = $data->assign_check_out;
                                             if($assign_check_in != null && strtotime($assign_check_in) > 0){
                                             $asn_checkin = date('d/m/Y h:i A', strtotime($assign_check_in));
                                             }
                                             if($assign_check_out != null && strtotime($assign_check_out) > 0){
                                             $asn_checkout = date('d/m/Y h:i A', strtotime($assign_check_out));
                                             }

                                             $checkin = $checkout = '';
                                             $check_in = $data->check_in;
                                             $check_out = $data->check_out;
                                             
                                             if($assign_check_in != null && strtotime($check_in) > 0){
                                             $checkin = date('d/m/Y h:i A', strtotime($check_in));
                                             }
                                             if($check_out != null && strtotime($check_out) > 0){
                                             $checkout = date('d/m/Y h:i A', strtotime($check_out));
                                             }

                                             $created_at = $data->created_at;
                                             $updated_at = $data->updated_at;
                                             $lastUpdate = '';
                                             if($updated_at != null && strtotime($updated_at) > 0){
                                             $lastUpdate = date('d/m/Y h:i A', strtotime($updated_at));
                                             }else{
                                             $lastUpdate = date('d/m/Y h:i A', strtotime($created_at));
                                             }
                                             @endphp
                                             <tr>
                                                 <td>{{ ($key+1) }}</td>
                                                 <td>{{ @$data->userDetails->cpf_no }}</td>
                                                 <td>{{ @$data->userDetails->name }}</td>

                                                 <td>{{ @$data->hotelDetails->hotel_name }}</td>


                                                 <td>{{ @$asn_checkin }}</td>
                                                 <td>{{ @$asn_checkout }}</td>
                                                 <td><a href='{{@$data->hotelDetails->hotel_geolocation }}'>Map Link</a> </td>
                                                 <td> {{ @$data->shareUserDetails->user_name  }} </td>

                                             </tr>
                                             @endforeach
                                             @endfor
                                   
                                     </tbody>
                                 </table>
                                 
                     </div>
              </div>
         </section>

     </div>
 </body>
 <!-- jQuery -->
 
 <script src="https://code.jquery.com/jquery-3.7.0.js"> </script>
 <script src="https://cdn.datatables.net/1.13.7/js/jquery.dataTables.min.js"></script>

 
 <script>
 $('#example').dataTable({
    aLengthMenu: [
        [25, 50, 100, 200, -1],
        [25, 50, 100, 200, "All"]
    ],
    iDisplayLength: 50
});
     setTimeout(function() {
         $('.loading-container').css('display', 'none');
     }, 200);
     sessionStorage.setItem("wel_cnt", 1);
 </script>

 </html>