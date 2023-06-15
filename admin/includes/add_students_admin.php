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
$avatar_images = glob("assets/img/avatars/*.png");

$success = "";
$message = "";
$message_username = "";
$message_email    = "";
$query = "";
$password = generatePassword();
$unhashedPassword = $password; // Store the unhashed password

$firstname = "";
$lastname  = "";
$email     = "";
$username  = "";
$city      = "";
$state     = "";


if (isset($_POST['add_student'])) {
  $firstname        = $_POST['firstname'];
  $lastname         = $_POST['lastname'];
  $email            = $_POST['email'];
  $username         = str_replace(' ', '', strtolower($_POST['username'])); // convert to lowercase and remove spaces
  $unhashedPassword = $_POST['password']; // Store the unhashed password
  $password         = password_hash($unhashedPassword, PASSWORD_BCRYPT, array('cost' => 12)); // Hash the password
  $city             = $_POST['city'];
  $state            = $_POST['state'];
  $img              = $_POST['img'];

  $_SESSION['form_data'] = array(
    'firstname' => $firstname,
    'lastname' => $lastname,
    'email' => $email,
    'username' => $username,
    'password' => $password,
    'city' => $city,
    'state' => $state,
  );

  if (!empty($username) && !empty($firstname) && !empty($lastname) && !empty($email) && !empty($password)) {


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
      $username  = mysqli_real_escape_string($connection, $username);
      $password  = mysqli_real_escape_string($connection, $password);
      $city      = mysqli_real_escape_string($connection, $city);
      $state     = mysqli_real_escape_string($connection, $state);

      // generate token
    $length = 50;
    $token_e = bin2hex(openssl_random_pseudo_bytes($length));
    $query .= "token = '{$token_e}', ";

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
    $mail->Subject = 'New User Student';
    $mail->Body = 'New account has been created.';

    if (!$mail->send()) {
        echo 'Mailer Error: ' . $mail->ErrorInfo;
    } else {
    }

    $mail->clearAddresses();

    $email = $_POST['email'];
    $mail->addAddress($email);
    $mail->Subject = 'Welcome to XOGOS GAMING';
    $mail->Body = 'Thank you for signing up to XOGOS GAMING. Here are your login credentials. Once logged in, you can change your password in "User Profile". Username: ' . $username . '. Password: ' . $unhashedPassword . ' <a href="https://myxogos.com/includes/verify.php?token=' . $token_e . '">Verify Email</a></p>';

    if (!$mail->send()) {
        echo 'Mailer Error: ' . $mail->ErrorInfo;
    } else {
    }

    $query  = "INSERT INTO users(firstname, lastname, email, username, password, city, state, parent_id, user_role, token) ";
    $query .= "VALUES('{$firstname}', '{$lastname}', '{$email}', '{$username}', '{$password}', '{$city}', '{$state}', RAND()*(999-1)+5, 'student', '{$token_e}'  ) ";

    // execute query
    $register_teacher_query = mysqli_query($connection, $query);
    if(!$register_teacher_query) {
      die("QUERY FAILED" . mysqli_error($connection) . '' . mysqli_errno($connection));
    } else {
      $success = true;
    }

      $data_register_lightning_round = [
        'username' => $username,
        'first_name' => $firstname,
        'last_name' => $lastname,
        'email' => $email,
        'password' => $_POST['password'],
        'password_confirmation' => $_POST['password'],
        'country_id' => 1,
        'parent_id' => $_SESSION['parent_id']
      ];
      $token = register_lighting_round($data_register_lightning_round);

      $query = "UPDATE users SET token_lr='{$token}' WHERE username='{$username}'";
      $update = mysqli_query($connection, $query);

      $message = "";
    }
  }
}
?>


<style>
  label,
  h5,
  input,
  select {
    color: black !important;
  }

  .avatar-images {
    display: flex;
    flex-wrap: wrap;
  }

  .avatar-images label {
    display: flex;
    flex-direction: column;
    align-items: center;
    margin: 0 10px 20px;
    cursor: pointer;
  }

  .avatar-images input[type="radio"] {
    display: none;
  }

  .avatar-images img {
    height: 100px;
    width: 100px;
    border: 2px solid transparent;
    border-radius: 50%;
    transition: border-color 0.2s ease-in-out;
  }

  .avatar-images input[type="radio"]:checked+img {
    border-color: #C153ED;
  }
</style>

<!-- Modal -->
<div class="modal fade" id="exampleModalCenterStudent" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLongTitle">Add Student</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <form method="post" enctype='multipart/form-data' class="needs-validation" novalidate>
        <div class="row">
              <div class="">
                <div class="form-group">
                  <label>Select an avatar:</label>
                  <div class="avatar-images">
                          <label>
                              <input type="radio" name="img" value="">
                              <img src="./assets/img/avatars/avatar_1.png" alt="Avatar Image 1">
                          </label>
                          <label>
                              <input type="radio" name="img" value="">
                              <img src="./assets/img/avatars/avatar_2.png" alt="Avatar Image 2>">
                          </label>
                          <label>
                              <input type="radio" name="img" value="">
                              <img src="./assets/img/avatars/avatar_3.png" alt="Avatar Image 3">
                          </label>
                          <label>
                              <input type="radio" name="img" value="">
                              <img src="./assets/img/avatars/avatar_4.png" alt="Avatar Image 4">
                          </label>
                  </div>
              </div>

              </div>
          </div>

          <div class="row">
              <div class="">
                <div class="form-group">
                  <label>Upload your own avatar:</label>
                  <div class="avatar-images">
                          <label>
                            <input type="file" name="img" value="" id="imageInput" onchange="previewFile(event)">
                            <img id="previewImage" src="./assets/img/avatars/default-avatar.png" alt="Default Avatar Image">
                        </label>
                  </div>
              </div>

              </div>
          </div>
          <div class="form-row">
            <div class="col-md-6 mb-3">
              <label for="validationCustom02">First name</label>
              <input type="text" name="firstname" class="form-control" id="validationCustom02" value="<?php echo $firstname ?>" required>
            </div>
            <div class="col-md-6 mb-3">
              <label for="validationCustom03">Last name</label>
              <input type="text" name="lastname" class="form-control" id="validationCustom03" value="<?php echo $lastname ?>" required>
            </div>
          </div>
          <div class="form-row">
            <div class="col-md-12 mb-3">
              <label for="validationCustom04">Email</label>
              <input type="email" name="email" class="form-control" id="validationCustom04" value="<?php echo $email ?>" required>
              <label class="text-danger" for="validationCustom01"><?php echo $message_email ?></label>
            </div>
          </div>
          <div class="form-row">
            <div class="col-md-8 mb-3">
              <label for="validationCustom05">City</label>
              <input type="text" name="city" class="form-control" id="validationCustom05" value="<?php echo $city ?>" required>
            </div>
            <div class="col-md-4 mb-3">
              <label for="validationCustom06">State</label>
              <select name="state" class="custom-select form-control" id="validationCustom06" value="<?php echo $state ?>" required>
                <option selected disabled value="">Choose...</option>
                <?php

                $query = "SELECT * FROM state ";
                $select_state = mysqli_query($connection, $query);

                while ($row = mysqli_fetch_assoc($select_state)) {
                  $id   = $row['id'];
                  $code = $row['code'];

                  echo "<option value='{$id}'>{$code}</option>";
                }

                ?>
              </select>
            </div>
          </div>
          <h5>Login Information</h5>
          <div class="form-row">
            <div class="col-md-4 mb-3">
              <label for="validationCustom07">Username</label>
              <input type="text" name="username" class="form-control" id="validationCustom07" value="<?php echo $username ?>" required>
              <label class="text-danger" for="validationCustom01"><?php echo $message_username ?></label>
            </div>
            <div class="col-md-4 mb-3">
              <input type="hidden" name="password" class="form-control" id="validationCustom08" value="<?php echo $password; ?>">
            </div>
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
            <button type="submit" name="add_student" class="btn btn-primary">Add Student</button>
          </div>
        </form>
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
    </div>
  </div>
</div>