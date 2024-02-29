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
    header("Location: index.html");
    exit();
    }


    $user_id=$_SESSION['account'];
    $stmt=$conn->prepare("SELECT account, name,phonenumber, longitude, latitude, wallet_balance FROM user WHERE user_id=:user_id");
	$stmt->execute(array("user_id"=>$user_id));
    $details = $stmt->fetchAll(PDO::FETCH_ASSOC);
    $longitude=$details[0]['longitude'];
    $latitude=$details[0]['latitude'];
    $username=$details[0]['name'];
    $phonenumber=$details[0]['phonenumber'];
    $account=$details[0]['account'];
    $_SESSION['longitude']=$longitude;
	$_SESSION['latitude']=$latitude;
    $_SESSION['name']=$username;
    $_SESSION['wallet'] = $details[0]['wallet_balance'];
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
                window.location.replace("index.php");
        </script></body>
        </html> 
EOT;
}
echo '<meta http-equiv=REFRESH CONTENT=100;url=nav.php>';
?>
