<?php include "header.php" ?>
<?php

//Import PHPMailer classes into the global namespace
//These must be at the top of your script, not inside a function
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

require '../classes/config.php';

require '../vendor/autoload.php';

    if(!isset($_GET['forgot'])){

        header('Location: ../index.php');

    }


    if(ifItIsMethod('post')){

        if(isset($_POST['email'])) {

            $email = $_POST['email'];

            $length = 50;

            $token = bin2hex(openssl_random_pseudo_bytes($length));


            if(email_exists($email)){


                if($stmt = mysqli_prepare($connection, "UPDATE users SET token='{$token}' WHERE email= ?")){

                    mysqli_stmt_bind_param($stmt, "s", $email);
                    mysqli_stmt_execute($stmt);
                    mysqli_stmt_close($stmt);



                    /**
                     *
                     * configure PHPMailer
                     *
                     *
                     */

                    $mail = new PHPMailer();

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
                    $mail->addAddress($email);

                    $mail->Subject = 'Password Reset';

                    $mail->Body = '<p>Please click to reset your password

                    <a href="http://localhost:8888/web-development/xogos-gaming/includes/reset.php?email='.$email.'&token='.$token.' ">http://localhost:8888/web-development/xogos-gaming/includes/reset.php?email='.$email.'&token='.$token.'</a>



                    </p>';


                    if($mail->send()){

                        $emailSent = true;

                    } else{

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
        <div class="card shadow-2-strong card-registration" style="border-radius: 15px; border:solid 1px; border-color: #C153ED; background-color: #27293D">
          <div class="card-body p-4 p-md-5">

          <?php if(!isset($emailSent)): ?>

          
            <h3 class="mb-4 pb-2 pb-md-0 mb-md-5">Forgot password?</h3>
            <p class="mb-4 pb-2 pb-md-0 mb-md-5">You can reset your password below</p>
            <form method="post" action="">

              <div class="row">
                <div class="col-md-12 mb-4">

                  <div class="form-outline">
                    <input type="text" name="email" id="email" class="form-control form-control-lg" />
                    <label class="form-label" for="email">Email Address</label>
                  </div>

                </div>
                <div class="mt-4 pt-2">
                <input style="background: rgb(223,78,204);
                background: linear-gradient(90deg, rgba(223,78,204,1) 0%, rgba(223,78,204,1) 35%, rgba(192,83,237,1) 62%); border:none;" class="btn btn-primary btn-lg" type="submit" name="recover-submit" value="Reset" />
              </div>
              <input type="hidden" class="hide" name="token" id="token" value="">
              </div>

            </form>

            <?php else: ?>

                <h3 class="mb-4 pb-2 pb-md-0 mb-md-5">Check your inbox!</h3>

            <?php endif ?>
          </div>
        </div>
      </div>
    </div>
  </div>
</section>