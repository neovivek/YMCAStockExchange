<?php
session_start();
if(isset($_SESSION['username'])){
    header('Location: #/home');
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="Virtual Stock Market presentd by MANAN as a part of Techno-Cultural Fest of YMCA">
    <link rel="icon" href="/img/icon.ico">
    <meta http-equiv="content-type" content="text/html; charset=UTF-8"/>
    <title>YMCA Stock Exchange | MANAN</title>

    <!-- Facebook tags -->
    <meta property="og:type" content="website" />
    <meta property="og:url" content="http://yse.elementsculmyca.in" />
    <meta property="og:title" content="YMCA Stock Exchange | Virtual Stock Market powered by MANAN" />
    <meta property="og:description" content="Come and be the part of this online Stock Market where you can control this miniature market with your fingertips and make money out of it. Behold the genius inside you and let the money flow into this market where there's only one rule. Start early and Be the Best." />
    <meta property="og:site_name" content="YMCA Stock Exchange | Virtual Stock Market powered by MANAN" />
    <meta property="og:image" content="http://www.elementsculmyca.in/images/temp2.jpg" />
    <!-- end Facbook tags -->

    <link href="/css/bootstrap.min.css" rel="stylesheet">
    <link href="/css/bootstrap-theme.min.css" rel="stylesheet">
    <link rel="stylesheet" type="text/css" href="/css/main.css">
    <script src="http://ajax.aspnetcdn.com/ajax/jQuery/jquery-1.10.1.min.js"></script>
    <script src="/js/ie-emulation-modes-warning.js"></script>

    <script type="text/javascript" src="/js/main.js"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/angularjs/1.2.28/angular.min.js"></script>
    <script src="http://ajax.googleapis.com/ajax/libs/angularjs/1.2.28/angular-animate.js"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/angularjs/1.2.28/angular-route.js"></script>
    <script type="text/javascript" src="/js/fb.js"></script>
    <link rel="stylesheet" type="text/css" href="/css/loading-bar.css">
    <script src="/js/loading-bar.js"></script>
    <script src="/js/jquery.ticker.js" type="text/javascript"></script>
</head>
<body ng-app="vsm" id="body">
    <div id="fb-root"></div>
    <div class="navbar navbar-fixed-top navbar-inverse" style="background: rgba(17, 42, 78, 0.83);">
        <h3>YMCA Stock Exchange</h3>
    </div>
    <div ng-view class="chamber"></div>
    <div class="bottom"></div>
    <link href="/css/ticker-style.css" rel="stylesheet" type="text/css" />
    <link rel="stylesheet" type="text/css" href="/css/dashboard.css">
    <script type="text/javascript" src="/js/ng-script.js"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"></script>
    <script src="/js/bootstrap.min.js"></script>
    <script src="/js/docs.min.js"></script>
    <script src="/js/jquery.cookie.js"></script>
</body>
</html>