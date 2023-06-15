<?php include "includes/sidebar.php" ?>
<?php include "includes/navbar.php" ?>


<?php

if(isset($_GET['edit_student'])) {

    $the_user_id = $_GET['edit_student'];

    $query = "SELECT * FROM users WHERE user_id = '{$the_user_id}' ";
    $select_user_profile_query = mysqli_query($connection, $query);

    while($row = mysqli_fetch_assoc($select_user_profile_query)) {

      $user_id      = $row['user_id'];
      $student_id   = $row['student_id'];
      $t_student_id = $row['t_student_id'];
      $firstname    = $row['firstname'];
      $lastname     = $row['lastname'];
      $img          = $row['img'];
      $email        = $row['email'];
      $username     = $row['username'];
      $password     = $row['password'];
      $city         = $row['city'];
      $state        = $row['state'];
      $verified     = $row['verified'];
      $active       = $row['active'];


    }
   
}

if(isset($_POST['edit_student'])) {
    
  $student_id   = escape($_POST['student_id']);
  $t_student_id = escape($_POST['t_student_id']);


  $firstname = escape($_POST['firstname']);
  $lastname  = escape($_POST['lastname']);
  $email     = escape($_POST['email']);
  $username  = escape($_POST['username']);
  $password  = escape($_POST['password']);
  $city      = escape($_POST['city']);
  $state     = escape($_POST['state']);
  $verified  = escape($_POST['verified']);
  $active    = escape($_POST['active']);

  $img      = $_FILES['img']['name'];
  $img_temp = $_FILES['img']['tmp_name'];

 
  move_uploaded_file($img_temp, "./assets/img/avatars/$img");


    if(empty($img)) {
        
        $query = "SELECT * FROM users WHERE user_id = '{$user_id}' ";
        $select_image = mysqli_query($connection,$query);
            
        while($row = mysqli_fetch_array($select_image)) {
            
          $img = $row['img'];
        
        }
        
        
}

if (!empty($password)) {
  $query_password = "SELECT password FROM users WHERE user_id = '{$the_user_id}' ";
  $get_user_query = mysqli_query($connection, $query_password);
  confirmQuery($get_user_query);

  $row = mysqli_fetch_array($get_user_query);
  $db_password = $row['password'];

  if ($db_password != $password) {
    $hashed_password = password_hash($password, PASSWORD_BCRYPT, array('cost' => 12));
  } else {
    $hashed_password = $password; // Use the existing hashed password if it hasn't changed
  }

  $query = "UPDATE users SET ";
  $query .= "student_id     = '{$student_id}', ";
  $query .= "t_student_id   = '{$t_student_id}', ";
  $query .= "firstname      = '{$firstname}', ";
  $query .= "lastname       = '{$lastname}', ";
  $query .= "lastname       = '{$lastname}', ";
  $query .= "img            = '{$img}', ";
  $query .= "email          = '{$email}', ";
  $query .= "username       = '{$username}', ";
  $query .= "password       = '{$hashed_password}', "; // Use hashed_password instead of password
  $query .= "city           = '{$city}', ";
  $query .= "state          = '{$state}', ";
  $query .= "verified       = '{$verified}', ";
  $query .= "active         = '{$active}' ";
  $query .= "WHERE user_id  = '{$the_user_id}' ";

  $edit_user_query = mysqli_query($connection, $query);
  $data_array = [
    'email' => $email,
    'first_name'=>$firstname,
    'last_name'=>$lastname,
    'password'=>$password,
    'username'=>$username,
  ];
  editInfoLightingRound($data_array);
  confirm($edit_user_query);
  update_kids_count();
  update_kids_count_byteacher();
  
  $message = "Profile Updated!";

  header("refresh:2;url=".$_SERVER['REQUEST_URI']);
}


      } else {

        $message = "";

        } 

       




?>

      <!-- End Navbar -->
      <div class="content">
        <div class="row">
          <div class="col-md-12">
            <div class="card">
              <div class="card-header">
                <h5 class="title">Edit Profile</h5>
                <h3 class="text-center" style="color:green";> <?php echo $message ?> </h3>
              </div>
              <div class="card-body">
                <!-- ADD PARENT MODAL -->
                
                  <!-- ----------------- -->
                  <form action="" method="post" enctype="multipart/form-data">
                  <div class="row">
                    <div class="col-md-6">
                      <div class="form-group">
                        <img id="previewImage" style="height:100px; width:100px" class="avatar border-gray" src="./assets/img/avatars/<?php echo $img;?>" alt='..'>
                        <input type="file" name="img" value="<?php echo $img ?>" id="imageInput" onchange="previewFile(event)">
                      </div>
                    </div>
                  </div>
                  <div class="row">
                    <div class="col-md-2">
                      <div class="form-group">
                      <label>Student Id <i class="fas fa-info-circle" data-toggle="tooltip" data-placement="right" title="Unique ID for user"></i></label>
                        <input type="text" class="form-control" placeholder="User ID" name="user" value="<?php echo $user_id; ?>" readonly>
                      </div>
                    </div>
                    <?php if(is_admin()): ?>
                    <div class="col-md-2">
                      <div class="form-group">
                      <label>Student Id <i class="fas fa-info-circle" data-toggle="tooltip" data-placement="right" title="Match it with Parent ID"></i></label>
                        <input type="text" class="form-control" placeholder="Student ID" name="student_id" value="<?php echo $student_id; ?>">
                      </div>
                    </div>
                    <div class="col-md-2">
                      <div class="form-group">
                      <label>Teacher Id <i class="fas fa-info-circle" data-toggle="tooltip" data-placement="right" title="Match it with Teacher ID"></i></label>
                        <input type="text" class="form-control" placeholder="Teacher ID" name="t_student_id" value="<?php echo $t_student_id; ?>">
                      </div>
                    </div>
                    <div class="col-md-2">
                      <div class="form-group">
                          <label for="users">Verified</label>
                          <select name="verified" class="form-control" id="">
                              <?php if ($verified === 'yes') {

                                echo "<option value='yes'>yes</option>" ;
                                echo "<option value='no'>no</option>";  

                              } elseif ($verified === 'no') {

                                echo "<option value='no'>no</option>";
                                echo "<option value='yes'>yes</option>";

                              }
                                
                                
                                ?>
                          </select>
                      </div>
                  </div>
                  <div class="col-md-2">
                      <div class="form-group">
                          <label for="users">Activate / Deactivate</label>
                          <select name="active" class="form-control" id="">
                              <?php if ($active === 'yes') {

                                echo "<option value='yes'>Active</option>" ;
                                echo "<option value='no'>Deactive</option>";  

                              } elseif ($active === 'no') {

                                echo "<option value='no'>Deactive</option>";
                                echo "<option value='yes'>Active</option>";

                              }
                                
                                
                                ?>
                          </select>
                      </div>
                  </div>
                    <?php endif ?>
                  </div>
                  <div class="row">
                    <div class="col-md-6">
                      <div class="form-group">
                        <label>First Name</label>
                        <input type="text" class="form-control" placeholder="First Name" name="firstname" value="<?php echo $firstname; ?>">
                      </div>
                    </div>
                    <div class="col-md-6">
                      <div class="form-group">
                        <label>Last Name</label>
                        <input type="text" class="form-control" placeholder="Last Name" name="lastname" value="<?php echo $lastname; ?>">
                      </div>
                    </div>
                  </div>
                  <div class="row">
                    <div class="col-md-6">
                      <div class="form-group">
                        <label>City</label>
                        <input type="text" class="form-control" placeholder="City" name="city" value="<?php echo $city; ?>">
                      </div>
                    </div>
                    <div class="col-md-6 mb-3">
                  <label for="validationCustom04">State</label>
                  <select name="state" class="custom-select form-control" id="exampleFormControlSelect1" required>
                    <option selected disabled value="">Choose...</option>
                    <?php 
                                $query = "SELECT * FROM state ";
                                $select_state = mysqli_query($connection, $query);

                                while ($row = mysqli_fetch_assoc($select_state)) {
                                    $id   = $row['id'];
                                    $name = $row['name'];

                                    if ($id === $state) {
                                        $selected = 'selected';
                                    } else {
                                        $selected = '';
                                    }

                                    echo "<option $selected value='{$id}'>{$name}</option>";
                                }
                            ?>
                  </select>
                </div>
                  </div>
                  <h5 class="mb-4 pb-2 pb-md-0 mb-md-5">Login Information</h5>
                  <div class="row">
                    <div class="col-md-4">
                      <div class="form-group">
                        <label>Username</label>
                        <input type="text" class="form-control" placeholder="Username" name="username" value="<?php echo $username; ?>" readonly>
                      </div>
                    </div>
                    <div class="col-md-4">
                      <div class="form-group">
                        <label>Password</label>
                        <input type="password" class="form-control" placeholder="Password" name="password" value="<?php echo $password; ?>">
                      </div>
                    </div>
                    <div class="col-md-4">
                      <div class="form-group">
                        <label>Email</label>
                        <input type="email" class="form-control" placeholder="Email" name="email" value="<?php echo $email; ?>">
                      </div>
                    </div>
                  </div>
                  <div class="form-group">
                    <input type="submit" class="btn btn-primary" name="edit_student" value="Update Profile">
                  </div>
                </form>
              </div>
            </div>
          </div>
        </div>