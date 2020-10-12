<style>
  .nav-link.active {
    color: #f8f9fa !important;
    background-color: #6c757d !important;
  }
</style>
<div class="">
  <div class="row justify-content-center">
    <div class="col-12 col-md-9 mt-1 pt-3 pb-3 bg-white from-wrapper">
      <div class="container">

        <?php if (session()->get('success') && (!isset($validation))): ?>
        <div class="alert alert-success" role="alert">
          <?= session()->get('success') ?>
        </div>
        <?php endif; ?>
        <form id="documentForm" action="/documents/<?= $action ?>" method="post">

          <div class="row">
            <div class="col-12 col-sm-6">
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
                  <div class="col-12">
                    <div class="form-group">
                      <label class="font-weight-bold text-muted" for="cp-line3">Title</label>
                      <input type="text" class="form-control" name="cp-line3" id="cp-line3"
                        value="<?= isset($temp["cp-line3"]) ? $temp["cp-line3"] : '' ?>">
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
                    <div class="card">
                      <div class="card-header text-white bg-dark">
                        <div class="row" style="margin-bottom:-10px">
                          <div class="col">
                            <p class="lead"><?=  $section["title"] ?></p>
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
                          <?php endif; ?>
                        </div>
                      </div>
                      <div class="card-body">
                        <textarea class="form-control sections" name="<?=  $section["id"] ?>"
                          id="<?=  $section["id"] ?>"><?=  $section["content"] ?></textarea>
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
                      <?= isset($projectDocument['status']) ? (($projectDocument['status'] == $key) ? 'selected': '') : '' ?>
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
  </div>
</div>
</div>

<script>
  var type;
  var entireTemplate;
  var existingDocs = [];
  var teamsTable;
  var reviewsTable;
  var referencesTable;
  var templateSections;

  $(document).ready(function () {
    <?php if (isset($type)): ?>
      type = '<?= $type ?>'; 
    <?php endif; ?>

    <?php if (isset($jsonTemplate)): ?>
      entireTemplate = <?= $jsonTemplate ?>;
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

    <?php if (isset($sections)): ?>
      sections = <?= json_encode($sections) ?>;
    <?php endif; ?>

  });

  $("#section-tab").click(function(){
    setTimeout(function(){ 
      $('textarea').each(function() {
      var textarea = this.name;
      if(textarea != ""){
        var $cm = $('textarea[name="'+textarea+'"]').nextAll('.CodeMirror')[0].CodeMirror;
        $cm.refresh();
      }
      
    });

    }, 500);

   
  

  });

  $('#documentForm').submit(function (eventObj) {

    const $codemirror1 = $('textarea[name="cp-change-history"]').nextAll('.CodeMirror')[0].CodeMirror;
    var changeHistory = $codemirror1.getValue();

    var allSections = $("textarea.sections");
    var newSections = []
    for (var i = 0; i < allSections.length; i++) {
      var sectionId = allSections[i].id;
      const $codemirror = $('textarea[name="' + sectionId + '"]').nextAll('.CodeMirror')[0].CodeMirror;
      var sectionValue = $codemirror.getValue();
      var temp = sections.find(x => x.id === sectionId);
      temp['content'] = sectionValue;
      newSections.push(temp);
    }

    entireTemplate[type]['cp-line3'] = $("#cp-line3").val();
    entireTemplate[type]['cp-line4'] = $("#cp-line4").val();
    entireTemplate[type]['cp-line5'] = $("#cp-line5").val();
    entireTemplate[type]['cp-approval-matrix'] = $("#cp-approval-matrix").val();
    entireTemplate[type]['cp-change-history'] = changeHistory;
    entireTemplate[type]["sections"] = newSections;
    console.log(entireTemplate);
    $(this).append('<textarea type="hidden" name="json-object" style="display:none;">' + JSON.stringify(
      entireTemplate) + '</textarea>');

    return true;
  });

  function insertTable(sectionId, tableName, columnValues) {
    console.log(columnValues, sectionId);
    var selectedIds = $("#select_" + sectionId).val();
    var table;
    if (tableName == "teams") {
      table = teamsTable;
    } else if (tableName == "reviews") {
      table = reviewsTable;
    } else if (tableName == "documentMaster") {
      table = referencesTable;
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
        content += record[index].replace(/(\r\n|\n|\r)/gm, "") + " |";
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

      const $codemirror1 = $('textarea[name="cp-change-history"]').nextAll('.CodeMirror')[0].CodeMirror;
      $codemirror1.getDoc().setValue(section.content);

      var sections = jsonValue.sections;
      for (var i = 0; i < sections.length; i++) {
        var section = sections[i];
        $("#" + section.id).text(section.content);

        const $codemirror = $('textarea[name="' + section.id + '"]').nextAll('.CodeMirror')[0].CodeMirror;
        $codemirror.getDoc().setValue(section.content);
      }



    }


  });
</script>