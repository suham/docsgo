<div class="">
  <div class="row">
    <div class="col-12 col-sm8- offset-sm-2 col-md-6 offset-md-3 mt-1 pt-3 pb-3 bg-white from-wrapper">
      <div class="container">
        <h3><?= $formTitle ?></h3>
        <hr>
        <?php if (session()->get('success')): ?>
          <div class="alert alert-success" role="alert">
            <?= session()->get('success') ?>
          </div>
        <?php endif; ?>
        <form class="" action="/team/<?= $action ?>" method="post">
          <div class="row">
            <div class="col-12">
              <div class="form-group">
               <label for="name">Name</label>
               <input type="text" class="form-control" name="name" id="name" 
               value="<?= isset($member['name']) ? $member['name'] : '' ?>">
              </div>
            </div>
          
            <div class="col-12  col-sm-6">
              <div class="form-group">
               <label for="role">Role</label>
               <input type="text" class="form-control" name="role" id="role"
               value="<?= isset($member['role']) ? $member['role'] : '' ?>" >
              </div>
            </div>
            <div class="col-12 col-sm-6">
              <div class="form-group">
               <label for="responsibility">Responsibility</label>
               <input type="text" class="form-control" name="responsibility" id="responsibility"
               value="<?= isset($member['responsibility']) ? $member['responsibility'] : '' ?>" >
             </div>
           </div>
           <div class="col-12">
              <div class="form-group">
               <label for="email">Email address</label>
               <input 
                  <?php if(isset($member['email'])){ if($member['email'] != ""){echo "readonly";} } ?>
                  type="text" class="form-control" name="email" id="email"
                  value="<?= isset($member['email']) ? $member['email'] : '' ?>" >
              </div>
            </div>
          <?php if (isset($validation)): ?>
            <div class="col-12">
              <div class="alert alert-danger" role="alert">
                <?= $validation->listErrors() ?>
              </div>
            </div>
          <?php endif; ?>
          </div>

          <div class="row">
            <div class="col-12 col-sm-4">
              <button type="submit" class="btn btn-primary">Submit</button>
            </div>

          </div>
        </form>
      </div>
    </div>
  </div>
</div>
