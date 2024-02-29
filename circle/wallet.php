<?php
session_start();
$dbservername='localhost';
$dbname='hw2';
$dbusername='root';
$dbpassword='';

$cleaned=""


?>
<?php
try {
$money = $_POST['addmoney'];
$user_id=$_SESSION['account'];
$cleaned = preg_replace("/[0-9]/", "", $money);
if ($cleaned!=""){
    throw new Exception('Addmoney  is invalid');
}
$conn = new PDO("mysql:host=$dbservername;dbname=$dbname",$dbusername, $dbpassword);
$conn->setAttribute(PDO::ATTR_ERRMODE,PDO::ERRMODE_EXCEPTION);
$stmt = $conn->prepare( "UPDATE user SET wallet_balance=(wallet_balance+:money) WHERE user_id=:user_id");
$stmt->execute(array(
	'money' => $money,
	'user_id' => $user_id
) );
$stmt = $conn->prepare("INSERT INTO transaction (money, time, action, trader, user_id) VALUES (:money, NOW(), :action, :trader, :user_id)");
        $stmt->execute( array(
            'money' => $money,
            'action' => "Recharge",
            'trader' => $_SESSION['name'],
            'user_id' =>$_SESSION['account']
) );
$_SESSION['wallet'] += $money;
echo' <script type="text/JavaScript"> alert("Recharge successful");</script> ';
header("Location: nav.php");
exit();
}catch(Exception $e)
{
    $msg=$e->getMessage();
 
    echo <<<EOT
    <!DOCTYPE html>
    <html>
        <body>
            <script>
            alert("$msg");
            window.location.replace("nav.php");
            </script>
        </body>
    </html>
   
EOT;

}

?>
<form action="myordersrch.php" class="fh5co-form animate-box" data-animate-effect="fadeIn" name="myForm" method="post">
<input type="hidden" name="smystatus" value="all" >
<input type="submit" style="display: none;" >
</form>

<script type="text/javascript">
document.forms["myForm"].submit();
</script>
