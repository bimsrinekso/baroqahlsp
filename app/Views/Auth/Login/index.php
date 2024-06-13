<?php $this->extend('inc/auth');?>
<?php $this->section('css');?>

<?php $this->endSection();?>
<?php $this->section('body');?>

<div class="container">
  <div class="row justify-content-center align-items-center min-vh-100">
      <div class="col-12 col-md-8 col-lg-6 col-xl-5">
          <div class="card shadow-lg">
              <div class="card-body p-5">
                  <h1 class="h3 mb-3 fw-normal text-center">Sign in</h1>
                  <form action="" method="POST">
                      <div class="form-floating mb-3">
                          <input type="text" class="form-control"  placeholder="Username" name="username">
                          <label>Username</label>
                      </div>
                      <div class="form-floating mb-3">
                          <input type="password" class="form-control" placeholder="Password" name="password">
                          <label>Password</label>
                      </div>
                      <button class="btn btn-primary w-100 py-2" type="submit">Sign in</button>
                  </form>
              </div>
          </div>
      </div>
  </div>
</div>


<?php $this->endSection();?>
<?php $this->section('javascript');?>
<?php $this->endSection();?>


