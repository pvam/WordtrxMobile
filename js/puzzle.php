<?php
try {
    $conn = new PDO ( "sqlsrv:server = tcp:pvp6ee8yc7.database.windows.net,1433; Database = gamer_scores", "dummies", "dumm!es3");
    $conn->setAttribute( PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION );
    }
   catch ( PDOException $e ) 
   {
   print( "Error connecting to SQL Server." );
   die(print_r($e));
    }


$h =date('H');
$m =date('i');
 //max time 23:59 
 $tmp = $h*20 + floor($m/3) ;
 //possible indexes , 1 2 3... 
 //max index - 23*20 + (59) /3 = 460 +19 =479 ;
// $tmp = ($tmp-1)*10 +1 ;
 //indexes  , 1 11 21 31..... ..max = 4781

 try
 {
$sqlq = "SELECT * FROM games";
/*$stmt = $conn->prepare($sqlq);
$stmt->bindValue(1, $tmp);*/
//$result =$stmt->execute();
$stmt = $conn->query($sqlq);
$registrants = $stmt->fetchAll(); 
if(count($registrants) > 0) 
{
/*echo "fuck me";
echo $result['id'];
echo $result['seq'];
echo "fucked";*/
 foreach($registrants as $registrant) 
		{
      if($tmp == $registrant['id'])
      echo $registrant['seq'];
		}
}

//sleep time would be 23 hr 59 mins ... => 23*60*60+59*60 = 4971540 seconds
}
 catch(Exception $e) 
 {
	 die($e);
 }
?>