ud = {
  getCheckin: function(thiss, in_out) {
    var div = $(thiss).closest('.checkinOutdates');
    var emp_ev_book_id = div.data('emp-ev-book-id');
    var route = div.data('route');
    var csrf_token = div.data('csrf-token');
    $.ajax({
      type: "POST",
      url: route,
      data: {  emp_event_id: emp_ev_book_id, _token: csrf_token, in_out: in_out },
      beforeSend: function(){
        $('.loading-container').css('display', 'flex');
      },
      success: function (response) {
        //console.log(response);
        var status = response.status;
        var message = response.message;
        var type = 3;
        if(status == '200'){
          type = 1;
          setTimeout(function() {  location.reload(); }, 2000);

        }
        show_msgT(type, message);
        $('.loading-container').css('display', 'none');
      }
    });
  },
  saveflight: function(thiss) {
    var div = $(thiss).closest('.frmFlightBook');
    var routeUrl = div.attr('action');
    var formData = div.serialize();
    $.ajax({
      type: "POST",
      url: routeUrl,
      data: formData,
      beforeSend: function(){
        $('.loading-container').css('display', 'flex');
      },
      success:function(response){
        console.log(response);
        var status = response.status;
        var message = response.message;
        var type = 3;
        if(status == '200'){
          type = 1;
          setTimeout(function() {  location.reload(); }, 2000);
        }
        show_msgT(type, message);
        $('.loading-container').css('display', 'none');
      }
    });
  },
  getRoomTypeList: function(thiss) {
    $('.room_type_cd').html('');
    var hotel_cd = $(thiss).val();
    var route = $(thiss).attr('data-link');
    var csrf_token = $('.frmHotel').find('input[name="_token"]').val();
    if(parseInt(hotel_cd) > 0){

      $.ajax({
        type: "POST",
        url: route,
        data: {  hotel_cd: hotel_cd, _token: csrf_token },
        beforeSend: function(){
          $('.loading-container').css('display', 'flex');
        },
        success: function (response) {
          //console.log(response);
          var category_list = response.category_list;
          $('.room_type_cd').html(category_list);
          $('.loading-container').css('display', 'none');
        }
      });
    }
  },
  query: function(thiss){
    var form= $('.sos-query');
    var formData = form.serialize();
    var route = form.attr('action');
    //console.log(formData);
    $.ajax({
      type: "POST",
      url: route,
      data: formData,
      beforeSend: function(){
        $('.loading-container').css('display', 'flex');
      },
      success:function(response){
       // console.log(response);
        var status = response.status;
        var message = response.message;
        var type = 3;
        if(status == '200'){
          type = 1;
        }
        if(status == '400'){
          $('.query_text').focus();
        }
        show_msgT(type, message);
        $('.loading-container').css('display', 'none');
      }
    });
  },
  cancelReason: function(thiss){
    var form = $('.frm_event_cancel');
    var formData = form.serialize();
    var route = form.attr('action');
    //console.log(formData);
    $.ajax({
      type: "POST",
      url: route,
      data: formData,
      beforeSend: function(){
        $('.loading-container').css('display', 'flex');
      },
      success:function(response){
       // console.log(response);
        var status = response.status;
        var message = response.message;
        var type = 3;
        if(status == '200'){
          type = 1;
          $('.cancel_reason').val('');
        }
        show_msgT(type, message);
        $('.loading-container').css('display', 'none');
      }
    });
  }
}
/////////////////////////////////////////////////////////////////
$(".cnfCkInOut").click(function() {
  var in_out = $(this).val();
  //console.log(in_out);
  ud.getCheckin(this, in_out);
});
ud.getRoomTypeList('.hotel_cd');
//////////////////////////////////////////////
//////////////////////////////////////////////////////////////////////////
$('.frmHotel').submit(function(e){
  e.preventDefault();
  var route = $(this).attr('action');
  $.ajax({
    type: "POST",
    url: route,
    data: $(this).serialize(), 
    beforeSend: function(){
      $('.loading-container').css('display', 'flex');
    },
    success: function (response) {
      //console.log(response);
      var status = response.status;
      var message = response.message;
      var type = 3;
      if(status == '200'){
        type = 1;
        setTimeout(function() {  location.reload(); }, 2000);

      }
      show_msgT(type, message);
      $('.loading-container').css('display', 'none');
    }
  });
});
//////////////////////////////////////////////////////////////////////////
var winHt = $(window).height() / 2;
var winHt = parseInt(winHt) - 150;
$('#mdlWelCome').css('margin', winHt+'px auto');
var wel_cnt = sessionStorage.getItem("wel_cnt");
if(wel_cnt == '1'){
  $('#mdlWelCome').modal('show');
}

$('.mdlWelComeClose').on('click', function(){
  var mdl = $('#mdlWelCome');
  var cpg = mdl.attr('data-cpg');
  var flg = mdl.attr('data-flg');
  sessionStorage.setItem("wel_cnt", 0);
  if(flg == '1'){
    location.href = cpg;
  }else{
    mdl.modal('hide');
  }
});

