<?php include "header.php" ?>

<?php

if (!isset($_GET['token'])) {
  header('Location: ../index.php');
}

$message_suc = "Verification Successful";
$message_inv = "Invalid verification token!";

require '../classes/config.php';
require '../vendor/autoload.php';

$token = $_GET['token'];

// Check if the token exists in the database
$query = "SELECT * FROM users WHERE token = '{$token}'";
$result = mysqli_query($connection, $query);

if (mysqli_num_rows($result) > 0) {
// Token is valid
// Update the verified and active columns to "yes" for the user with the given token
$updateQuery = "UPDATE users SET verified = 'yes', active = 'yes' WHERE token = '{$token}'";
mysqli_query($connection, $updateQuery);

// Check if the update was successful
if (mysqli_affected_rows($connection) > 0) {
    // Delete the token from the database
    $deleteQuery = "UPDATE users SET token = NULL WHERE token = '{$token}'";
    mysqli_query($connection, $deleteQuery);
}
} else {
// Token is invalid or not found
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
        <div class="card shadow-2-strong card-registration" style="border-radius: 15px; border:solid 1px; border-color: #C153ED; background-color: #27293D">
          <div class="card-body p-4 p-md-5">

          <?php if(!isset($emailSent)): ?>

          
            <h3 class="mb-4 pb-2 pb-md-0 mb-md-5"><?php echo $message_suc ?> </h3>
            <p class="mb-4 pb-2 pb-md-0 mb-md-5">Returning to login to continue register you kid in:</p>
            <h4 id="countdown">5</h4>
            <?php else: ?>

                <h3 class="mb-4 pb-2 pb-md-0 mb-md-5">Check your inbox!</h3>

            <?php endif ?>
          </div>
        </div>
      </div>
    </div>
  </div>
</section>

<style>
  #countdown {
    font-size: 48px;
    font-weight: bold;
    color: white;
    text-align: center;
    margin-top: 20px;
  }
</style>

<script>
  // Countdown timer
  var countdownElement = document.getElementById("countdown");
  var countdown = 5; // Countdown duration in seconds
  var countdownInterval = setInterval(updateCountdown, 1000);

  function updateCountdown() {
    countdown--;
    countdownElement.innerText = countdown;

    if (countdown <= 0) {
      clearInterval(countdownInterval);
      countdownElement.style.display = "none";
      // Perform any action you want after the countdown finishes
      // For example, you can hide the countdown element or show another message
      // Redirect to the desired URL
      window.location.href = "https://myxogos.com/"; // Replace "http://example.com" with your desired URL
    }
  }
</script>
