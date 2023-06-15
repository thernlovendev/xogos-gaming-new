<?php

if(isset($_POST['add_class'])) {
  
    $class_teacher_id = escape($_POST['class_teacher_id']);
    $class_subject	  = escape($_POST['class_subject']);

    $query = "INSERT INTO classes(class_teacher_id, class_subject) ";
    $query .= "VALUES('{$_SESSION['teacher_id']}', '{$class_subject}') ";

    $add_class_query = mysqli_query($connection, $query);

    if(!$add_class_query) {
      die("QUERY FAILED" . mysqli_error($connection));
  }

  header('Location: my_classes.php');
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
<div class="modal fade" id="newClass" tabindex="-1" role="dialog" aria-labelledby="newClass" aria-hidden="true">
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
                    <input type="hidden" name="class_teacher_id" id="class_teacher_id" value="">
                      <div class="form-group">
                        <label>Class Name</label>
                        <input type="text" class="form-control" placeholder="Class Name" name="class_subject" style="color:black !important;">
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

        