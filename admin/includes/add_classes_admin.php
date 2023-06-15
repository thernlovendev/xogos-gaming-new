<?php

if(isset($_POST['add_class'])) {
  
    $class_teacher_id = escape($_POST['class_teacher_id']);
    $class_subject	  = escape($_POST['class_subject']);

    $query = "INSERT INTO classes(class_teacher_id, class_subject) ";
    $query .= "VALUES('{$class_teacher_id}', '{$class_subject}') ";

    $add_class_query = mysqli_query($connection, $query);

    if(!$add_class_query) {
      die("QUERY FAILED" . mysqli_error($connection));
  }

  header('Location: classes.php');
}

?>



<style>
    .content {
        padding:50px;
    }
    .input-modal{
        color:black !important;
    }
</style>


<!-- Modal -->
<div class="modal fade" id="adminNewClass" tabindex="-1" role="dialog" aria-labelledby="adminNewClass" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="newClass">Add Class</h5>
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">
          <i class="tim-icons icon-simple-remove"></i>
        </button>
      </div>
      <div class="modal-body">
      <form action="" method="post" enctype="multipart/form-data">
                  <div class="row">
                    <div class="col-md-12 pr-md-1">
                      <div class="form-group">
                        <label>Class Name</label>
                        <input type="text" class="form-control" placeholder="Class Name" name="class_subject" style="color:black !important;">
                      </div>
                    </div>
                  </div>
                    <div class="row">
                    <div class="col-md-12 pr-md-1">
                      <div class="form-group">
                      <label for="users">Select Teacher</label>
                    <select style='color:black !important' name="class_teacher_id" class="form-control">
                        <option style='color:black !important' value="">Select Teacher</option>
                    <?php 
            
                    $query = "SELECT * FROM users WHERE user_role = 'teacher' ORDER BY teacher_id DESC";
                    $select_user = mysqli_query($connection, $query);

                    while ($row = mysqli_fetch_assoc($select_user)) {
                    $teacher_id = $row['teacher_id'];
                    $firstname = $row['firstname'];
                
                    echo "<option class='input-modal' style='color:black !important' value='{$teacher_id}'>{$firstname}</option>";

                      }
                
                    ?>
                    </select>
                      </div>
                    </div>
                  </div>
                  <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
        <input type="submit" class="btn btn-primary" name="add_class" value="Add Class">
      </div>
                </form>
      </div>
    </div>
  </div>
</div>

        