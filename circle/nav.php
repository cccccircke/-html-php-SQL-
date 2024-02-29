<?php    
  $dbservername='localhost';
  $dbname='hw2';
  $dbusername='root';
  $dbpassword='';
 
  $conn = new PDO("mysql:host=$dbservername;dbname=$dbname",$dbusername, $dbpassword);
  $conn->setAttribute(PDO::ATTR_ERRMODE,PDO::ERRMODE_EXCEPTION);

?>

<!doctype html>
<html lang="en">

<head>
  <!-- Required meta tags -->
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">

  <!-- Bootstrap CSS -->

  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">

  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>
  <title>Hello, world!</title>
</head>

<body>
 
  <nav class="navbar navbar-inverse">
    <div class="container-fluid">
      <div class="navbar-header">
        <a class="navbar-brand " href="#">WebSiteName</a>
      </div>
      <div class="navbar-header">
        <a class="navbar-brand " href="logout.php"><u>Log out</u></a>
      </div>
      


    </div>
  </nav>
  <div class="container">

    <ul class="nav nav-tabs">
      <li class="active"><a href="#home">Home</a></li>
      <li><a href="#menu1">shop</a></li>
      <li><a href="#myorder">My Order</a></li>
      <li><a href="#shop_order">Shop Order</a></li>
      <li><a href="#transaction_record">Transaction Record </a></li>



    </ul>
    
    <div class="tab-content">

      <div id="home" class="tab-pane fade in active">
        <h3>Profile</h3>
        <div class="row">
          <div class="col-xs-12">
          
            Accouont: <?php  include("search.php");echo$account." ";?>, <?php echo$username." ";?>, PhoneNumber: <?php echo"0"."$phonenumber"." ";?>,  location: <?php echo "$longitude $latitude";?>
            
            <button type="button " style="margin-left: 5px;" class=" btn btn-info " data-toggle="modal"
            data-target="#location">edit location</button>
            
            <!--  -->
            
            <div class="modal fade" id="location"  data-backdrop="static" tabindex="-1" role="dialog" aria-labelledby="staticBackdropLabel" aria-hidden="true">
              <div class="modal-dialog  modal-sm">
                <div class="modal-content">
                  <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                    <h4 class="modal-title">edit location</h4>
                  </div>
                  <form action="edit.php" class="fh5co-form animate-box" data-animate-effect="fadeIn" method="get">
                  <div class="modal-body">
                    <label class="control-label " for="latitude">latitude</label>
					        
                    <input type="text" class="form-control" name="latitude" placeholder="enter latitude" value="" oninput="if(value<-90)value=-90;if(value>90)value=90">
                      <br>
                      <label class="control-label " for="longitude">longitude</label>
					          <input type="text" class="form-control" name="longitude" placeholder="enter longitude"  value="" oninput="if(value<-180)value=-180;if(value>180)value=180">
                  </div>
                  <div class="modal-footer">
                    <input type="submit" value="Edit" class="btn btn-default">
                  </div>
				        </form>
                </div>
              </div>
            </div>
            
           

            <!--  -->
            walletbalance:  <?php echo $_SESSION['wallet']?>
            <!-- Modal -->
            <button type="button " style="margin-left: 5px;" class=" btn btn-info " data-toggle="modal"
              data-target="#myModal">Add value</button>
            <div class="modal fade" id="myModal"  data-backdrop="static" tabindex="-1" role="dialog" aria-labelledby="staticBackdropLabel" aria-hidden="true">
              <div class="modal-dialog  modal-sm">
                <div class="modal-content">
                  <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                    <h4 class="modal-title">Add value</h4>
                  </div>
                  <div class="modal-body">
                  <form action="wallet.php" class="fh5co-form animate-box" data-animate-effect="fadeIn" method="post">
                    <input class="input-group-field" type="text" name="addmoney"  placeholder="enter add value">
                  </div>
                  <div class="modal-footer">
                  <input type="submit" value="Add" class="btn btn-default">
                   
                  </div>
                  </form>
                </div>
              </div>
            </div>
          </div>

        </div>

        <!-- 
           
             -->
        <h3>Search</h3>
        <div class=" row  col-xs-8">
          <form  action="find.php" class="form-horizontal" method="get">
            <div class="form-group">
              <label class="control-label col-sm-1" for="Shop">Shop</label>
              <div class="col-sm-5">
                <input type="text" class="form-control" name="Shopname" placeholder="Enter Shop name">
              </div>
              <label class="control-label col-sm-1" for="distance">distance</label>
              <div class="col-sm-5">


                <select class="form-control" id="sel1" name="distance">
                  <option value="near">near</option>
                  <option value="medium">medium </option>
                  <option value="far">far</option>
                  <option value="all">-</option>
                </select>
              </div>
              

            </div>

            <div class="form-group">

              <label class="control-label col-sm-1" for="Price">Price</label>
              <div class="col-sm-2">

                <input type="text" class="form-control" name="price_1">

              </div>
              <label class="control-label col-sm-1" for="~">~</label>
              <div class="col-sm-2">

                <input type="text" class="form-control"  name="price_2">

              </div>
              <label class="control-label col-sm-1" for="Meal">Meal</label>
              <div class="col-sm-5">
                <input type="text" list="Meals" class="form-control" id="Meal" placeholder="Enter Meal" name="Meal">
                <datalist id="Meals">
                  <option value="Hamburger">
                  <option value="coffee">
                </datalist>
              </div>
            </div>
    
            <div class="form-group">
              <label class="control-label col-sm-1" for="category"> category</label>
            
                <div class="col-sm-5">
                  <input type="text" list="categorys" class="form-control" id="category" name="category" placeholder="Enter shop category">
                  <datalist id="categorys">
                    <option value="fast food">
               
                  </datalist>
                </div>
                <button type="submit" name="search" value="search" style="margin-left: 18px;"class="btn btn-primary">Search</button>
              
            </div>
        </div>
        </form>
        <div class="row">
          <div class="  col-xs-8">
            <table class="table" style=" margin-top: 15px;">
              <thead>
                <tr>
                  <th scope="col">#</th>
                
                  <th scope="col">shop name</th>
                  <th scope="col">shop category</th>
                  <th scope="col">Distance</th>
               
                </tr>
              </thead>
            
              <?php foreach($_SESSION['row'] as $key=>$value)
                    {
                    ?>
              <tbody>
                <tr>
                    
                        <td><?php echo $key+1;?></td>
                        <td><?php echo $value['shopname'];?></td>
                        <td><?php echo $value['category'];?></td>
                        <td><?php echo ceil($value['distance']/1000);?></td>
                        <td>
                    <form action="showm.php" class="fh5co-form animate-box" data-animate-effect="fadeIn" method="post" id="<?php echo $key+1;?>">
                      <input type="hidden" name="shop_id" value="<?php echo  $value['shop_id'];?>">
                      <input type="hidden" name="shop_dist" value="<?php echo ceil($value['distance']/1000);?>">
                    </form>
                    <button type="submit" form="<?php echo $key+1;?>" name="openmenubutton" class="btn btn-info">Open menu</button>
                  </td>
                </tr>
                <?php }?>
              </tbody>
            </table>
          </div>
        </div>
      </div>             <!-- Modal -->
    
      
       
     
      <div id="menu1" class="tab-pane fade">
      <form method="POST" action="shopregister.php">
         
        <h3> Start a business </h3>
        <div class="form-group ">
          <div class="row">
            <div class="col-xs-2">
              <label for="ex5">shop name</label>
              <input name="ushopname" class="form-control" id="ex5" placeholder="macdonald" type="text" >
              
            </div>
            <div class="col-xs-2">
              <label for="ex5">shop category</label>
              <input name="ucategory" class="form-control" id="ex5" placeholder="fast food" type="text" >
            </div>
            <div class="col-xs-2">
              <label for="ex6">latitude</label>
              <input name="ulatitude" class="form-control" id="ex6" placeholder="121.00028167648875" type="text" >
            </div>
            <div class="col-xs-2">
              <label for="ex8">longitude</label>
              <input name="ulongitude" class="form-control" id="ex8" placeholder="24.78472733371133" type="text" >
            </div>
          </div>
        
        </div>
        
        
      


        
        <div class=" row" style=" margin-top: 25px;">
          <div class=" col-xs-3">
            <input type="submit" value="register" class="btn btn-primary">
          </div>
        </div>
    
      </form>
        
        <hr>
        <form method="POST" action="shopadd.php" enctype="multipart/form-data">
        <h3>ADD</h3>
        <div class="form-group ">
          <div class="row">

            <div class="col-xs-6">
              <label for="ex3">meal name</label>
              <input type="text" class="form-control" name="umealname" id="ex3" type="text">
            </div>
          </div>
          <div class="row" style=" margin-top: 15px;">
            <div class="col-xs-3">
              <label for="ex7">price</label>
              <input class="form-control" name="uprice" id="ex7" type="text">
            </div>
            <div class="col-xs-3">
              <label for="ex4">quantity</label>
              <input class="form-control" name="uquantity" id="ex4" type="text">
            </div>
          </div>


          <div class="row" style=" margin-top: 25px;">

            <div class=" col-xs-3">
              <label for="ex12">上傳圖片</label>
              <input id="myfile" type="file" name="myfile" Enctype="multipart/form-data">
            </div>
            <div class=" col-xs-3">
              <input type="submit" value="Add" class="btn btn-primary" style="margin-top: 15px;">
            </div>
          </div>
        </div>

        <div class="row">
          <div class="  col-xs-8">
            <table class="table" style=" margin-top: 15px;">
              <thead>
                <tr>
                  <th scope="col">#</th>
                  <th scope="col">Picture</th>
                  <th scope="col">meal name</th>
              
                  <th scope="col">price</th>
                  <th scope="col">Quantity</th>
                  <th scope="col">Edit</th>
                  <th scope="col">Delete</th>
                </tr>
              </thead>

              <tbody>
                <tr>
                <form action="shoplist.php">
                <?php
                include("shoplist.php");
                for($j=0;$j<$number;$j+=1){
                ?>
                <tr>
                <td><?php include("shoplist.php"); $k=$j+1; echo $k;?></td>
                <td><?php include("shoplist.php"); echo '<img width="100" height="100" src="data:'.$arr[$j][4].';base64,' . $arr[$j][3].'" />';?></td>
                <td><?php include("shoplist.php"); echo $arr[$j][0];?></td>
                <td><?php include("shoplist.php"); echo $arr[$j][1];?></td>
                <td><?php include("shoplist.php"); echo $arr[$j][2];?></td>
                <td><button type="button" class="btn btn-info" data-toggle="modal" data-target="#coffee-1">
                  Edit
                  </button></td>
                  <!-- Modal -->
                      <div class="modal fade" id="coffee-1" data-backdrop="static" tabindex="-1" role="dialog" aria-labelledby="staticBackdropLabel" aria-hidden="true">
                        <div class="modal-dialog" role="document">
                          <div class="modal-content">
                            <div class="modal-header">
                              <h5 class="modal-title" id="staticBackdropLabel">coffee Edit</h5>
                              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                              </button>
                            </div>
                            <div class="modal-body">
                              <div class="row" >
                                <div class="col-xs-6">
                                  
                                  <label for="ex72">price</label>
                                  <input name="nprice" class="form-control" id="ex72" type="text">
                                </div>
                                <div class="col-xs-6">
                                  <label for="ex42">quantity</label>
                                  <input name="nquantity" class="form-control" id="ex42" type="text">
                                </div>
                              </div>
                    
                            </div>
                            <div class="modal-footer">
                              <button type="button" class="btn btn-secondary" data-dismiss="modal">Edit</button>
                             
                            </div>
                            
                          </div>
                        </div>
                      </div>


                  <td><input type="button" value="Delete" class="btn btn-danger" onClick=" window.alert('I told you not to click me!');"></td>
                  <script>
                    function click(){
                     
                    }
                    
                </script>
                 
                </tr>
                <?php
                }
                ?>
                
              </form>

              </tbody>
            </table>
          </div>

        </div>
      </form>
      </div>
      
 <!-- myorder page -->
      
      <div id="myorder" class="tab-pane fade">
      </br>
        <div class=" row  col-xs-8">
          <form class="form-horizontal" action="myorder.php" method="post">
			<div class="form-group">
              <label class="control-label col-sm-1" for="status">Status</label>
              <div class="col-sm-5">
                <select class="form-control" name="mystatus">
                  <option value="all">All</option>
                  <option value="Finished">Finished</option>
                  <option value="Not Finish">Not Finish</option>
                  <option value="Cancel">Cancel</option>

                </select>
              </div>
              <button type="submit" name="Search" value="Search" style="margin-left: 18px;"
                class="btn btn-primary">Search</button>
				</div>
          </form>
		</div>
	      <div class="row">
          <div class="  col-xs-8">
            <table class="table" style=" margin-top: 15px;">
              <thead>
                <tr>
                  <th scope="col">Order ID</th>
                  <th scope="col">Status</th>
                  <th scope="col">Start</th>
                  <th scope="col">End</th>
                  <th scope="col">Shop name</th>
                  <th scope="col">Total Price</th>
                  <th scope="col">Order Details</th>
                  <th scope="col">Action</th>
                </tr>
              </thead>
              <tbody>
                <?php
                 if(!isset($_SESSION['myorder']) )
                 {
                    echo '<tr>No data found</tr>';
                 }
                 else{
                    foreach($_SESSION['myorder'] as $key=>$value)
                    {
                        ?>
                <tr>
                  <td><?php echo $value['order_id'];?></td>
                  <td><?php echo $value['status'];?></td>
                  <td><?php echo $value['start'];?></td>
                  <td><?php echo $value['end'];?></td>
				          <td><?php echo $value['shopname'];?></td>
				          <td><?php echo $value['money'];?></td>
                    <td>
					<form action="o_detail.php" class="fh5co-form animate-box" data-animate-effect="fadeIn" method="post">
					<input type="hidden" name="order_id" value="<?php echo $value['order_id'];?>" >
					<input type="hidden" name="distance" value="<?php echo $value['distance'];?>" >
					<input type="hidden" name="type" value="<?php echo $value['type'];?>" >
					<input type="submit" class="btn btn-info" value="order details">
					</form>
				 </td>
				 <?php if($value['status']=="Not Finish"): ?>
				   <td>
					<form action="o_cancel.php" class="fh5co-form animate-box" data-animate-effect="fadeIn" method="post">
					<input type="hidden" name="order_id" value="<?php echo $value['order_id'];?>" >
					<input type="hidden" name="shop_id" value="<?php echo $value['shop_id'];?>" >
					<input type="hidden" name="money" value="<?php echo $value['money'];?>" >
					<input type="submit" class="btn btn-danger" value="Cancel">
					</form>
				 </td>
				<?php endif; ?>
                </tr>
			<?php }
			}?>
		 </tbody>
	</table>

  </div>
</div>
    </div>
  
        <!-- my order page -->

  <!-- Option 1: Bootstrap Bundle with Popper -->
  <!-- <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous"></script> -->
  <script>
    $(document).ready(function () {
      $(".nav-tabs a").click(function () {
        $(this).tab('show');
      });
    });
  </script>

  <!-- Option 2: Separate Popper and Bootstrap JS -->
  <!--
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.10.2/dist/umd/popper.min.js" integrity="sha384-7+zCNj/IqJ95wo16oMtfsKbZ9ccEh31eOz1HGyDuCQ6wgnyJNSYdrPa03rtR1zdB" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.min.js" integrity="sha384-QJHtvGhmr9XOIpI6YVutG+2QOK9T+ZnN4kzFN1RtK3zEFEIsxhlmWl5/YESvpZ13" crossorigin="anonymous"></script>
    -->
</body>

</html>