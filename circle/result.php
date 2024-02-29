
    $sql = "SELECT DISTINCT shop.shop_id as shop_id,DISTINCT shop.shopname as shopname, shop.category as category, ST_Distance_Sphere(shop.location,$location)as distance FROM meal LEFT JOIN shop ON shop.shop_id = meal.shop_id WHERE 1=1";

if (!empty($_GET['price_1'])){
    $cleaned!="";
    $price_1=$_GET['price_1'];
    $cleaned = preg_replace("/[0-9]/", "",  $price_1);
    if ($cleaned!=""){
        throw new Exception('This price is invalid');
    }
    $intprice_1=intval($price_1);
    $sql .=' AND(meal.price >'.$intprice_1.')';    
}
if (!empty($_GET['price_2'])){
    $cleaned!="";
    $price_2=$_GET['price_2'];
    $cleaned = preg_replace("/[0-9]/", "",  $price_2);
    if ($cleaned!=""){
        throw new Exception('This price is invalid');
    }
    $intprice_2=intval($price_2);
    $sql .=' AND(meal.price <'.$intprice_2.')'; 
}
if (!empty($_GET['distance'])){
    $distance=$_GET['distance']; 
    $sql .= "AND (CASE  WHEN :distance='0~3000' THEN ST_Distance_Sphere(shop.location,$location) between 0 and 3000 
      WHEN :distance='3000~12000' THEN ST_Distance_Sphere(shop.location,$location) between 3000 and 12000
      WHEN :distance='12000~' THEN ST_Distance_Sphere(shop.location,$location)>=12000 END)";
    
}
if (!empty($_GET['category'])){
    $category=$_GET['category'];
    $sql .= ' AND(shop.category  LIKE "%'.$category.'%")';
}
if (!empty($_GET['Meal'])){
    $Meal=$_GET['Meal'];
    $sql .= ' AND(meal.mealname LIKE "%'.$Meal.'%")';
}
if (!empty($_GET['Shopname'])){
    $Shopname=$_GET['Shopname'];
    $sql .= ' AND(shop.shopname  LIKE "%'.$Shopname.'%")';
}
$stmt=$conn->prepare($sql."GROUP BY shop.shopname");
$stmt->execute();
$page=$stmt->fetch();
$totalpage=ceil($page[0]/$postperpage);