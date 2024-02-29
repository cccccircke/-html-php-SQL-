<?php
session_start();
$_SESSION['Authenticated']=false;
$dbservername='localhost';
$dbname='hw2';
$dbusername='root';
$dbpassword='';
$cleaned="";
$conn = new PDO("mysql:host=$dbservername;dbname=$dbname",$dbusername, $dbpassword);
$conn->setAttribute(PDO::ATTR_ERRMODE,PDO::ERRMODE_EXCEPTION);
try {
    if (!isset($_POST['name']) || !isset($_POST['Account'])|| !isset($_POST['password'])||!isset($_POST['re-password'])||!isset($_POST['phonenumber'])|| !isset($_POST['latitude'])|| !isset($_POST['longitude']))
    {
    header("Location: sign-up.html");
    exit();
    }
    if (empty($_POST['Account'])){
        throw new Exception('Please input account');
    }
  	else{
  		$stmt=$conn->prepare("SELECT account FROM user WHERE account=:account");
		$stmt->execute(array("account"=>$_POST['Account']));
		if($stmt->rowCount()==1){
            throw new Exception('This account is already in use!');
		}

  		else{
            $cleaned!="";
            $u_account=$_POST['Account'];
            $cleaned = preg_replace("/[A-Za-z0-9]/", "", $u_account);
            if ($cleaned!=""){
                throw new Exception('This account is invalid');
            }
  		}
  	}
      if(empty($_POST['name'])){
        throw new Exception('Name is required');
    }
    else{
        $cleaned!="";
        $uname=$_POST['name'];
        $cleaned = preg_replace("/[A-Za-z]/", "", $uname);
        if ($cleaned!=""){
            throw new Exception('This name is invalid');
        }
    }

    if(empty($_POST['phonenumber'])){
        throw new Exception('Phone is required');
    }
    else{
        $telephone=strip_tags($_POST['phonenumber']);
      
            if(strlen($telephone)!=10){
                throw new Exception('Phone is invalid');
            }
        
        
    }
    if(empty($_POST['password'])){
        throw new Exception('Please input user password.');
    }
    else{
        $cleaned!="";
        $pwd=$_POST['password'];
        $cleaned = preg_replace("/[A-Za-z0-9]/", "", $pwd);
        if ($cleaned!=""){
            throw new Exception('This password is invalid');
        }
    }
    if(empty($_POST['re-password'])){
        throw new Exception('Please input user re_password.');
    }
    else{
        if(!empty($_POST["password"])&&($_POST["password"]!=$_POST['re-password'])){
             throw new Exception('Please confirm your password correctly');
        }
    }
    if(empty($_POST['latitude'])){
        throw new Exception('Latitude is required');
    }else{
        if($_POST['latitude']<=90 and $_POST['latitude']>=-90){
            $latitude=$_POST['latitude']; 
        }else{
            throw new Exception('Latitude is invalid');
        }
                
            
    }
    if(empty($_POST['longitude'])){
        throw new Exception('Longitude is required');
    }else{     
        if($_POST['longitude']<=180 and $_POST['longitude']>=-180){
        $longitude=$_POST['longitude'];
        }else{
            throw new Exception('Longitude is invalid');
        }
    }
   
   
    # set the PDO error mode to exception
    $conn->setAttribute(PDO::ATTR_ERRMODE,PDO::ERRMODE_EXCEPTION);
    $stmt=$conn->prepare("select account from user where account=:account");
    $stmt->execute(array('account' => $u_account));
    if ($stmt->rowCount()==0)
    {
    $salt=strval(rand(1000,9999));
    $hashvalue=hash('sha256', $salt.$pwd);
    $sql = "INSERT INTO user (user_id, account, password, name, phonenumber, salt, longitude, latitude, wallet_balance) VALUES (?,?,?,?,?,?,?,?,?)";
    $stmt= $conn->prepare($sql);
    $stmt->execute(['NULL',$u_account,$hashvalue,$uname,$telephone,$salt,$longitude,$latitude,0 ]);
    //$stmt->execute(['NULL',$u_account,$hashvalue,$uname,$telephone, 'POINT(' . $longitude . ' ' . $latitude . ')',$salt]);
    //$sql=$conn->"insert into user (user_id,account,password,name,phonenumber,location,salt) values (NULL,$u_account,$hashvalue,$uname,$telephone,ST_GeomFromText('POINT(12 12)'),$salt)";
  
    
    //$sql=$conn->"INSERT INTO user (user_id, account, password, name, phonenumber, location,salt) VALUES(NULL,'".$u_account."','".$hashvalue."','".$uname."','".$telephone."','ST_GeomFromText(POINT('".$longitude.'"  $latitude )'."','".$salt."')";
    //$stmt=$conn->prepare("insert into user ( user_id, account, password, name, phonenumber, location,salt) values (NULL,:account, :password, :name, :phonenumber, ST_GeomFromText(:route), :salt");
    //$stmt->execute(array('account' => $u_account,'password' => $hashvalue,'name' =>$uname, 'phonenumber' =>$telephone, 'route'  => 'POINT(' . $longitude . ' ' . $latitude . ')',  'salt' => $salt));
    $_SESSION['Authenticated']=true;
    $_SESSION['account']=$u_account;
    //mysql_query($sql);//藉SQL語句插入數據

    //mysql_close();
    //$sql="INSERT INTO user (user_id, account, password, name, phonenumber, location,salt) VALUES(NULL,'d','d','d','','".'"POINT(' . $longitude . ' ' . $latitude . ')"'."','".$salt."')";
    //mysqli_query($conn, $sql);
 
    echo <<<EOT
        <!DOCTYPE html>
        <html>
            <body>
                <script>
                alert("Create an account successfully.");
                window.location.replace("index.html");
            </script> </body> </html>
    EOT;
        exit();
    }
    else
    throw new Exception("Login failed.");
    }

catch(Exception $e)
{
    $msg=$e->getMessage();
    session_unset();
    session_destroy();
    echo <<<EOT
    <!DOCTYPE html>
    <html>
        <body>
            <script>
            alert("$msg");
            window.location.replace("sign-up.html");
            </script>
        </body>
    </html>
EOT;
}
?>
</body>
</html>