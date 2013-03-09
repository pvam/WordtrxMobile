<!DOCTYPE html>
<head>
<title>wordtrix</title>
<link rel="shortcut icon" href="images/icon.png" type="image/x-icon" />
<meta charset="utf-8"/>
<link href="styles/coolMenu.css" rel="stylesheet" type="text/css" media="screen"/>
<link href="styles/check_cs6.css" rel="stylesheet" type="text/css">
<link href="styles/play.css" rel="stylesheet" type="text/css">
<link href="styles/images.css" rel="stylesheet" type="text/css">
<script src="js/fb.js"> </script>
<script type="text/javascript">

  var _gaq = _gaq || [];
  _gaq.push(['_setAccount', 'UA-37535306-1']);
  _gaq.push(['_trackPageview']);

  (function() {
    var ga = document.createElement('script'); ga.type = 'text/javascript'; ga.async = true;
    ga.src = ('https:' == document.location.protocol ? 'https://ssl' : 'http://www') + '.google-analytics.com/ga.js';
    var s = document.getElementsByTagName('script')[0]; s.parentNode.insertBefore(ga, s);
  })();

</script>
<script src="//connect.facebook.net/en_US/all.js"></script>
<style>
.goup {
	position:relative;
	top:-80px;
	color:#fff;
    font-size:20px;
	font-family:"Trebuchet MS", Arial, Helvetica, sans-serif;
}

.goup2 {
	position:relative;
	top:-90px;
	color:#fff;
    font-size:20px;
	font-family:"Trebuchet MS", Arial, Helvetica, sans-serif;
}

</style>
</head>
<body>
    <div style="background-color:#E7EBF2;height:auto;">
	<div class="container_16" style="background-color:#004080; height:90px; opacity:0.8" >
    <a href="http://www.wordtrix.in/">
        <img style="background-color:transparent;float:left" src="images/logo-final.png">
    </a>
		<div align="right" style="margin-left: 800px">  
		<ul id="coolMenu" style="margin-top:40px;">
			<li id="user-info"><a href="#" onClick="loginUser();">login</a></li>
			<li>
				<a href="#">Settings</a>
				<ul class="noJS">
					<li><a href="#">profile</a></li>
					<li><a href="#">others</a></li>
					<li id="logout"><a href="#" onClick="logoutUser();">logout</a></li>
				</ul>
			</li>
		</ul>
		</div>
        <div style="float:right;">
        <img id="user_photo" height="50px" width="50px;" style="padding:30px;margin-right:90px;">
        <label id="user_name" style="position:relative;left:-115px;top:-40px;color:#FFF"> Hi ,Player </label>
        </div>
	</div>
    
<div id="details" style="background-color:#3c3c3c; opacity:0.80; height:150px; margin-top:3px; margin-left:100px; margin-right:100px">
     <!--  <p style="margin-top:0px; text-align:center; color:#dedede; font-size:40px; font-family:segoe Ui; font-weight:bold">Wordtrix </p>-->
       <p align="center" style="font-size:26px; font-family:segoe Ui;color:#dedede">Play with words and compete with other gamers on the internet. Get ready to try out your word making skills at wordtrix and have fun playing it! :)</p>
       <div style="margin-top:0px; margin-left:750px">
                       <a onClick="loginCheck();" class="hover-panel">
                    <h3 align="center">Play the game</h3>
                </a>
       </div>
    </div>
    
    <div style="margin-left:100px; margin-right:100px; margin-top:60px">
    <div style="background-color:#4617b4;opacity:0.90">
    <p align="center" style="margin-top:0px; color:#FFF; font-size:30px; font-family:segoe Ui; font-weight:bold">how to play ?</p>
    </div>
    <div id="footer" style="margin-left: 50px; margin-right: 50px; color: #F0F0F0;opacity:.75;">
      <img src="images/demo/demo.png" style="margin-left:-65px;" />
     </div>
     </div>
    
    
  <div style="margin-left:100px; margin-right:100px; margin-top:30px;">
	<div style="background-color:#4617b4;opacity:0.90">
    <p align="center" style="margin-top:0px; color:#FFF; font-size:30px; font-family:segoe Ui; font-weight:bold"> Top Players</p>
    </div>
	<div style="margin-left:200px; margin-right:200px">	
  </div>
</div>
</div>
<?php

	try {
    $conn = new PDO ( "sqlsrv:server = tcp:pvp6ee8yc7.database.windows.net,1433; Database = gamer_scores", "dummies", "dumm!es3");
    $conn->setAttribute( PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION );
    }
   catch ( PDOException $e ) {
   print( "Error connecting to SQL Server." );
   die(print_r($e));
}
    $sql_select = "SELECT * FROM leaderboard order by Score desc";
    $stmt = $conn->query($sql_select);
    $registrants = $stmt->fetchAll(); 
	//var_dump($registrants);
	//echo "<br/> I am fetching <br/> ";
    if(count($registrants) > 0)
	{
		//echo count($registrants);
        echo "<div id='container'>";
		$i=0;
		$prev=NULL;
        foreach($registrants as $registrant) 
		{
			//var_dump($registrant);
			if($i < 8)	
			{
			echo "<div class='panel'><div class='hover'>";
            /*echo "<tr><th>".$i."</th>";
			echo "<th>".$registrant['Name']."</th>";
            echo "<th><th>".$registrant['Score']."</th></th></tr>";*/
			$tmp = "https://graph.facebook.com/".$registrant['id']."/picture?type=large";
			echo "<img src='$tmp' height='200' width='200'>";
			echo "<label class='goup'>".$registrant['name']."</label><br/>";
			echo "<label class='goup2'> Score:".$registrant['score']."</label>";
			echo "</div></div>";
			}
			$i++;
        }
        echo "</div>";
    } 
	else
	{
        echo "<h3>Oops,Looks like its sleep time ,nobody is playing! </h3>";
    }
	echo "</div>";
?>
</body>
</html>