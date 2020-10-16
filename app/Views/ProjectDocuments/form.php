<style>
  .nav-link.active {
    color: #f8f9fa !important;
    background-color: #6c757d !important;
  }
  .reviewComments textarea { height: 300px; }
</style>

  <div class="row pl-0 justify-content-center">
    <div class="col-12 col-md-9 ml-0  mt-1 pt-3 pb-3 bg-white from-wrapper rounded">
      <div class="container">

        <?php if (session()->get('success') && (!isset($validation))): ?>
        <div class="alert alert-success" role="alert">
          <?= session()->get('success') ?>
        </div>
        <?php endif; ?>
        <form id="documentForm" action="/documents/<?= $action ?>" method="post">

          <div class="row">
            <div class="col-12 ">
              <h3><?= $formTitle ?></h3>
            </div>
            
          </div>
          <hr>
          <?php if (isset($validation)): ?>
          <div class="col-12">
            <div class="alert alert-danger" role="alert">
              <?= $validation->listErrors() ?>
            </div>
          </div>
          <?php endif; ?>


          <div class="col-12 col-sm-6" style="margin:0 auto">
            <div class="form-group">
              <label class="font-weight-bold text-muted" for="type">Type</label>
              <select class="form-control" name="type" id="type">
                <option value="" disabled <?= isset($projectDocument["type"]) ? '' : 'selected' ?>>
                  Select
                </option>
                <?php foreach ($documentType as $key=>$value): ?>
                <option
                  <?= isset($projectDocument["type"]) ? (($projectDocument["type"] == $key) ? 'selected readonly': '') : '' ?>
                  value="<?=  $key ?>"><?=  $value ?></option>
                <?php endforeach; ?>

              </select>
            </div>

          </div>


          <?php if (isset($sections)): ?>
          <div class="card  mt-2">
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

            <div class="tab-content p-4" id="myTabContent">
              <div class="tab-pane fade show active mt-4" id="header" role="tabpanel" aria-labelledby="header-tab">
                <div class="row">
                  <div class="col-12 col-sm-4">
                    <div class="form-group">
                      <label class="font-weight-bold text-muted" for="project-id">Project</label>
                      <select class="form-control fstdropdown-select" name="project-id" id="project-id">
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
                  <div class="col-12 col-sm-2"></div>
                  <div class="col-12 col-sm-6">
                    <div class="form-group">
                      <label class="font-weight-bold text-muted" for="existingDocs">Fill From Existing</label>
                      <select class="form-control fstdropdown-select" name="existingDocs" id="existingDocs">
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
                  <div class="col-6">
                    <div class="form-group">
                      <label class = "font-weight-bold text-muted" for="author-id">Author</label>
                      <select class="form-control selectpicker" data-live-search="true" data-size="8"
                          id="author-id" name="author-id">
                          <option disabled selected value> -- select an author -- </option>
                          <?php foreach ($teams as $key=>$value): ?>
                          <option <?= isset($projectDocument['author-id']) ? (($projectDocument['author-id'] == $value['id']) ? 'selected': '') : '' ?>
                          value='<?=  $value['id'] ?>' >
                            <?=  $value['name'] ?></option>
                          <?php endforeach; ?>
                      </select>
                    </div>
                  </div>

                  <div class="col-12 col-sm-6">
                    <div class="form-group">
                      <label class="font-weight-bold text-muted" for="cp-line4">Document ID</label>
                      <input type="text" class="form-control" name="cp-line4" id="cp-line4"
                        value="<?= isset($temp["cp-line4"]) ? $temp["cp-line4"] : '' ?>">
                    </div>
                  </div>
                  <div class="col-12 col-sm-6">
                    <div class="form-group">
                      <label class="font-weight-bold text-muted" for="cp-line5">Revision</label>
                      <input type="text" class="form-control" name="cp-line5" id="cp-line5"
                        value="<?= isset($temp["cp-line5"]) ? $temp["cp-line5"] : '' ?>">
                    </div>
                  </div>


                  <div class="col-12">
                    <div class="form-group">
                      <label class="font-weight-bold text-muted" for="cp-approval-matrix">Approval Matrix</label>
                      <input type="text" class="form-control" name="cp-approval-matrix" id="cp-approval-matrix"
                        value="<?= isset($temp["cp-approval-matrix"]) ? $temp["cp-approval-matrix"] : '' ?>">
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
              <div class="tab-pane fade mt-3" id="section" role="tabpanel" aria-labelledby="section-tab">
                <?php foreach ($sections as $section): ?>
                  <div class="col-12 mb-3">
                    <div class="">
                      <div class="card-header text-white bg-dark">
                        <div class="row" style="margin-bottom:-10px">

                          <div class="col-6">
                            <div class="row">
                              <?php if (isset($projectDocument['project-id'])): ?>
                              <div class="col-2">
                                <a href="#" class="btn btn-sm btn-warning" onclick="addComment('<?=$section['title']?>')" title="Add review comment">
                                <i class="fas fa-comments text-dark"></i></a>
                              </div>
                              <?php endif; ?>
                              <div class="col-8">
                                <p class="lead "><?=  $section["title"] ?></p>
                              </div>
                            </div>
                           
                          </div>

                          <?php if (isset($section["type"])): ?>
                            <?php if ($section["type"] == "database"): ?>
                              <div class="col-5">
                                <select class="form-control selectpicker" data-actions-box="true" data-live-search="true" data-size="8"
                                  id="select_<?=  $section["id"] ?>" multiple>
                                  <?php foreach (${$section["tableName"]} as $key=>$value): ?>
                                  <option value='<?=  $value['id'] ?>'>
                                    <?=  $value[$section["headerColumns"] ] ?></option>
                                  <?php endforeach; ?>
                                </select>
                              </div>
                              <div class="col-1 ">
                                <button type="button" class="btn btn-sm btn-success text-white float-right mt-1"
                                  onclick='insertTable("<?=  $section["id"] ?>","<?=$section["tableName"] ?>", "<?=  $section["contentColumns"] ?>" )'>
                                  Insert</button>
                              </div>
                            <?php endif; ?>

                            <?php if ($section["type"] == "differential"): ?>
                              <div class="col-6 ">
                                <button type="button" id="btn_diff_eval_<?=  $section["id"] ?>" class="btn btn-sm btn-success text-white float-right mt-1"
                                  onclick='evaluteDiff("<?=  $section["id"] ?>", "show")'>
                                  Evaluate</button>
                                <button type="button" id="btn_text_eval_<?=  $section["id"] ?>" class="btn btn-sm btn-success text-white float-right mt-1 d-none"
                                  onclick='evaluteDiff("<?=  $section["id"] ?>", "hide")'>
                                  Edit</button>
                              </div>
                            <?php endif; ?>
                          <?php endif; ?>
                        </div>
                      </div>

                      
                      <div class="card-body p-0">     
                          
                        <? if (isset($section["type"])): ?>
                            <? if ($section["type"] == "differential"): ?>
                              <div id="diffDiv_<?=  $section["id"] ?>" class="pb-2"></div>
                            <? endif; ?>
                        <? else : ?>
                          <textarea class="form-control sections" name="<?=  $section["id"] ?>" id="<?=  $section["id"] ?>"></textarea>
                        <? endif; ?>

                      </div>
                     
                      
                    </div>
                  </div>


          
                <?php endforeach; ?>
              </div>
            </div>

            <div class="row">
              <div class="col-12 col-sm-3"></div>
              <div class="col-12 col-sm-4">
                <div class="form-group">
                  <label class="font-weight-bold text-muted" for="status">Status</label>
                  <select class="form-control" name="status" id="status">
                    <option value="" disabled <?= isset($projectDocument['status']) ? '' : 'selected' ?>>
                      Select
                    </option>
                    <?php foreach ($planStatus as $key=>$value): ?>
                    <option
                      <?= isset($projectDocument['status']) ? (($projectDocument['status'] == $value) ? 'selected': '') : '' ?>
                      value="<?=  $value ?>"><?=  $value ?></option>
                    <?php endforeach; ?>

                  </select>
                </div>
              </div>
              <div class="col-12 col-sm-4 " style="margin-top:1.8rem">
                <button type="submit" class="btn btn-primary">Submit</button>
              </div>
            </div>
          </div>
          <?php endif; ?>

      </div>


      </form>
    </div>
    <?php if (isset($projectDocument['project-id'])): ?>
    <div class="col reviewDiv"> 
        <div class="from-wrapper mt-1 p-3 pb-3 bg-white rounded">
          <div class="row">
            <div class="col">
              <h3>Review Comments</h3>
            </div>
            <div class="col text-center">
              <a onclick="saveReview()" class="btn btn-primary mt-2 text-light">
                <i class="fas fa-save "></i>
                Save
              </a>
            </div>
          </div>
          <hr>
          <div class="row justify-content-center">
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
  var teamsTable;
  var reviewsTable;
  var referencesTable;
  var requirementsTable;
  var traceabilityMatrixTable;
  var documentsTable;
  var riskAssessmentTable; 

  var templateSections;
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

  $(document).ready(function () {
    <?php if (isset($type)): ?>
      type = '<?= $type ?>'; 
    <?php endif; ?>

    <?php if (isset($jsonTemplate)): ?>
      entireTemplate = <?= $jsonTemplate ?>;
    <?php endif; ?>
    fileName = "<?= isset($projectDocument['file-name']) ? $projectDocument['file-name']: '' ?>";

    documentReview.docId = "<?= isset($projectDocument['id']) ? $projectDocument['id']: '' ?>";
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

    <?php if (isset($teams)): ?>
      teamsTable = <?= json_encode($teams) ?>;
    <?php endif; ?>
    <?php if (isset($reviews)): ?>
      reviewsTable = <?= json_encode($reviews) ?>;
    <?php endif; ?>
    <?php if (isset($documentMaster)): ?>
      referencesTable = <?= json_encode($documentMaster) ?>;
    <?php endif; ?>
    <?php if (isset($requirements)): ?>
      requirementsTable = <?= json_encode($requirements) ?>;
    <?php endif; ?>
    <?php if (isset($traceabilityMatrix)): ?>
      traceabilityMatrixTable = <?= json_encode($traceabilityMatrix) ?>;
    <?php endif; ?>
    <?php if (isset($documents)): ?>
      documentsTable = <?= json_encode($documents) ?>;
    <?php endif; ?>
    <?php if (isset($riskAssessment)): ?>
      riskAssessmentTable = <?= json_encode($riskAssessment) ?>;
    <?php endif; ?>


    <?php if (isset($sections)): ?>
      sections = <?= json_encode($sections) ?>;
      
    <?php endif; ?>

    if(!reviewComments.length){
      $(".reviewDiv").addClass('d-none');
    }

  });

  window.addEventListener("load", function(){
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
  });

  function saveReview(){
    if(reviewComments == "") return;
    
    var teamOptions = "";
    
    teamsTable.forEach((data)=>{
      teamOptions += `<option value="${data.id}">${data.name}</option>`;
    });

    var dialog = bootbox.dialog({
      title: 'Add review comments',
      message: `<div class="row justify-content-center saveModal">
                <div class="col-12 col-md-6">
                  <select class="form-control reviewedBy selectpicker" data-live-search="true" data-size="8" name="type" id="type">
                    <option value="" disabled selected>
                      Select Reviewer Name
                    </option>
                    ${teamOptions}
                  </select>
                </div>
              </div>
              <div class="row mt-3">
                <div class="col-12 col-md-6">
                  <select class="form-control reviewCategory selectpicker" name="type" id="type">
                    <option value="" disabled selected>
                      Select Category
                    </option>
                    <option value="Document">Document</option>
                    <option value="Test case">Test case</option>
                    <option value="Code">Code</option>
                    <option value="Report">Report</option>
                  </select>
                </div>
                <div class="col-12 col-md-6">
                  <select class="form-control reviewStatus selectpicker" name="type" id="type">
                    <option value="" disabled selected>
                      Select Status
                    </option>
                    <option value="Request Change">Request Change</option>
                    <option value="Ready For Review">Ready For Review</option>
                    <option value="Accepted">Accepted</option>
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
                var reviewedBy = $("select.reviewedBy").val();
                var reviewCategory = $("select.reviewCategory").val();
                var reviewStatus = $("select.reviewStatus").val();
                var reviewRef =  $(".reviewRef").val();
                
                if(reviewedBy ==  null || reviewCategory == null || reviewStatus == null){
                  showPopUp('Error', "Reviewer name, review category and status are required.");
                  
                }else{
                  
                  documentReview.projectId = $("#project-id").val();
                  documentReview.reviewName = fileName;
                  documentReview.category = reviewCategory;
                  documentReview.context = fileName;
                  documentReview.description = reviewComments.trim();
                  documentReview.reviewBy = reviewedBy;
                  documentReview.assignedTo = $("#author-id").val();
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
      
      var toolbar = $("#section1").closest('div').find('.editor-toolbar');
      var codeMirror = $("#section1").closest('div').find('.CodeMirror');
      $(toolbar).addClass('d-none');
      $(codeMirror).addClass('d-none');
    }else{
      
      $("#diffDiv_"+sectionId).addClass('d-none');
      $("#btn_text_eval_"+sectionId).addClass('d-none');
      $("#btn_diff_eval_"+sectionId).removeClass('d-none');
      var toolbar = $("#section1").closest('div').find('.editor-toolbar');
      var codeMirror = $("#section1").closest('div').find('.CodeMirror');
      $(toolbar).removeClass('d-none');
      $(codeMirror).removeClass('d-none');
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
    var table;
    if (tableName == "teams") {
      table = teamsTable;
    } else if (tableName == "reviews") {
      table = reviewsTable;
    } else if (tableName == "documentMaster") {
      table = referencesTable;
    } else if (tableName == "requirements") {
      table = requirementsTable;
    }else if (tableName == "traceabilityMatrix") {
      table = traceabilityMatrixTable;
    }else if (tableName == "documents") {
      table = documentsTable;
    }else if (tableName == "riskAssessment") {
      table = riskAssessmentTable;
    }
    
    var indexes = columnValues.split(',');
    var separator = "";
    for (var i = 0; i < indexes.length; i++) {
      separator += "|-------";
    }
    separator += "|";

    var content = "";
    content += "| " + columnValues.replaceAll(',', " | ") + " |";
    content = content.toUpperCase();
    content += "\r\n";
    content += separator;
    content += "\r\n";
    selectedIds.forEach((id) => {
      var record = table.find(x => x.id === id);
      content += "| ";
      indexes.forEach((index) => {
        var value = record[index];
        content += value.replace(/(\r\n|\n|\r)/gm, "") + " |";
      });
      content += "\r\n";
    });
    const $codemirror = $('textarea[name="' + sectionId + '"]').nextAll('.CodeMirror')[0].CodeMirror;
    $codemirror.getDoc().setValue(content);
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

      $("#cp-line3").val(jsonValue['cp-line3']);
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