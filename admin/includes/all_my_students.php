<?php include "includes/sidebar.php" ?>
<?php include "includes/navbar.php"; ?>
<div class="content">
<div class="row">
          <div class="col-md-12">
            <div class="card ">
              <div class="card-header">
                <h4 class="card-title"> My Students</h4>
                <!-- ADD KID MODAL -->
                <?php if(is_teacher()): ?>
                  <a href="./stripe-one/checkout.php" class="btn btn-primary">Add Student</a>
                  <?php endif ?>
              </div>
              <div class="card-body">
                <div class="table-responsive">
                <table class="table tablesorter">
                        <thead class="text-primary">
                            <tr>
                                <th>Id</th>
                                <th>Name</th>
                                <th class="text-right">Edit</th>
                                <th class="text-right">Delete</th>
                            </tr>
                        </thead>
                        <tbody>

                        <?php 
                        
                        $query = "SELECT * FROM users WHERE t_student_id =".loggedInUserIdTeacher()." ORDER BY student_id DESC";
                        $select_student = mysqli_query($connection, $query);
                
                        while ($row = mysqli_fetch_assoc($select_student)) {
                        $user_id   = $row['user_id'];
                        $firstname = $row['firstname'];
                        $lastname  = $row['lastname'];

                        echo "<tr>";
                            echo "<td>$user_id</td>";
                            echo "<td>$firstname $lastname</td>";
                            echo "<td class='text-right'><a href='students.php?source=edit_student&edit_student={$user_id}'>Edit</a></td>";  
                            echo "<td class='text-right'><a onClick=\"javascript: return confirm('Are you sure you want to remove this student?'); \"href='my_students.php?remove={$user_id}'>Remove</a></td>";  
                            echo "</tr>";
                        }
                        
                        ?>
                   </tbody>
                   </table>

                   <?php 
              if(isset($_GET['remove'])) {
                $user_id = $_GET['remove'];

                $query = "UPDATE users SET t_student_id = '0' WHERE user_id = '{$user_id}'";
                $remove_user = mysqli_query($connection, $query);

                // Check if the user was successfully deactivated
                if($remove_user) {
                  header("Location: {$_SERVER['PHP_SELF']}"); // Redirect to the same page
                  exit();
                } else {
                  echo "<p>Failed to remove user. Please try again.</p>";
                }
              }
              ?>

                </div>
              </div>
            </div>
          </div>
</div>