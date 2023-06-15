<?php users_online();?>

<div class="col-lg-4">
            <div class="card card-chart">
              <div class="card-header">
                <h5 class="card-category">Start Chatting</h5>
                <h3 class="card-title"><i class="tim-icons icon-chat-33 text-info"></i>Friends Online</h3>
              </div>
              <div class="card-body">
                <div class="chart-area">
                  <div class="row">

                  <?php if(is_parent()): ?>

                  <?php 
                 
                        $query = "SELECT * FROM users_online WHERE online_student_id =".loggedInUserIdParent()."";
                        $select_students = mysqli_query($connection, $query);
          

                          while ($row = mysqli_fetch_assoc($select_students)) {
                          $online_id        = $row['online_id'];
                          $online_firstname = $row['online_firstname'];
                          $online_img       = $row['online_img'];
                      
                      echo "<div class='col-lg-4 col-md-4 col-sm-4 col-4 text-center'>
                          <a href='./chat.php'>
                          <img style='border-radius:100%; border: 2px solid #74FFBA; height:80px' src='assets/img/avatars/$online_img' alt=''>
                          </a>
                          <h5>$online_firstname</h5>
                      </div>";
                  }
                  ?>

                <?php endif ?>

                <?php if(is_student()): ?>

                  <?php
                    $query = "SELECT * FROM users_online WHERE (online_parent_id = ? AND online_teacher_id = ?) OR online_parent_id = ?";
                    $stmt = mysqli_prepare($connection, $query);
                    mysqli_stmt_bind_param($stmt, "iii", $_SESSION['student_id'], $_SESSION['t_student_id'], $_SESSION['student_id']);
                    mysqli_stmt_execute($stmt);
                    $result = mysqli_stmt_get_result($stmt);

                    while ($row = mysqli_fetch_assoc($result)) {
                        $online_id = $row['online_id'];
                        $online_firstname = $row['online_firstname'];
                        $online_img = $row['online_img'];

                        echo "<div class='col-lg-4 col-md-4 col-sm-4 col-4 text-center'>
                                  <a href='./chat.php'>
                                  <img style='border-radius:100%; border: 2px solid #74FFBA; height:80px' src='assets/img/avatars/$online_img' alt=''>
                                  </a>
                                  <h5>$online_firstname</h5>
                              </div>";
                    }
                    ?>



                <?php endif ?>

                  </div>
                </div>
              </div>
            </div>
          </div>