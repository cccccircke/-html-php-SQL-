<?php    
  session_start();
  $dbservername='localhost';
  $dbname='hw2';
  $dbusername='root';
  $dbpassword='';

  $conn = new PDO("mysql:host=$dbservername;dbname=$dbname",$dbusername, $dbpassword);
  $conn->setAttribute(PDO::ATTR_ERRMODE,PDO::ERRMODE_EXCEPTION);
?>
<div class="modal fade" id="showmenu"  data-backdrop="static" tabindex="-1" role="dialog" aria-labelledby="staticBackdropLabel" aria-hidden="true">
    
    <div class="modal-dialog">
    
      <!-- Modal content-->
      <div class="modal-content">
        <div class="modal-header">
        <a href="nav.php">
          <button type="button" class="close" data-dismiss="modal">&times;</button>
          </a>
          <h3 class="modal-title">menu</h3>
        </div>
        <div class="modal-body">
         <!--  -->
  
         <div class="row">
         <div class="  col-xs-12">
            <table class="table" style=" margin-top: 15px;">
              <thead>
                <tr>
                  <th scope="col">#</th>
                  <th scope="col">Picture</th>
                 
                  <th scope="col">meal name</th>
               
                  <th scope="col">price</th>
                  <th scope="col">Quantity</th>
                
                  <th scope="col">Order check</th>
                </tr>
              </thead>
              <tbody>
          
              <?php
                    $shop_id=$_POST['shop_id'];
                    $_SESSION['shop_id']=$shop_id;
                    $shop_dist=$_POST['shop_dist'];
                    $_SESSION['shop_dist']=$shop_dist;
				      $sql="select picture, mealname, price, quantity from meal where shop_id=$shop_id";?>
							<form action="order.php" class="fh5co-form animate-box" data-animate-effect="fadeIn" method="post">
              <?php
              $stmt = $conn->prepare($sql);
              $stmt->execute();
              $all['result']= $stmt->fetchAll(PDO::FETCH_ASSOC);
             
				      foreach( $all['result'] as $k=>$val)
                    {?>
                   <tr>
                        <td><?php echo $k+1;?></td>
                        <?php
						            $img=$val['picture'];
                        
                        $logodata = 'data:;base64,' .$img . ' ';
						            
						            ?> 
                         
                         <td><img src=<?php echo $logodata;?> width="100" height="100" ?></td>
                        <td><?php echo $val['mealname'];?></td>
                        <td><?php echo $val['price'];?></td>
						            <td><?php echo $val['quantity'];?></td>
                        <td>
								        <input class="input-group-field" type="number" name="order[]" value="0" min="0" step="1">
							          </td>
						            
						        </tr>
                        <?php
                      }
                      ?>
				      </tbody>
            </table>
				</div>

				  </div>
  
          </div>
          
          <h4>
          <label class="control-label col-sm-1" for="Type">Type</label>
          
          <td>
                <select class="form-control" name="order_type">
                  <option value="delivery">Delivery</option>
                  <option value="pick_up">Pick-up</option>
                </select>
          </td>
          </h4>
         
        	<hr />
				<div class="modal-footer">
        <input type="submit" value="Calculate the price" class="btn btn-default">
				</div>
        </form>
                </div>

              </div>
            </div>