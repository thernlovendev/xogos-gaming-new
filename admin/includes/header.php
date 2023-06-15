<?php include "db.php" ?>
<?php include "functions.php" ?>

<?php ob_start(); ?>
<?php session_start(); ?>
<?php $DOMAIN = "http://localhost:8888/web-development/xogos-gaming/admin/"; ?>

<?php

// $user_role = $_SESSION['user_role'];
  // $kids_count = $_SESSION['kids_count'];

  // // Check user role and kids count conditions
  // if($user_role !== 'student' && $user_role !== 'admin' && $kids_count < 1) {
  //   header("Location: ../stripe-one/checkout.php");
  //   exit();
  // }

  if(isset($_SESSION['user_id'])) {
    $user_id = $_SESSION['user_id'];
    $user_role = $_SESSION['user_role'];
    $kids_count = $_SESSION['kids_count'];
  
    // Check if user is verified and active
    $query = "SELECT verified, active FROM users WHERE user_id = ?";
    $stmt = mysqli_prepare($connection, $query);
    mysqli_stmt_bind_param($stmt, "i", $user_id);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);
    $row = mysqli_fetch_assoc($result);
    $verified = $row['verified'];
    $active = $row['active'];
  
    if (!isset($user_role) || $verified === 'no' || $active === 'no') {
      // Redirect to the login page
      header("Location: ../includes/login.php");
      exit();
    } elseif($user_role !== 'student' && $user_role !== 'admin' && $kids_count < 1) {
      header("Location: ../stripe-one/checkout.php");
      exit();
    }
  } else {
    // Redirect to the login page
    header("Location: ../includes/login.php");
    exit();
  }
  
  

?>




<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <link rel="apple-touch-icon" sizes="76x76" href="assets/img/apple-icon.png">
  <!-- <link rel="icon" type="image/png" href="assets/img/favicon.png"> -->
  <title>
    XOGOS GAMING
  </title>
  <!--     Fonts and icons     -->
  <link href="https://fonts.googleapis.com/css?family=Poppins:200,300,400,600,700,800" rel="stylesheet" />
  <link href="https://use.fontawesome.com/releases/v5.0.6/css/all.css" rel="stylesheet">
  <!-- Nucleo Icons -->
  <link href="assets/css/nucleo-icons.css" rel="stylesheet" />
  <!-- CSS Files -->
  <link href="assets/css/styles.css?v=1.0.0" rel="stylesheet" />
  <!-- CSS Just for demo purpose, don't include it in your project -->
  <link href="assets/demo/demo.css" rel="stylesheet" />
</head>

<body class="">