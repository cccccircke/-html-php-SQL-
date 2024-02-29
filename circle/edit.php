<?php
session_start();
$dbservername='localhost';
$dbname='hw2';
$dbusername='root';
$dbpassword='';
$cleaned="";
$conn = new PDO("mysql:host=$dbservername;dbname=$dbname",$dbusername, $dbpassword);
$conn->setAttribute(PDO::ATTR_ERRMODE,PDO::ERRMODE_EXCEPTION);
try{
    if (!isset($_SESSION['authenticated']) ||
    $_SESSION['authenticated']!=true)
    {
    header("Location: sign-up.html");
    exit();
    }
    if(empty($_GET['latitude'])){
        throw new Exception('Latitude is required');
    }else{
        
        if($_GET['latitude']<=90 and $_GET['latitude']>=-90){
            $latitude=$_GET['latitude']; 
        }else{
            echo"Latitude is invalid";
            throw new Exception('Latitude is invalid');
        }
    }
    if(empty($_GET['longitude'])){
        throw new Exception('Longitude is required');
    }else{
        
        if($_GET['longitude']<=180 and $_GET['longitude']>=-180){
            $longitude=$_GET['longitude'];
            }else{
                throw new Exception('Longitude is invalid');
            }
    }
    if($latitude<=90 and $latitude>=-90){
        if($longitude<=180 and $longitude>=-180){
    $user_id=$_SESSION['account'];
    $stmt=$conn->prepare("UPDATE user SET latitude=:latitude, longitude=:longitude  WHERE user_id=:user_id");
	//$stmt->execute(array("latitude"=>$latitude,"longitude"=>$longitude,"user_id"=>$user_id));
    //$stmt=$conn->prepare("UPDATE user SET latitude=:latitude, longitude=:longitude WHERE account=:account");
	$stmt->execute(array(
		'latitude' => $latitude,
		'longitude' => $longitude,
		'user_id'=>$user_id
		));
    header("Location: nav.php");
	exit();
    }else{
        $searchErr = "input is invalid";
	    echo $searchErr;
	    header("Location: nav.php");
	    exit();
    }

    }

}
catch (PDOException $e)
{
    session_unset(); 
    session_destroy(); 
    echo <<<EOT
    <!DOCTYPE html>
        <html>
            <body><script>
                alert("Internal Error. $msg");
                window.location.replace("nav.php");
        </script></body>
        </html> 
EOT;
    header("Location: nav.php");
    exit();
}

?>