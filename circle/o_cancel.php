<?php
session_start();
$dbservername='localhost';
$dbname='hw2';
$dbusername='root';
$dbpassword='';

$conn = new PDO("mysql:host=$dbservername;dbname=$dbname",$dbusername, $dbpassword);
$conn->setAttribute(PDO::ATTR_ERRMODE,PDO::ERRMODE_EXCEPTION);


?>
<?php

$user_id=$_SESSION['account'];
$order_id=$_POST['order_id'];
$shop_id=$_POST['shop_id'];
$username=$_SESSION['name'];
$money=$_POST['money'];
$stmt = $conn->prepare( "select status from orders where order_id=:order_id" );
$stmt->execute(array('order_id' => $order_id));
$row = $stmt->fetch();
$last=$row['status'];
if($row['status']!="Not Finish"){
	echo' <script type="text/JavaScript"> alert("Cannot cancel the order.");</script> ';
}

$stmt1 = $conn->prepare("select shopname, user_id from shop where shop_id=$shop_id");
$stmt1->execute( );
$result = $stmt1->fetch();
$shopownerid=$result['user_id'];
$shopname=$result['shopname'];
if($last=="Not Finish"){
    $stmt5 = $conn->prepare("INSERT INTO transaction (money, time, action, trader, user_id) VALUES (:money, NOW(), :action, :trader, :user_id)");
    $stmt5->execute( array(
        'money' => $money,
        'action' =>"Receive",
        'trader' => $shopname,
        'user_id' =>$user_id
    ) );
    
    $stmt6 = $conn->prepare("INSERT INTO transaction (money, time, action, trader, user_id) VALUES (:money, NOW(), :action, :trader, :user_id)");
    $stmt6->execute( array(
        'money' => $money,
        'action' =>"Payment",
        'trader' => $username,
        'user_id' => $shopownerid
    ) );
    
$stmt2 = $conn->prepare( "UPDATE user SET wallet_balance=(wallet_balance-$money) WHERE user_id=$shopownerid");
$stmt2->execute();
$stmt3 = $conn->prepare( "UPDATE user SET wallet_balance=(wallet_balance+$money) WHERE user_id=$user_id");
$stmt3->execute();
$stmt4 = $conn->prepare("UPDATE orders SET status=:status WHERE order_id=:order_id");
$stmt4->execute( array(
	'order_id' => $order_id,
	'status' => "Cancel"
) );


$stmt7 = $conn->prepare( "UPDATE meal inner join detail on meal.meal_id=detail.meal_id SET meal.quantity=meal.quantity+detail.number WHERE detail.order_id=$order_id" );
$stmt7->execute();
}?>
<form action="myorder.php" class="fh5co-form animate-box" data-animate-effect="fadeIn" name="myForm" method="post">
<input type="hidden" name="mystatus" value="all" >
<input type="submit" style="display: none;" >
</form>

<script type="text/javascript">
document.forms["myForm"].submit();
</script>
