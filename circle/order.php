<?php    

  session_start();
  $dbservername='localhost';
  $dbname='hw2';
  $dbusername='root';
  $dbpassword='';
  
  $conn = new PDO("mysql:host=$dbservername;dbname=$dbname",$dbusername, $dbpassword);
  $conn->setAttribute(PDO::ATTR_ERRMODE,PDO::ERRMODE_EXCEPTION);
?>
 <!-- Modal -->
            <div class="modal fade" id="showmenu" data-backdrop="static" tabindex="-1" role="dialog"
              aria-labelledby="staticBackdropLabel" aria-hidden="true">
              <div class="modal-dialog">

                <!-- Modal content-->
                <div class="modal-content">
                  <div class="modal-header">
				  <a href="nav.php">
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
							$sub=0;
							$say=0;
							$disable=0;
							$sentence="The product quantity is not enough: ";
                            $shop_id= $_SESSION['shop_id'];
                            $stmt = $conn->prepare("select * from meal where shop_id=:shop_id");
                            $stmt->execute(array('shop_id' => $shop_id));
                            $menu_result = $stmt->fetchAll(PDO::FETCH_ASSOC);
							
							?>
							<form action="action.php" class="fh5co-form animate-box" data-animate-effect="fadeIn" method="post">
                            <?php foreach($menu_result as $k=>$val){
                             $img=$val['picture'];
                             $logodata = 'data:;base64,' .$img . ' ';
                              
							  if($_POST['order'][$k]==0){
								  $k=$k+1;
								  continue;
							  }
                             
							  if($val['quantity'] < $_POST['order'][$k]){
								  $disable=1;
								  $say=1;
								  $sentence.=$val['mealname'];
								  $sentence.=" ";
							  }
                            ?>
                            <tr>
                              
                              <td><img src=<?php echo $logodata;?> width="100" height="100" ?></td>
                              <td><?php echo $val['mealname'];?></td>
                            <td><?php echo $val['price'];?></td>
                              <td>
								<?php echo $_POST['order'][$k];?>
								  <input type="hidden" name="detail_meal[]" value="<?php echo $val['meal_id'];?>" >
								  <input type="hidden" name="detail_price[]" value="<?php echo $val['price'];?>" >
								  <input type="hidden" name="order[]" value="<?php echo $_POST['order'][$k];?>" >
							 </td>
							<?php $sub+=$_POST['order'][$k]*$val['price'];?>

                            </tr>
                            <?php
				  }
				?>
                          </tbody>
                        </table>
                      </div>
                    </div>
					 <!--  -->
                  </div>
				  <label class="control-label col-sm-1" >Subtotal:</label><?php echo $sub;?>
				  <?php if($_POST['order_type']=="pick_up"){
					  $total=$sub;
					  $delivery=0;
					  }
					  else{
					  $total=$sub+10*$_SESSION['shop_dist'];
					  $delivery=10*$_SESSION['shop_dist'];
					  }
					  if($total>$_SESSION[ 'wallet' ]){
						  $disable=1;
						  echo' <script type="text/JavaScript"> 
						  alert("Not enough money");
						 </script> ';
								  
					  }
					  
					  if($say==1){
						  echo "<script type='text/javascript'>alert('$sentence');</script>";
					  }
				  ?>
				  <input type="hidden" name="order_type" value="<?php echo $_POST['order_type'];?>" >
				  <input type="hidden" name="total" value="<?php echo $total;?>" >
				  <label class="control-label col-sm-1" >Delivery fee:</label><?php echo $delivery;?>
				  <label class="control-label col-sm-1" >Total Price:</label><?php echo $total?>
                  <div class="modal-footer">
					<input type="submit" id="toorderact" class="btn btn-default" <?php if ($disable==1){ ?> disabled <?php } ?>value="Order">
				  </div>
				  </form>
                </div>
              </div>
            </div>