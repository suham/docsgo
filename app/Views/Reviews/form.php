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
            <div class="col-12 col-sm-4">
              <div class="form-group">
               <label for="project-id">Project</label>
               <select class="form-control" name="project-id" id="project-id" >
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
               <label for="authors">Authors</label>
               <input type="text" class="form-control" name="authors" id="authors"
                value="<?= isset($review['authors']) ? $review['authors'] : '' ?>" >
              </div>
            </div>

            <div class="col-12 col-sm-4">
              <div class="form-group">
               <label for="status">Status</label>
               <select class="form-control" name="status" id="status" >
                <option value="" disabled <?= isset($review['status']) ? '' : 'selected' ?>>
                    Select
                </option>
                <?php foreach ($reviewStatus as $key=>$value): ?>
                  <option 
                    <?= isset($review['status']) ? (($review['status'] == $key) ? 'selected': '') : '' ?>
                    value="<?=  $key ?>" ><?=  $value ?></option>
                <?php endforeach; ?>
                
              </select>
              </div>
            </div>

            <div class="col-12  col-sm-4">
              <div class="form-group">
               <label for="opened-date">Open Date</label>
               <input type="date" class="form-control" name="opened-date" id="opened-date"
                value="<?= isset($review['opened-date']) ? $review['opened-date'] : '' ?>" >
              </div>
            </div>

            <div class="col-12  col-sm-4">
              <div class="form-group">
               <label for="closed-date">Closed Date</label>
               <input type="date" class="form-control" name="closed-date" id="closed-date"
                value="<?= isset($review['closed-date']) ? $review['closed-date'] : '' ?>" >
              </div>
            </div>

            <div class="col-12 col-sm-8">
              <div class="form-group">
               <label for="subtitle">Subtitle</label>
               <input type="text" class="form-control" name="subtitle" id="subtitle"
                value="<?= isset($review['subtitle']) ? $review['subtitle'] : '' ?>" >
              </div>
            </div>

          
          
            <div class="col-12">
              <div class="form-group">
               <label for="description1">Purpose</label>
               <textarea class="form-control" name="description1" id="description1" maxlength=100><?=
                isset($review['description1']) ? trim($review['description1']) : ''
                ?></textarea>
              </div>
            </div>

            <div class="col-12">
              <div class="form-group">
               <label for="description2">Review Comments</label>
               <textarea class="form-control" name="description2" id="description2" maxlength=200><?=
                isset($review['description2']) ? trim($review['description2']) : ''
                ?></textarea>
              </div>
            </div>

            <div class="col-12">
              <div class="form-group">
               <label for="description3">Update Comments</label>
               <textarea class="form-control" name="description3" id="description3" maxlength=100><?=
                isset($review['description3']) ? trim($review['description3']) : ''
                ?></textarea>
              </div>
            </div>

            <div class="col-12  col-sm-4">
              <div class="form-group">
               <label for="ref">Review Items</label>
               <input type="text" class="form-control" name="review-items" id="review-items"
                value="<?= isset($review['review-items']) ? $review['review-items'] : '' ?>" >
              </div>
            </div>

            <div class="col-12  col-sm-4">
              <div class="form-group">
               <label for="ref">Reviewed by</label>
               <input type="text" class="form-control" name="reviewed-by" id="reviewed-by"
                value="<?= isset($review['reviewed-by']) ? $review['reviewed-by'] : '' ?>" >
              </div>
            </div>

            <div class="col-12  col-sm-4">
              <div class="form-group">
               <label for="reviewed-date">Reviewed Date</label>
               <input type="date" class="form-control" name="reviewed-date" id="reviewed-date"
                value="<?= isset($review['reviewed-date']) ? $review['reviewed-date'] : '' ?>" >
              </div>
            </div>

            <div class="col-12  col-sm-4">
              <div class="form-group">
               <label for="reviewers">Reviewers</label>
               <input type="text" class="form-control" name="reviewers" id="reviewers"
                value="<?= isset($review['reviewers']) ? $review['reviewers'] : '' ?>" >
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
