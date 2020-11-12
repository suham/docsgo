<div class="row p-4 form-color">
        <div class="col-sm-10 col-10">
            <h3 class="display-9 text-muted" style='font-size:2.2rem'><?php echo $pageTitle; ?></h1>
        </div>
        <?php if ($addBtn): ?>
        <div class="col-sm-2 col-2">
            <a href="<?= $addUrl ?>" class="btn btn-primary">
                <i class="fa fa-plus"></i> Add
            </a>
            <?php if (isset($AddMoreBtn)): ?>
                <a href="#" class="btn btn-primary get-risks-sync">
                   <i class="fa fa-plus"></i> <?php echo $AddMoreBtnText; ?>
                </a>
            <?php endif; ?>
        </div>
        <?php elseif(isset($titleDD)): ?>
        <div class="col-sm-2 col-2">
            <select class="form-control selectpicker text-light" id="newDoc"  data-style="btn-primary" data-live-search="true" data-size="8" >
                <option value="" selected disabled >New Document</option>
                <?php foreach ($documentType as $key=>$value): ?>
                    <option  value="<?=  $key ?>"><?=  $value ?></option>
                <?php endforeach; ?>
            </select>
        </div>
        <?php else: ?>
        <div class="col-sm-2 col-2 ">
            <a class="btn btn-secondary text-light" href="<?= $backUrl ?>">
                <i class="fa fa-chevron-left"></i> Back
            </a>
        </div>
        <?php endif; ?>
    </div>
</div>

