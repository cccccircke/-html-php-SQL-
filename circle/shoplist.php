<?php
    

    $dbservername='localhost';
    $dbname='hw2';
    $dbusername='root';
    $dbpassword='';
    $cleaned="";
    $conn = new PDO("mysql:host=$dbservername;dbname=$dbname",$dbusername, $dbpassword);
    $conn->setAttribute(PDO::ATTR_ERRMODE,PDO::ERRMODE_EXCEPTION);

    $stmt=$conn->prepare("SELECT count(*) from meal");
    $stmt->execute();
    $row=$stmt->fetch();
    $number=$row[0];

    $stmt=$conn->prepare("SELECT * from meal");
    $stmt->execute();
    $i=0;
    while($row=$stmt->fetch()){
        $arr[$i][0]=$row['mealname'];
        $arr[$i][1]=$row['price'];
        $arr[$i][2]=$row['quantity'];
        $arr[$i][3]=$row['picture'];
        $arr[$i][4]=$row['picture_type'];
        $arr[$i][5]=$row['meal_id'];
       # echo '<img src="data:'.$arr[$i][4].';base64,' . $arr[$i][3].'" />';
       # echo '<img with="10" heigh="10" alt="coffee" src='.$arr[$i][4].';base64,'.$arr[$i][3].'" />';
        $i+=1;
    }

    #echo '<meta http-equiv=REFRESH CONTENT=0;url=nav.php#menu1>';
?>

