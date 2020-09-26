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
        <form class="" action="/documents/<?= $action ?>" method="post">
          <div class="row">
            <div class="col-12 col-sm-6">
              <div class="form-group">
               <label for="project-id">Project</label>
               <select class="form-control" name="project-id" id="project-id" >
                <option value="" disabled <?= isset($planDocument['project-id']) ? '' : 'selected' ?>>
                    Select
                </option>
                <?php foreach ($projects as $key=>$value): ?>
                  <option 
                    <?= isset($planDocument['project-id']) ? (($planDocument['project-id'] == $key) ? 'selected': '') : '' ?>
                    value="<?=  $key ?>" ><?=  $value ?></option>
                <?php endforeach; ?>
                
              </select>
              </div>
            </div>

            <div class="col-12 col-sm-6">
              <div class="form-group">
               <label for="author">Author</label>
               <input type="text" class="form-control" name="author" id="author"
                value="<?= isset($planDocument['author']) ? $planDocument['author'] : '' ?>" >
              </div>
            </div>

           

            <div class="col-12 col-sm-4">
              <div class="form-group">
               <label for="status">Status</label>
               <select class="form-control" name="status" id="status" >
                <option value="" disabled <?= isset($planDocument['status']) ? '' : 'selected' ?>>
                    Select
                </option>
                <?php foreach ($planStatus as $key=>$value): ?>
                  <option 
                    <?= isset($planDocument['status']) ? (($planDocument['status'] == $key) ? 'selected': '') : '' ?>
                    value="<?=  $key ?>" ><?=  $value ?></option>
                <?php endforeach; ?>
                
              </select>
              </div>
            </div>

            <div class="col-12 col-sm-6">
              <div class="form-group">
               <label for="type">Type</label>
               <input type="text" class="form-control" name="type" id="type"
                value="<?= isset($planDocument['type']) ? $planDocument['type'] : '' ?>" >
              </div>
            </div>

            <div class="col-12 col-sm-2">
              <div class="form-group">
               <label for="version">Version</label>
               <input type="text" class="form-control" name="version" id="version"
                value="<?= isset($planDocument['version']) ? $planDocument['version'] : '' ?>" >
              </div>
            </div>


             

            <div class="col-12 ">
              <div class="form-group">
               <label for="subtitle">Subtitle</label>
               <input type="text" class="form-control" name="subtitle" id="subtitle"
                value="<?= isset($planDocument['subtitle']) ? $planDocument['subtitle'] : '' ?>" >
              </div>
            </div>

          
            <div class="col-12">
              <div class="form-group">
               <label for="description1">Introduction</label>
               <textarea class="form-control" name="description1" id="description1" maxlength=100><?=
                isset($planDocument['description1']) ? trim($planDocument['description1']) : ''
                ?></textarea>
              </div>
            </div>

            <div class="col-12">
              <div class="form-group">
               <label for="description2">Execution Details</label>
               <textarea class="form-control" name="description2" id="description2" maxlength=200><?=
                isset($planDocument['description2']) ? trim($planDocument['description2']) : ''
                ?></textarea>
              </div>
            </div>

            <div class="col-12">
              <div class="form-group">
               <label for="description3">Dependencies</label>
               <textarea class="form-control" name="description3" id="description3" maxlength=100><?=
                isset($planDocument['description3']) ? trim($planDocument['description3']) : ''
                ?></textarea>
              </div>
            </div>

            <div class="col-12">
              <div class="form-group">
               <label for="description4">Deliverables</label>
               <textarea class="form-control" name="description4" id="description4" maxlength=100><?=
                isset($planDocument['description4']) ? trim($planDocument['description4']) : ''
                ?></textarea>
              </div>
            </div>

            <div class="col-12">
              <div class="form-group">
               <label for="description5">Metrics</label>
               <textarea class="form-control" name="description5" id="description5" maxlength=200><?=
                isset($planDocument['description5']) ? trim($planDocument['description5']) : ''
                ?></textarea>
              </div>
            </div>

            <div class="col-12 ">
              <div class="form-group">
               <label for="ref">Reference</label>
               <input type="text" class="form-control" name="ref" id="ref"
                value="<?= isset($planDocument['ref']) ? $planDocument['ref'] : '' ?>" >
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
