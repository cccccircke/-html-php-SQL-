<?php
session_start();

$dbservername='localhost';
$dbname='hw2';
$dbusername='root';
$dbpassword='';
$cleaned="";
$conn = new PDO("mysql:host=$dbservername;dbname=$dbname",$dbusername, $dbpassword);
$conn->setAttribute(PDO::ATTR_ERRMODE,PDO::ERRMODE_EXCEPTION);

$user_id=1;

try{
    if(!isset($_POST['ushopname'])||(!isset($_POST['ucategory']))){
        header('Location: nav.php');
        exit();
    }

    if(empty($_POST['ushopname'])){
        throw new Exception('Please input shopname.');
    }
    elseif(empty($_POST['ucategory'])){
        throw new Exception('Please input category.');
    }
    elseif(empty($_POST['ulatitude'])){
        throw new Exception('Please input latitude.');
    }
    elseif(empty($_POST['ulongitude'])){
        throw new Exception('Please input longitude.');
    }

    if($_POST['ulatitude']>90||$_POST['ulatitude']<-90||$_POST['ulongitude']>180||$_POST['ulongitude']<-180){
        throw new Exception('Please input correct location.');
    }
    
    $shopname=$_POST['ushopname'];

    #php connect to mysql 
    
    $stmt=$conn->prepare("SELECT shopname from shop where shopname=:shopname");
    $stmt->execute(array('shopname'=>$shopname));

    if($stmt->rowCount()==1){
        throw new Exception('Shop name had already been used.');
    }

    $category=$_POST['ucategory'];
    $latitude=$_POST['ulatitude'];
    $longitude=$_POST['ulongitude'];

    $sql="INSERT INTO shop(shop_id, shopname, category, longitude, latitude) values (?,?,?,?,?)";
    $stmt=$conn->prepare($sql);
    $stmt->execute(['NULL',$shopname, $category, $longitude,$latitude]);
    $_SESSION['shop_authenticated']=false;

    $stmt=$conn->prepare("SELECT * from shop order by shop_id desc");
    $stmt->execute();
    $row=$stmt->fetch();
    $_SESSION['shop_id']=$row['shop_id'];
   
    $boss=$_SESSION['shop_id'];
    $stmt=$conn->prepare("UPDATE user SET boss=:boss  WHERE user_id=:user_id");
    $stmt->execute(array('boss'=>$boss,'user_id'=>$user_id));

    echo <<<EOT
    <!DOCTYPE html>
    <html>
        <body>
            <script>
            alert('Register successfully.');
            window.location.replace("nav.php");
            </script>
        </body>
    </html>
EOT;
}
catch(Exception $e){
    $msg=$e->getMessage();
    session_unset();
    session_destroy();
    echo <<<EOT
        <!DOCTYPE html>
        <html>
            <body>
                <script>
                alert('$msg');
                    window.location.replace("nav.php");
                </script>
            </body>
        </html>
EOT;
}
?>