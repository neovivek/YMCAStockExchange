<?php

if (date('M-d') < 'Mar-14') {
	echo "<!DOCTYPE html>
<html>
	<head>
	</head>
	<body>
		<h1>This is to inform the crazy audience that the following content will be visible after 14th March. Till then control ur feelings n enjoy Holi.</h1>
		<h4>Issued by Malasi n Hodal in public intrest</h4>
	</body>
</html>";
die();
}
require 'connect.inc.php';
require 'core.inc.php';
if(loggedin())
{
$level=getuserfield('level');
$name=getuserfield('name');

    $id=getuserfield('uid');
}
else
{
echo "You have to log in to Play!";
exit();
}
?>
<!DOCTYPE html>
<html>
	<head>
	<link rel="icon" 
      type="image/png" 
      href="logo.jpg" />
  
		<meta charset="UTF-8" />
		<meta http-equiv="X-UA-Compatible" content="IE=edge"> 
		<meta name="viewport" content="width=device-width, initial-scale=1"> 
		<title>Treasure Hunt'15</title>
		<meta name="description" content="treasure hunt game " />
		<meta name="keywords" content="treasure hunt,ymca,culymca'15,culymca,manan" />
	
		
		<link rel="stylesheet" type="text/css" href="css/normalize.css" />
		<link rel="stylesheet" type="text/css" href="css/demo.css" />
		<link rel="stylesheet" type="text/css" href="fonts/font-awesome-4.2.0/css/font-awesome.min.css" />
		<link rel="stylesheet" type="text/css" href="css/menu_topside.css" />
                
		<!--[if IE]>
  		<script src="http://html5shiv.googlecode.com/svn/trunk/html5.js"></script>
		<![endif]-->
	</head>

<body>	

	    		<div class="container">
			<div class="menu-wrap">
				<nav class="menu-top">
					<div class="profile"><img src="" alt=""/><span><?php $name=getuserfield('name'); echo $name;?></span></div>
					<div class="icon-list">
						<a href="https://www.facebook.com/culmyca15" target="_blank"><i class="fa fa-fw fa-star-o"></i></a>
						<a href="https://www.facebook.com/culmyca15/app_202980683107053" target="_blank"><i class="fa fa-fw fa-comment-o"></i></a>
						<a href="mailto:tarungarg546@gmail.com" target="_blank"><i class="fa fa-fw fa-envelope-o"></i></a>
					</div>
				</nav>
				<nav class="menu-side">
				        <a href="level.php">Home</a>
					<a href="rules.php" target="_blank">Rules</a>
					<a href="leaderboard.php" target="_blank">Leaderboard</a>
                                        <a href="https://www.facebook.com/culmyca15/app_202980683107053" target="_blank">Forum</a>
					<a href="contactus.html" target="_blank">About US</a>
					<a href="http://elementsculmyca.in/" target="_blank">CULYMCA'15 </a>
					<a href="http://elementsculmyca.in/privacy" target="_blank">Privacy Policy</a>
					
				</nav>
			</div>
			<button class="menu-button" id="open-button">Open Menu</button>
			<div class="content-wrap">
				<div class="content">
					<header class="codrops-header">
						
						<h1>Treasure Hunt'15 <span>Powered by Ymca University Of Science and Technology</span></h1>
						
                
  <nav class="codrops-demos">              
              	<div class="column_right_grid qstn">
                 <div class="newsletter">
                     <h1> Level 1 </h1>
                     <h3>
					 <?php 
					 
							
							  $q="SELECT `que` FROM `ques` WHERE `no`='$level'";
                              $q_run=mysql_query($q); 
							  $question=mysql_result($q_run,0);							 
							  echo '<img src="'.$question.'" height="30%" width="45%">';
							 

				     ?>					 </h3>
					    <form method="post" action="level.php">
					    	<span>
					 	    <i><img src="img/lock.png" alt="" /></i>
                            <input type="text" name = "answer" value="Your answer" onfocus="this.value = '';" onblur="if (this.value == '') {this.value = 'Your Answer';}">
                            </span>			 	    
					 		<input type="submit" name="submit" class="my_button" value="Submit">
					 	</form>
				 	
					 	
				   </div>
			   </div>
		                   
		        
		          	</nav>  
                                </header>
                                </div>                      
                                 </div><!-- /content-wrap -->
		
						
					<!--	<p>Powered by manan</p>-->
					
				
		<script src="js/classie.js"></script>
		<script src="js/main.js"></script>
	
                        </div><!-- /container -->       

<?php
if(isset($_POST['answer']))
 {
  $ans=$_POST['answer'];
  if($ans!='Your answer')
  {
   if(loggedin()) 
   {
	$level=getuserfield('level'); 
	$q="SELECT `ans` FROM `ques` WHERE `no`='$level'";
    $q_run=mysql_query($q); 
	$correctans=mysql_result($q_run,0);
	if($level<>2)
	{
	 $ans=strtoupper($ans);
	} 
	if($level==2)
	{
	 $correctans=getuserfield('name');
	}
	if($ans==$correctans)
	{

         $id=getuserfield('uid');
	 $level++;
	 
	  $q="UPDATE `user` SET `level`='$level' WHERE `uid`='$id'";
      if($qu_run=mysql_query($q))
      {
	  $q="UPDATE `user` SET `time`=NOW() WHERE `uid`='$id'";
      $qu_run=mysql_query($q);

        echo '<script> fun(); </script>';
	   header('Location: rank.php'); 
     
	  }	 
	}
	else
	{
	 header('Location: level.php');
	}
   } 
  }
  else
  {
   header('Location: level.php');
  }
 } 
?>
                        </body>                                                      
 </html>