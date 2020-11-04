<style>
  .nav-link.active {
    color: #f8f9fa !important;
    background-color: #6c757d !important;
  }
  .reviewComments textarea { height: 300px; }
</style>

  <div class="row pl-0 justify-content-center pt-0">
    <div class="col-12 col-md-8 ml-4 pb-3 mt-3 " style="min-height:400px;">
      <div class="container pl-0 pr-0">

        <?php if (session()->get('success') && (!isset($validation))): ?>
        <div class="alert alert-success" role="alert">
          <?= session()->get('success') ?>
        </div>
        <?php endif; ?>
        <form id="documentForm" action="/documents/<?= $action ?>" method="post">

          <div class="row card-header pt-3 mt-3 form-color" >
            <div class="col-8 ">
              <h3><?= $formTitle ?></h3>
            </div>

            <div class="col-4" >
              <div class="form-group mb-0">
                
                <select class="form-control selectpicker" data-style="btn-primary" data-live-search="true" data-size="8" name="type" id="type">
                  <option value="" disabled <?= isset($projectDocument["type"]) ? '' : 'selected' ?>>
                    Select Document Type
                  </option>
                  <?php foreach ($documentType as $key=>$value): ?>
                  <option
                    <?= isset($projectDocument["type"]) ? (($projectDocument["type"] == $key) ? 'selected': '') : '' ?>
                    value="<?=  $key ?>"><?=  $value ?></option>
                  <?php endforeach; ?>

                </select>
              </div>

            </div>
            
          </div>
         
          <?php if (isset($validation)): ?>
          <div class="col-12">
            <div class="alert alert-danger" role="alert">
              <?= $validation->listErrors() ?>
            </div>
          </div>
          <?php endif; ?>

          <?php if (isset($sections)): ?>
          <div class="card  mt-2 form-color">
            <ul class="nav nav-tabs nav-justified" id="myTab" role="tablist">
              <li class="nav-item">
                <a class="nav-link active lead" id="header-tab" data-toggle="tab" href="#header" role="tab"
                  aria-controls="header" aria-selected="true">Header</a>
              </li>
              <li class="nav-item">
                <a class="nav-link lead" id="section-tab" data-toggle="tab" href="#section" role="tab" aria-controls="section"
                  aria-selected="false">Sections</a>
              </li>
            </ul>

            <div class="tab-content pt-1 pl-3 pr-3" id="myTabContent">
              <div class="tab-pane fade show active " id="header" role="tabpanel" aria-labelledby="header-tab">
                <div class="row">
                  <div class="col-12 col-sm-4">
                    <div class="form-group">
                      <label class="font-weight-bold text-muted" for="project-id">Project</label>
                      <select class="form-control  selectpicker" data-live-search="true" data-size="8" name="project-id" id="project-id">
                        <option value="" disabled <?= isset($projectDocument['project-id']) ? '' : 'selected' ?>>
                          Select
                        </option>
                        <?php foreach ($projects as $key=>$value): ?>
                        <option
                          <?= isset($projectDocument['project-id']) ? (($projectDocument['project-id'] == $key) ? 'selected': '') : '' ?>
                          value="<?=  $key ?>"><?=  $value ?></option>
                        <?php endforeach; ?>

                      </select>
                    </div>
                  </div>
                  <?php if (count($existingDocs)): ?>
                  <div class="col-12 col-sm-4"></div>
                  <div class="col-12 col-sm-4 <?= isset($projectDocument["id"]) ? 'd-none' : '' ?>">
                    <div class="form-group">
                      <label class="font-weight-bold text-muted" for="existingDocs">Fill From Existing</label>
                      <select class="form-control  selectpicker" data-live-search="true" data-size="8" name="existingDocs" id="existingDocs">
                        <option value="" selected>
                          Select
                        </option>
                        <?php foreach ($existingDocs as $key=>$value): ?>
                        <option value='<?=  $key ?>'>
                          <?=  $value['json-object'][$type]['cp-line3'] ?></option>
                        <?php endforeach; ?>

                      </select>
                    </div>
                  </div>
                  <?php endif; ?>


                </div>
                <?php $decodedJson = json_decode($jsonTemplate, true);$temp = $decodedJson[$type]; ?>
                <div class="row">
                  <div class="col-6">
                    <div class="form-group">
                      <label class="font-weight-bold text-muted" for="cp-line3">Title</label>
                      <input type="text" class="form-control" name="cp-line3" id="cp-line3"
                        value="<?= isset($temp["cp-line3"]) ? $temp["cp-line3"] : '' ?>" maxlength="64">
                    </div>
                  </div>
                  <div class="col-4">
                    <div class="form-group">
                      <label class = "font-weight-bold text-muted" for="reviewer-id">Reviewer</label>
                      <select class="form-control selectpicker" data-live-search="true" data-size="8"
                          id="reviewer-id" name="reviewer-id">
                          <option disabled selected value> -- select a reviewer -- </option>
                          <?php foreach ($teams as $key=>$value): ?>
                          <option <?= isset($projectDocument['reviewer-id']) ? (($projectDocument['reviewer-id'] == $value['id']) ? 'selected': '') : '' ?>
                          value='<?=  $value['id'] ?>' >
                            <?=  $value['name'] ?></option>
                          <?php endforeach; ?>
                      </select>
                    </div>
                  </div>

                  <div class="col-12 col-sm-2">
                    <div class="form-group">
                      <label class="font-weight-bold text-muted" for="cp-line5">Revision</label>
                      <input type="text" class="form-control" name="cp-line5" id="cp-line5"
                        value="<?= isset($temp["cp-line5"]) ? $temp["cp-line5"] : '' ?>">
                    </div>
                  </div>

                  <div class="col-12 col-sm-9">
                    <div class="form-group">
                      <label class="font-weight-bold text-muted" for="cp-approval-matrix">Approval Matrix</label>
                      <input type="text" class="form-control" name="cp-approval-matrix" id="cp-approval-matrix"
                        value="<?= isset($temp["cp-approval-matrix"]) ? $temp["cp-approval-matrix"] : '' ?>">
                    </div>
                  </div>

                  <div class="col-12 col-sm-3">
                    <div class="form-group">
                      <label class="font-weight-bold text-muted" for="cp-line4">Document ID</label>
                      <input type="text" class="form-control" name="cp-line4" id="cp-line4"
                        value="<?= isset($temp["cp-line4"]) ? $temp["cp-line4"] : '' ?>">
                    </div>
                  </div>
                 
                  <div class="col-12">
                    <div class="form-group">
                      <label class="font-weight-bold text-muted" for="cp-change-history">Change History</label>
                      <textarea data-adaptheight class="form-control" name="cp-change-history"
                        id="cp-change-history"><?= isset($temp["cp-change-history"]) ? $temp["cp-change-history"] : '' ?></textarea>
                    </div>
                  </div>
                </div>
              </div>
              <div class="tab-pane fade" id="section" role="tabpanel" aria-labelledby="section-tab">
                <!-- <div class="d-flex flex-row-reverse ">
                    <a href="#" onclick="reloadSections()" class="btn btn-success mb-2"><i class="fa fa-refresh" aria-hidden="true"></i></a>
                </div> -->
                <?php foreach ($sections as $section): ?>
                  <div class="col-12 mb-3 pl-1 pr-1">
                    
                      <div class="card-header text-white bg-dark">
                        <div class="row" >

                          <div class="col-<?= (isset($section["type"])) ? ($section["type"] == "text" ? '12' : '6') : '12'?>">
                            <div class="row">
                              <div class="col">
                                <div class="input-group">
                                  <?php if (isset($projectDocument['id'])): ?>
                                    <?php if (session()->get('id') == $projectDocument['reviewer-id']): ?>
                                      <div>
                                        <div class="pr-3 pt-1">
                                          <a href="#" class="btn btn-sm btn-outline-warning " onclick="addComment('<?=$section['title']?>')" title="Add review comment">
                                            <i class="fas fa-list "></i>
                                          </a>
                                        </div>
                                      </div>
                                    <?php endif; ?>
                                  <?php endif; ?>
                                  <p class="lead mb-0 pt-1 "><?=  $section["title"] ?></p> 
                                </div>
                              </div>
                            </div>
                           
                          </div>

                          <?php if (isset($section["type"])): ?>
                            <?php if ($section["type"] == "database"): ?>
                              <div class="col-5">
                                <select class="form-control selectpicker" data-actions-box="true" data-live-search="true" data-size="8"
                                  id="select_<?=  $section["id"] ?>" multiple>
                                  <?php foreach ($lookUpTables[$section["tableName"]] as $key=>$value): ?>
                                  <option value='<?=  $value['id'] ?>'>
                                    <?=  $value[$section["headerColumns"] ] ?></option>
                                  <?php endforeach; ?>
                                </select>
                              </div>
                              <div class="col-1 ">
                                <button type="button" class="btn btn-sm btn-outline-light float-right mt-1"
                                  onclick='insertTable("<?=  $section["id"] ?>","<?=$section["tableName"] ?>", "<?=  $section["contentColumns"] ?>" )'>
                                  Insert</button>
                              </div>
                            <?php endif; ?>

                            <?php if ($section["type"] == "differential"): ?>
                              <div class="col-6 ">
                                <button type="button" id="btn_diff_eval_<?=  $section["id"] ?>" class="btn btn-sm  btn-outline-light float-right mt-1"
                                  onclick='evaluteDiff("<?=  $section["id"] ?>", "show")'>
                                  Evaluate</button>
                                <button type="button" id="btn_text_eval_<?=  $section["id"] ?>" class="btn btn-sm  btn-outline-light float-right mt-1 d-none"
                                  onclick='evaluteDiff("<?=  $section["id"] ?>", "hide")'>
                                  Edit</button>
                              </div>
                            <?php endif; ?>
                          <?php endif; ?>
                        </div>
                      </div>
                      
                      <div class="card-body p-0">     
                          
                        <?php if (isset($section["type"])): ?>
                            <?php if ($section["type"] == "differential"): ?>
                              <div id="diffDiv_<?=  $section["id"] ?>" ></div>
                            <?php endif; ?>
                        <?php endif; ?>
                        <textarea class="form-control sections" name="<?=  $section["id"] ?>" id="<?=  $section["id"] ?>"></textarea>
                        

                      </div>
                     
                  </div>


          
                <?php endforeach; ?>
              </div>
            </div>
            <?php 

              $showSubmit = True;
              if(isset($projectDocument["id"])){
                if(session()->get('id') == $projectDocument['author-id'] ){
                  $showSubmit = True;
                }else{
                  $showSubmit = False;
                }
              }
              
              ?>
            
            <?php if($showSubmit): ?>
            <div class="row">
              <div class="col-12 col-sm-3"></div>
              <div class="col-12 col-sm-4">
                <div class="form-group">
                  
                  <select class="form-control" name="status" id="status">
                    <option value="" disabled >
                      Select Status
                    </option>
                    <?php foreach ($documentStatus as $docStatus): ?>
                        <option
                          <?= isset($projectDocument["status"]) ? (($projectDocument["status"] == $docStatus["value"]) ? 'selected': '') : '' ?>
                          value="<?=  $docStatus["value"] ?>"><?=  $docStatus["value"] ?></option>
                    <?php endforeach; ?>

                  </select>
                </div>
              </div>
             
              <div class="col-12 col-sm-4 " >
                <button type="submit" class="btn btn-primary">Submit</button>
              </div>
            
            
            </div>
            <?php endif; ?>
          </div>
          <?php endif; ?>

      </div>


      </form>
    </div>
    <?php if (isset($projectDocument['project-id'])): ?>
    <div class="col reviewDiv ml-2 mr-4 d-none"> 
        <div class="pt-3 mt-3">
          <div class="row card-header  form-color">
            <div class="col-10">
              <h3>Review Comments</h3>
            </div>
            <div class="col-2 text-center">
              <a onclick="saveReview()" class="btn btn-success text-light">
                <i class="fas fa-save "></i>
              </a>
            </div>
          </div>
         
          <div class="row justify-content-center mt-2">
            <div class="col-11 table-warning text-muted rounded">
              <p class="reviewCommentsPara font-weight-bold p-1 pt-3 ">
              </p>
            </div>
            
          </div>
        </div>
    </div>
    <?php endif; ?>
  </div>



<script>
  var type;
  var entireTemplate;
  var existingDocs = [];
  var lookUpTables;

  var sections;
  var reviewComments = "";
  var fileName = "";
  var reviewedSection = [];

  class Review {
    constructor(){
      this.id = '';
      this.docId = '';
      this.projectId = '';
      this.reviewName = '';
      this.category = '';
      this.context = '';
      this.description = '';
      this.reviewBy = '';
      this.assignedTo = '';
      this.reviewRef = '';
      this.status = '';
    }
  }

  var documentReview = new Review();
  var reviewCategory = [];
  var documentStatus = [];



  $(document).ready(function () {
    <?php if (isset($type)): ?>
      type = '<?= $type ?>'; 
    <?php endif; ?>

    <?php foreach ($documentStatus as $docStatus): ?>
      documentStatus.push("<?= $docStatus["value"] ?>");
    <?php endforeach; ?>

    <?php foreach ($reviewCategory as $revCat): ?>
      reviewCategory.push("<?= $revCat["value"] ?>");
    <?php endforeach; ?>

    <?php if (isset($jsonTemplate)): ?>
      entireTemplate = <?= json_encode($jsonTemplate) ?>;
      entireTemplate = JSON.parse(entireTemplate);
    <?php endif; ?>
    fileName = "<?= isset($projectDocument['file-name']) ? $projectDocument['file-name']: '' ?>";
    

    <?php if(isset($projectDocument["id"])): ?>      
      documentReview.docId = "<?= $projectDocument['id'] ?>";
      documentReview.assignedTo = "<?= $projectDocument['author-id'] ?>";      
      documentReview.reviewBy = "<?= session()->get('id') ?>";    
    <?php endif; ?>

    <?php if (isset($documentReview)): ?>
      var savedReview = <?= json_encode($documentReview) ?> ;
      documentReview.id = savedReview["id"];
      documentReview.projectId = savedReview["project-id"];
      documentReview.reviewName = savedReview["review-name"];
      documentReview.category = savedReview["category"];
      documentReview.context = savedReview["context"];
      documentReview.description = savedReview["description"];
      documentReview.reviewBy = savedReview["review-by"];
      documentReview.assignedTo = savedReview["assigned-to"];
      documentReview.reviewRef = savedReview["review-ref"];
      documentReview.status = savedReview["status"];

      reviewComments = documentReview.description;
      var obj = $(".reviewCommentsPara").text(reviewComments);
      obj.html(obj.html().replace(/\n/g,'<br/>'));
   <?php endif; ?>

    <?php if (isset($existingDocs)): ?>
      <?php foreach($existingDocs as $key => $value) : ?>
        var json = <?= json_encode($value['json-object'][$type]) ?> ;
        existingDocs.push(json);
      <?php endforeach; ?>
    <?php endif; ?>



    <?php if (isset($lookUpTables)): ?>
      lookUpTables = <?= json_encode($lookUpTables) ?>;
    <?php endif; ?>

    <?php if (isset($sections)): ?>
      sections = <?= json_encode($sections) ?>;
      
    <?php endif; ?>

    if(!reviewComments.length){
      $(".reviewDiv").addClass('d-none');
    }else{
      $(".reviewDiv").removeClass('d-none');
    }

  });

  $("#project-id").change(function(){
    var type = $( "#type option:selected" ).text();
    var projectName = $( "#project-id option:selected" ).text();
    var title = $("#cp-line3").val();

    if(title == ""){
       $("#cp-line3").val(type+","+projectName);
      }
  });

  window.addEventListener("load", function(){

    setTimeout(function(){ 
      
      if(sections  != undefined){
        for(var z =0; z< sections.length; z++){
          const secType = sections[z].type;
            
            const secId = sections[z].id;
            const secVal = sections[z].content;
            $('#'+secId).val(secVal)
            const $codemirror = $('textarea[name="'+secId+'"]').nextAll('.CodeMirror')[0].CodeMirror;
            $codemirror.setValue(secVal);
            $codemirror.refresh();
            if(secType == "differential"){
              if(secVal != ""){
                evaluteDiff(secId, 'show');
              }
              
            }
            
        }
      }
  
      }, 500);

 });

  function saveReview(){
    if(reviewComments == "") return;
    
    var categoryOptions = "", statusOptions = "";

    documentStatus.forEach((value)=>{
      statusOptions += `<option value="${value}">${value}</option>`;
    });

    reviewCategory.forEach((value)=>{
      categoryOptions += `<option value="${value}">${value}</option>`;
    });

    var dialog = bootbox.dialog({
      title: 'Add review comments',
      message: `<div class="row mt-3">
                <div class="col-12 col-md-6">
                  <select class="form-control reviewCategory selectpicker" data-live-search="true" data-size="8" name="type" id="type">
                    <option value="" disabled selected>
                      Select Category
                    </option>
                    ${categoryOptions}
                  </select>
                </div>
                <div class="col-12 col-md-6">
                  <select class="form-control reviewStatus selectpicker" name="type" id="type">
                    <option value="" disabled selected>
                      Select Status
                    </option>
                    ${statusOptions}
                  </select>
                </div>
              </div>
              <div class="row mt-3">
                <div class="col-12">
                  <textarea class="form-control reviewRef" maxlength="250"  placeholder="Reference" ></textarea>
                </div>
              </div>`,
      buttons: {
        cancel: {
            label: "Cancel",
            className: 'btn-secondary'
        },
        ok: {
            label: "OK",
            className: 'btn-primary',
            callback: function(){
                
                var reviewCategory = $("select.reviewCategory").val();
                var reviewStatus = $("select.reviewStatus").val();
                var reviewRef =  $(".reviewRef").val();
                
                if(reviewCategory == null || reviewStatus == null){
                  showPopUp('Error', "Reviewer name, review category and status are required.");
                  
                }else{
                  
                  documentReview.projectId = $("#project-id").val();
                  documentReview.reviewName = fileName;
                  documentReview.category = reviewCategory;
                  documentReview.context = fileName;
                  documentReview.description = reviewComments.trim();
                  // documentReview.reviewBy = reviewedBy;
                  
                  // documentReview.assignedTo = $("#author-id").val();
                  documentReview.reviewRef = reviewRef;
                  documentReview.status = reviewStatus;

                  console.log(documentReview);
                  submitReviewComment(documentReview);
                  
                }
              }
        }
      }
    });

    if(documentReview.reviewBy != ""){
      $("select.reviewedBy").val(documentReview.reviewBy);
      $("select.reviewCategory").val(documentReview.category);
      $("select.reviewStatus").val(documentReview.status);
      $(".reviewRef").text(documentReview.reviewRef);
    }

    $('.selectpicker').selectpicker('refresh');

  }

  function submitReviewComment(documentReview) {
    var successMessage = "Review comment added successfully!."
    if(documentReview["id"] != ""){
      successMessage = "Review comment updated successfully!."
    }
        
    $.ajax({
      type: 'POST',
      url: '/reviews/addDocReview',
      data: documentReview,
      success: function (response) {        
        response = JSON.parse(response);
        if (response.success == "True") {
          documentReview["id"] = response.reviewId;
          var statusDD = $("#status").val();
          if(statusDD != undefined){
            $("#status").val(documentReview["status"]);
          }
          showPopUp("Success", successMessage);
        } else {
          showPopUp("Failure", "Failed to add a new template!.");
        }
      },
      error: function (err) {
        console.log(err);
      }
    })

 }

 function showPopUp(title, message){
  bootbox.alert({
        title: title, 
        message: message,
        centerVertical: true,
        backdrop: true
    });
}

  function evaluteDiff(sectionId, visibility){
    
    if(visibility == "show"){
     
      const $codemirror = $('textarea[name="' + sectionId + '"]').nextAll('.CodeMirror')[0].CodeMirror;
      var sectionValue = $codemirror.getValue();
      const targetElement = document.getElementById('diffDiv_'+sectionId);
      const configuration = { drawFileList: true, matching: 'none', };

      const diff2htmlUi = new Diff2HtmlUI(targetElement, sectionValue, configuration);
      diff2htmlUi.draw();

      $("#diffDiv_"+sectionId).removeClass('d-none');
      
      $("#btn_text_eval_"+sectionId).removeClass('d-none');
      $("#btn_diff_eval_"+sectionId).addClass('d-none');
      
      var toolbar = $("#"+sectionId).closest('div').find('.editor-toolbar');
      var codeMirrorDiv = $("#"+sectionId).closest('div').find('.CodeMirror');
      $(toolbar).addClass('d-none');
      $(codeMirrorDiv).addClass('d-none');
    }else{
      
      $("#diffDiv_"+sectionId).addClass('d-none');
      $("#btn_text_eval_"+sectionId).addClass('d-none');
      $("#btn_diff_eval_"+sectionId).removeClass('d-none');
      var toolbar = $("#"+sectionId).closest('div').find('.editor-toolbar');
      var codeMirrorDiv = $("#"+sectionId).closest('div').find('.CodeMirror');
      $(toolbar).removeClass('d-none');
      $(codeMirrorDiv).removeClass('d-none');
      const $codemirror = $('textarea[name="' + sectionId + '"]').nextAll('.CodeMirror')[0].CodeMirror;
      $codemirror.refresh();
    }
   
  }

  function addComment(sectionName){
    bootbox.prompt({
      title: "Review Comments",
      className: 'reviewComments',
      inputType: 'textarea',
        callback: function (result) {
          if(result != null){
           
            reviewComments =  result;
            reviewedSection.push(sectionName); 
            
            var obj = $(".reviewCommentsPara").text(reviewComments);
            obj.html(obj.html().replace(/\n/g,'<br/>'));
            $(".reviewDiv").removeClass('d-none');
          }
            
        }
    });
    if(reviewComments != ""){reviewComments = reviewComments+ "\n\n"}
    if(reviewedSection.includes(sectionName)){
      sectionName = "";
    }
    var description = reviewComments+sectionName+ "\n";
    $('.bootbox-input-textarea').val(description.trim());
  
  }


 

  $("#section-tab").click(function(){
    setTimeout(function(){ 
      for(var z =0; z< sections.length; z++){
        const secId = sections[z].id;
        var $cm = $('textarea[name="'+secId+'"]').nextAll('.CodeMirror')[0].CodeMirror;
        $cm.refresh();
      }
    }, 500);
  });

  function reloadSections(){
    console.log("Reload Sections");
    for(var z =0; z< sections.length; z++){
        const secId = sections[z].id;
        var $cm = $('textarea[name="'+secId+'"]').nextAll('.CodeMirror')[0].CodeMirror;
        $cm.refresh();
      }
      return false;
  }

  $('#documentForm').submit(function (eventObj) {

    var $codemirror1 = $('textarea[name="cp-change-history"]').nextAll('.CodeMirror')[0].CodeMirror;
    var changeHistory = $codemirror1.getValue();

    var allSections = $("textarea.sections");
    var newSections = []
    for (var i = 0; i < allSections.length; i++) {
      var sectionId = allSections[i].id;
      const $codemirror = $('textarea[name="' + sectionId + '"]').nextAll('.CodeMirror')[0].CodeMirror;
      var sectionValue = $codemirror.getValue();      

      var temp = sections.find(x => x.id === sectionId);
      if(temp.type == "differential"){
        temp['content'] = sectionId;
      }else{
        temp['content'] = sectionValue;
      }
      
      
      newSections.push(temp);

    }

    entireTemplate[type]['cp-line3'] = $("#cp-line3").val();
    entireTemplate[type]['cp-line4'] = $("#cp-line4").val();
    entireTemplate[type]['cp-line5'] = $("#cp-line5").val();
    entireTemplate[type]['cp-approval-matrix'] = $("#cp-approval-matrix").val();
    entireTemplate[type]['cp-change-history'] = changeHistory;
    entireTemplate[type]["sections"] = newSections;
    console.log(entireTemplate);
    var jsonObject = JSON.stringify(entireTemplate);
    
    $(this).append('<textarea name="json-object" style="display:none;">' + jsonObject + '</textarea>');

    return true;
  });

  function insertTable(sectionId, tableName, columnValues) {
    
    var selectedIds = $("#select_" + sectionId).val();
    var table = lookUpTables[tableName];
    var dataFormat = "table";
    if (tableName == "traceabilityMatrix" || tableName == "riskAssessment") {
      dataFormat = "list";
    }

    var indexes = columnValues.split(',');
    var content = "";

    if(dataFormat == "table"){

      var thead = "| " + columnValues.toUpperCase().replaceAll(',', " | ") + " |\n";
      
      indexes.forEach((index, i) => {
        thead += "|-------";

        if(i == (indexes.length-1)){
          thead += "|\r\n";
        }

      });

      content = thead;
      
      selectedIds.forEach((id) => {
        var record = table.find(x => x.id === id);
       
        indexes.forEach((index, j) => {
          if(j == 0){
            content += "| ";
          }

          var value = record[index];
          content += value.replace(/(\r\n|\n|\r)/gm, "") + " |";

          if(j == (indexes.length-1)){
            content += "\n";
          }
        });
       
      });

    }else{
      
      selectedIds.forEach((id) => {
        var record = table.find(x => x.id === id);
        indexes.forEach((index, i) => {
          var value = record[index];
          content += "|"+index.toUpperCase()+"|"+value.replace(/(\r\n|\n|\r)/gm, "") + "|\r\n";
          if(i == 0){
            content += "|---------|---------|\r\n";
          }
          if(i == (indexes.length-1)){
            content += "\n";
          }
          
        });
        
      });


    }

    const $codemirror = $('textarea[name="' + sectionId + '"]').nextAll('.CodeMirror')[0].CodeMirror;
    const existingVal = $codemirror.getDoc().getValue();
    $codemirror.getDoc().setValue(existingVal+"\n"+content);

  }

  $("#updateTemplate").click(function () {

    var form = $("#documentForm");
    $.ajax({
      type: 'POST',
      url: '/documents/updateTemplate',
      data: form.serialize(),
      success: function (response) {
        response = JSON.parse(response);
        if (response.success == "True") {
          bootbox.alert({
            message: "Template updated successfully!.",
            backdrop: true
          });
        } else {
          bootbox.alert({
            message: "Template update failed!.",
            backdrop: true
          });
        }
      },
      error: function (err) {
        console.log(err);
      }
    })

  });

  $("#type").change(function () {
    var type = $(this).val();
    var url = "/documents/add/" + type;

    window.location.href = url;
  });

  $("#existingDocs").change(function () {
    var value = $(this).val();
    if (value != "") {
      var jsonValue = existingDocs[value];

      // $("#cp-line3").val(jsonValue['cp-line3']);
      $("#cp-line4").val(jsonValue['cp-line4']);
      $("#cp-line5").val(jsonValue['cp-line5']);
      $("#cp-approval-matrix").val(jsonValue['cp-approval-matrix']);
      $("#cp-change-history").val(jsonValue['cp-change-history']);

      var $codemirror1 = $('textarea[name="cp-change-history"]').nextAll('.CodeMirror')[0].CodeMirror;
      $codemirror1.getDoc().setValue(jsonValue["cp-change-history"]);

      var sections = jsonValue.sections;
      for (var i = 0; i < sections.length; i++) {
        var section = sections[i];
        $("#" + section.id).text(section.content);

        var $codemirror = $('textarea[name="' + section.id + '"]').nextAll('.CodeMirror')[0].CodeMirror;
        $codemirror.getDoc().setValue(section.content);
      }



    }


  });
</script>