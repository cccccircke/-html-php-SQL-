<?php
session_start();
$dbservername='localhost';
$dbname='hw2';
$dbusername='root';
$dbpassword='';
$cleaned="";
$conn = new PDO("mysql:host=$dbservername;dbname=$dbname",$dbusername, $dbpassword);
$conn->setAttribute(PDO::ATTR_ERRMODE,PDO::ERRMODE_EXCEPTION);
$longitude=$_SESSION['longitude'];
$latitude=$_SESSION['latitude'];
if (!isset($_SESSION['authenticated']) ||
$_SESSION['authenticated']!=true)
{
header("Location: index.html");
exit();
}
if(isset($_GET['search']))
{
	$sql = "SELECT shop.shop_id , shop.shopname , shop.category , ST_Distance_Sphere(POINT(shop.longitude,shop.latitude),ST_GeomFromText('POINT($longitude $latitude)')) as distance FROM shop inner join meal on shop.shop_id = meal.shop_id WHERE 1=1";

	if (!empty($_GET['price_1'])){
		$cleaned!="";
		$price_1=$_GET['price_1'];
		$cleaned = preg_replace("/[0-9]/", "",  $price_1);
		if ($cleaned!=""){
			throw new Exception('This price is invalid');
		}
		$intprice_1=intval($price_1);
		$sql .=" AND(meal.price >".$intprice_1.")";    
	}
	if (!empty($_GET['price_2'])){
		$cleaned!="";
		$price_2=$_GET['price_2'];
		$cleaned = preg_replace("/[0-9]/", "",  $price_2);
		if ($cleaned!=""){
			throw new Exception('This price is invalid');
		}
		$intprice_2=intval($price_2);
		$sql .=" AND(meal.price <".$intprice_2.")"; 
	}
	if (!empty($_GET['distance'])){
		$sql .=" AND(ST_Distance_Sphere(POINT(shop.longitude,shop.latitude),ST_GeomFromText('POINT($longitude $latitude)'))>0)";	
		if($_GET['distance']=="near"){
			$sql .=" AND(ST_Distance_Sphere(POINT(shop.longitude,shop.latitude),ST_GeomFromText('POINT($longitude $latitude)'))<=500000)";	
		}
		if($_GET['distance']=="medium"){	
			$sql .=" AND(ST_Distance_Sphere(POINT(shop.longitude,shop.latitude),ST_GeomFromText('POINT($longitude $latitude)'))>500000)";
			$sql .=" AND(ST_Distance_Sphere(POINT(shop.longitude,shop.latitude),ST_GeomFromText('POINT($longitude $latitude)'))<=2000000)";	
			}
		if($_GET['distance']=="far"){
			$sql .=" AND(ST_Distance_Sphere(POINT(shop.longitude,shop.latitude),ST_GeomFromText('POINT($longitude $latitude)'))>2000000)";	
			}
		
	}
	if (!empty($_GET['category'])){
		$category=$_GET['category'];
		$sql .= " AND(shop.category  LIKE LOWER('%$category%'))";
	}
	if (!empty($_GET['Meal'])){
		$Meal=$_GET['Meal'];
		$sql .= " AND(meal.mealname LIKE LOWER('%$Meal%'))";
	}
	if (!empty($_GET['Shopname'])){
		$Shopname=$_GET['Shopname'];
		$sql .= " AND(shop.shopname  LIKE LOWER('%$Shopname%'))";
	}
	$stmt = $conn->prepare($sql."GROUP BY shop.shopname");
	$stmt->execute();
	
	
	$i=0;
	$_SESSION['row']= $stmt->fetchAll(PDO::FETCH_ASSOC);
	
	//$_SESSION['row']=array_unique($_SESSION['row']);
	header("Location: nav.php");
	exit();
}
else
{
    $Err = "Enter information";
		echo "$Err";
}

?>