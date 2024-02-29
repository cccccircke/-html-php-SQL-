<?php
session_start();

$_SESSION['authenticated']=false;
$dbservername='localhost';
$dbname='hw2';
$dbusername='root';
$dbpassword='';
$cleaned="";
$conn = new PDO("mysql:host=$dbservername;dbname=$dbname",$dbusername, $dbpassword);
$conn->setAttribute(PDO::ATTR_ERRMODE,PDO::ERRMODE_EXCEPTION);


try{
    if(!isset($_POST['uaccount'])||(!isset($_POST['upassword']))){
        header('Location: index.html');
        exit();
    }
    if(empty($_POST['uaccount'])||empty($_POST['upassword'])){
        throw new Exception('Please input name and password.');
    }

    $account=$_POST['uaccount'];
    $password=$_POST['upassword'];
    
    #php connect to mysql 
   

    $stmt=$conn->prepare('SELECT * from user where account = :account');
    $stmt->execute(array('account' => $account));
    

    if($stmt->rowCount()==1){
        $row=$stmt->fetch();
        if ($row['password']==hash('sha256',$row['salt'].$_POST['upassword'])){
            $_SESSION['authenticated']=true;
            $_SESSION['account']=$row[0];
            header("Location: nav.php");
            exit();
        }
        else{
            throw new Exception('Login failed!!');
        }
    }
    else{
        throw new Exception('Login failed!!');
    }
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
                    window.location.replace("index.html");
                </script>
            </body>
        </html>
EOT;
}

?>