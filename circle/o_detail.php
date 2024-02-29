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
$order_id=$_POST['order_id'];
$distance=$_POST['distance'];
$type=$_POST['type'];
$subtotal=0;
$stmt = $conn->prepare("select meal.picture, meal.picture_type, meal.mealname, detail.price, detail.number from meal inner join detail on meal.meal_id=detail.meal_id where detail.order_id=$order_id");
$stmt->execute();
$_SESSION['detail'] = $stmt->fetchAll(PDO::FETCH_ASSOC);
$subtotal=0;
?>
	                <!-- Modal -->
  <div class="modal fade" id="myorderdetails"  data-backdrop="static" tabindex="-1" role="dialog" aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog">
	
      <!-- Modal content-->
      <div class="modal-content">
        <div class="modal-header">
		<a href="nav.php#myorder">
          <button type="button" class="close" data-dismiss="modal">&times;</button>
		</a>
          <h4 class="modal-title">Order</h4>
        </div>
        <div class="modal-body">
         <!--  -->
  
         <div class="row">
          <div class="  col-xs-12">
            <table class="table" style=" margin-top: 15px;">
              <thead>
                <tr>
                  <th scope="col">Picture</th>
                 
                  <th scope="col">meal name</th>
               
                  <th scope="col">price</th>
                
                  <th scope="col">Order Quantity</th>
                </tr>
              </thead>
              <tbody>
                <?php
            
                 if(!isset($_SESSION['detail']) )
                 {
                    echo '<tr>No data found</tr>';
                 }
                 else{
                    foreach($_SESSION['detail'] as $key=>$value){
                    
                    $img=$value['picture'];
                    $logodata = 'data:;base64,' .$img . ' ';
                    if($value['number']==0){
                        $k=$k+1;
								  continue;
						      }

               
					        ?>
                <tr>
                   <td><img src=<?php echo $logodata;?> width="100" height="100" ?></td>
                  <td><?php echo $value['mealname'];?></td>
                  <td><?php echo $value['price'];?></td>
                  <td><?php echo $value['number'];?></td>
				  <?php $subtotal+=$value['number']*$value['price'];?>
                </tr>
              
			<?php }
			}?>
            </tbody>
            </table>
    <hr size="8px" width="100%">
	  <label class="control-label col-sm-1" >Subtotal:</label><?php echo $subtotal;?>
	  <?php if($type=="pick_up"){
		  $total=$subtotal;
		  $delivery=0;
		  }
		  else{
		  $total=$subtotal+10*$distance;
		  $delivery=10*$distance;
		  }
	  ?>
      <hr size="8px" width="100%">
    <label class="control-label col-sm-1" >Delivery fee:</label><?php echo $delivery;?>
    <hr size="8px" width="100%">
    <label class="control-label col-sm-1" >Total Price:</label><?php echo $total;?>
	  

			
          </div>

        </div>
         <!--  -->
        </div>
      </div>
      
    </div>
  </div>