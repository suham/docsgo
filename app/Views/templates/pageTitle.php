
<div class="jumbotron jumbotron-fluid">
  <div class="container">
    <div class="row">
            <div class="col-sm-10 col-12">
                 <h3 class="display-4"><?php echo $pageTitle; ?></h1>
            </div>
            <?php if ($addBtn): ?>
            <div class="col-sm-2 col-12 ">
                <a href="<?= $addUrl ?>" class="btn btn-primary mt-3">
                   <i class="fa fa-plus"></i> Add
                </a>
            </div>
            <?php else: ?>
                <div class="col-sm-2 col-12 ">
                <a class="btn btn-secondary text-light mt-3" href="<?= $backUrl ?>">
                   <i class="fa fa-chevron-left"></i> Back
                </a>
            </div>
            <?php endif; ?>
        </div>
   </div>
</div>
