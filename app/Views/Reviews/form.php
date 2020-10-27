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
               <label class = "font-weight-bold text-muted" for="project-id">Project</label>
               <select class="form-control  selectpicker" data-live-search="true" data-size="8" name="project-id" id="project-id">
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

            <div class="col-12 col-sm-4">
                <div class="form-group">
                  <label class = "font-weight-bold text-muted" for="category">Category</label>
                  <select class="form-control  selectpicker" data-live-search="true" data-size="8" name="category" id="category">
                    <option value="" disabled <?= isset($review['category']) ? '' : 'selected' ?>>
                        Select
                    </option>
                    <?php foreach ($categoryList as $value): ?>
                      <option 
                        <?= isset($review['category']) ? (($review['category'] == $value) ? 'selected': '') : '' ?>
                        value="<?=  $value ?>" ><?=  $value ?></option>
                    <?php endforeach; ?>
                    
                  </select>
                </div>
            </div>

            <div class="col-12  col-sm-4">
              <div class="form-group">
               <label class = "font-weight-bold text-muted" for="review-name">Name</label>
               <input type="text" class="form-control" required name="review-name" id="review-name"
                value="<?= isset($review['review-name']) ? $review['review-name'] : '' ?>" >
              </div>
            </div>

            <div class="col-12 col-sm-8">
              <div class="form-group">
               <label class = "font-weight-bold text-muted" for="context">Review Item</label>
                <input  maxlength=60  type="text" class="form-control" required name="context" id="context"
                value="<?= isset($review['context']) ? $review['context'] : '' ?>" >
              </div>
            </div>
            <div class="col-12 col-sm-4">
              <div class="form-group">
               <label class = "font-weight-bold text-muted" for="assigned-to">Assigned To</label>
               
               <select class="form-control  selectpicker" data-live-search="true" data-size="8" name="assigned-to" id="assigned-to">
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
               <label class = "font-weight-bold text-muted" for="description">Review Comment</label>
               <textarea  class="form-control" name="description" id="description" maxlength=1000><?=
                isset($review['description']) ? trim($review['description']) : ''
                ?></textarea>
            </div>
            </div>

            <div class="col-12 ">
              <div class="form-group">
               <label class = "font-weight-bold text-muted" for="review-ref">Author's Note</label>
               <textarea  class="form-control" name="review-ref" id="review-ref" maxlength=500><?=
                isset($review['review-ref']) ? trim($review['review-ref']) : ''
                ?></textarea>
              </div>
            </div>

          </div>

            <div class="row justify-content-md-center" >
              <div class="col-12 col-sm-4" >
                <div class="form-group">
                <label class = "font-weight-bold text-muted" for="review-by">Reviewed by</label>
                
                <select class="form-control  selectpicker" data-live-search="true" data-size="8" name="review-by" id="review-by">
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
                    <label class = "font-weight-bold text-muted" for="status">Status</label>
                    <select class="form-control  selectpicker" data-live-search="true" data-size="8" name="status" id="status">
                      <option value="" disabled >
                          Select
                      </option>
                      <?php foreach ($reviewStatus as $rev): ?>
                        <option 
                          <?= isset($review['status']) ? (($review['status'] == $rev["value"]) ? 'selected': '') : '' ?>
                          value="<?=  $rev["value"] ?>" ><?=  $rev["value"] ?></option>
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