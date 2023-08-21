$(document).ready(function(argument) {
	if($('form.ajx-submit').length > 0){
		$('form.ajx-submit').submit(function(e) {
			e.preventDefault();
			var autoAjx = new Ajx;
			var formID = $(this).attr('id');
			if(formID != ''){
				autoAjx.form = '#'+formID;
				autoAjx.start();
			}
		});
	}
});

// Ajax class -----------
// with loader and progressbar

class Ajx{

	constructor(){
		this.form = false;
		this.loader = false;
		this.disable = false;
		this.progressbar = false;
		this.reset = false;
		this.error_msg = 'Something error ..! \n\n Please refresh the page.';
		this.attr = '';
		this.form_data = false;
		this.ajx_form = new FormData();
		this.action = false;
		this.global_alert = false;
		this.update_html = false;
	}


	passData(key_param,val_param){
		this.ajx_form.append(key_param,val_param);
		this.form_data = this.ajx_form;
	}

	actionUrl(action_url){
		this.action = action_url;
	}

	disableBtn(btn_slector){
		this.disable = btn_slector;
	}

	progressBar(progress = true){
		this.progressbar = progress;
	}

	errorMsg(msg = false){
		this.error_msg = msg;
	}

	ajxLoader(loaderid = false){
		this.loader = loaderid;
	}

	globalAlert(ajx_msg = false){
		this.global_alert = ajx_msg;
	}

	updateHtml(updt_html = false){
		this.update_html = updt_html;
		if(updt_html != false){
			this.passData('update_html',updt_html);
		}
	}

	start(successData=false){
		var ajxcontroller = $(this.form +' [data-ajxcontroller="true"]');
		var ajxx = $(this.form +' [data-ajx="true"]');
		if(ajxcontroller.length > 0 || ajxx.length > 0){
			var fm = this.form;
			if($(fm+' [data-action-url]').length > 0){ this.action = $(fm+' [data-action-url]').attr('data-action-url'); }
			if($(fm+' [data-disable-btn]').length > 0){ this.disable = $(fm+' [data-disable-btn]').attr('data-disable-btn'); }
			if($(fm+' [data-progress-bar]').length > 0){ this.progressbar = $(fm+' [data-progress-bar]').attr('data-progress-bar'); }
			if($(fm+' [data-error-msg]').length > 0){ this.error_msg = $(fm+' [data-error-msg]').attr('data-error-msg'); }
			if($(fm+' [data-ajx-loader]').length > 0){ this.loader = $(fm+' [data-ajx-loader]').attr('data-ajx-loader'); }
			if($(fm+' [data-form-reset]').length > 0){ this.reset = $(fm+' [data-form-reset]').attr('data-form-reset'); }
			if($(fm+' [data-global-alert]').length > 0){ this.global_alert = $(fm+' [data-global-alert]').attr('data-global-alert'); }
			if($(fm+' [data-success-function]').length > 0){ successData = $(fm+' [data-success-function]').attr('data-success-function'); }
		}

		if(this.form != false && this.form_data != false){
			var form1data = $(this.form).serializeArray();
			for (var i=0; i<form1data.length; i++){
    		this.form_data.append(form1data[i].name, form1data[i].value);
    	}
    	this.form = false;
		}

		if(this.disable != false){
			$(this.disable).prop('disabled', true);
			if($(this.disable).attr('onclick')){
				this.attr = $(this.disable).attr('onclick');
				$(this.disable).attr('onclick','');
			}
		}
		if(this.loader != false){
			$(this.loader).css({'display':'inline-block'});
		}
		
		let form_id;
		let form_data;

		if(this.form != false){
			form_id = this.form.replace('#',''); 
	  		form_data = document.getElementById(form_id);
		}

		var formx = this.form;
		var disablex = this.disable;
		var attrx = this.attr;
		var loaderx = this.loader;
		var error_msgx = this.error_msg;
		var resetx = this.reset;
		var progress = this.progressbar;
		var percent = this.progressbar+' div';
		var form_datax = this.form_data;
		var actionx = this.action;
		var global_alertx = this.global_alert;
		var update_htmlx = this.update_html;

	  $.ajaxSetup({ headers: {'X-CSRF-Token': $('meta[name="csrf-token"]').attr('content')}}); 
	  if(progress != false){

	  	$(progress).show();
	  	
	  	$.ajax({
	  		xhr:function(){
		        var xhr = new window.XMLHttpRequest();
		        xhr.upload.addEventListener("progress", function (evt) {
		            if (evt.lengthComputable) {
		                var percentComplete = evt.loaded / evt.total;
		                $(percent).css({
		                    width: percentComplete * 100 + '%'
		                }).html(percentComplete * 100 + '%');
		                if (percentComplete === 1) {
		                    $(progress).hide();
		                }
		            }
		        }, false);
		        xhr.addEventListener("progress", function (evt) {
		            if (evt.lengthComputable) {
		                var percentComplete = evt.loaded / evt.total;
		                $(percent).css({
		                    width: percentComplete * 100 + '%'
		                }).html(percentComplete * 100 + '%');
		            }
		      }, false);
		      return xhr;
		    },
		   url:actionx != false ? actionx : $(formx).attr('action'),
		   method:$(formx).attr('method') ? $(formx).attr('method') : 'POST',
		   data:form_datax != false ? form_datax : new FormData(form_data),
		   dataType:'JSON',
		   contentType: false,
		   cache: false,
		   processData: false,
		   complete:function(){ 
		   		if(disablex != false){
					$(disablex).prop('disabled', false);
					if(attrx != ""){
						$(disablex).attr('onclick',attrx);
					}
				}
				if(loaderx != false){
					$(loaderx).hide();
				}
		   	},
		   error:function(){ 
		   		if(disablex != false){
					$(disablex).prop('disabled', false);
					if(attrx != ""){
						$(disablex).attr('onclick',attrx);
					}
				}
				if(loaderx != false){
					$(loaderx).hide();
				} 
				if(error_msgx != false){
		   			alert(error_msgx);
		   		}
		   	},
		   success:function(data){
	      	
	      	if(data.status == true && update_htmlx != false){
	      		if(resetx != false){
			   			document.getElementById(form_id).reset();
			   		}
	      		if(data.html_content != undefined && data.html_content != null){
	      			if($(update_htmlx).length > 0){
	      				$(update_htmlx).html(data.html_content);
	      			}
	      		}
	      	}

	      	if(global_alertx == true){ 
	      		if(resetx != false){
			   			document.getElementById(form_id).reset();
			   		}
	      		if(data.status == true){
			         globalAlert(data.message,'alert-success');
			      }else{
			         globalAlert(data.message);
			      }
	      	}

	      	if(successData != false){ successData(data); }
		   }
  		});

	  }else{
		
		$.ajax({
		   url:actionx != false ? actionx : $(formx).attr('action'),
		   method:$(formx).attr('method') ? $(formx).attr('method') : 'POST',
		   data:form_datax != false ? form_datax : new FormData(form_data),
		   dataType:'JSON',
		   contentType: false,
		   cache: false,
		   processData: false,
		   complete:function(){ 
		   		if(disablex != false){
					$(disablex).prop('disabled', false);
					if(attrx != ""){
						$(disablex).attr('onclick',attrx);
					}
				}
				if(loaderx != false){
					$(loaderx).hide();
				}
		   	},
		   error:function(){ 
		   		if(disablex != false){
					$(disablex).prop('disabled', false);
					if(attrx != ""){
						$(disablex).attr('onclick',attrx);
					}
				}
				if(loaderx != false){
					$(loaderx).hide();
				} 
				if(error_msgx != false){
		   			alert(error_msgx);
		   		}
		   	},
		   success:function(data){
		   	
		   		if(data.status == true && update_htmlx != false){
		   			if(resetx != false){
			   			document.getElementById(form_id).reset();
			   		}
	      		if(data.html_content != undefined && data.html_content != null){
	      			if($(update_htmlx).length > 0){
	      				$(update_htmlx).html(data.html_content);
	      			}
	      		}
	      	}

	      	if(global_alertx == true){ 
	      		if(data.status == true){
	      			if(resetx != false){
				   			document.getElementById(form_id).reset();
				   		}
			         globalAlert(data.message,'alert-success');
			      }else{
			         globalAlert(data.message);
			      }
	      	}
		      if(successData != false){ successData(data); }
		   }
  		});
	}
}
}


// Global Alert ------------------------------------------------------------------
function globalAlert(message = '',class_name = 'alert-danger',auto_hide = true){
  if($('#global_alert').length <= 0){
    $('body').append('<div id="global_alert" style="max-width: 340px; position: fixed; top: 0; right: 0; z-index: 9999;"></div>');
  }
  var uid_class = 'hide'+Math.floor((Math.random() * 9999) + 1);
  var elm = '<div class="'+uid_class+' alert '+class_name+' alert-dismissible fade show" role="alert" style="margin:20px; font-size:14px;">';
      elm += message;
      elm += `<button type="button" class="close" data-dismiss="alert" aria-label="Close" style="margin-top:-3px;">
			    <span aria-hidden="true">&times;</span>
			  </button>`;

      $(document).find('#global_alert').append(elm);
      
      if(auto_hide == true){
        setTimeout(function(){
          $(document).find('.'+uid_class).fadeOut();
          setTimeout(function(){ 
            $(document).find('.'+uid_class).remove(); 
            if($('#global_alert .alert').length <= 0){
              $('#global_alert').remove();
            }
          },2000);
        },6000);
      }
}


// Redirection --------------------
function redirect_to_url($http_url){
  window.location.replace($http_url);
}

function put_value(selector,value){
	$(selector).val(value);
}

function getLocation(user_function){
  if (navigator.geolocation) {
    navigator.geolocation.getCurrentPosition(user_function, showError);
  } else { 
    globalAlert("Geolocation is not supported by this browser.",'alert-danger');
    return false;
  }
}


function showError(error) {
  switch(error.code) {
    case error.PERMISSION_DENIED:
       globalAlert("User denied the request for Geolocation.",'alert-danger');
      break;
    case error.POSITION_UNAVAILABLE:
      globalAlert("Location information is unavailable.",'alert-danger');
      break;
    case error.TIMEOUT:
      globalAlert("The request to get user location timed out.",'alert-danger');
      break;
    case error.UNKNOWN_ERROR:
      globalAlert("An unknown error occurred.",'alert-danger');
      break;
  }
}

// ========= Get Current Coordinates ============
function showPosition(position){
    if(position.coords.latitude != ''){
    	return [position.coords.latitude,position.coords.longitude];
  	}else{
  		return false;
  	}
}


function autoFill(main_selector_id = false,arr_data = false){
	var arr_keys = Object.keys(arr_data);
	if(Array.isArray(arr_keys) == true && main_selector_id != false && arr_data != false){
		arr_keys.forEach(function(key_name,index){
			$(main_selector_id+' [name="'+key_name+'"]').val(arr_data[key_name]);
		});
	}else{
		alert('Auto fill is not working..!');
	}	
}



function autocomp(input_id,suggestions){
    currentFocus = -1;
    if($(input_id+'_ajxcom').length > 0){
    	//$(input_id+'_ajxcom').html('');
    }else{
    	var w = $(input_id).parent().width(); 
    	$('<div class="autocom-box border text-capitalize" id="'+$(input_id).attr('id')+'_ajxcom" style="max-height: 280px; width:'+w+'px; overflow-y: auto; position: absolute; background-color: white; z-index: 10; display: none;"></div>').insertAfter(input_id);
    	$(input_id).parent().css('display','block');
    	$(input_id).parent().css('position','relative');
    }
    const input_box = document.querySelector(input_id);
    const sugg_box = document.querySelector(input_id+'_ajxcom');
    input_box.onkeyup = (e)=>{
      if(e.keyCode != 38 && e.keyCode != 40 && e.keyCode != 13){
          currentFocus = -1;
          let userData = e.target.value; 
          let emptyArray = [];
          if(userData){
              sugg_box.style.display = "block";
              sugg_box.innerHTML = suggestions;
          }else{
              sugg_box.style.display = "none";
          }
      }

      var x = sugg_box;
      if (x) x = x.getElementsByTagName("li");
      if (e.keyCode == 40) {
       
          currentFocus++;
          if (x){
              for (var i = 0; i < x.length; i++) {
                x[i].classList.remove("autocomplete-active");
              }
              if (currentFocus >= x.length) currentFocus = 0;
              if (currentFocus < 0) currentFocus = (x.length - 1);
              x[currentFocus].classList.add("autocomplete-active");
          }

      }else if (e.keyCode == 38) { 
        currentFocus--;
          if(x){
              for (var i = 0; i < x.length; i++) {
                x[i].classList.remove("autocomplete-active");
              }
              if (currentFocus >= x.length) currentFocus = 0;
              if (currentFocus < 0) currentFocus = (x.length - 1);
              x[currentFocus].classList.add("autocomplete-active");
          }
      } 
      else if (e.keyCode == 13) {
        e.preventDefault();
        if (currentFocus > -1) {
          var ahref = x[currentFocus];
          x[currentFocus].click();
          $(input_id+'_ajxcom').hide();
        }
      }
    }
    $(input_id).focusout(function(){
        setTimeout(function(){ $(input_id+'_ajxcom').hide() },200);
    });
    $(input_id+'_ajxcom'+' li').click(function(){
        $(input_id+'_ajxcom').hide();
    });
    
}


// Image --> Create delete button & preview image & remove image & delete image from server

function image_edit(image_id='',route=false,action='',row_id='',column=''){

	var btn_name = $(image_id).attr('id')+'_delx_btn';
	var btn_id = image_id+'_delx_btn';

	var html_button = '<button type="button" id="'+btn_name+'" class="btn btn-sm btn-danger del_icon_btn" style="display: none;">';
	html_button += '<i class="icofont-ui-delete"></i>';
	html_button += '</button>';

	if(image_id != ''){
		$(image_id).parent().append(html_button);
	}

	var dummy_image = $(image_id).attr('data-dummy-image');
	var src_image = $(image_id).attr('src');

	var close_btn = $(document).find(btn_id);
	if(dummy_image == src_image){
		close_btn.hide();
	}else{ close_btn.show(); }

	var file_id_name = $(image_id).parent().find('input[type="file"]').attr('id');
	var input_file_id = '#'+file_id_name;

	$(image_id).parent().addClass('position-relative');
	$(input_file_id).change(function(){
		$(btn_id).show();
	});

	$(image_id).click(function(){
		document.getElementById(file_id_name).click();
	});

	document.getElementById(file_id_name).onchange = evt => {
	  const [file] = document.getElementById(file_id_name).files;
	  if (file) {
	    document.getElementById($(image_id).attr('id')).src = URL.createObjectURL(file);
	  }
	}

	$(document).on('click',btn_id,function(){
		// delete image from server
		if(route != false){
			var x = new Ajx;
			x.actionUrl(route);
			x.passData('action',action);
			x.passData('id',row_id);
			x.passData('column',column);
			$(btn_id).html('<span class="spinner-border spinner-s1 loaderx" role="status" aria-hidden="true"></span>');
			x.globalAlert(false);
			x.start(function(response){
				$(btn_id).html('<i class="icofont-ui-delete"></i>');		
				$(image_id).attr('src',dummy_image);
				$(btn_id).hide();
				$(input_file_id).val("");
			});
		}else{
			$(image_id).attr('src',dummy_image);
			$(btn_id).hide();
			$(input_file_id).val("");
		}
	});		
}

