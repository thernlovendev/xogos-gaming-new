<?php include "includes/header.php" ?>
<?php include "includes/sidebar.php" ?>
<?php include "includes/navbar.php" ?>

<?php
    $message = "";
    $query = "";

// Import PHPMailer classes into the global namespace
// These must be at the top of your script, not inside a function
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

require '../classes/config.php';
require '../vendor/autoload.php';

if (isset($_POST['send'])) {
    // Retrieve the textarea value
    $issueDescription = $_POST['issue_description'];

    // Generate token
    $length = 5;
    $token = bin2hex(openssl_random_pseudo_bytes($length));
    $query .= "token = '{$token}', ";

    // Send email notification using PHPMailer
    $mail = new PHPMailer;
    $mail->isSMTP();
    // Configure your SMTP settings
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
    $mail->Subject = 'New Ticket';
    $mail->Body = $issueDescription . '<br><br>' .
        'First Name: ' . $_SESSION['firstname'] . '<br>' .
        'Last Name: ' . $_SESSION['lastname'] . '<br>' .
        'User ID: ' . $_SESSION['user_id'] . '<br>' .
        'Username: ' . $_SESSION['username'] . '<br>' .
        'Email: ' . $_SESSION['email'];

    if (!$mail->send()) {
        echo 'Mailer Error: ' . $mail->ErrorInfo;
    }

    $mail->clearAddresses();

    $email = $_SESSION['email'];
    $mail->addAddress($email);
    $mail->Subject = 'New Ticket Confirmation';
    // Include the message "Your ticket has been submitted" and the ticket number (token) in the email body
    $mail->Body = 'Your ticket has been submitted.' . '<br><br>' .
        'Ticket Number: ' . $token . '<br><br>' .
        'Issue Description: ' . $issueDescription . '<br><br>' .
        'First Name: ' . $_SESSION['firstname'] . '<br>' .
        'Last Name: ' . $_SESSION['lastname'] . '<br>' .
        'User ID: ' . $_SESSION['user_id'] . '<br>' .
        'Username: ' . $_SESSION['username'] . '<br>' .
        'Email: ' . $_SESSION['email'];

    if (!$mail->send()) {
        echo 'Mailer Error: ' . $mail->ErrorInfo;
    }

    $message = "Your ticket has been submitted";
}
?>


<!-- Rest of your HTML code -->


 <!-- End Navbar -->
 <div class="content">
        <div class="row">
          <div class="col-md-12">
            <div class="card">
              <div class="card-header">
                <h5 class="title">New Ticket</h5>
                <h3 class="text-center" style="color:green";><?php echo $message ?></h3>
              </div>
              <div class="card-body">
                  <!-- ----------------- -->
                  <form method="post" enctype='multipart/form-data' class="needs-validation" novalidate>       
              <div class="form-row">
                <div class="col-md-6 mb-3">
                  <label for="validationCustom01">Describe your issue</label>
                  <textarea name="issue_description" class="form-control" id="validationCustom01" value="" required></textarea>
                </div>
              </div>
              <input style="background: rgb(223,78,204);
                background: linear-gradient(90deg, rgba(223,78,204,1) 0%, rgba(223,78,204,1) 35%, rgba(192,83,237,1) 62%); border:none;" class="btn btn-primary btn" type="submit" name="send" value="Send">
            </form>
              </div>
            </div>
          </div>
        </div>

      <?php include "includes/footer.php" ?>
      

