<div class="wrapper">
    <div class="sidebar" data-color="blue">
      <!--
        Tip 1: You can change the color of the sidebar using: data-color="blue | green | orange | red"
    -->
      <div class="sidebar-wrapper">
        <div class="logo">
          <a href="javascript:void(0)" class="simple-text logo-normal">
           <img src="./assets/img/xogos-gaming-logo.png" alt="">
          </a>
        </div>
        <ul class="nav">
          <li class="">
            <a href="index.php">
              <i class="tim-icons icon-chart-pie-36"></i>
              <p>Dashboard</p>
            </a>
          </li>
          <!-- <li>
            <a href="examples/notifications.html">
              <i class="tim-icons icon-bell-55"></i>
              <p>Tasks</p>
            </a>
          </li> -->

          <?php if(is_admin()): ?>
          <li>
            <a href="students.php">
              <i class="tim-icons icon-badge"></i>
              <p>Students</p>
            </a>
          </li>
          <?php endif ?>

          <?php if(is_teacher()): ?>
          <li>
            <a href="my_students.php">
              <i class="tim-icons icon-badge"></i>
              <p>My Students</p>
            </a>
          </li>
          <?php endif ?>

          <?php if(is_teacher() OR is_student()): ?>
          <li>
            <a href="my_classes.php">
              <i class="tim-icons icon-globe-2"></i>
              <p>My Classes</p>
            </a>
          </li>
          <?php endif ?>

          <?php if(is_admin()): ?>
          <li>
            <a href="teachers.php">
              <i class="tim-icons icon-notes"></i>
              <p>Teachers</p>
            </a>
          </li>
          <?php endif ?>

          <?php if(is_admin()): ?>
          <li>
            <a href="parents.php">
              <i class="tim-icons icon-attach-87"></i>
              <p>Parents</p>
            </a>
          </li>
          <?php endif ?>

          <?php if(is_admin()): ?>
          <li>
            <a href="classes.php">
              <i class="tim-icons icon-globe-2"></i>
              <p>Classes</p>
            </a>
          </li>
          <?php endif ?>

          <?php if(is_parent()): ?>
          <li>
            <a href="my_kids.php">
              <i class="tim-icons icon-badge"></i>
              <p>My Kids</p>
            </a>
          </li>
          <?php endif ?>
          <li>
            <a href="all_games.php">
              <i class="tim-icons icon-controller"></i>
              <p>All Games</p>
            </a>
          </li>
          <li>
            <a href="chat.php">
              <i class="tim-icons icon-single-02"></i>
              <p>Chat</p>
            </a>
          </li>
          <!-- <li>
            <a href="examples/icons.html">
              <i class="tim-icons icon-atom"></i>
              <p>Icons</p>
            </a>
          </li> -->
        </ul>
      </div>
    </div>