<h1><?php echo $_settings->info('name') ?> - Jiren Kebele</h1>
<hr>
<style>
  #system-banner{
    width:100%;
    max-height:35em;
    object-fit:cover;
    object-position: center center;
  }
</style>
<div class="row">
  <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
    <div class="info-box">
      <span class="info-box-icon bg-gradient-dark elevation-1"><i class="fas fa-id-card"></i></span>
      <div class="info-box-content">
        <span class="info-box-text">Tax Payers Registered in the kebele</span>
        <span class="info-box-number">
          <?php 
            $categories = $conn->query("SELECT * FROM tax_payer_list")->num_rows;
            echo format_num($categories);
          ?>
          <?php ?>
        </span>
      </div>
      <!-- /.info-box-content -->
    </div>
    <!-- /.info-box -->
  </div>
  <!-- /.col -->
  <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
    <div class="info-box">
      <span class="info-box-icon bg-gradient-dark elevation-1"><i class="fas fa-credit-card"></i></span>
      <div class="info-box-content">
        <span class="info-box-text">Total tax payers paid</span>
        <span class="info-box-number">
          <?php 
            $tolls = $conn->query("SELECT * FROM tax_payment_history")->num_rows;
            echo format_num($tolls);
          ?>
          <?php ?>
        </span>
      </div>
      <!-- /.info-box-content -->
    </div>
    <!-- /.info-box -->
  </div>
  <!-- /.col -->
  <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
    <div class="info-box">
      <span class="info-box-icon bg-gradient-dark elevation-1"><i class="fas fa-money-bill"></i></span>
      <div class="info-box-content">
        <span class="info-box-text">Amount of Tax Collected so far</span>
        <span class="info-box-number">
          <?php 
            $history = $conn->query("SELECT * FROM tax_payment_history where date(date_created) = '".date('Y-m-d')."'")->num_rows;
            echo format_num($history);
          ?>
          <?php ?>
        </span>
      </div>
      <!-- /.info-box-content -->
    </div>
    <!-- /.info-box -->
  </div>
  <!-- /.col -->
  <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
    <div class="info-box">
      <span class="info-box-icon bg-gradient-dark elevation-1"><i class="fas fa-users"></i></span>
      <div class="info-box-content">
        <span class="info-box-text">System Users</span>
        <span class="info-box-number">
          <?php 
            $user = $conn->query("SELECT * FROM `users` ")->num_rows;
            echo format_num($user);
          ?>
          <?php ?>
        </span>
      </div>
      <!-- /.info-box-content -->
    </div>
    <!-- /.info-box -->
  </div>
  <!-- /.col -->
</div>
<hr>
<center>
  <!-- <img src="<?= validate_image($_settings->info('cover')) ?>" class="img-fluid img-thumbnail" id="system-banner" alt="<?= $_settings->info('name') ?>"> -->
</center>