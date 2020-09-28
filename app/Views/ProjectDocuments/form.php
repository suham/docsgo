<div class="">
  <div class="row">
    <div class="col-12 col-sm8- offset-sm-2 col-md-7 offset-md-3 mt-1 pt-3 pb-3 bg-white from-wrapper">
      <div class="container">
        <h3><?= $formTitle ?></h3>
        <hr>
        <?php if (session()->get('success') && (!isset($validation))): ?>
          <div class="alert alert-success" role="alert">
            <?= session()->get('success') ?>
          </div>
        <?php endif; ?>
        <form id="documentForm" action="/documents/<?= $action ?>" method="post">
        <?php if (isset($validation)): ?>
            <div class="col-12">
              <div class="alert alert-danger" role="alert">
                <?= $validation->listErrors() ?>
              </div>
            </div>
          <?php endif; ?>
          <div class="col-12 col-sm-6" style="margin:0 auto">
                <div class="form-group">
                <label for="type">Type</label>
                  <select class="form-control" name="type" id="type" >
                  <option value="" disabled <?= isset($projectDocument["type"]) ? '' : 'selected' ?>>
                      Select
                  </option>
                  <?php foreach ($documentType as $key=>$value): ?>
                    <option 
                      <?= isset($projectDocument["type"]) ? (($projectDocument["type"] == $key) ? 'selected readonly': '') : '' ?>
                      value="<?=  $key ?>" ><?=  $value ?></option>
                  <?php endforeach; ?>
                  
                </select>
                </div>

          </div>


          <?php if (isset($sections)): ?>
            <div class="row">
              <div class="col-12 col-sm-4">
                  <div class="form-group">
                  <label for="project-id">Project</label>
                  <select class="form-control" name="project-id" id="project-id" >
                    <option value="" disabled <?= isset($projectDocument['project-id']) ? '' : 'selected' ?>>
                        Select
                    </option>
                    <?php foreach ($projects as $key=>$value): ?>
                      <option 
                        <?= isset($projectDocument['project-id']) ? (($projectDocument['project-id'] == $key) ? 'selected': '') : '' ?>
                        value="<?=  $key ?>" ><?=  $value ?></option>
                    <?php endforeach; ?>
                    
                  </select>
                  </div>
              </div>

              <div class="col-12 col-sm-4">
                <div class="form-group">
                <label for="file-name">File Name</label>
                <input type="text" class="form-control" name="file-name" id="file-name"
                  value="<?= isset($projectDocument['file-name']) ? $projectDocument['file-name'] : '' ?>" >
                </div>
              </div>

              <div class="col-12 col-sm-4">
                <div class="form-group">
                <label for="status">Status</label>
                <select class="form-control" name="status" id="status" >
                  <option value="" disabled <?= isset($projectDocument['status']) ? '' : 'selected' ?>>
                      Select
                  </option>
                  <?php foreach ($planStatus as $key=>$value): ?>
                    <option 
                      <?= isset($projectDocument['status']) ? (($projectDocument['status'] == $key) ? 'selected': '') : '' ?>
                      value="<?=  $value ?>" ><?=  $value ?></option>
                  <?php endforeach; ?>
                  
                </select>
                </div>
              </div>
            </div>

            <hr/>
            <div class="row">
            <div class="col-12">
              <div class="form-group">
                <label for="cp-line3">Title</label>
                <input type="text" class="form-control" name="cp-line3" id="cp-line3"
                  value="<?= isset($template["cp-line3"]) ? $template["cp-line3"] : '' ?>" >
              </div>
            </div>
            
            <div class="col-12 col-sm-6">
              <div class="form-group">
                <label for="cp-line4">Document ID</label>
                <input type="text" class="form-control" name="cp-line4" id="cp-line4"
                  value="<?= isset($template["cp-line4"]) ? $template["cp-line4"] : '' ?>" >
              </div>
            </div>
            <div class="col-12 col-sm-6">
              <div class="form-group">
                <label for="cp-line5">Revision</label>
                <input type="text" class="form-control" name="cp-line5" id="cp-line5"
                  value="<?= isset($template["cp-line5"]) ? $template["cp-line5"] : '' ?>" >
              </div>
            </div>
            
              
            <div class="col-12">
              <div class="form-group">
                <label for="cp-approval-matrix">Approval Matrix</label>
                <input type="text" class="form-control" name="cp-approval-matrix" id="cp-approval-matrix"
                  value="<?= isset($template["cp-approval-matrix"]) ? $template["cp-approval-matrix"] : '' ?>" >
              </div>
            </div>

            <div class="col-12">
              <div class="form-group">
                <label for="cp-change-history">Change History</label>
                <input type="text" class="form-control" name="cp-change-history" id="cp-change-history"
                  value="<?= isset($template["cp-change-history"]) ? $template["cp-change-history"] : '' ?>" >
              </div>
            </div>
          </div>
            <hr/>
            

            <?php foreach ($sections as $section): ?>
              <div class="col-12">
              <div class="form-group">
                <label for="<?=  $section["id"] ?>"><?=  $section["title"] ?></label>
          
                <textarea class="form-control" name="<?=  $section["id"] ?>" id="<?=  $section["id"] ?>"><?=  $section["content"] ?></textarea>
                </div>
              </div>
                

              <?php endforeach; ?>

            <div class="row">
              <div class="col-12 text-center">
                <button type="button" id="updateTemplate" class="btn btn-secondary" title="Save content to template">Update Template</button>
                <button type="submit" class="btn btn-primary ml-3">Submit</button>
              </div>
            </div>

          <?php endif; ?>
       

           

         
        </div>

          
        </form>
      </div>
    </div>
  </div>
</div>

<script>

$("#updateTemplate").click(function(){
  console.log('Update template clicked');
  var form =  $("#documentForm");
  $.ajax({
    type:'POST',
    url: '/documents/updateTemplate',
    data: form.serialize(),
    success: function(response){
      response = JSON.parse(response);
      if(response.success == "True"){
        bootbox.alert({
            message: "Template updated successfully!.",
            backdrop: true
        });
      }else{
        bootbox.alert({
            message: "Template update failed!.",
            backdrop: true
        });
      }
    },
    error: function(err){
      console.log(err);
    }
  })

});

$("#type").change(function(){
  var type = $(this).val();
  var baseUrl = "<?=  $_SERVER['SERVER_NAME'] ?>"
  console.log(baseUrl);
  var url = "/documents/add/"+type;
  console.log(type);
  console.log(url)
  window.location.href = url;
});



</script>

