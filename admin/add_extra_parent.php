<?php include "includes/header.php" ?>
<?php include "includes/sidebar.php" ?>
<?php include "includes/navbar.php" ?>

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
$phone     = "";
$username  = "";
$address   = "";
$city      = "";
$state     = "";
$zip       = "";

if(isset($_POST['add_parent'])) {

  $firstname       = $_POST['firstname'];
  $lastname        = $_POST['lastname'];
  $email           = $_POST['email'];
  $phone           = $_POST['phone'];
  $username        = str_replace(' ', '', strtolower($_POST['username'])); // convert to lowercase and remove spaces
  $unhashedPassword = $_POST['password']; // Store the unhashed password
  $password        = password_hash($unhashedPassword, PASSWORD_BCRYPT, array('cost' => 12)); // Hash the password
  $address         = $_POST['address'];
  $city            = $_POST['city'];
  $state           = $_POST['state'];
  $zip             = $_POST['zip'];

  $_SESSION['form_data'] = array(
    'firstname' => $firstname,
    'lastname' => $lastname,
    'email' => $email,
    'username' => $username,
    'password' => $password,
    'city' => $city,
    'state' => $state,
  );


  if(!empty($username) && !empty($firstname) && !empty($lastname) && !empty($email) && !empty($password) ) {

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
    $mail->Subject = 'New User Extra Parent';
    $mail->Body = 'New account has been created.';

    if (!$mail->send()) {
        echo 'Mailer Error: ' . $mail->ErrorInfo;
    } else {
    }

    $mail->clearAddresses();

    $email = $_POST['email'];
    $mail->addAddress($email);
    $mail->Subject = 'Welcome to XOGOS GAMING';
    $mail->Body = 'Thank you for signing up to XOGOS GAMING. Here are your login credentials. Once logged in, you can change your password in "User Profile". Username: ' . $username . '. Password: ' . $unhashedPassword . ' <a href="https://myxogos.com/includes/verify.php?token=' . $token . '">Verify Email</a></p>';

    if (!$mail->send()) {
        echo 'Mailer Error: ' . $mail->ErrorInfo;
    } else {
    }
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
    $mail->Body = 'Thank you for signing up to XOGOS GAMING. Here are your login credentials. Once logged in, you can change your password in "User Profile". Username: ' . $username . '. Password: ' . $unhashedPassword . ' <a href="https://myxogos.com/includes/verify.php?token=' . $token . '">Verify Email</a></p>';

    if (!$mail->send()) {
        echo 'Mailer Error: ' . $mail->ErrorInfo;
    } else {
    }

    $query  = "INSERT INTO users(firstname, lastname, email, username, password, address, city, state, zip, parent_id, user_role, token) ";
    $query .= "VALUES('{$firstname}', '{$lastname}', '{$email}', '{$username}', '{$password}', '{$address}', '{$city}', '{$state}', '{$zip}', '{$_SESSION['parent_id']}', 'parent', '{$token}'  ) ";

    // execute query
    $register_teacher_query = mysqli_query($connection, $query);
    if(!$register_teacher_query) {
      die("QUERY FAILED" . mysqli_error($connection) . '' . mysqli_errno($connection));
    } else {
      $success = true;
    }

    if(!$register_teacher_query) {
        die("QUERY FAILED" . mysqli_error($connection) . '' . mysqli_errno($connection));
    }
    update_kids_count();
    update_kids_count_byteacher();
    $message = "Your registration was successful";

  }
}

  }


?>

 <!-- End Navbar -->
 <div class="content">
        <div class="row">
          <div class="col-md-12">
            <div class="card">
              <div class="card-header">
                <h5 class="title">Add Extra Parent</h5>
                <h3 class="text-center" style="color:green";> <?php echo $message ?> </h3>
              </div>
              <div class="card-body">
                  <!-- ----------------- -->
                  <form method="post" enctype='multipart/form-data' class="needs-validation" novalidate>       
              <div class="form-row">
                <div class="col-md-6 mb-3">
                  <label for="validationCustom01">First name</label>
                  <input type="text" name="firstname" class="form-control" id="validationCustom01" value="<?php echo $firstname; ?>" required>
                </div>
                <div class="col-md-6 mb-3">
                  <label for="validationCustom02">Last name</label>
                  <input type="text" name="lastname" class="form-control" id="validationCustom02" value="<?php echo $lastname; ?>" required>
                </div>
              </div>
              <div class="form-row">
                <div class="col-md-6 mb-3">
                  <label for="validationCustom01">Email</label>
                  <input type="email" name="email" class="form-control" id="validationCustom01" value="<?php echo $email; ?>" required>
                </div>
                <div class="col-md-6 mb-3">
                  <label for="validationCustom01">Phone Number</label>
                  <input type="text" name="phone" class="form-control" id="validationCustom01" value="<?php echo $phone; ?>" required>
                </div>
              </div>
              <div class="form-row">
                <div class="col-md-12 mb-3">
                  <label for="validationCustom01">Address</label>
                  <input type="text" name="address" class="form-control" id="validationCustom01" value="<?php echo $address; ?>" required>
                </div>
              </div>
              <div class="form-row">
                <div class="col-md-4 mb-3">
                  <label for="validationCustom01">City</label>
                  <input type="text" name="city" class="form-control" id="validationCustom01" value="<?php echo $city; ?>" required>
                </div>
                <div class="col-md-4 mb-3">
                  <label for="validationCustom01">ZIP</label>
                  <input type="text" name="zip" class="form-control" id="validationCustom01" value="<?php echo $zip; ?>" required>
                </div>
                <div class="col-md-4 mb-3">
                  <label for="validationCustom04">State</label>
                  <select name="state" class="custom-select form-control" id="exampleFormControlSelect1" value="<?php echo $state; ?>" required>
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
                <div class="col-md-4 mb-3">
                  <label for="validationCustom01">Username</label>
                  <input type="text" name="username" class="form-control" id="validationCustom01" value="<?php echo $username; ?>">
                </div>
                <div class="col-md-4 mb-3">
                  <input type="hidden" name="password" class="form-control" id="validationCustom02" value="<?php echo $password; ?>" required>
                </div>
                </div>
              <input style="background: rgb(223,78,204);
                background: linear-gradient(90deg, rgba(223,78,204,1) 0%, rgba(223,78,204,1) 35%, rgba(192,83,237,1) 62%); border:none;" class="btn btn-primary btn" type="submit" name="add_parent" value="Add Parent">
            </form>
              </div>
            </div>
          </div>
        </div>

      <?php include "includes/footer.php" ?>
      

