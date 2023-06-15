<?php include "includes/sidebar.php" ?>
<?php include "includes/navbar.php"; ?>
<div class="content">
<div class="row">
          <div class="col-md-12">
            <div class="card ">
              <div class="card-header">
                <h4 class="card-title"> All Parents</h4>
                <?php include "add_parents_admin.php" ?>
                        <div class="form-group">
                            <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#exampleModalCenterParent">Add Parent</button>
                        </div>
              </div>
              <div class="card-body">
                <div class="table-responsive">
                <table class="table tablesorter">
                        <thead class="text-primary">
                            <tr>
                                <th>Id</th>
                                <th>Name</th>
                                <th>Verified</th>
                                <th class="text-right">Edit</th>
                                <th class="text-right">Delete</th>
                            </tr>
                        </thead>
                        <tbody>

                        <?php 
                        
                        $query = "SELECT * FROM users WHERE user_role = 'parent' ORDER BY user_id DESC ";
                        $select_student = mysqli_query($connection, $query);
                
                        while ($row = mysqli_fetch_assoc($select_student)) {
                        $user_id   = $row['user_id'];
                        $firstname = $row['firstname'];
                        $lastname  = $row['lastname'];
                        $verified  = $row['verified'];

                        echo "<tr>";
                            echo "<td>$user_id</td>";
                            echo "<td>$firstname $lastname</td>";
                            echo "<td>$verified</td>";
                            echo "<td class='text-right'><a href='parents.php?source=edit_parent&edit_parent={$user_id}'>Edit</a></td>";  
                            echo "<td class='text-right'><a onClick=\"javascript: return confirm('Are you sure you want to delete?'); \"href='parents.php?delete={$user_id}'>Delete</a></td>";  
                            echo "</tr>";
                        }
                        
                        ?>
                   </tbody>
                   </table>

                   <?php 
                   
                   if(isset($_GET['delete'])) {

                    $user_id = $_GET['delete'];

                    $query = "DELETE FROM users WHERE user_id = {$user_id}";
                    $delete_query = mysqli_query($connection, $query);
                    update_kids_count();
                    update_kids_count_byteacher();
                    header("Location: parents.php");


                   }
                   
                   
                   ?>

                </div>
              </div>
            </div>
          </div>
</div>