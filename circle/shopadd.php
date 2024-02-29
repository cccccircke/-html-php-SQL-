<?php
session_start();


$dbservername='localhost';
$dbname='hw2';
$dbusername='root';
$dbpassword='';
$cleaned="";
$conn = new PDO("mysql:host=$dbservername;dbname=$dbname",$dbusername, $dbpassword);
$conn->setAttribute(PDO::ATTR_ERRMODE,PDO::ERRMODE_EXCEPTION);

$_SESSION['shop_authenticated']=true;
$_SESSION['shop_id']=1;


try{
    if(!isset($_SESSION['shop_authenticated'])||$_SESSION['shop_authenticated']!=true){
        header('Location: logout.php');
        exit();
    }

    
    if(!isset($_POST['umealname'])||!isset($_POST['uprice'])||!isset($_POST['uquantity'])){
        header('Location: nav.php');
        exit();
    }
    #ADD
    if(empty($_POST['umealname'])){
        throw new Exception('Please input meal name.');
    }
    elseif(empty($_POST['uprice'])){
        throw new Exception('Please input price.');
    }
    elseif(empty($_POST['uquantity'])){
        throw new Exception('Please input quantity.');
    }
    
    if($_FILES['myfile']['error']===UPLOAD_ERR_OK){
        $file=fopen($_FILES['myfile']['tmp_name'], 'rb');
        $fileContents=fread($file, filesize($_FILES['myfile']['tmp_name']));
        fclose($file);
        $picture=base64_encode($fileContents);
        $picture_type=$_FILES['myfile']['type'];
    }
    else{
        throw new Exception('Please upload picture.');
    }

    if(($_POST['uprice']<0)||($_POST['uquantity']<0)){
        throw new Exception('Please input non-negative integer.');
    }
    
    $mealname=$_POST['umealname'];
    $price=$_POST['uprice'];
    $quantity=$_POST['uquantity'];
    
    
    #php connect to mysql 

    
    $shop_id=$_SESSION['shop_id'];

    $sql="INSERT INTO meal(meal_id, mealname, picture, picture_type, price, quantity, shop_id) values (?,?,?,?,?,?,?)";
    $stmt=$conn->prepare($sql);
    $stmt->execute(['NULL', $mealname, $picture, $picture_type, $price, $quantity, $shop_id]);

    echo <<<EOT
    <!DOCTYPE html>
    <html>
        <body>
            <script>
            alert('Add successfully.');
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