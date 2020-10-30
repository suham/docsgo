<div class="p-0 p-md-4">
  <div class="row justify-content-center">
    <div class="col-12 col-md-9 ml-0 pb-3 pt-3 from-wrapper rounded bg-white">
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

                    <?php foreach ($reviewCategory as $revCat): ?>
                        <option 
                          <?= isset($review['category']) ? (($review['category'] == $revCat["value"]) ? 'selected': '') : '' ?>
                          value="<?=  $revCat["value"] ?>" ><?=  $revCat["value"] ?></option>
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

            <div class="col-12 differential <?=isset($review['category']) ? (($review['category'] == "Code") ? '' : 'd-none' ) : 'd-none'?>">
              <div class="form-group">
                <div class="row">
                  <div class="col-10"><label class = "font-weight-bold text-muted" for="code-diff">Code Diff</label></div>
                  <div class="col-2">
                    <button type="button" id="btn_diff_eval"  class="btn btn-sm  btn-outline-dark float-right mt-1"
                            onclick='evaluteDiff("code-diff", "show")'>
                            Evaluate</button>
                    <button type="button" id="btn_text_eval"  class="btn btn-sm  btn-outline-dark float-right mt-1 d-none"
                            onclick='evaluteDiff("code-diff", "hide")'>
                            Edit</button>
                  </div>
                </div>
               
                <textarea  class="form-control" name="code-diff" id="code-diff" ></textarea>
                <div id="diffDiv"></div>
              </div>
            </div>
           

            <div class="col-12">
              <div class="form-group">
               <label class = "font-weight-bold text-muted" for="description">Review Comment</label>
               <textarea  class="form-control" name="description" id="description" ><?=
                isset($review['description']) ? trim($review['description']) : ''
                ?></textarea>
              </div>
            </div>

            <div class="col-12 ">
              <div class="form-group">
               <label class = "font-weight-bold text-muted" for="review-ref">Author's Note</label>
               <textarea  class="form-control" name="review-ref" id="review-ref" ><?=
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

<script>
var review;
  $(document).ready(function () {
    <?php if (isset($review)): ?>
      review = <?= json_encode($review) ?>;
      if(review["code-diff"] != null && review["code-diff"] != ""){
        var differential = review["code-diff"];
          $('#code-diff').val(differential)
        setTimeout(function(){ 
          
          evaluteDiff("code-diff", "show");
        },500);
        // evaluteDiff("diffDiv", "show");
        // const $codemirror = $('textarea[name="code-diff"]').nextAll('.CodeMirror')[0].CodeMirror;
        // $codemirror.setValue(differential);
        // $codemirror.refresh();
      }
    <?php endif; ?>


  });

  function evaluteDiff(sectionId, visibility){
    
    if(visibility == "show"){
     
      const $codemirror = $('textarea[name="' + sectionId + '"]').nextAll('.CodeMirror')[0].CodeMirror;
      var sectionValue = $codemirror.getValue();
      const targetElement = document.getElementById('diffDiv');
      const configuration = { drawFileList: true, matching: 'none', };

      const diff2htmlUi = new Diff2HtmlUI(targetElement, sectionValue, configuration);
      diff2htmlUi.draw();

      $("#diffDiv").removeClass('d-none');
      
      $("#btn_text_eval").removeClass('d-none');
      $("#btn_diff_eval").addClass('d-none');
      
      var toolbar = $("#"+sectionId).closest('div').find('.editor-toolbar');
      var codeMirrorDiv = $("#"+sectionId).closest('div').find('.CodeMirror');
      $(toolbar).addClass('d-none');
      $(codeMirrorDiv).addClass('d-none');
    }else{
      
      $("#diffDiv").addClass('d-none');
      $("#btn_text_eval").addClass('d-none');
      $("#btn_diff_eval").removeClass('d-none');
      var toolbar = $("#"+sectionId).closest('div').find('.editor-toolbar');
      var codeMirrorDiv = $("#"+sectionId).closest('div').find('.CodeMirror');
      $(toolbar).removeClass('d-none');
      $(codeMirrorDiv).removeClass('d-none');
      const $codemirror = $('textarea[name="' + sectionId + '"]').nextAll('.CodeMirror')[0].CodeMirror;
      $codemirror.refresh();
    }
   
  }

  $("#category").change(function(){
    var selectedText = $(this).find("option:selected").text();
    var selectedValue = $(this).val();
    console.log(selectedValue)
    if(selectedValue == "Code"){
      $(".differential").removeClass('d-none');
    }else{
      $(".differential").addClass('d-none');
    }

  });
</script>