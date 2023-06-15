<?php include "includes/sidebar.php" ?>
<?php include "includes/navbar.php"; ?>

<?php 
$kids_count = count_records(get_all_user_kids());
?>

<div class="content">
  <div class="row">
    <div class="col-md-12">
      <div class="card ">
        <div class="card-header">
          <h4 class="card-title"> My Kids <?php echo $kids_count ?></h4>
          <!-- ADD KID MODAL -->
          <?php if(is_parent()): ?>
            <a href="./stripe-one/checkout.php" class="btn btn-primary">Add Kid</a>
          <?php endif ?>
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
                  <th class="text-right">Action</th>
                </tr>
              </thead>
              <tbody>

                <?php 
                $query = "SELECT * FROM users WHERE student_id =".loggedInUserIdParent()." ORDER BY student_id DESC";
                $select_student = mysqli_query($connection, $query);

                while ($row = mysqli_fetch_assoc($select_student)) {
                  $user_id   = $row['user_id'];
                  $firstname = $row['firstname'];
                  $lastname  = $row['lastname'];
                  $verified  = $row['verified'];
                  $active    = $row['active'];

                  echo "<tr>";
                  echo "<td>$user_id</td>";
                  echo "<td>$firstname $lastname</td>";
                  echo "<td>$verified</td>";
                  echo "<td class='text-right'><a href='students.php?source=edit_student&edit_student={$user_id}'>Edit</a></td>";  
                  
                  if ($active == 'yes') {
                    // User is active, show Deactivate button
                    echo "<td class='text-right'><a onClick=\"javascript: return confirm('Are you sure you want to deactivate this user?'); \"href='my_kids.php?deactivate={$user_id}'>Deactivate</a></td>";
                  } else {
                    // User is deactivated, show Activate button
                    echo "<td class='text-right'><a onClick=\"javascript: return confirm('Are you sure you want to activate this user?'); \"href='my_kids.php?activate={$user_id}'>Activate</a></td>";
                  }
                  
                  echo "</tr>";
                }
                ?>

              </tbody>
            </table>

            <?php 
              if(isset($_GET['deactivate'])) {
                $user_id = $_GET['deactivate'];

                $query = "UPDATE users SET active = 'no' WHERE user_id = '{$user_id}'";
                $deactivate_user = mysqli_query($connection, $query);

                // Check if the user was successfully deactivated
                if($deactivate_user) {
                  echo "<p>User deactivated successfully.</p>";
                  header("Location: {$_SERVER['PHP_SELF']}"); // Redirect to the same page
                  exit();
                } else {
                  echo "<p>Failed to deactivate user. Please try again.</p>";
                }
              }

              if(isset($_GET['activate'])) {
                $user_id = $_GET['activate'];

                $query = "UPDATE users SET active = 'yes' WHERE user_id = '{$user_id}'";
                $activate_user = mysqli_query($connection, $query);

                // Check if the user was successfully activated
                if($activate_user) {
                  echo "<p>User activated successfully.</p>";
                  header("Location: {$_SERVER['PHP_SELF']}"); // Redirect to the same page
                  exit();
                } else {
                  echo "<p>Failed to activate user. Please try again.</p>";
                }
              }
              ?>



          </div>
        </div>
      </div>
    </div>
  </div>
</div>
