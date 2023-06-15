<?php include "includes/sidebar.php" ?>
<?php include "includes/navbar.php" ?>


<?php

if(isset($_GET['edit_teacher'])) {

    $the_user_id = $_GET['edit_teacher'];

    $query = "SELECT * FROM users WHERE user_id = '{$the_user_id}' ";
    $select_user_profile_query = mysqli_query($connection, $query);

    while($row = mysqli_fetch_assoc($select_user_profile_query)) {

      $user_id    = $row['user_id'];
      $teacher_id = $row['teacher_id'];
      $firstname  = $row['firstname'];
      $lastname   = $row['lastname'];
      $img        = $row['img'];
      $email      = $row['email'];
      $phone      = $row['phone'];
      $username   = $row['username'];
      $password   = $row['password'];
      $address    = $row['address'];
      $city       = $row['city'];
      $state      = $row['state'];
      $zip        = $row['zip'];
      $verified   = $row['verified'];
      $active     = $row['active'];


    }
   
}

if(isset($_POST['edit_teacher'])) {
    
  $teacher_id = escape($_POST['teacher_id']);

  $firstname = escape($_POST['firstname']);
  $lastname  = escape($_POST['lastname']);
  $email     = escape($_POST['email']);
  $phone     = escape($_POST['phone']);
  $username  = escape($_POST['username']);
  $password  = escape($_POST['password']);
  $address   = escape($_POST['address']);
  $city      = escape($_POST['city']);
  $state     = escape($_POST['state']);
  $zip       = escape($_POST['zip']);
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
  $query .= "firstname      = '{$firstname}', ";
  $query .= "lastname       = '{$lastname}', ";
  $query .= "lastname       = '{$lastname}', ";
  $query .= "img            = '{$img}', ";
  $query .= "email          = '{$email}', ";
  $query .= "phone          = '{$phone}', ";
  $query .= "username       = '{$username}', ";
  $query .= "password       = '{$hashed_password}', "; // Use hashed_password instead of password
  $query .= "address        = '{$address}', ";
  $query .= "city           = '{$city}', ";
  $query .= "state          = '{$state}', ";
  $query .= "zip            = '{$zip}', ";
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
                      <label>User Id <i class="fas fa-info-circle" data-toggle="tooltip" data-placement="right" title="Match it with Parent ID"></i></label>
                        <input type="text" class="form-control" placeholder="Username" name="user_id" value="<?php echo $user_id; ?>" readonly>
                      </div>
                    </div>
                    <div class="col-md-2">
                      <div class="form-group">
                      <label>Teacher Id <i class="fas fa-info-circle" data-toggle="tooltip" data-placement="right" title="ID used to match with respective students"></i></label>
                        <input type="text" class="form-control" placeholder="Username" name="teacher_id" value="<?php echo $teacher_id; ?>" readonly>
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
                  </div>
                  <div class="row">
                    <div class="col-md-6">
                      <div class="form-group">
                        <label>First Name</label>
                        <input type="text" class="form-control" placeholder="First Name" name="firstname" value="<?php echo $firstname; ?>" required>
                      </div>
                    </div>
                    <div class="col-md-6">
                      <div class="form-group">
                        <label>Last Name</label>
                        <input type="text" class="form-control" placeholder="Last Name" name="lastname" value="<?php echo $lastname; ?>" required>
                      </div>
                    </div>
                  </div>
                  <div class="row">
                    <div class="col-md-6">
                      <div class="form-group">
                        <label>Email</label>
                        <input type="email" class="form-control" placeholder="Email" name="email" value="<?php echo $email; ?>" required>
                      </div>
                    </div>
                    <div class="col-md-6">
                      <div class="form-group">
                        <label>Phone Number</label>
                        <input type="text" class="form-control" placeholder="Number" name="phone" value="<?php echo $phone; ?>" required>
                      </div>
                    </div>
                  </div>
                  <div class="row">
                    <div class="col-md-12">
                      <div class="form-group">
                        <label>Address</label>
                        <input type="text" class="form-control" placeholder="Address" name="address" value="<?php echo $address; ?>" required>
                      </div>
                    </div>
                  </div>
                  <div class="row">
                    <div class="col-md-4">
                      <div class="form-group">
                        <label>City</label>
                        <input type="text" class="form-control" placeholder="City" name="city" value="<?php echo $city; ?>" required>
                      </div>
                    </div>
                    <div class="col-md-4">
                      <div class="form-group">
                        <label>Postal Code</label>
                        <input type="number" class="form-control" placeholder="ZIP Code" name="zip" value="<?php echo $zip; ?>" required>
                      </div>
                    </div>
                    <div class="col-md-4 mb-3">
                  <label for="validationCustom04">State</label>
                  <select name="state" class="custom-select form-control" id="exampleFormControlSelect1" required>
                    <option selected value=""><?php echo $state; ?></option>
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
                    <div class="form-row">
                    <div class="col-md-3">
                      <div class="form-group">
                        <label>Username</label>
                        <input type="text" class="form-control" placeholder="Username" name="username" value="<?php echo $username; ?>" readonly>
                      </div>
                    </div>
                    <div class="col-md-3">
                      <div class="form-group">
                        <label>Password</label>
                        <input type="password" class="form-control" placeholder="Password" name="password" value="<?php echo $password; ?>" required>
                      </div>
                    </div>
                  </div>
                    <input type="submit" class="btn btn-primary" name="edit_teacher" value="Update Profile">
                </form>
              </div>
            </div>
          </div>
        </div>