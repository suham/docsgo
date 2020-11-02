<style>
body{
  padding:0px;
}
</style>
<div class="container">
  <div class="row justify-content-center">
    <div class="col-12 col-sm-8 col-md-6 col-lg-5 mt-5 pt-2 pb-3 form-color">
      <div class="container">
        <div class="row">
            <div class="col"><h3 class="mt-5 text-muted">Login</h3></div>
            <div class="col"><img class="float-right" src="/Docsgo-Logo.png" height="100px" width="100px" alt="Card image cap"></div>
        </div>
        <hr>
        <?php if (session()->get('success')): ?>
          <div class="alert alert-success" role="alert">
            <?= session()->get('success') ?>
          </div>
        <?php endif; ?>
        <form class="" action="/" method="post">
          <div class="form-group">
           <label for="email">Email address</label>
           <input type="text" class="form-control" name="email" id="email" value="<?= set_value('email') ?>">
          </div>
          <div class="form-group">
           <label for="password">Password</label>
           <input type="password" class="form-control" name="password" id="password" value="">
          </div>
          <?php if (isset($validation)): ?>
            <div class="col-12">
              <div class="alert alert-danger" role="alert">
                <?= $validation->listErrors() ?>
              </div>
            </div>
          <?php endif; ?>
          <div class="row">
            <div class="col-12 col-sm-4">
              <button type="submit" class="btn btn-primary">Login</button>
            </div>
            <div class="col-12 col-sm-8 text-right">
              <a href="/register">Don't have an account yet?</a>
            </div>
          </div>
        </form>
      </div>
    </div>
  </div>
</div>
