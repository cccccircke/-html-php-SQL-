<?php
session_start();
$dbservername='localhost';
$dbname='hw2';
$dbusername='root';
$dbpassword='';
$cleaned="";
$conn = new PDO("mysql:host=$dbservername;dbname=$dbname",$dbusername, $dbpassword);
$conn->setAttribute(PDO::ATTR_ERRMODE,PDO::ERRMODE_EXCEPTION);

if (!isset($_SESSION['authenticated']) ||
$_SESSION['authenticated']!=true)
{
header("Location: index.html");
exit();
}
if(isset($_GET['search']))
{
    if(!empty($_GET['Shopname']))
    {
		$find = $_GET['Shopname'];
		$longitude=$_SESSION['longitude'];
		$latitude=$_SESSION['latitude'];
        $stmt = $conn->prepare("select shop.shop_id, shopname, shop.category, ST_Distance_Sphere(POINT(shop.longitude,shop.latitude),ST_GeomFromText('POINT($longitude $latitude)')) as distance from shop where LOWER(shop.shopname) like LOWER('%$find%')");
        $stmt->execute();
        $_SESSION['row'] = $stmt->fetchAll(PDO::FETCH_ASSOC);
		$_SESSION['row']=array_unique($_SESSION['row']);
		header("Location: nav.php");
		exit();    
    }
	if($_GET['distance']!="all"){
		if($_GET['distance']=="near"){
		$find = $_GET['distance'];
		$longitude=$_SESSION['longitude'];
		$latitude=$_SESSION['latitude'];
        $stmt = $conn->prepare("select shop.shop_id, shopname, shop.category, ST_Distance_Sphere(POINT(shop.longitude,shop.latitude),ST_GeomFromText('POINT($longitude $latitude)')) as distance from shop where ST_Distance_Sphere(POINT(shop.longitude,shop.latitude),ST_GeomFromText('POINT($longitude $latitude)'))<=500000");
        $stmt->execute();
        $_SESSION['row'] = $stmt->fetchAll(PDO::FETCH_ASSOC);
		$_SESSION['row']=array_unique($_SESSION['row']);
		header("Location: nav.php");
		exit();
		}
		if($_GET['distance']=="medium"){	
		$find = $_GET['distance'];
		$longitude=$_SESSION['longitude'];
		$latitude=$_SESSION['latitude'];
        $stmt = $conn->prepare("select shop.shop_id, shopname, shop.category, ST_Distance_Sphere(POINT(shop.longitude,shop.latitude),ST_GeomFromText('POINT($longitude $latitude)')) as distance from shop where ST_Distance_Sphere(POINT(shop.longitude,shop.latitude),ST_GeomFromText('POINT($longitude $latitude)'))>=500000 and ST_Distance_Sphere(POINT(shop.longitude,shop.latitude),ST_GeomFromText('POINT($longitude $latitude)'))<=1000000");
        $stmt->execute();
        $_SESSION['row'] = $stmt->fetchAll(PDO::FETCH_ASSOC);
		$_SESSION['row']=array_unique($_SESSION['row']);
		header("Location: nav.php");
		exit();
		}
		else if($_GET['distance']=="far"){
		$find = $_GET['distance'];
		$longitude=$_SESSION['longitude'];
		$latitude=$_SESSION['latitude'];
        $stmt = $conn->prepare("select shop.shop_id, shopname, shop.category, ST_Distance_Sphere(POINT(shop.longitude,shop.latitude),ST_GeomFromText('POINT($longitude $latitude)')) as distance from shop where ST_Distance_Sphere(POINT(shop.longitude,shop.latitude),ST_GeomFromText('POINT($longitude $latitude)'))>=1000000");
        $stmt->execute();
        $_SESSION['row'] = $stmt->fetchAll(PDO::FETCH_ASSOC);
		$_SESSION['row']=array_unique($_SESSION['row']);
		header("Location: nav.php");
		exit();
		}
	}
	if(!empty($_GET['price_1']) or !empty($_GET['price_2'])){
        if(empty($_GET['price_1'])){
			$find = $_GET['price_2'];
			$longitude=$_SESSION['longitude'];
			$latitude=$_SESSION['latitude'];
			$stmt = $conn->prepare("select shop.shop_id, shopname, shop.category, ST_Distance_Sphere(POINT(shop.longitude,shop.latitude),ST_GeomFromText('POINT($longitude $latitude)')) as distance from shop inner join meal on shop.shop_id=meal.shop_id where meal.price<=$find");
			$stmt->execute();
			$_SESSION['row'] = $stmt->fetchAll(PDO::FETCH_ASSOC);
			$_SESSION['row']=array_unique($_SESSION['row']);
			header("Location: nav.php");
			exit();
		}
		else if(empty($_GET['price_2'])){
			$find = $_GET['price_1'];
			$longitude=$_SESSION['longitude'];
			$latitude=$_SESSION['latitude'];
			$stmt = $conn->prepare("select shop.shop_id, shopname, shop.category, ST_Distance_Sphere(POINT(shop.longitude,shop.latitude),ST_GeomFromText('POINT($longitude $latitude)')) as distance from shop inner join meal on shop.shop_id=meal.shop_id where meal.price>=$search");
			$stmt->execute();
			$_SESSION['row'] = $stmt->fetchAll(PDO::FETCH_ASSOC);
			$_SESSION['row']=array_unique($_SESSION['row']);
			header("Location: nav.php");
			exit();
        }
		else{
			$find_1 = $_GET['price_1'];
			$find_2 = $_GET['price_2'];
			$longitude=$_SESSION['longitude'];
			$latitude=$_SESSION['latitude'];
			$stmt = $conn->prepare("select shop.shop_id, shopname, shop.category, ST_Distance_Sphere(POINT(shop.longitude,shop.latitude),ST_GeomFromText('POINT($longitude $latitude)')) as distance from shop inner join meal on shop.shop_id=meal.shop_id where meal.price>=$find_1 and meal.price<=$find_2");
			$stmt->execute();
			$_SESSION['row'] = $stmt->fetchAll(PDO::FETCH_ASSOC);
			$_SESSION['row']=array_unique($_SESSION['row']);
			header("Location: nav.php");
			exit();
		}
	}
	if(!empty($_GET['Meal'])){
		$find = $_GET['Meal'];
		$longitude=$_SESSION['longitude'];
		$latitude=$_SESSION['latitude'];
        $stmt = $conn->prepare("select shop.shop_id, shopname, shop.category, ST_Distance_Sphere(POINT(shop.longitude,shop.latitude),ST_GeomFromText('POINT($longitude $latitude)')) as distance from shop inner join meal on shop.shop_id=meal.shop_id where LOWER(meal.mealname) like LOWER('%$find%')");
        $stmt->execute();
        $_SESSION['row'] = $stmt->fetchAll(PDO::FETCH_ASSOC);
		$_SESSION['row']=array_unique($_SESSION['row']);
		header("Location: nav.php");
		exit();
	}
	if(!empty($_GET['category'])){
		$find = $_GET['category'];
		$longitude=$_SESSION['longitude'];
		$latitude=$_SESSION['latitude'];
        $stmt = $conn->prepare("select shop.shop_id, shopname, shop.category, ST_Distance_Sphere(POINT(shop.longitude,shop.latitude),ST_GeomFromText('POINT($longitude $latitude)')) as distance from shop inner join meal on shop.shop_id=meal.shop_id where LOWER(shop.category) like LOWER('%$find%')");
        $stmt->execute();
        $_SESSION['row'] = $stmt->fetchAll(PDO::FETCH_ASSOC);
		$_SESSION['row']=array_unique($_SESSION['row']);
		header("Location: nav.php");
		exit();
	}
	else{
		$Err = "Enter information";
		echo "$Err";
	}
}else
{
    $Err = "Enter information";
		echo "$Err";
}

?>