<script>
    var has_permission = 99;

  window.fbAsyncInit = function() {
    FB.init({appId  : '134893243199526',
             status : true, // check login status
             cookie : true, // enable cookies to allow the server to access the session
             xfbml  : true  // parse XFBML
           });
    
    FB.getLoginStatus(function(response) {
      if (response.session) {
		var query = FB.Data.query('select publish_stream from permissions where uid={0}', response.session["uid"]);
		query.wait(function(rows) {
		   if (rows[0].publish_stream) {
			   publishPost(response.session);
		   } else {
			   notReadyToPost();
		   }
		});
      } else {
        notReadyToPost();
      }
    });    

  };

  (function() {
    var e = document.createElement('script');
    e.src = document.location.protocol + '//connect.facebook.net/en_US/all.js';
    e.async = true;
    document.getElementById('fb-root').appendChild(e);
  }());

  function requestExtPerm(){
    FB.login(function(response) {
       if (response.session) {
          if (response.perms) {
            publishPost(response.session);
          } else {
              // user is logged in, but did not grant any permissions
          }
        } else {
          // user is not logged in
        }
    }, {perms:'publish_stream'});
  };
  
  
  function notReadyToPost() {
    document.getElementById('confirmMsg').innerHTML = 'Not ready to publish post yet. ' + 
             'Please click the button. ' +
             '<button id="fb-login" onclick="requestExtPerm();">Grant Permissions</button>';
  };
  
  function publishPost(session) {
    var publish = {
      method: 'stream.publish',
      message: 'is learning how to develop Facebook apps.',
      picture : 'http://www.takwing.idv.hk/facebook/demoapp_jssdk/img/logo.gif',
      link : 'http://www.takwing.idv.hk/facebook/demoapp_jssdk/',
      name: 'This is my demo Facebook application (JS SDK)!',
      caption: 'Caption of the Post',
      description: 'It is fun to write Facebook App!',
      actions : { name : 'Start Learning', link : 'http://www.takwing.idv.hk/tech/fb_dev/index.php'}
    };

    FB.api('/me/feed', 'POST', publish, function(response) {  
        document.getElementById('confirmMsg').innerHTML = 
               'A post had just been published into the stream on your wall.';
    });
  };
  
</script>
