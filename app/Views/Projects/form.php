<div class="">
  <div class="row">
    <div class="col-12 col-sm8- offset-sm-2 col-md-7 offset-md-3 mt-1 pt-3 pb-3 bg-white from-wrapper">
      <div class="container">
        <h3><?= $formTitle ?></h3>
        <hr>
        <?php if (session()->get('success')): ?>
          <div class="alert alert-success" role="alert">
            <?= session()->get('success') ?>
          </div>
        <?php endif; ?>
        <form class="" action="/projects/<?= $action ?>" method="post">
          <div class="row">
            <div class="col-12 col-sm-6">
              <div class="form-group">
               <label for="name">Name</label>
               <input type="text" class="form-control" name="name" id="name"
                value="<?= isset($project['name']) ? $project['name'] :'' ?>">
              </div>
            </div>

            <div class="col-12 col-sm-6">
              <div class="form-group">
               <label for="manager-id">Manager</label>
               
               <select class="form-control" name="manager-id" id="manager-id" >
                <option value="" disabled <?= isset($project['manager-id']) ? '' : 'selected' ?>>
                    Select
                </option>
                <?php foreach ($teamMembers as $key=>$value): ?>
                  <option 
                    <?= isset($project['manager-id']) ? (($project['manager-id'] == $key) ? 'selected': '') : '' ?>
                    value="<?=  $key ?>" ><?=  $value ?></option>
                <?php endforeach; ?>
                
              </select>

              </div>
            </div>
          
            <div class="col-12">
              <div class="form-group">
               <label for="description">Description</label>
               <textarea class="form-control" name="description" id="description" maxlength=100><?=
                isset($project['description']) ? trim($project['description']) : ''
                ?></textarea>
              </div>
            </div>

            <div class="col-12  col-sm-4">
              <div class="form-group">
               <label for="start-date">Start Date</label>
               <input type="date" class="form-control" name="start-date" id="start-date"
                value="<?= isset($project['start-date']) ? $project['start-date'] : '' ?>" >
              </div>
            </div>

            <div class="col-12  col-sm-4">
              <div class="form-group">
               <label for="end-date">End Date</label>
               <input type="date" class="form-control" name="end-date" id="end-date"
                value="<?= isset($project['end-date']) ? $project['end-date'] : '' ?>" >
              </div>
            </div>

          
            <div class="col-12 col-sm-4">
              <div class="form-group">
               <label for="is-active">Status</label>
               <select class="form-control" name="is-active" id="is-active" >
                <option value="" disabled <?= isset($project['is-active']) ? '' : 'selected' ?>>
                    Select
                </option>
                <?php foreach ($isActiveList as $value): ?>
                  <option 
                    <?= isset($project['is-active']) ? (($project['is-active'] == $value) ? 'selected': '') : '' ?>
                    value="<?= $value ?>" >
                    <?= $value ?>
                  </option>
                <?php endforeach; ?>
                
              </select>
              
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
            <div class="col-12 text-center">
              <button type="submit" class="btn btn-primary">Submit</button>
            </div>

          </div>
        </form>
      </div>
    </div>
  </div>
</div>
