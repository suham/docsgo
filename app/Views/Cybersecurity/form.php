
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
        <!-- Submit action -->
        <form class="" action="/cybersecurity/<?= $action ?>" method="post">
          <div class="row">
            <?php if (isset($validation)): ?>
              <div class="col-12">
                <div class="alert alert-danger" role="alert">
                  <?= $validation->listErrors() ?>
                </div>
              </div>
            <?php endif; ?>
            <div class="col-12">
              <div class="form-group">
              <label class = "font-weight-bold text-muted" for="project">Project</label>
               <select class="form-control fstdropdown-select" name="project" id="project">
                <option value="" disabled <?= isset($member['project_id']) ? '' : 'selected' ?>>
                    Select
                </option>
                <?php foreach ($projects as $key=>$value): ?>
                  <option 
                    <?= isset($member['project_id']) ? (($member['project_id'] == $key) ? 'selected': '') : '' ?>
                    value="<?=  $key ?>" ><?=  $value ?></option>
                <?php endforeach; ?>
                
              </select>

              </div>
            </div>

            <div class="col-12">
              <div class="form-group">
              <label class = "font-weight-bold text-muted" for="reference">Reference</label>
              <input type="text" class="form-control" name="reference" id="reference"
              value="<?= isset($member['reference']) ? $member['reference'] : '' ?>" >
              </div>
            </div>

            <div class="col-12">
              <div class="form-group">
                <label class = "font-weight-bold text-muted" for="description">Description</label>
                <textarea class="form-control" name="description" id="description" maxlength=100><?=
                isset($member['description']) ? trim($member['description']) : ''
                ?></textarea>
              </div>
            </div>

            <div class="col-12">
              <div class="form-group">
              <label class = "font-weight-bold text-muted" for="control">Established Control</label>
              <input type="text" class="form-control" name="control" id="control"
              value="<?= isset($member['control']) ? $member['control'] : '' ?>" >
              </div>
            </div>

          </div>

          <div class="row mt-sm-2">
            <div class="col-12 col-sm-8">
                <div class="form-group">
                <label class = "font-weight-bold text-muted" for="status">Status</label>
                    <select class="form-control fstdropdown-select" name="status" id="status">
                      <option value="" disabled <?= isset($member['status']) ? '' : 'selected' ?>>
                          Select
                      </option>
                      <?php foreach ($cybersecurityStatus as $value): ?>
                        <option 
                          <?= isset($member['status']) ? (($member['status'] == $value) ? 'selected': '') : '' ?>
                          value="<?=  $value ?>" ><?=  $value ?></option>
                      <?php endforeach; ?>
                      
                    </select>

                </div>
            </div>
          </div>
          <br/><br/><br/><br/>
          <div class="row">
            <div class="col-12 col-sm-4">
              <button type="submit" class="btn btn-primary">Submit</button>
            </div>
          </div>

        </form>
      </div>

    </div>
  </div>

