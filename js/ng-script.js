
var myapp = angular.module("vsm", ['ngRoute','ngAnimate','chieffancypants.loadingBar'])	
.config(function(cfpLoadingBarProvider) {
    cfpLoadingBarProvider.includeSpinner = true;
  });
myapp.controller("homepageController", function ($scope)
{
	if( typeof $.cookie('username') !== 'undefined' ){
        window.location = "#/home";
	}
});
myapp.controller("homeController",function($scope)
{
	if( typeof $.cookie('username') === 'undefined'){
		window.location = "/";
	}
});
myapp.controller("marketController",function($scope)
{
	if( typeof $.cookie('username') === 'undefined'){
		window.location = "/";
	}else{
		update();
	}
});
myapp.controller("profileController",function($scope)
{
	if( typeof $.cookie('username') === 'undefined'){
		window.location = "/";
	}else{
		profiler();
	}
});
myapp.controller("boardController",function($scope)
{
	if( typeof $.cookie('username') === 'undefined'){
		window.location = "/";
	}else{
		board();
	}
});
myapp.controller("historyController",function($scope)
{
	if( typeof $.cookie('username') === 'undefined'){
		window.location = "/";
	}else{
		log();
	}
});
myapp.controller("faqController",function($scope)
{
	if(typeof $.cookie('username') === 'undefined'){
		window.location = "/";
	}else{
	}
});

myapp.config(['$routeProvider',function($routeProvider)
{
	$routeProvider.
	when
	('/',
	{
		templateUrl: "homepage.html",
		controller: "homepageController"
	}).
	when
	('/home',
	{
		templateUrl : "home.html",
		controller : "homeController"
	}).
	when
	('/market',
	{
		templateUrl : "market.html",
		controller : "marketController"
	}).
	when
	('/profile',
	{
		templateUrl : "profile.html",
		controller : "profileController"
	}).
	when
	('/leaderboard',
	{
		templateUrl : "board.html",
		controller : "boardController"
	}).
	when
	('/history',
	{
		templateUrl : "history.html",
		controller : "historyController"
	}).
	when
	('/faq',
	{
		templateUrl : "faq.html",
		controller : "faqController"
	}).
	otherwise({
	    redirectTo: '/'
	});
}]);
	