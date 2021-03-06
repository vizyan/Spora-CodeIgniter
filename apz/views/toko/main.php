<!DOCTYPE html>
<html lang="en">
<head>
<title>Proyek Spora</title>
<meta charset="utf-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="description" content="Colo Shop Template">
<meta name="viewport" content="width=device-width, initial-scale=1">
<link rel="stylesheet" type="text/css" href="<?= base_url() ?>assets/css/coloshop/bootstrap4/bootstrap.min.css">
<link href="<?= base_url() ?>assets/plugins/font-awesome-4.7.0/css/font-awesome.min.css" rel="stylesheet" type="text/css">
<link rel="stylesheet" type="text/css" href="<?= base_url() ?>assets/plugins/OwlCarousel2-2.2.1/owl.carousel.css">
<link rel="stylesheet" type="text/css" href="<?= base_url() ?>assets/plugins/OwlCarousel2-2.2.1/owl.theme.default.css">
<link rel="stylesheet" type="text/css" href="<?= base_url() ?>assets/plugins/OwlCarousel2-2.2.1/animate.css">
<link rel="stylesheet" type="text/css" href="<?= base_url() ?>assets/css/coloshop/single_styles.css">
<link rel="stylesheet" type="text/css" href="<?= base_url() ?>assets/css/coloshop/single_responsive.css">
<link rel="stylesheet" type="text/css" href="<?= base_url() ?>assets/css/coloshop/responsive.css">
<link rel="stylesheet" type="text/css" href="<?= base_url() ?>assets/css/coloshop/main_styles.css">
<link rel="stylesheet" type="text/css" href="<?= base_url() ?>assets/css/custom.css">

</head>
<body>
  <div class="super_container">
  <!-- Header -->
  <header class="header trans_300">
    <div class="main_nav_container">
      <div class="container">
        <div class="row">
          <div class="col-lg-12 text-right">
            <div class="logo_container">
              <img src="<?php echo base_url();?>assets/img/logo.png" style="">
            </div>
            <nav class="navbar">
              <ul class="navbar_menu">
                <li><a href="<?= site_url(''); ?>">Beranda</a></li>
                <li><a href="<?= site_url('shop'); ?>">Toko</a></li>
                <li><a href="<?= site_url('project'); ?>">Relawan</a></li>
                <li class="account">
                  <a href="#">Tentang</a>
                  <ul class="account_selection" style="width:200px">
                    <li><a href="<?= site_url('help'); ?>">Petunjuk Bantuan</a></li>
                    <li><a href="<?= site_url('term'); ?>">Ketentuan</a></li>
                    <li><a href="<?= site_url('policy'); ?>">Kebijakan Privasi</a></li>
                  </ul>
                </li>
                <li><a href="#"><i class="fa fa-search" aria-hidden="true"></i></a></li>
                <li class="account">
                  <a href="#"><i class="fa fa-user" style="min-width:30px"></i>
                    <?php if($this->session->userdata('nama')){
                      echo explode(" ", $this->session->userdata('nama'))[0];
                    } else { ?>
                      &nbsp; Akun
                    <?php } ?>
                  </a>
                  <ul class="account_selection" style="width:200px">
                    <?php if($this->session->userdata('login')){ ?>
                      <li><a href="<?= site_url('profil'); ?>"><i class="fa fa-user-circle"></i>Profil</a></li>
                      <li><a href="<?= site_url('dashboard'); ?>"><i class="fa fa-dashboard"></i>Dashboard</a></li>
                      <li><a href="<?= site_url('logout'); ?>"><i class="fa fa-sign-out"></i>Keluar</a></li>
                    <?php } else { ?>
                      <li><a href="<?= site_url('login'); ?>"><i class="fa fa-user-circle"></i>Masuk</a></li>
                      <li><a href="<?= site_url('register'); ?>"><i class="fa fa-sign-out"></i>Daftar</a></li>
                    <?php } ?>
                  </ul>
                </li>
              </ul>
              <div class="hamburger_container">
                <i class="fa fa-bars" aria-hidden="true"></i>
              </div>
            </nav>
          </div>
        </div>
      </div>
    </div>

  </header>

  <div class="fs_menu_overlay"></div>
  <div class="hamburger_menu">
    <div class="hamburger_close"><i class="fa fa-times" aria-hidden="true"></i></div>
    <div class="hamburger_menu_content text-right">
      <ul class="menu_top_nav">
        <li class="menu_item has-children"><a href="#">Akun Saya<i class="fa fa-angle-down"></i></a>
          <ul class="menu_selection">
            <?php if($this->session->userdata('login')){ ?>

              <li><a href="<?= site_url('profil'); ?>"><i class="fa fa-user-circle" aria-hidden="true"></i>Profil</a></li>
              <li><a href="<?= site_url('dashboard'); ?>"><i class="fa fa-dashboard" aria-hidden="true"></i>Dashboard</a></li>
              <li><a href="<?= site_url('logout'); ?>"><i class="fa fa-sign-out" aria-hidden="true"></i>Keluar</a></li>

            <?php } else { ?>
              <li><a href="#"><i class="fa fa-sign-in" aria-hidden="true"></i>Masuk</a></li>
              <li><a href="#"><i class="fa fa-user-plus" aria-hidden="true"></i>Daftar</a></li>
            <?php } ?>

          </ul>
        </li>
        <li><a href="<?php echo base_url('dashboard');?>">Beranda</a></li>
        <li><a href="<?php echo base_url('toko'); ?>">Toko</a></li>
        <li><a href="<?php echo base_url('proyek'); ?>">Relawan</a></li>
        <li><a href="#">Tentang</a></li>
      </ul>
    </div>
  </div>

  <!-- Slider -->

  <div class="main_slider" style="background-image:url(<?php echo base_url(); ?>assets/img/carousel<?php echo(rand(1,3));  ?>.jpg); margin-top: 100px;">
    <div class="container fill_height">
      <div class="row align-items-center fill_height">
        <div class="col">
          <div class="main_slider_content">

          </div>
        </div>
      </div>
    </div>
  </div>

  <!-- Banner -->

  <?php $this->load->view('toko/'. $view_name); ?>

  <!-- Footer -->

  <footer class="footer">
    <div class="container">
      <div class="row">
        <div class="col-lg-6">
          <div class="footer_nav_container d-flex flex-sm-row flex-column align-items-center justify-content-lg-start justify-content-center text-center">
            <ul class="footer_nav">
              <li><a href="#">Blog</a></li>
              <li><a href="#">FAQs</a></li>
              <li><a href="contact.html">Contact us</a></li>
            </ul>
          </div>
        </div>
        <div class="col-lg-6">
          <div class="footer_social d-flex flex-row align-items-center justify-content-lg-end justify-content-center">
            <ul>
              <li><a href="#"><i class="fa fa-facebook" aria-hidden="true"></i></a></li>
              <li><a href="#"><i class="fa fa-twitter" aria-hidden="true"></i></a></li>
              <li><a href="#"><i class="fa fa-instagram" aria-hidden="true"></i></a></li>
              <li><a href="#"><i class="fa fa-skype" aria-hidden="true"></i></a></li>
              <li><a href="#"><i class="fa fa-pinterest" aria-hidden="true"></i></a></li>
            </ul>
          </div>
        </div>
      </div>
      <div class="row">
        <div class="col-lg-12">
          <div class="footer_nav_container">
            <div class="cr">© <?php echo date('Y'); ?> All Rights Reserverd.</div>
          </div>
        </div>
      </div>
    </div>
  </footer>

</div>

<script src="<?php echo base_url(); ?>assets/js/coloshop/jquery-3.2.1.min.js"></script>
<script src="<?php echo base_url(); ?>assets/css/coloshop/bootstrap4/popper.js"></script>
<script src="<?php echo base_url(); ?>assets/css/coloshop/bootstrap4/bootstrap.min.js"></script>
<script src="<?php echo base_url(); ?>assets/plugins/Isotope/isotope.pkgd.min.js"></script>
<script src="<?php echo base_url(); ?>assets/plugins/OwlCarousel2-2.2.1/owl.carousel.js"></script>
<script src="<?php echo base_url(); ?>assets/plugins/easing/easing.js"></script>
<script src="<?php echo base_url(); ?>assets/js/coloshop/custom.js"></script>
<script src="<?php echo base_url(); ?>assets/js/coloshop/single_custom.js"></script>

</body>

</html>
