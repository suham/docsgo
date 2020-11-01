
  <div class="row p-0 p-md-4">
    <div class="col-12 col-sm8- offset-sm-2 col-md-6 offset-md-3 mt-1 pt-3 pb-3 form-color">

      <div class="container">
        <h3><?= $formTitle ?></h3>
        <hr>
        <?php if (session()->get('success')): ?>
          <div class="alert alert-success" role="alert">
            <?= session()->get('success') ?>
          </div>
        <?php endif; ?>
        <!-- Submit action -->
        <form class="" action="/test-cases/<?= $action ?>" method="post">
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
              <label class = "font-weight-bold text-muted" for="testcase">Test Case</label>
              <input type="text" class="form-control" name="testcase" id="testcase"
              value="<?= isset($member['testcase']) ? $member['testcase'] : '' ?>" >
              </div>
            </div>

            <div class="col-12">
              <div class="form-group">
                <label class = "font-weight-bold text-muted" for="description">Description</label>
                <textarea class="form-control" name="description" id="description" maxlength=500><?=
                  isset($member['description']) ? trim($member['description']) : ''
                  ?></textarea>
              </div>
            </div>

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

