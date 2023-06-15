<?php

if(isset($_GET['edit_student'])) {

    $the_user_id = $_GET['edit_student'];

    $query = "SELECT * FROM users WHERE user_id = '{$the_user_id}' ";
    $select_user_profile_query = mysqli_query($connection, $query);

    while($row = mysqli_fetch_assoc($select_user_profile_query)) {

      $student_id   = $row['student_id'];


    }

    
}

if(isset($_POST['edit_user'])) {
    
  $student_id = $_POST['student_id'];    

        $query = "UPDATE users SET ";
        $query .= "student_id      = '{$student_id}' ";
        $query .= "WHERE user_id  = '{$the_user_id}' ";
    
        $edit_user_query = mysqli_query($connection, $query);
    
        confirm($edit_user_query);
       update_kids_count();
    update_kids_count_byteacher();
        
        $message = "Profile Updated!";

        header("refresh:2;url=user.php");

        }

       else {

        $message = "";

        } 

       




?>

<style>
    .input-modal{
        color:black !important;
    }
</style>

<!-- Modal -->
<div class="modal fade" id="exampleModalCenterAssignParent" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLongTitle">Assign Parent</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
      <form action="" method="post" enctype="multipart/form-data">
      <div class="row">
                <div class="col-md-12 form-group">
                    <label class="input-modal" for="users">Parent</label>
                    <select style="color:black;" name="student_id" class="form-control" id="">
                    <?php 
            
                    $query = "SELECT * FROM users WHERE user_role = 'parent'";
                    $select_user = mysqli_query($connection, $query);

                    while ($row = mysqli_fetch_assoc($select_user)) {
                    $student_id = $row['student_id'];
                    $firstname = $row['firstname'];
                
                    echo "<option value='{$student_id}'>{$firstname}</option>";

                      }
                
                    ?>
                    </select>
                  </div>
                    </div>
                  <div class="modal-footer">
                    <input type="button" class="btn btn-secondary" data-dismiss="modal" value="Close">
                    <input type="submit" name="edit_student" class="btn btn-primary" value="Add Parent">
                    </div>
                </form>
      </div>
    </div>
  </div>
</div>

