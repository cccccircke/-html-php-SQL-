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

    if(!empty($_POST['mystatus']))
    {
		if($_POST['mystatus']=="all"){
			$stmt = $conn->prepare("select shop.shopname, orders.order_id, orders.status, orders.start, orders.end, orders.money, orders.shop_id, orders.type, orders.distance from shop inner join orders on shop.shop_id=orders.shop_id where orders.user_id=$user_id");
			$stmt->execute();
			$_SESSION['myorder'] = $stmt->fetchAll(PDO::FETCH_ASSOC);
			header("Location: nav.php#myorder");
			exit();
		}
		else{
		$search = $_POST['mystatus'];
        $stmt = $conn->prepare("select shop.shopname, orders.order_id, orders.status, orders.start, orders.end, orders.money, orders.shop_id, orders.type, orders.distance  from shop inner join orders on shop.shop_id=orders.shop_id where orders.user_id=$user_id and orders.status=:status");
        $stmt->execute(array('status'=>$search));
        $_SESSION['myorder'] = $stmt->fetchAll(PDO::FETCH_ASSOC);
		header("Location: nav.php#myorder");
		exit();
		}
    }
	else{
		$searchErr = "Please enter information";
		echo $searchErr;
		echo "<meta http-equiv='Refresh' content='1;URL=nav.php#myorder'>";
	}

?>
