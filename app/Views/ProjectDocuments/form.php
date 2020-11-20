<style>
    
    .nav-link.active {
        color: #f8f9fa !important;
        background-color: #6c757d !important;
    }

    .nav-item {
        background: #e9ecef;
    }

    .reviewComments textarea { 
        height: 300px;
    }

    .scroll-primary {
        max-height: 625px;
        overflow: scroll;
        overflow-x:hidden;
    }

    .scroll-primary::-webkit-scrollbar {
        width: 0.25rem;
    }

    .scroll-primary::-webkit-scrollbar-track {
        width: #007bff;
    }

    .scroll-primary::-webkit-scrollbar-thumb {
        background: #007bff;
    }


    .sticky {
        position: sticky;
        top: 0;
        z-index:9;
    }

    .back-to-top {
        position: fixed;
        bottom: 25px;
        right: 25px;
        display: none;
        border: 1px solid;
    }

</style>

<div class="row pl-4 justify-content-center pt-0">

    <div class="col-12 col-md-8 ml-4 pb-3 mt-3 ">

        <?php if (session()->get('success')): ?>
          <div class="alert alert-success" role="alert">
            <?= session()->get('success') ?>
          </div>
        <?php endif; ?>

        <!-- Form starts here -->
        <form id="documentForm" action="/documents/save" method="post">
            <?php
                if(isset($projectDocument)){
                    $heading = $projectDocument['file-name'];
                    $title = $jsonObject["cp-line3"];
                    $docId = $projectDocument["id"];
                    $docType = $projectDocument["type"];
                    
                }else{
                    $heading = $formTitle;
                    $title = $docTitle;
                    $docId = "";
                    $docType = $type;                    
                }
                     
            ?>
         

             <!-- Hidden Fields for form -->
            <input type="hidden" id="project-id" name="project-id" value="<?= $project_id ?>" >
            <input type="hidden" id="id" name="id" value="<?= $docId ?>" >
            <input type="hidden" id="type" name="type" value="<?= $docType ?>" >

            <div class="card  mt-2 form-color" style="border:0px !important;">
                 <!-- Document Title -->
                <div class="card-header form-color sticky" >
                    <div class="row">
                        
                        <div class="ml-3">
                            <h3 title="<?= $heading ?>" class="heading"><?= $heading ?></h3>
                        </div>
                        <?php if (isset($projectDocument)): ?>   
                            <div class="ml-auto mr-3" >
                                <button type="button" id ="project-name" 
                                        class="btn btn-info"><?= $project_name ?>
                                </button>
                            </div>
                        <?php endif; ?>

                    </div>
                
                

                </div>


                <ul class="nav nav-tabs nav-justified sticky" style="top:66px" id="myTab" role="tablist">
                    <li class="nav-item">
                        <a class="nav-link active lead" id="header-tab" data-toggle="tab" href="#header" role="tab"
                        aria-controls="header" aria-selected="true">Header</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link lead" id="section-tab" data-toggle="tab" href="#section" role="tab" aria-controls="section"
                        aria-selected="false">Sections</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link lead" id="revision-tab" data-toggle="tab" href="#revision" role="tab" aria-controls="revision"
                        aria-selected="false">Revision History</a>
                    </li>
                </ul>

                <div class="tab-content pt-1 pl-3 pr-3" id="myTabContent">

                    <div class="tab-pane fade show active" id="header" role="tabpanel" aria-labelledby="header-tab">
                        <?php if (isset($existingDocs)): ?>
                            <div class="row">

                                <div class="col-12 col-sm-4">
                                    <div class="form-group">
                                        <label class="font-weight-bold text-muted" for="project-name">Project</label> <br/>
                                        <button type="button" id ="project-name" 
                                                class="btn btn-info"><?= $project_name ?>
                                        </button>
                                    
                                    </div>
                                </div>
                                
                                
                                <div class="col-12 col-sm-2"></div>

                                <div class="col-12 col-sm-6 <?= isset($projectDocument["id"]) ? 'd-none' : '' ?>">
                                    <div class="form-group">
                                        <label class="font-weight-bold text-muted" for="existingDocs">Fill From Existing</label>
                                        <div class="input-group">
                                            <?php 
                                                if($allExistingDocs != "TRUE" ){
                                                    $docsDrop = $existingDocs["my"];
                                                    $checked = "checked";
                                                }else{
                                                    $docsDrop = $existingDocs["all"];
                                                    $checked = "";
                                                }

                                                if(isset($selectedExistingDocId)){
                                                    $selectedDocId = $selectedExistingDocId;
                                                }else{
                                                    $selectedDocId = "";
                                                }
                                            ?>
                                        
                                            <select class="form-control  selectpicker"   data-live-search="true" data-size="8" id="existingDocs">
                                                <option value="" selected>
                                                Select
                                                </option>
                                                <?php foreach ($docsDrop as $key=>$value): ?>
                                                    <option <?=  ($value["id"] == $selectedDocId)? 'selected' : '' ?>
                                                    value='<?=  $value["id"] ?>'><?=  $value['title'] ?></option>
                                                <?php endforeach; ?>

                                            </select>
                                            <input type="checkbox"  id="existingDocType" data-on="MY" data-onstyle="success"  data-offstyle="info"
                                            data-off="ALL" <?= $checked ?> data-toggle="toggle" >
                                        </div>
                                    </div>
                                </div>
                                

                            </div>
                        <?php endif; ?>
                        <div class="row">

                            <div class="col-6">
                                <div class="form-group">
                                    <label class="font-weight-bold text-muted" for="cp-line3">Title</label>
                                    <input required type="text" class="form-control" name="cp-line3" id="cp-line3"
                                        value="<?= $title  ?>" maxlength="64">
                                </div>
                            </div>

                            <div class="col-4">
                                <div class="form-group">
                                    <label class = "font-weight-bold text-muted" for="reviewer-id">Reviewer</label>
                                    <select  class="form-control selectpicker" data-live-search="true" data-size="8"
                                        id="reviewer-id" name="reviewer-id" requried>
                                        <option disabled selected value> -- select a reviewer -- </option>
                                        <?php foreach ($teams as $key=>$value): ?>
                                        <option <?= isset($projectDocument['reviewer-id']) ? (($projectDocument['reviewer-id'] == $key) ? 'selected': '') : '' ?>
                                        value='<?=  $key ?>' >
                                            <?=  $value ?></option>
                                        <?php endforeach; ?>
                                    </select>
                                </div>
                            </div>

                            <div class="col-12 col-sm-2">
                                <div class="form-group">
                                    <label class="font-weight-bold text-muted" for="cp-line5">Revision</label>
                                    <input type="text" class="form-control" name="cp-line5" id="cp-line5"
                                        value="<?= $jsonObject["cp-line5"] ?>">
                                </div>
                            </div>

                            <div class="col-12 col-sm-9">
                                <div class="form-group">
                                    <label class="font-weight-bold text-muted" for="cp-approval-matrix">Approval Matrix</label>
                                    <input type="text" class="form-control" name="cp-approval-matrix" id="cp-approval-matrix"
                                        value="<?= $jsonObject["cp-approval-matrix"] ?>">
                                </div>
                            </div>

                            <div class="col-12 col-sm-3">
                                <div class="form-group">
                                <label class="font-weight-bold text-muted" for="cp-line4">Document ID</label>
                                <input type="text" class="form-control" name="cp-line4" id="cp-line4"
                                    value="<?= $jsonObject["cp-line4"] ?>">
                                </div>
                            </div>

                            <div class="col-12">
                                <div class="form-group">
                                    <label class="font-weight-bold text-muted" for="cp-change-history">Change History</label>
                                    <textarea class="form-control" name="cp-change-history"
                                        id="cp-change-history"><?= $jsonObject["cp-change-history"] ?></textarea>
                                </div>
                            </div>
                        </div>

                        <!-- Submit button shouldb be visible if -->
                        <!-- it is new or owned by author -->
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
                                        <select class="form-control selectpicker" name="status" id="status">
                                            <option value="" disabled >
                                            Select Status
                                            </option>
                                            <?php foreach ($documentStatus as $key=>$value): ?>
                                                <option
                                                <?= isset($projectDocument["status"]) ? (($projectDocument["status"] == $value) ? 'selected': '') : '' ?>
                                                value="<?=  $value ?>"><?=  $value ?></option>
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



                    <div class="tab-pane fade" id="section" role="tabpanel" aria-labelledby="section-tab">
                        
                        <!-- Creating Sections -->
                        <?php foreach ($jsonObject['sections'] as $section): ?>
                            
                            <div class="col-12 mb-3 pl-1 pr-1">
                                <!-- Section Title -->
                                <div class="card-header text-white bg-dark">
                                    <div class="row" >
                                        <!-- If a section has a dropdown than take half the width otherwise take full width -->
                                        <div class="col-<?= (isset($section["type"])) ? ($section["type"] == "text" ? '12' : '6') : '12'?>">
                                            <div class="row">
                                                <div class="col">
                                                    <div class="input-group">
                                                        <!-- Show Review button only if it matches with assigned reviewer id -->
                                                        <?php if (isset($projectDocument['id'])): ?>
                                                            
                                                            <div>
                                                                <div class="pr-3 pt-1">
                                                                    <a href="#" class="btn btn-sm btn-outline-warning " onclick="addComment('<?=$section['title']?>')" title="Add review comment">
                                                                        <i class="fas fa-list "></i>
                                                                    </a>
                                                                </div>
                                                            </div>
                                                            
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

                                        <?php endif; ?>
                                    </div>
                                </div>

                                <!-- Section Body -->
                            
                                <div class="card-body p-0">     
                                    <textarea class="form-control sections" name="<?=  $section["id"] ?>" id="<?=  $section["id"] ?>"><?=  $section["content"] ?></textarea>
                                </div>
                            
                            </div>
                        
                        <?php endforeach; ?>
                    </div>

                    <div class="tab-pane fade" id="revision" tole="tabpanel" aria-labelledby="revision-tab">
                        <div class="alert alert-warning revisionAlert" role="alert">
                            No revision history available.
                        </div>
                        <table class="table table-hover d-none revisionTable">
                            <thead>
                                <tr>
                                <th scope="col" >#</th>
                                <th scope="col">Revision log</th>
                                <th scope="col">User name</th>
                                <th scope="col" style="width:125px">Timestamp</th>
                                </tr>
                            </thead>
                            <tbody id="revisionBody">
                                
                            </tbody>
                        </table>
                    </div>

                </div>


            </div>


        </form>


    </div>

    <!-- Review Div -->
    <?php if (isset($projectDocument['project-id'])): ?>
        <div class="col reviewDiv mr-2 mt-4 d-none"> 
            <div class="col sticky">
                <div class="p-3 form-color ">

                    <div class="row">
                        <div class="col-10">
                            <h5 class="text-primary mt-2">Review Comments</h5>
                        </div>
                        <div class="col-2 pl-2">
                            
                            <a onclick="saveReview()" class="btn btn-primary text-light ">
                                <i class="fas fa-save "></i>
                            </a>
                            
                        </div>
                        
                    </div>
                    <hr/>
                    <div class="scroll-primary">
                        <p class="reviewCommentsPara p-1 pt-3" style="max-height: 456px;"></p>
                    </div>
                
                </div>
            </div>
        </div>
    <?php endif; ?>
</div>

<a id="back-to-top" href="#" class="btn btn-light btn-lg back-to-top text-primary" role="button"><i class="fas fa-chevron-up"></i></a>
<script>
    var existingDocList = [];
    var revisionHistory = null;
    var lookUpTables;
    //For Review
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
    var reviewedSection = [], reviewComments = "", reviewCategory = [], documentStatus = [];

    $(document).ready( function () {
        $(window).scroll(function () {
			if ($(this).scrollTop() > 50) {
				$('#back-to-top').fadeIn();
			} else {
				$('#back-to-top').fadeOut();
			}
		});
		// scroll body to 0px on click
		$('#back-to-top').click(function () {
			$('body,html').animate({
				scrollTop: 0
			}, 400);
			return false;
        });
        
        <?php if (isset($lookUpTables)): ?>
            lookUpTables = <?= json_encode($lookUpTables) ?>;
        <?php endif; ?>

        <?php if (isset($existingDocs)): ?>
            existingDocList =  <?= json_encode($existingDocs) ?>;
        <?php endif; ?>

        <?php if(isset($projectDocument)): ?>
            <?php if($projectDocument["revision-history"] != null): ?>
                revisionHistory =  <?= json_encode($projectDocument["revision-history"]) ?>;
                showRevisionHistory(revisionHistory);
            <?php endif; ?>
        <?php endif; ?>
        $(".sticky").parents().css("overflow", "visible")
        $("body").css("overflow-x", "hidden");

        // For Review
        <?php foreach ($documentStatus as $docStatus): ?>
            documentStatus.push("<?= $docStatus ?>");
        <?php endforeach; ?>

        <?php foreach ($reviewCategory as $revCat): ?>
            reviewCategory.push("<?= $revCat ?>");
        <?php endforeach; ?>

        <?php if(isset($projectDocument["id"])): ?>      
            documentReview.docId = "<?= $projectDocument['id'] ?>";
            documentReview.assignedTo = "<?= $projectDocument['author-id'] ?>";      
            documentReview.reviewBy = "<?= session()->get('id') ?>";    
            documentReview.projectId = $("#project-id").val();
            documentReview.context = "<?= $projectDocument['file-name'] ?>";
        <?php endif; ?>

        <?php if (isset($documentReview)): ?>
            $(".reviewDiv").removeClass('d-none');
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
        columnValues = columnValues.toUpperCase();
        var thead = "| " + columnValues.replace(/,/g," | ");+ " |\n";
        
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

    // Revision History Feature
    function showRevisionHistory(revisionHistory){
        $(".revisionTable").removeClass('d-none');
        $(".revisionAlert").addClass('d-none');

        revisionHistory = JSON.parse(revisionHistory);
        revisionHistory = revisionHistory['revision-history'].reverse();
        // console.log(revisionHistory);
        var totalCount = revisionHistory.length;
        var rowClass = "";
        var iconClass = "";
        $('#revisionBody').html("");
        revisionHistory.forEach((revision)=>{
            if(revision["type"] == "Created"){
                rowClass = "primary";
                iconClass = "fa fa-plus-circle";
            }else if(revision["type"] == "Edited"){
                rowClass = "success";
                iconClass = "fa fa-pencil";
            }else{
                rowClass = "warning";
                iconClass = "fas fa-list";
            }
            var td = `<td> 
                        <a title="${revision["type"]}" class="text-light btn btn-${rowClass}">
                            <i class="${iconClass}"></i>
                        <span class="ml-2  badge  badge-light">${totalCount}</span>
                        </a>
                    </td>`;
            td += `<td>${revision["log"]}</td>`;
            td += `<td>${revision["who"]}</td>`;
            td += `<td>${formatDate(revision["dateTime"])}</td>`;
            $('#revisionBody').append( `<tr class="table-${rowClass}">` + td + '</tr>' );
            totalCount--;
        });
    }

    function formatDate(utcDate) {
        let utc = new Date(utcDate)
        var ist = new Date(utc.getTime() + ( 5.5 * 60 * 60 * 1000 ));
        var date = ist;
        var year = date.getFullYear();
        var month = date.getMonth() + 1;
        var day = date.getDate();
        var hours = date.getHours();
        var minutes = date.getMinutes();
        var ampm = hours >= 12 ? 'pm' : 'am';
        hours = hours % 12;
        hours = hours ? hours : 12; // the hour '0' should be '12'
        minutes = minutes < 10 ? '0'+minutes : minutes;
        var strTime = hours + ':' + minutes + ' ' + ampm;
        return year+"-"+month+"-"+day+" "+strTime;
    }

    // For Reloading Sections in section tab
    $("#section-tab").click(function(){
        setTimeout(function(){ 
            $('.sections').each(function () {
                var $cm = $(this).nextAll('.CodeMirror')[0].CodeMirror;
                $cm.refresh();
                // $cm.on("update", function(el) {
                //     const updatedValue = el.getValue()
                //     var textarea = el.getTextArea();
                //     textarea.innerHTML = updatedValue;
                // });
            });
      
        }, 500);
    });

    // For Updating Existing List Dropdown
    $("#existingDocType").change(function(){
        const checked = $(this).prop('checked');
        var options;
        if(checked){
            options = existingDocList["my"];
        }else{
            options = existingDocList["all"];
        }

        var docOptions = '<option value="" disabled selected>SELECT</option>';
        options.forEach((value)=>{
            docOptions += `<option value="${value["id"]}">${value["title"]}</option>`;
        });

        
        var selectExistingDocs = $("#existingDocs");
        selectExistingDocs.empty();
        selectExistingDocs.append(docOptions);
        selectExistingDocs.selectpicker('refresh');

    });

    $("#existingDocs").change(function(){
        const existingId = this.value;
        const project_id = $("#project-id").val();
        // console.log(this.value);
        const url = `/documents/add?project_id=${project_id}&existing_id=${this.value}`;
        // console.log(url);
        location.href = url;
    });

    $('form').on('submit', function (e) {
        e.preventDefault();

        var docId = $("#id").val();
        const reviewerId = $("#reviewer-id").val();
        if(reviewerId == null){
            showPopUp("Validation Error", "Reviewer is required!");
            return false;
        }

        var $codemirror1 = $('textarea[name="cp-change-history"]').nextAll('.CodeMirror')[0].CodeMirror;
        var changeHistory = $codemirror1.getValue();

        //Creating formData as original form is sometimes not taking updated values
        //of textareas.
        var formData = {
            'id': $("#id").val(),
            'type': $("#type").val(), 
            'project-id': $("#project-id").val(),
            'reviewer-id': $("#reviewer-id").val(),
            'status': $("#status").val(),
            'cp-line3' : $("#cp-line3").val(),
            'cp-line4' : $("#cp-line4").val(),
            'cp-line5' : $("#cp-line5").val(),
            'cp-approval-matrix' : $("#cp-approval-matrix").val(),
            'cp-change-history' : changeHistory,
        }

        var allSections = $("textarea.sections");
        for (var i = 0; i < allSections.length; i++) {
            var sectionId = allSections[i].id;
            const $codemirror = $('textarea[name="' + sectionId + '"]').nextAll('.CodeMirror')[0].CodeMirror;
            var sectionValue = $codemirror.getValue();      

            formData[sectionId] = sectionValue;

        }

        var successMessage = "Document created successfully.";
        if(docId != ""){
            successMessage = "Document updated successfully.";
        }        


        $.ajax({
            type: 'post',
            url: '/documents/save',
            data: formData,
            success: function (response) {       
                response = JSON.parse(response);
                if (response.success == "True") {
                    if(docId == ""){
                        location.href = "/documents/add?id="+response.id;
                    }else{
                        const fileName = response.fileName;
                        $(".heading").text(fileName);

                        revisionHistory = response.revisionHistory;
                        showRevisionHistory(revisionHistory);
                        showPopUp("Success", successMessage);
                    }
                    
                    
                    
                   
                } else {
                    showPopUp("Failure", "Failed to update document");
                }
            },
            error: function (err) {
                showPopUp("Failure", "Error occured on server.");
            }
        });

    });


    function addComment(sectionName){
        bootbox.prompt({
            title: "Review Comments",
            className: 'reviewComments',
            centerVertical: true,
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
        if(reviewComments != ""){reviewComments = reviewComments+ "\n"}
        var dash = "";
        if(reviewedSection.includes(sectionName)){
            sectionName = "";
        }else{
            dash += " - ";
        }
        var description = reviewComments+sectionName+dash+ "\n";
        $('.bootbox-input-textarea').val(description.trim());
  
    }

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
            centerVertical: true,
            title: 'Save review comments',
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
                            <textarea class="form-control reviewRef" maxlength="250"  placeholder="Author's Note" ></textarea>
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
                        
                            documentReview.category = reviewCategory;
                            documentReview.description = reviewComments.trim();
                            documentReview.reviewRef = reviewRef;
                            documentReview.status = reviewStatus;
                            documentReview.reviewName = reviewCategory+" Review";
                            // console.log(documentReview);
                            submitReviewComment(documentReview);
                        
                        }
                    }
                }
            }
        });

        
        if(documentReview.id != ""){            
            $("select.reviewCategory").val(documentReview.category);
            $("select.reviewStatus").val(documentReview.status);
            $(".reviewRef").text(documentReview.reviewRef);
        }else{
            $("select.reviewStatus").val("Request Change");
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
                    $("#status").val(response.status);
                    $('.selectpicker').selectpicker('refresh');
                    showRevisionHistory(response.revisionHistory);
                    showPopUp("Success", successMessage);
                } else {
                    showPopUp("Failure", "Failed to add a review comment!.");
                }
            },
            error: function (err) {
                console.log(err);
            }
        })

    }

    //Auto Hiding of Success alert after document generation
    $(".alert-success").fadeTo(2000, 500).slideUp(500, function() {
      $(".alert-success").slideUp(500);
    });

    
    function showPopUp(title, message){
        bootbox.alert({
                title: title, 
                message: message,
                centerVertical: true,
                backdrop: true
            });
    }


</script>