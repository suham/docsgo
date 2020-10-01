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
        <form class="" action="/reviews/<?= $action ?>" method="post">

          <div class="row">

            <?php if (isset($validation)): ?>
              <div class="col-12">
                <div class="alert alert-danger" role="alert">
                  <?= $validation->listErrors() ?>
                </div>
              </div>
            <?php endif; ?>

            <div class="col-12 col-sm-4">
              <div class="form-group">
               <label for="project-id">Project</label>
               <select class="form-control fstdropdown-select" name="project-id" id="project-id" required>
                <option value="" disabled <?= isset($review['project-id']) ? '' : 'selected' ?>>
                    Select
                </option>
                <?php foreach ($projects as $key=>$value): ?>
                  <option 
                    <?= isset($review['project-id']) ? (($review['project-id'] == $key) ? 'selected': '') : '' ?>
                    value="<?=  $key ?>" ><?=  $value ?></option>
                <?php endforeach; ?>
                
              </select>
              </div>
            </div>

            <div class="col-12  col-sm-4">
              <div class="form-group">
               <label for="review-name">Name</label>
               <input type="text" class="form-control" required name="review-name" id="review-name"
                value="<?= isset($review['review-name']) ? $review['review-name'] : '' ?>" >
              </div>
            </div>

            <div class="col-12 col-sm-4">
              <div class="form-group">
               <label for="assigned-to">Assigned To</label>
               
               <select class="form-control fstdropdown-select" name="assigned-to" id="assigned-to" required>
                <option value="" disabled <?= isset($review['assigned-to']) ? '' : 'selected' ?>>
                    Select
                </option>
                <?php foreach ($teamMembers as $key=>$value): ?>
                  <option 
                    <?= isset($review['assigned-to']) ? (($review['assigned-to'] == $key) ? 'selected': '') : '' ?>
                    value="<?=  $key ?>" ><?=  $value ?></option>
                <?php endforeach; ?>
                
              </select>

              </div>
            </div>

            <div class="col-12">
              <div class="form-group">
               <label for="context">Context</label>
               <textarea data-adaptheight class="form-control" name="context" id="context" maxlength=200><?=
                isset($review['context']) ? trim($review['context']) : ''
                ?></textarea>
              </div>
            </div>

            <div class="col-12">
              <div class="form-group">
               <label for="description">Description</label>
               <textarea data-adaptheight class="form-control" name="description" id="description" maxlength=400><?=
                isset($review['description']) ? trim($review['description']) : ''
                ?></textarea>
            </div>
            </div>

            <div class="col-12 ">
              <div class="form-group">
               <label for="review-ref">Reference</label>
               <textarea data-adaptheight class="form-control" name="review-ref" id="review-ref" maxlength=250><?=
                isset($review['review-ref']) ? trim($review['review-ref']) : ''
                ?></textarea>
              </div>
            </div>

          </div>

            <div class="row justify-content-md-center" >
              <div class="col-12 col-sm-4" >
                <div class="form-group">
                <label for="review-by">Reviewd By</label>
                
                <select class="form-control fstdropdown-select" name="review-by" id="review-by" required>
                  <option value="" disabled <?= isset($review['review-by']) ? '' : 'selected' ?>>
                      Select
                  </option>
                  <?php foreach ($teamMembers as $key=>$value): ?>
                    <option 
                      <?= isset($review['review-by']) ? (($review['review-by'] == $key) ? 'selected': '') : '' ?>
                      value="<?=  $key ?>" ><?=  $value ?></option>
                  <?php endforeach; ?>
                  
                </select>

                </div>
              </div>

              <div class="col-12 col-sm-4">
                  <div class="form-group">
                    <label for="status">Status</label>
                    <select class="form-control fstdropdown-select" name="status" id="status" required>
                      <option value="" disabled <?= isset($review['status']) ? '' : 'selected' ?>>
                          Select
                      </option>
                      <?php foreach ($reviewStatus as $value): ?>
                        <option 
                          <?= isset($review['status']) ? (($review['status'] == $value) ? 'selected': '') : '' ?>
                          value="<?=  $value ?>" ><?=  $value ?></option>
                      <?php endforeach; ?>
                      
                    </select>
                  </div>
              </div>
            
            </div>
           
          <div class="row">
         
            <div class="col-12 text-center mt-3" >
                <button type="submit" class="btn btn-primary">Submit</button>
            </div>
          
          </div>

        </form>
      </div>
    </div>
  </div>
</div>
