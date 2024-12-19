<?php
session_start();
if(!isset($_SESSION['IS_LOGIN'])){
   header('location:login.php');
   die();
}
?>
<!DOCTYPE html>
<html lang="en">
   <head>
      <meta charset="utf-8">
      <meta http-equiv="X-UA-Compatible" content="IE=edge">
      <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
      <title>Admin</title>
      <!-- Custom fonts for this template-->
      <link href="vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
      <!-- Page level plugin CSS-->
      <link href="vendor/datatables/dataTables.bootstrap4.css" rel="stylesheet">
      <!-- Custom styles for this template-->
      <link href="css/sb-admin.css" rel="stylesheet">
   </head>
   <body id="page-top">
      <nav class="navbar navbar-expand navbar-dark bg-dark static-top">
         <a class="navbar-brand mr-1" href="index.php">Admin panel</a>
         <div class="d-none d-md-inline-block ml-auto"></div>
         <!-- Navbar -->
         <ul class="navbar-nav ml-auto ml-md-0">
            <li class="nav-item dropdown no-arrow">
               <a class="nav-link dropdown-toggle" href="#" id="userDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
               <i class="fas fa-user-circle fa-fw"></i>
               </a>
               <div class="dropdown-menu dropdown-menu-right" aria-labelledby="userDropdown">
                  <a class="dropdown-item" href="logout.php">Logout</a>
               </div>
            </li>
         </ul>
      </nav>
      <div id="wrapper">
         <!-- Sidebar -->
         <ul class="sidebar navbar-nav">
         <li class="nav-item">
               <a class="nav-link" href="dashbord.php">
               <i class="fas fa-fw fa-tachometer-alt"></i>
               <span>Dashboard</span>
               </a>
            <li class="nav-item">
               <a class="nav-link" href="addproduct.php">
               <i class="fa fa-fw fa-user"></i>
               <span>Add product</span></a>
            </li>
            <li class="nav-item">
               <a class="nav-link" href="laptop.php">
               <i class="fa fa-fw fa-user"></i>
               <span>Add laptops</span></a>
         </li>
         <li class="nav-item">
               <a class="nav-link" href="cabels.php">
               <i class="fa fa-fw fa-user"></i>
               <span>Add cabels</span></a>
            </li>
            <li class="nav-item">
               <a class="nav-link" href="tab.php">
               <i class="fa fa-fw fa-user"></i>
               <span>Add tabs</span></a>
            </li>
            <li class="nav-item">
               <a class="nav-link" href="edit.php">
               <i class="fa fa-fw fa-user"></i>
               <span>edit product</span></a>
            </li>
            <li class="nav-item">
               <a class="nav-link" href="editlaptop.php">
               <i class="fa fa-fw fa-user"></i>
               <span>edit laptop</span></a>
            </li>
            <li class="nav-item">
               <a class="nav-link" href="editcab.php">
               <i class="fa fa-fw fa-user"></i>
               <span>edit cabels</span></a>
            </li>
            <li class="nav-item">
               <a class="nav-link" href="edittab.php">
               <i class="fa fa-fw fa-user"></i>
               <span>edit tabs</span></a>
            </li>
      </li>
         <?php  ?>
            <li class="nav-item">
               <a class="nav-link" href="userorder.php">
               <i class="fa fa-fw fa-newspaper"></i>
               <span>user orders</span></a>
            </li>
         <li class="nav-item">
               <a class="nav-link" href="userlogin.php">
               <i class="fa fa-fw fa-user"></i>
               <span>user_login</span></a>
            </li>
         <div id="content-wrapper">
         </div>
      </ul>