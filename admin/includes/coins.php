<style>

.card {
  position: relative;
  background-size: cover;
  background-position: center;
}

.card .overlay {
  position: absolute;
  top: 0;
  left: 0;
  width: 100%;
  height: 100%;
  background-color: rgba(0, 0, 0, 0.5); /* Black with 50% opacity */
  z-index: 1; /* Ensure the overlay is above other elements */
}

.card-body {
  position: relative;
}


</style>

<div class="col-lg-4">
            <div class="card card-chart">
              <div class="card-header">
                <h5 class="card-category">Coins Available</h5>
                <h3 class="card-title text-bold"><i class="tim-icons icon-coins text-info"></i><?php echo $_SESSION['total_coins']; ?></h3>
              </div>
            </div>
            <div class="card card-chart" style="background-image: url('./assets/img/avatars/<?php echo $_SESSION['img']; ?>');">
  <div class="overlay"></div> <!-- Added overlay div -->
  <div class="card-header" style="position: relative; z-index: 2;">
    <h5 class="card-category">Welcome</h5>
    <h3 class="card-title"><?php echo $_SESSION['firstname']; ?></h3>
  </div>
  <div class="card-body" style="height: 150px; position: relative;">
    <div class="chart-area">
      <!-- Content inside the chart-area -->
    </div>
  </div>
</div>

          </div>