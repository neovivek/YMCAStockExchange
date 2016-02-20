function checkLoginState() {
  FB.getLoginStatus(function(response) {
    statusChangeCallback(response);
  });
}
function statusChangeCallback(response) {
  if (response.status === 'connected') {
    testAPI();
  } else if (response.status === 'not_authorized') {  
    $.removeCookie('username');
    $('.homecontainer').prepend("<div class='alert alert-danger alert-dismissible' role='alert'><button type='button' class='close' data-dismiss='alert' aria-label='Close'><span aria-hidden='true'>&times;</span></button>Please Allow the app on facebook !</div>");
  } else {
    $.removeCookie('username');
    $('.homecontainer').prepend("<div class='alert alert-danger alert-dismissible' role='alert'><button type='button' class='close' data-dismiss='alert' aria-label='Close'><span aria-hidden='true'>&times;</span></button>Please Login on Facebook !</div>");
  }
}

window.fbAsyncInit = function() {
  FB.init({
  	cookie   : true,
    appId    : '1607516596138196',
    xfbml    : true,
    version  : 'v2.2',
    status : true,
  });
  FB.getLoginStatus(function(response) {
  	statusChangeCallback(response);
	});
};

(function(d, s, id){
   var js, fjs = d.getElementsByTagName(s)[0];
   if (d.getElementById(id)) {return;}
   js = d.createElement(s); js.id = id;
   js.src = "//connect.facebook.net/en_US/sdk.js";
   fjs.parentNode.insertBefore(js, fjs);
 }(document, 'script', 'facebook-jssdk'));

function testAPI() {
	FB.api("/me?fields=id,first_name,last_name,gender,email",
	function (response) {
    $.ajax({
      url:'/php/signup.php?email='+response.email+'&fname='+response.first_name+'&lname='+response.last_name+'&gender='+response.gender,
      success: function(data){
        $.cookie('username', response.first_name);
          console.log(window.location.hash);
        if(window.location.hash == '#/'){
          window.location = "#/home";
        }else{
          window.location = window.location.hash;
        }
        setTimeout( $('.homecontainer').prepend("<div class='alert alert-success alert-dismissible' role='alert'><button type='button' class='close' data-dismiss='alert' aria-label='Close'><span aria-hidden='true'>&times;</span></button>Welcome "+response.first_name+" "+response.last_name+" !</div>") ,200);
      }
    });
  });
}