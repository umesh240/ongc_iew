function show_msg(type=3, url='', msg='', act=0){
    var icon = '';    var tim = 6000000;
    if(type == 0){  icon = 'error';   }
    else if(type == 1){ icon = 'success';   tim = 2000;   }
    else if(type == 2){ icon = 'warning';   }
    else if(type == 3){ icon = 'info';   }
    else {  icon = 'warning'; msg='Not valid info.'; }
    
    var cnfBtn = clsBtn = true;
    if(act==1){// insert
      cnclBtn = false;
      cnfBtnTxt = 'Ok';
      cnlBtnText = '';
    }
    else if(act==2){// update
      cnclBtn = true;
      cnfBtnTxt = 'Yes';
      cnlBtnText = 'No';
    }
    else if(act==3){// delete
      cnclBtn = true;
      cnfBtnTxt = 'Yes, Delete It.';
      cnlBtnText = 'Cancel';
    }
    else if(act==4){ // wait
      cnclBtn = cnfBtn = clsBtn = false;
      cnfBtnTxt = cnlBtnText = 'Cancel';
    }else{ // wrong type
      cnclBtn = false;
      cnfBtnTxt = 'Ok';
      cnlBtnText = '';
    }
    url = url.trim();
    return Swal.fire({
	   timer: tim,
      icon: icon,
      //title: 'Oops...',
      showCloseButton: clsBtn,
      showCancelButton: cnclBtn,
      showConfirmButton: cnfBtn,
      html: msg,
      confirmButtonText: cnfBtnTxt,
      cancelButtonText: cnlBtnText,
      showClass: { popup: 'animate__animated animate__fadeInDown'   },
      hideClass: { popup: 'animate__animated animate__fadeOutUp'    },
      onClose: () => {  
        if (type == '1' && url != '') {
          window.location=url;
        }   
      },
    }).then((result) => {
      if (result.value && url != '') {
      window.location=url;
      }
    });
}
function show_msgT(type, msg, url=''){
	type = parseInt(type);
	switch(type){
		case 1:
			toastr.success(msg);
		break;
		case 2:
			toastr.error(msg);
		break;
		case 3:
			toastr.info(msg);
		break;
		case 4:
			toastr.warning(msg);
		break;
		default:
			toastr.error("Invalid alert call.");
		break;
	}
	setTimeout(() => {
		if(url.trim() != ''){
			window.location = url;
		}
	}, 1000);
}
//////////////////////////////////////////////////////////////////
function linkClick(thiss, target=''){
	target = target.toUpperCase();
	if(target == 'O'){
		var link = $(thiss).find('option:selected').attr('data-link');
	}else{
		var link = $(thiss).attr('data-link');
	}
	
	if(target == 'B'){
		window.open(link, '_blank');
	}else{
		window.location = link;
	}
}
//////////////////////////////////////////////////////////////////
function recordsDelete(thiss, idd){
	var cnf = confirm("Are you sure to delete it..?");
	if(cnf){
		var url = $(thiss).attr('data-link');
		$.ajax({
			type: "POST",
			url: url,
			data: {id:idd, _token: "{{ csrf_token() }}"},
			success:function(result){
			  console.log(result);
			  result = result.trim();
			  result = result.split('||');
			  var msg = result[1];
			  var mod = result[2];
			  show_msgT(mod, msg);
			  if(mod == '1'){
				setTimeout(function() {
				  //location = "{{ route('login') }}";
				  location.reload();
				}, 2000);
			  }
			}
		});
	}
}
//////////////////////////////////////////////////////////////////
$('.alpnum').on('keyup', function() {
	var inputValue = $(this).val();
	var alphanumericRegex = /^[a-zA-Z0-9_]+$/;

	if (!alphanumericRegex.test(inputValue)) {
	  $(this).val(inputValue.replace(/[^a-zA-Z0-9_]/g, ''));
	}
});
///////////////////////////////////////////////////////////////////
$(document).on('keyup', 'input[type="text"]', function(){
	var value = $(this).val();
	value = value.trim();
	if(value == ''){
		$(this).val('');
	}
});
$('input[type="text"]').on( "focusout", function() {
    var value = $(this).val();
    value = value.trim();
    $(this).val(value);
 } );
////////////////////////////////////////////////////////
$(".float").on("keypress keyup blur",function (event) {
	//this.value = this.value.replace(/[^0-9\.]/g,'');
	$(this).val($(this).val().replace(/[^0-9\.]/g,''));
	if ((event.which != 46 || $(this).val().indexOf('.') != -1) && (event.which < 48 || event.which > 57)) {
		event.preventDefault();
	}
	
	if($(this).val() < 0){		$(this).val('');			}
});

	
//////////////////////////////////////////////////////////////
$(".int").on("keypress keyup blur",function (event) {    
   $(this).val($(this).val().replace(/[^\d].+/, ""));
	if ((event.which < 48 || event.which > 57)) {
		event.preventDefault();
	}
});
////////////////////////////////////////////////////////////
$('.char').on("keypress keyup blur",function (e) { 
var key = e.keyCode;
	if (!((key == 8) || (key == 32) || (key == 46) || (key >= 65 && key <= 90) || (key >= 97 && key <= 122) || (e.shiftKey || e.ctrlKey || e.altKey))) {
	  e.preventDefault();
	}	 
});
///////////////////////////////////////////////////////////////////
$(document).on('keyup, keypress', 'input[maxlength]', function(e){
	var maxx = $(this).attr('maxlength');
	var value = $(this).val();
	value = value.trim();
	if(value.length == maxx){
		e.preventDefault();
	}
});