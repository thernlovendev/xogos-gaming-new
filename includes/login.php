<?php include "header.php" ?>


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
            <h3 class="mb-4 pb-2 pb-md-0 mb-md-5">Login</h3>
            <form method="post" action="login_db.php">

              <div class="row">
                <div class="col-md-12 mb-4">

                  <div class="form-outline">
                    <input type="text" name="username" id="firstName" class="form-control form-control-lg" />
                    <label class="form-label" for="firstName">Username</label>
                  </div>

                </div>
                <div class="col-md-12 mb-4">

                  <div class="form-outline">
                    <input type="password" name="password" id="lastName" class="form-control form-control-lg" />
                    <label class="form-label" for="lastName">Password</label>
                  </div>
                  <a class="text-sm" href="forgot.php?forgot=<?php echo uniqid(true); ?>">Forgot Password</a>

                </div>

                <div class="mt-4 pt-2">
                <input style="background: rgb(223,78,204);
                background: linear-gradient(90deg, rgba(223,78,204,1) 0%, rgba(223,78,204,1) 35%, rgba(192,83,237,1) 62%); border:none;" class="btn btn-primary btn-lg" type="submit" name="login" value="Login" />
              </div>

              <div class="row">
                <div class="ml-auto mr-auto" style="margin-top: 0.5rem";>
                  <a href="register.php">Or Register</a>
                </div>
              </div>
              </div>

            </form>
          </div>
        </div>
      </div>
    </div>
  </div>
</section>

<script src="//code.tidio.co/cbe0s02d74bhkvjfagrlculfyt01g7fv.js" async></script>