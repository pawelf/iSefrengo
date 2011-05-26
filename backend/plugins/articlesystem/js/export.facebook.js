  window.fbAsyncInit = function() {
    FB.init({	appId: applicationid, 
    					status: true, 
    					cookie: true,
             	xfbml: true});

                /* All the events registered */
                FB.Event.subscribe('auth.login', function(response) {
                    // do something with response
                    login();
                });
                FB.Event.subscribe('auth.logout', function(response) {
                    // do something with response
                    logout();
                });

                FB.getLoginStatus(function(response) {
                    if (response.session) {
                        // logged in and connected user, someone you know
                        login();
                    }
                });
            };
            (function() {
                var e = document.createElement('script');
                e.type = 'text/javascript';
                e.src = document.location.protocol +
                    '//connect.facebook.net/en_US/all.js';
                e.async = true;
                document.getElementById('fb-root').appendChild(e);
            }());

            function login(){
                FB.api('/me', function(response) {
                    document.getElementById('login').style.display = "block";
                    document.getElementById('login').innerHTML = response.name + " succsessfully logged in!";
                });
            }
            function logout(){
                document.getElementById('login').style.display = "none";
            }

            //stream publish method
            function streamPublish(linkname, link, caption, description, mediatype, media, aid){

							if (mediatype=='image' || mediatype=='flash' || mediatype=='mp3') {
								var attachment = { 
								    'name': linkname, 
								    'href': link, 
								    'caption': caption, 
								    'description': (description), 
								    'media': [{ 
													        'type': mediatype, 
													        'src': media, 
													        'href': link
													    }]	 
								}; 
							} else {
								var attachment = { 
								    'name': linkname, 
								    'href': link, 
								    'caption': caption, 
								    'description': (description)
								}; 							
							}

              FB.ui({
                  method: 'stream.publish',
                  message: '',  
                  attachment: attachment,
                  action_links: [{ text: linkname, href: link }]
              },
              
              function(response) {

						   	if (applicationid=="")
									check = confirm(jslangfbsentconfirm);

							  if ((!response || response.error) && applicationid!="") {

							   	if (applicationid!="")
								    document.getElementById('post'+aid).className='fullwidtherrormsg';

							  } else {

							   	if (applicationid!="")
							    	document.getElementById('post'+aid).className='fullwidthsuccessmsg';
							    
							    if (applicationid=="")
							    	if (check) 
									    document.getElementById('post'+aid).className='fullwidthsuccessmsg';
							    	else
								    	document.getElementById('post'+aid).className='fullwidtherrormsg';
							    	
							    if (document.getElementById('post'+aid).className=="fullwidthsuccessmsg") {
								    window.frames['articleupdate'+aid].document.frm.sentdatetime.value=getDateTime();
								    window.frames['articleupdate'+aid].document.frm.sentdata.value=description;
								    window.frames['articleupdate'+aid].document.frm.action.value='update';
								    window.frames['articleupdate'+aid].document.frm.submit();
							    }
							  }

              });

            }

function getDateTime(){
	var now = new Date();
	
	var year=now.getFullYear();
	var month=now.getMonth()+1;
	var day=now.getDate();
	var minute=now.getMinutes()
	var hour=now.getHours();
	var seconds=now.getSeconds();
	
	if (month<10)
		month='0'+month;

	if (day<10)
		day='0'+day;

	if (minute<10)
		minute='0'+minute;

	if (hour<10)
		hour='0'+hour;

	if (seconds<10)
		seconds='0'+seconds;

	return year+"-"+month+"-"+day+" "+hour+":"+minute+":"+seconds;
																	
}
    