<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=no">
	<title>IOA Chat</title>

	<!-- ============== favicons =========== -->
  <link rel="apple-touch-icon" sizes="180x180" href="{{asset('/assets/img/favicon/apple-touch-icon.png')}}">
  <link rel="icon" type="image/png" sizes="32x32" href="{{asset('/assets/img/favicon/favicon-32x32.png')}}">
  <link rel="icon" type="image/png" sizes="16x16" href="{{asset('/assets/img/favicon/favicon-16x16.png')}}">

	<meta name="csrf-token" content="{{csrf_token()}}">
	<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.0/css/bootstrap.min.css" integrity="sha384-9gVQ4dYFwwWSjIDZnLEWnxCjeSWFphJiwGPXr1jddIhOegiu1FwO5qRGvFXOdJZ4" crossorigin="anonymous">
	<link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.0.10/css/all.css" integrity="sha384-+d0P83n9kaQMCwj8F4RJB66tzIwOKmrdb46+porD/OvrJ+37WqIM7UoBtwHO6Nlg" crossorigin="anonymous">
	<link rel="stylesheet" href="{{asset('assets/chat/style.css')}}">
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
	<style type="text/css">
		.pro-data label{ margin-bottom: 0 !important; font-size: 14px !important; }
		.pro-data span{ display: block; margin-bottom: 20px; font-size: 15px; }
	</style>
</head>

<body>

<audio id="myAudio">
  <source src="../assets/chat/notification.mp3" type="audio/mpeg">
</audio>
	<div class="container-fluid" id="main-container">
		<div class="row h-100">
			<div class="col-12 col-sm-5 col-md-4 d-flex flex-column bg-white" id="chat-list-area" style="position:relative;">

				<!-- Navbar -->
				<div class="row d-flex flex-row align-items-center p-2" id="navbar">
					<img alt="Profile Photo" class="img-fluid rounded-circle mr-2" style="cursor:pointer;" id="display-pic">
					<div class="text-white font-weight-bold" id="username"></div>
					<div class="nav-item dropdown ml-auto">
						<a class="nav-link dropdown-toggle" data-toggle="dropdown" href="#" role="button" aria-haspopup="true" aria-expanded="false"><i class="fas fa-ellipsis-v text-white"></i></a>
						<div class="dropdown-menu dropdown-menu-right">
							<a class="dropdown-item" href="{{route('admin.dashboard')}}">Back to Admin Panel</a>
						</div>
					</div>
				</div>

				<!-- Chat List -->
				<div class="row" id="chat-list" style="overflow:auto;"></div>

				<!-- Profile Settings -->
				<div class="d-flex flex-column w-100 h-100" id="profile-settings">
					<div class="row d-flex flex-row align-items-center p-2 m-0" style="background:var(--theme-color); min-height:65px;">
						<i class="fas fa-arrow-left p-2 mx-3 my-1 text-white" style="font-size: 1.5rem; cursor: pointer;" onclick="hideProfileSettings()"></i>
						<div class="text-white font-weight-bold">Profile</div>
					</div>
					<div class="loader-line" id="line-loader2" style="display:none"></div>
					<div class="d-flex flex-column pro-data" style="overflow:auto;">
						
					</div>					
				</div>
			</div>

			<!-- Message Area -->
			<div class="d-none d-sm-flex flex-column col-12 col-sm-7 col-md-8 p-0 h-100" id="message-area">
				<div class="w-100 h-100 overlay bg-wall"></div>

				<!-- Navbar -->
				<div class="row d-flex flex-row align-items-center p-2 m-0 w-100" id="navbar">
					<div class="d-block d-sm-none">
						<i class="fas fa-arrow-left p-2 mr-2 text-white" style="font-size: 1.5rem; cursor: pointer;" onclick="showChatList()"></i>
					</div>
					<a href="#">
						<img src="https://via.placeholder.com/400x400" alt="Profile Photo" class="img-fluid rounded-circle mr-2" style="height:48px;" id="pic">
					</a>
					<div class="d-flex flex-column">
						<div class="text-white font-weight-bold text-capitalize" id="name"></div>
						<div class="text-white small" id="details"></div>
					</div>
					<div class="nav-item dropdown ml-auto">
						<a class="nav-link dropdown-toggle" data-toggle="dropdown" href="#" role="button" aria-haspopup="true" aria-expanded="false"><i class="fas fa-ellipsis-v text-white"></i></a>
						<div class="dropdown-menu dropdown-menu-right">
							<a class="dropdown-item" href="#" id="open_profile_btn" data-uid="">Open Profile</a>
						</div>
					</div>
					<!-- <div class="d-flex flex-row align-items-center ml-auto">
						<a href="#"><i class="fas fa-search mx-3 text-white d-none d-md-block"></i></a>
						<a href="#"><i class="fas fa-paperclip mx-3 text-white d-none d-md-block"></i></a>
						<a href="#"><i class="fas fa-ellipsis-v mr-2 mx-sm-3 text-white"></i></a>
					</div> -->
				</div>

				<!-- Messages -->
				<div id="msg_loader" style="position: absolute; text-align: center; margin-top: 20%; width: 100%; color: var(--theme-color); font-size:20px; display: none;">
					<i class="fas fa-spinner fa-spin"></i>
				</div>
				
				<div class="d-flex flex-column bg-wall" id="messages"></div>
				<div class="loader-line" id="line-loader" style="display:none"></div>

				<!-- Input -->
				<form action="{{route('admin.sendMessage')}}" method="POST" class="d-none justify-self-end align-items-center flex-row" id="input-area" enctype="multipart/form-data">
					<span>
						<i class="far fa-image px-3" style="font-size:1.5rem;" id="input-img-btn"></i>
						<input accept="image/*" type='file' name="image" id="input-image" class="invisible" />
						<input type="hidden" name="recevied_id" value="" id="recv_id">
					</span>
					<input type="text" name="message" id="input" placeholder="Type a message" class="flex-grow-1 border-0 px-3 py-2 my-3 rounded shadow-sm" autocomplete="off">
					<i class="fas fa-paper-plane text-muted px-3" style="cursor:pointer;" onclick="sendMessage()"></i>
				</form>
			</div>
		</div>
	</div>

	<input type="hidden" id="active_uid" value="">
	<input type="hidden" id="last_chat_id" value="0">

	<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.0/umd/popper.min.js" integrity="sha384-cs/chFZiN24E4KMATLdqdvsezGxaGsi4hLGOzlXwp5UZB1LY//20VyM2taTB4QvJ"
	    crossorigin="anonymous"></script>
	<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.0/js/bootstrap.min.js" integrity="sha384-uefMccjFJAIv6A+rW+L4AHf99KvxDjWSu1z9VI8SKNVmz4sk7buKt/6v9KI65qnm"
		crossorigin="anonymous"></script>
	<script src="{{asset('assets/chat/datastore.js')}}"></script>
	<script src="{{asset('assets/chat/date-utils.js')}}"></script>
	<script src="{{asset('assets/chat/script.js')}}"></script>
	<script src="{{asset('assets/chat/classes.js')}}"></script>
	<script>
		$(document).ready(function(){
			$('#input-area').submit(function(e){
				e.preventDefault();
				sendMessage();
			});

			$('#input-image').change(function(){
				sendMessage();
			});

			$('#input-img-btn').click(function(){
				document.getElementById("input-image").click();
			});
		});

		function sendMessage(){
			var recevied_id = $('#active_uid').val();
			$('#recv_id').val(recevied_id);
			if(recevied_id != ''){
				var x = new Ajx;
				x.form = '#input-area';
		        // x.passData('recevied_id',recevied_id)
		        x.ajxLoader('#line-loader');
		        x.globalAlert(false);
		        x.start();
		        $('#input').val('');
		        $('#input-image').val('');
	    	}else{
	    		alert('Something error..! Please Refresh The Page.');
	    	}	
		}

		function chatApp(){
			var x = new Ajx;
	        x.actionUrl('../chat_id.txt');
	        x.globalAlert(false);
	        x.start(function(response){
	            if(response != '' && response != null && response != undefined){
	                getChatData(response);
	            }
	            setTimeout(()=>{
					chatApp();
				},700);
	    });
		}

		function getChatData(last_chat_id=null){
			if(last_chat_id == '' || last_chat_id == null){ last_chat_id = null;  }
			var last_id = $('#last_chat_id').val();
			if(last_chat_id == null || last_chat_id != last_id){
				$('#last_chat_id').val(last_chat_id);
				var active_uid = $('#active_uid').val();
				var x = new Ajx;
		        x.actionUrl('{{route("admin.getChatList")}}');
		        x.passData('action','chat_list');
		        x.passData('active_uid',active_uid);
		        x.passData('last_id',last_id);
		        x.globalAlert(false);
		        x.start(function(response){
		            if(response.chat_list != '' && response.chat_list != null && response.chat_list != undefined){
	            		var chat_list = response.chat_list;
	            		chat_list.forEach((data)=>{  
	            			var user_id = `user_`+data.uid;
	            			var pro_img = '../assets/chat/images/adminx.png';
	            			if(data.profile_image != null && data.profile_image != undefined)
	            			{ pro_img = '../assets/img/userprofile/'+data.profile_image; }
	            			var name = data.name == null ? 'Unknown' : data.name;
	            			var mobile = data.mobile == null ? '##########' : data.mobile;
	            			var html_list = `
		            		<div class="chat-list-item d-flex flex-row w-100 p-2 border-bottom `+(data.seen == false ? 'unread' : '')+` `+user_id+`" onclick="loadMessages(this,`+data.uid+`)" data-uid="`+data.uid+`">
		            			<input type="hidden" value="`+data.mobile+`" class="user_mobile">
											<img src="`+pro_img+`" alt="Profile" class="img-fluid rounded-circle mr-2" style="max-height:50px;">
											<div class="w-50">
												<div class="name text-capitalize">`+name+`</div>
												<div class="small last-message" data-mobile="`+data.mobile+`">`+data.last_msg+`</div>
											</div>
											<div class="flex-grow-1 text-right">
												<div class="small time">`+data.last_date+`</div>
												<div class="badge badge-success badge-pill small `+(data.seen == true ? 'd-none' : '')+`" id="unread-count">`+data.msg_count+`</div>
											</div>
										</div>`;

							var chat_user = $(document).find('#chat-list .'+user_id);
							var badge = $(document).find('#chat-list .'+user_id+' .badge');
							var last_message = $(document).find('#chat-list .'+user_id+' .last-message');
							if(chat_user.length > 0){ 
								if(chat_user.hasClass('active') == false && data.seen == false){
									chat_user.addClass('unread'); 
									badge.removeClass('d-none');
									badge.html(data.msg_count);
									last_message.html(data.last_msg);
									chat_user.insertBefore('#chat-list > div:first-child');
									playAudio();
								}
							}else{
								$('#chat-list').prepend(html_list);								
							}
	            		});
		            }
		            
		            if(response.messages != '' && response.messages != null && response.messages != undefined){

	            		var messages = response.messages;
	            		var msg_box = $('#messages');
	            		var msg_id = $(document).find('#messages .message-item').last().attr('data-msg-id');
	               		messages.forEach((data)=>{  	               			
	               			if(msg_id == null || msg_id == undefined || parseInt(msg_id) < parseInt(data.id)){ 
		               			if(data.send_id == 'admin'){
		               				msg_box.append(rightMsg(data));
		               				$("html, body").animate({ scrollTop: $("#messages").scrollTop(+10000) }, 1000);
		               			}else{
		               				msg_box.append(leftMsg(data));
		               				$("html, body").animate({ scrollTop: $("#messages").scrollTop(+10000) }, 1000);
		               			}          			
		               		}		  
	            		});	            		
	            	}
		        });
			}
		}

		function loadMessages(elm,uid){

			$('#open_profile_btn').attr('data-uid',uid);

			generateMessageArea(elm)
			var x = new Ajx;
      x.actionUrl('{{route("admin.loadMessages")}}');
      x.passData('action','messages');
      x.passData('active_uid',uid);
      x.ajxLoader('#msg_loader');
      x.globalAlert(false);
      x.start(function(response){
      	$('#msg_loader').hide();
				if(response.messages != '' && response.messages != null && response.messages != undefined){
      		var messages = response.messages;
      		var msg_box = $('#messages');
      		msg_box.html('');
      		$('#line-loader').hide();
         		messages.forEach((data)=>{  
         			if(data.send_id == 'admin'){
         				msg_box.prepend(rightMsg(data));
         			}else{
         				msg_box.prepend(leftMsg(data));
         			}                   			      		
      		});
      		$("html, body").animate({ scrollTop: $("#messages").scrollTop(+10000) }, 1000);
      	}
		  });
		}

		function leftMsg(data=''){

			var image = '';
			if(data.image != null){
				var img_path = '../assets/img/message/'+data.image;
				image = `
					<a href="`+img_path+`" target="_blank">
						<img src="`+img_path+`" class="msg_image" />
					</a>
				`;
			}

			left_msg = `
    			<div class="align-self-start p-1 my-1 mx-3 rounded bg-white shadow-sm message-item" data-msg-id="`+data.id+`">
					<div class="d-flex flex-column">
						`+image+(data.message != null ? `<div class="body m-1 mr-2">`+data.message+`</div>`:'')+`
						<div class="time ml-auto small text-right flex-shrink-0 align-self-end text-muted" style="width:100%;">
							`+data.msg_date+` `+data.msg_time+`
						</div>
					</div>
				</div>
    		`;
    		playAudio();
    		return left_msg;
		}
		
		function rightMsg(data=''){
			
			var image = '';
			if(data.image != null){
				var img_path = '../assets/img/message/'+data.image;
				image = `
					<a href="`+img_path+`" target="_blank">
						<img src="`+img_path+`" class="msg_image" />
					</a>
				`;
			}

			right_msg = `
    			<div class="align-self-end self p-1 my-1 mx-3 rounded bg-white shadow-sm message-item" data-msg-id="`+data.id+`">
					<div class="d-flex flex-column">
						`+image+(data.message != null ? `<div class="body m-1 mr-2">`+data.message+`</div>`:'')+`
						<div class="time ml-auto small text-right flex-shrink-0 align-self-end text-muted" style="width:100%;">
							`+data.msg_date+` `+data.msg_time+`
							<i class="fas fa-check-circle"></i>
						</div>
					</div>
				</div>
    		`;
    		playAudio();
    		return right_msg;
		}

		function getUserDetails(active_uid){
			showProfileSettings()
			var x = new Ajx;
      x.actionUrl('{{route("admin.getUserDetails")}}');
      x.passData('active_uid',active_uid);
      x.ajxLoader('#line-loader2');
      x.globalAlert(false);
      x.start(function(response){
				if(response.data != '' && response.data != null){
      		var data = response.data;
      		var pro_data = `
      				<img alt="Profile Photo" src="`+(data.image != null ? '../assets/img/userprofile/'+data.image : '{{asset('assets/chat/images/user.jpg')}}')+`" class="img-fluid rounded-circle my-5 justify-self-center mx-auto">
      				<div class="bg-white px-3 py-2">
	      				<div class="text-muted"><label>Name</label></div>
								<span>`+data.name+`</span>
								<div class="text-muted "><label>DOB</label></div>
								<span>`+data.dob+`</span>
								<div class="text-muted "><label>Gender</label></div>
								<span>`+data.gender+`</span>
								<div class="text-muted "><label>Mobile</label></div>
								<span><a href="tel:`+data.mobile+`">`+data.mobile+`</a></span>
								<div class="text-muted "><label>Email</label></div>
								<span><a href="mailto:`+data.email+`">`+data.email+`</a></span>
								<div class="text-muted"><label>City</label></div>
								<span>`+data.city+(data.state != '' ? ', '+data.state:'')+(data.pincode != '' ? ', '+data.pincode:'')+`</span>
							</div>
      		`;
      		$('.pro-data').html(pro_data);
      	}
		  });
		}


		$(document).ready(function(){
			chatApp();		
			$('#open_profile_btn').click(function(){
				showChatList();
				getUserDetails($(this).attr('data-uid'));
			});	
		});
	</script>

<script>
	var Notify = document.getElementById("myAudio"); 
	function playAudio(){ Notify.play(); } 
	function pauseAudio(){ Notify.pause(); } 
</script>

</body>

</html>