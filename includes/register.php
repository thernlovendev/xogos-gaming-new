<?php include "header.php" ?>

<?php
//Import PHPMailer classes into the global namespace
//These must be at the top of your script, not inside a function
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

require '../classes/config.php';

require '../vendor/autoload.php';

?>

<?php
$success          = false;
$pass_modal       = false;
$message          = "";
$message_username = "";
$message_email    = "";

$firstname = "";
$lastname  = "";
$email     = "";
$phone     = "";
$username  = "";
$address   = "";
$city      = "";
$state     = "";
$zip       = "";
$img       = "";

session_start(); // Start the session

if (isset($_POST['add_user'])) {
  $firstname       = $_POST['firstname'];
  $lastname        = $_POST['lastname'];
  $email           = $_POST['email'];
  $phone           = $_POST['phone'];
  $username        = str_replace(' ', '', strtolower($_POST['username'])); // convert to lowercase and remove spaces
  $password        = $_POST['password'];
  $repeat_password = $_POST['repeat_password'];
  $address         = $_POST['address'];
  $city            = $_POST['city'];
  $state           = $_POST['state'];
  $zip             = $_POST['zip'];

  $img      = $_FILES['img']['name'];
  $img_temp = $_FILES['img']['tmp_name'];

    move_uploaded_file($img_temp, "../admin/assets/img/avatars/$img");

  $_SESSION['form_data'] = array(
    'firstname' => $firstname,
    'lastname' => $lastname,
    'email' => $email,
    'phone' => $phone,
    'username' => $username,
    'address' => $address,
    'city' => $city,
    'state' => $state,
    'zip' => $zip,
    'img' => $img
  );

  if (!empty($username) && !empty($firstname) && !empty($lastname) && !empty($email) && !empty($password) && !empty($repeat_password)) {

    // check if passwords match
    if ($password !== $repeat_password) {
      $message = "Passwords do not match";
    } else {

      // check password strength
      if (!check_password_strength($password)) {
        $pass_modal = true;
      } else {

        // check if username and email already exist
        $query = "SELECT * FROM users WHERE username = '$username' OR email = '$email'";
        $result = mysqli_query($connection, $query);

        if (mysqli_num_rows($result) > 0) {
          $row = mysqli_fetch_assoc($result);
          if ($row['username'] == $username) {
            $message_username = "Username already exists";
          } else {
            $message_email = "Email already exists";
          }
        } else {

        // sanitize inputs
        $firstname = mysqli_real_escape_string($connection, $firstname);
        $lastname  = mysqli_real_escape_string($connection, $lastname);
        $email     = mysqli_real_escape_string($connection, $email);
        $phone     = mysqli_real_escape_string($connection, $phone);
        $username  = mysqli_real_escape_string($connection, $username);
        $password  = mysqli_real_escape_string($connection, $password);
        $address   = mysqli_real_escape_string($connection, $address);
        $city      = mysqli_real_escape_string($connection, $city);
        $state     = mysqli_real_escape_string($connection, $state);
        $zip       = mysqli_real_escape_string($connection, $zip);

        // hash password
        $password = password_hash($password, PASSWORD_BCRYPT, array('cost' => 12));

        // generate random values for parent_id, teacher_id, and admin_id columns
        $parent_id  = rand(1, 999);
        $teacher_id = rand(1, 999);
        $admin_id   = rand(1, 999);

        // generate token
        $length = 50;
        $token = bin2hex(openssl_random_pseudo_bytes($length));
        $query .= "token = '{$token}', ";

        // Send email notification using PHPMailer
        $mail = new PHPMailer;
        $mail->isSMTP();
        $mail->Host = Config::SMTP_HOST;
        $mail->Username = Config::SMTP_USER;
        $mail->Password = Config::SMTP_PASSWORD;
        $mail->Port = Config::SMTP_PORT;
        $mail->SMTPSecure = 'tls';
        $mail->SMTPAuth = true;
        $mail->isHTML(true);
        $mail->CharSet = 'UTF-8';

        $mail->setFrom('noreply.xogos@gmail.com', 'XOGOS GAMING');
        $mail->addAddress('noreply.xogos@gmail.com');

        $mail->Subject = 'New User Parent';
        $mail->Body = 'New account has been created.';

        // Send the email to the admin
        if (!$mail->send()) {
            echo 'Mailer Error: ' . $mail->ErrorInfo;
        } else {
        }

        // Clear the recipients before sending the second email
        $mail->clearAddresses();

        // Set the recipient and email content for the user
        $email = $_POST['email'];
        $mail->addAddress($email);
        $mail->Subject = 'Welcome to XOGOS GAMING';
        $mail->Body = 'Thank you for signing up to XOGOS GAMING. To continue adding your kids, please click the following link to verify your email: <a href=' . $DOMAIN . 'includes/verify.php?token=' . $token . '">Verify Email</a></p>';

        // Send the email to the user
        if (!$mail->send()) {
            echo 'Mailer Error: ' . $mail->ErrorInfo;
        } else {
        }

        // build SQL query
        $query  = "INSERT INTO users(img, firstname, lastname, email, phone, username, password, address, city, state, zip, user_role, parent_id, teacher_id, admin_id, token) ";
        $query .= "VALUES('{$img}', '{$firstname}', '{$lastname}', '{$email}', '{$phone}', '{$username}', '{$password}','{$address}', '{$city}', '{$state}', '{$zip}', 'parent', '{$parent_id}', '{$teacher_id}', '{$admin_id}', '{$token}') ";

        // execute query
        $register_parent_query = mysqli_query($connection, $query);

        if (!$register_parent_query) {
          die("QUERY FAILED" . mysqli_error($connection) . '' . mysqli_errno($connection));
        } else {
          $success = true;
          unset($_SESSION['form_data']); // Remove the form data from the session upon successful submission
        }
      }
    }
    }
  }
}
?>





<style>
  body {
    background-color: #1E1E2E;
    font-family: "Poppins";
    color:white;
  }

  h3, h5 {
    font-weight: 300 !important;
  }

  input {
    background-color: #27293D !important;
    border: 1px solid #C153ED !important;
    color: white !important;
  }

  label {
    color: #e5e5e5 !important;
  }

  .form-label {
    margin-top:0.5rem !important;
  }

</style>

<section class="vh-100 gradient-custom">
  <div class="container py-5 h-100">
    <div class="row justify-content-center align-items-center h-100">
      <div class="col-12 col-lg-9 col-xl-7" style="padding-bottom: 50px;">
        <div class="card shadow-5-strong card-registration" style="border-radius: 15px; border:solid 1px; border-color: #C153ED; background-color: #27293D">
          <div class="card-body p-4 p-md-5">
            <h3 class="mb-4 pb-2 pb-md-0 mb-md-5">Register</h3>
            <h5 class="mb-4 pb-2 pb-md-0 mb-md-5">Personal Information</h5>
            <form method="post" class="needs-validation" novalidate enctype="multipart/form-data">
            <div class="form-row">
              <div class="col-md-4 pr-md-1">
                <div class="form-group">
                  <img id="previewImage" style="height: 100px; width: 100px" class="avatar border-gray" src="../admin/assets/img/avatars/default-avatar.png" alt='..'>
                  <input type="file" class="form-control" name="img" id="imageInput" value="<?php echo $img ?>" onchange="previewFile(event)">
                  <br>
                  <label for="imageInput">Select the photo to add or update</label>
                </div>
              </div>
            </div>
              <div class="form-row">
                <div class="col-md-6 mb-3">
                  <label for="validationCustom01">First name</label>
                  <input type="text" name="firstname" class="form-control" id="validationCustom01" value="<?php echo $firstname ?>" required>
                </div>
                <div class="col-md-6 mb-3">
                  <label for="validationCustom02">Last name</label>
                  <input type="text" name="lastname" class="form-control" id="validationCustom02" value="<?php echo $lastname ?>" required>
                </div>
              </div>
              <div class="form-row">
                <div class="col-md-6 mb-3">
                  <label for="validationCustom01">Email</label>
                  <input type="email" name="email" class="form-control" id="validationCustom01" value="<?php echo $email ?>" required>
                  <label class="text-danger" for="validationCustom01"><?php echo $message_email ?></label>
                </div>
                <div class="col-md-6 mb-3">
                  <label for="validationCustom02">Phone Number</label>
                  <input type="text" name="phone" class="form-control" id="validationCustom02" value="<?php echo $phone ?>" required>
                </div>
              </div>
              <div class="form-row">
                <div class="col-md-12 mb-3">
                  <label for="validationCustom01">Address</label>
                  <input type="text" name="address" class="form-control" id="validationCustom01" value="<?php echo $address ?>" required>
                </div>
              </div>
              <div class="form-row">
                <div class="col-md-6 mb-3">
                  <label for="validationCustom03">City</label>
                  <input type="text" name="city" class="form-control" id="validationCustom03" value="<?php echo $city ?>" required>
                </div>
                <div class="col-md-3 mb-3">
                  <label for="validationCustom04">State</label>
                  <select name="state" class="custom-select form-control" id="validationCustom04" value="<?php echo $state ?>" required>
                    <option selected disabled value="">Choose...</option>
                  <?php 
                                    
                  $query = "SELECT * FROM state ";
                  $select_state = mysqli_query($connection, $query);

                  while ($row = mysqli_fetch_assoc($select_state)) {
                  $id   = $row['id'];
                  $name = $row['name'];

                  echo "<option>$name</option>";

                  }

                  ?>
                  </select>
                </div>
                <div class="col-md-3 mb-3">
                  <label for="validationCustom05">Zip</label>
                  <input type="text" name="zip" class="form-control" id="validationCustom05" value="<?php echo $zip ?>" required>
                </div>
              </div>
              <h5 class="mb-4 pb-2 pb-md-0 mb-md-5">Login Information</h5>
              <div class="form-row">
                <div class="col-md-4 mb-3">
                  <label for="validationCustom01">Username</label>
                  <input type="text" name="username" class="form-control" id="validationCustom01" value="<?php echo $username ?>" required>
                  <label class="text-danger" for="validationCustom01"><?php echo $message_username ?></label>
                </div>
                <div class="col-md-4 mb-3">
                  <label for="validationCustom02">Password</label>
                  <input type="password" name="password" class="form-control" id="validationCustom02" required>
                </div>
                <div class="col-md-4 mb-3">
                  <label for="validationCustom02">Repeat Password</label>
                  <input type="password" name="repeat_password" class="form-control" id="validationCustom02" required>
                  <label class="text-danger" for="validationCustom02"><?php echo $message ?></label>
                </div>
              </div>
              <input style="background: rgb(223,78,204);
                background: linear-gradient(90deg, rgba(223,78,204,1) 0%, rgba(223,78,204,1) 35%, rgba(192,83,237,1) 62%); border:none;" class="btn btn-primary btn" type="submit" name="add_user" value="Register">
                <div class="row">
                <div class="ml-auto mr-auto" style="margin-top: 0.5rem";>
                  <a href="login.php">Or Login</a>
                </div>
              </div>
            </form>

            <?php include "success_modal.php" ?>
            <?php include "pass_modal.php" ?>



            <script>
            // Example starter JavaScript for disabling form submissions if there are invalid fields
            (function() {
              'use strict';
              window.addEventListener('load', function() {
                // Fetch all the forms we want to apply custom Bootstrap validation styles to
                var forms = document.getElementsByClassName('needs-validation');
                // Loop over them and prevent submission
                var validation = Array.prototype.filter.call(forms, function(form) {
                  form.addEventListener('submit', function(event) {
                    if (form.checkValidity() === false) {
                      event.preventDefault();
                      event.stopPropagation();
                    }
                    form.classList.add('was-validated');
                  }, false);
                });
              }, false);
            })();
            </script>
          </div>
          <?php include "footer.php" ?>

        </div>
      </div>
    </div>
  </div>
</section>


