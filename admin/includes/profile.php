<div class="col-lg-4 col-md-12 col-sm-6">
            <div class="card card-chart">
              <div class="card-header">
                <h5 class="card-category">Welcome</h5>
                <h3 class="card-title"><?php echo $_SESSION['firstname']; echo " "; echo $_SESSION['lastname'] ?> </h3>
              </div>
              <div class="card-body">
                <div class="chart-area">
                <img src="./assets/img/avatars/<?php echo $_SESSION['img']; ?>" alt="">
                </div>
              </div>
            </div>
          </div>