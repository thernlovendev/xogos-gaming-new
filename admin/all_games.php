<?php include "includes/header.php" ?>
<?php include "includes/sidebar.php" ?>
<?php include "includes/navbar.php"; ?>

<div class="content">
<div class="row">
          <div class="col-md-12">
            <div class="card ">
              <div class="card-header">
                <h4 class="card-title"> All Games</h4>
              </div>
              <div class="card-body">
                <div class="table-responsive">
                <table class="table tablesorter">
                        <thead class="text-primary">
                            <tr>
                                <th>Id</th>
                                <th>Name</th>
                                <th class="text-right"></th>
                            </tr>
                        </thead>
                        <tbody>
                          <tr>
                            <td>1</td>
                            <td><img src="assets/img/lightning-round.jpg" alt="" style="width:125px; height:auto;"></td>
                            <td>Lightning Round</td>
                            <td class='text-right'><a href='https://lightninground.rocks/?token=<?php echo $_SESSION['token_LR']; ?>'>Play</a></td>
                          </tr>
                          <tr>
                            <td>2</td>
                            <td><img src="assets/img/historical-conquest.jpg" alt="" style="width:125px; height:auto;"></td>
                            <td>Historical Conquest</td>
                            <td class='text-right'><a href=''>Play</a></td>
                          </tr>
                          <tr>
                            <td>3</td>
                            <td><img src="assets/img/time-quest.jpg" alt="" style="width:125px; height:auto;"></td>
                            <td>Time Quest</td>
                            <td class='text-right'><a href=''>Play</a></td>
                          </tr>
                
                   </tbody>
                   </table>

                   <?php 
                   
                   if(isset($_GET['delete'])) {

                    $client_id = $_GET['delete'];
                    $query = "DELETE FROM users WHERE user_id = {$user_id}";
                    $delete_query = mysqli_query($connection, $query);
                     
        update_kids_count();
        update_kids_count_byteacher();
                    header("Location: my_kids.php");


                   }
                   ?>

                </div>
              </div>
            </div>
          </div>
</div>