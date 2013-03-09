<?php
    ignore_user_abort(true);
	/*used to insert data into leader board.*/
	/*$host = "us-cdbr-azure-east-b.cloudapp.net";
    $user = "bcd2949c8baf7b";
    $pwd = "ee7246b9";
    $db = "wordaddABbVVe2ev";
    try 
	{
        $conn = new PDO( "mysql:host=$host;dbname=$db", $user, $pwd);
        $conn->setAttribute( PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION );
    }
    catch(Exception $e)
	{
        die(var_dump($e));
    }
//$sql1 = "CREATE TABLE scoreboard( name VARCHAR(30), score int)";
//$conn->query($sql1);

   try 
	{
        $name = $_GET["name"];
        $score = $_GET['score'];
        $sql_insert = "INSERT INTO scoreboard (name, score) 
                   VALUES (?,?)";
        $stmt = $conn->prepare($sql_insert);
        $stmt->bindValue(1, $name);
        $stmt->bindValue(2, $score);
        $stmt->execute();
    }
	
    catch(Exception $e)
    {
        die(var_dump($e));
    }*/
	try {
    $conn = new PDO ( "sqlsrv:server = tcp:pvp6ee8yc7.database.windows.net,1433; Database = gamer_scores", "dummies", "dumm!es3");
    $conn->setAttribute( PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION );
    }
   catch ( PDOException $e ) 
   {
   print( "Error connecting to SQL Server." );
   die(print_r($e));
    }
   try 
	{
        $name = $_GET["name"];
		$score = $_GET['score'];
		$id =$_GET['id'];
		$sql_insert = "INSERT INTO scores (id, Name, Score) 
				   VALUES (?,?,?)";
		$stmt = $conn->prepare($sql_insert);
		$stmt->bindValue(1, $id);
		$stmt->bindValue(2, $name);
		$stmt->bindValue(3, $score);
		$stmt->execute();
    }
	
    catch(Exception $e)
    {
        die(var_dump($e));
    }
	echo "success" ;
	//now submit to leaderboard if score >last value score of db
	$sql_select = "SELECT * FROM leaderboard order by Score desc";
    $stmt = $conn->query($sql_select);
    $registrants = $stmt->fetchAll(); 
	//var_dump($registrants);
	//echo "<br/> I am fetching <br/> ";
	$cnt =count($registrants) ;
	$pushintodb = true;
    if($cnt > 8) {
		if($registrants[cnt-1]['score'] > $score)
		 $pushintodb = false;
	}
	if($pushintodb) {
		//push to leaderbaord now
					try 
					{
						$name = $_GET["name"];
						$score = $_GET['score'];
						$id =$_GET['id'];
						$sql_insert = "INSERT INTO leaderboard(name,score,id) 
								   VALUES (?,?,?)";
						$stmt = $conn->prepare($sql_insert);
						$stmt->bindValue(1, $name);
						$stmt->bindValue(2, $score);
						$stmt->bindValue(3, $id);
						$stmt->execute();
					}
					catch(Exception $e)
					{
						die(var_dump($e));
					}
	}
	echo "<br/>inserted into leaderbaord";
?>