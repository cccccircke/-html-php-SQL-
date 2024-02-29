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

$dist=$_SESSION['shop_dist'];
$money=$_POST['total'];
$cate=$_POST['order_type'];

$SID=$_SESSION['shop_id'];
$UID=$_SESSION['account'];
$username=$_SESSION['name'];
$stmt = $conn->prepare( "select shopname, user_id from shop where shop_id=$SID" );
$stmt->execute( );
$result = $stmt->fetch();
$owner_id=$result['user_id'];
$shopname=$result['shopname'];

   
    $sql = "INSERT INTO orders (status,  distance, money, type, shop_id, user_id) VALUES (?, ?, ?, ?, ?, ?)";
    $stmt1= $conn->prepare($sql);
    $stmt1->execute(['Not Finish', $dist, $money, $cate, $SID, $UID ]);
	
    $oid = $conn->lastInsertId();

		$stmt = $conn->prepare("INSERT INTO transaction (money, time, action, trader, user_id) VALUES (:money, NOW(), :action, :trader, :user_id)");
        $stmt->execute( array(
            'money' => $money,
            'action' =>"Payment",
            'trader' => $shopname,
            'user_id' => $UID
            
        ) );
		$stmt = $conn->prepare("INSERT INTO transaction (money, time, action, trader, user_id) VALUES (:money, NOW(), :action, :trader,:user_id)");
        $stmt->execute( array(
            'money' => $money,
            'action' => "Receive",
            'trader' => $username,
            'user_id' => $owner_id
        ) );
		$stmt = $conn->prepare("UPDATE user SET wallet_balance=(wallet_balance-:money) WHERE user_id=:UID");
        $stmt->execute( array(
            'money' => $money,
            'UID' => $UID
        ) );
		$stmt = $conn->prepare("UPDATE user SET wallet_balance=(wallet_balance+:money) WHERE user_id=:UID");
        $stmt->execute( array(
            'money' => $money,
            'UID' => $owner_id
        ) );

		for ($k = 0; $k < count($_POST['detail_meal']); $k++)
        {
			$meal_id=$_POST['detail_meal'][$k];
			$number=$_POST['order'][$k];
			$price=$_POST['detail_price'][$k];
           
            $sql2 = "INSERT INTO detail (order_id, meal_id, price, number) VALUES (?,?,?,?)";
            $stmt= $conn->prepare($sql2);
            $stmt->execute([$oid, $meal_id, $price, $number]);
            $sql3 = "UPDATE meal SET quantity=(quantity-$number) WHERE meal_id=$meal_id";
            $stmt= $conn->prepare($sql3);
            $stmt->execute();
			
		}
		
echo' <script type="text/JavaScript"> alert("Order successful");</script> ';

?>
<form action="myorder.php" class="fh5co-form animate-box" data-animate-effect="fadeIn" name="myForm" method="post">
<input type="hidden" name="mystatus" value="all" >
<input type="submit" style="display: none;" >
</form>

<script type="text/javascript">
document.forms["myForm"].submit();
</script>
