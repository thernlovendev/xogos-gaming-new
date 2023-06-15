<?php include "includes/sidebar.php" ?>
<?php include "includes/navbar.php"; ?>
<div class="content">
  <div class="row">
    <div class="col-md-12">
      <div class="card ">
        <div class="card-header">
          <h4 class="card-title"> All Classes</h4>
          <?php include "add_classes_admin.php" ?>
          <div class="form-group">
            <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#adminNewClass">Add Class</button>
          </div>
        </div>
        <div class="card-body">
          <div class="table-responsive">
            <table class="table tablesorter">
              <thead class="text-primary">
                <tr>
                  <th>Id</th>
                  <th>Name</th>
                  <th>Attendees</th>
                  <th class="text-right">Edit</th>
                </tr>
              </thead>
              <tbody>

                <?php 
                $query = "SELECT classes.class_id, classes.class_subject, COUNT(enrollments.student_id) as attendees 
                          FROM classes 
                          LEFT JOIN enrollments ON classes.class_id = enrollments.class_id 
                          GROUP BY classes.class_id, classes.class_subject 
                          ORDER BY classes.class_subject DESC";

                $select_class = mysqli_query($connection, $query);
                
                while ($row = mysqli_fetch_assoc($select_class)) {
                  $class_id      = $row['class_id'];
                  $class_subject = $row['class_subject'];
                  $attendees     = $row['attendees'];

                  echo "<tr>";
                  echo "<td>$class_id</td>";
                  echo "<td>$class_subject</td>";
                  echo "<td>$attendees</td>";
                  echo "<td class='text-right'><a href='classes.php?source=edit_class_admin&edit_class_admin={$class_id}'>Edit</a></td>";  
                  echo "</tr>";
                }
                        
                ?>
              </tbody>
            </table>

            <?php 
            if(isset($_GET['delete'])) {
              $class_id = $_GET['delete'];

              $query = "DELETE FROM classes WHERE class_id = {$class_id}";
              $delete_query = mysqli_query($connection, $query);
              update_kids_count();
              update_kids_count_byteacher();
              header("Location: classes.php");
            }
            ?>

          </div>
        </div>
      </div>
    </div>
  </div>
</div>
