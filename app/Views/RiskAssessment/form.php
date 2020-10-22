
  <div class="row">
    <div class="col-12 col-sm8- offset-sm-2 col-md-6 offset-md-3 mt-1 pt-3 pb-3 bg-white from-wrapper">

      <div class="container">
        <h3><?= $formTitle ?></h3>
        <hr>
        <?php if (session()->get('success')): ?>
          <div class="alert alert-success" role="alert">
            <?= session()->get('success') ?>
          </div>
        <?php endif; ?>
        <!-- Submit action -->
        <form class="" action="/risk-assessment/<?= $action ?>" method="post">
          <div class="row">
            <?php if (isset($validation)): ?>
              <div class="col-12">
                <div class="alert alert-danger" role="alert">
                  <?= $validation->listErrors() ?>
                </div>
              </div>
            <?php endif; ?>

            <div class="col-12">
              <div class="form-group" readonly="readonly" id="risk_type_selection">
              <label class = "font-weight-bold text-muted" for="project">Project</label>
               <select class="form-control  selectpicker" data-live-search="true" data-size="8" name="project" id="project">
                <option value="" disabled <?= isset($member['project_id']) ? '' : 'selected' ?>>
                    Select
                </option>
                <?php foreach ($projects as $key=>$value): ?>
                  <option 
                    <?= isset($member['project_id']) ? (($member['project_id'] == $key) ? 'selected': '') : '' ?>
                    value="<?=  $key ?>" ><?=  $value ?></option>
                <?php endforeach; ?>
              </select>
              </div>
            </div>

            <div class="col-12">
              <div class="form-group" id="risk_name">
              <label class = "font-weight-bold text-muted" for="category">Category</label>
                  <select class="form-control  selectpicker" data-live-search="true" data-size="8" name="category" id="category">
                    <option value="" disabled <?= isset($member['category']) ? '' : 'selected' ?>>
                        Select
                    </option>
                    <?php foreach ($riskCategory as $value): ?>
                      <option 
                        <?= isset($member['category']) ? (($member['category'] == $value) ? 'selected': '') : '' ?>
                        value="<?=  $value ?>" ><?=  $value ?></option>
                    <?php endforeach; ?>                    
                  </select>
              </div>
            </div>

            <div class="col-12">
              <div class="form-group">
              <label class = "font-weight-bold text-muted" for="name">Name</label>
              <input type="text" class="form-control" name="name" id="name"
              value="<?= isset($member['name']) ? $member['name'] : '' ?>" >
              </div>
            </div>

            <div class="col-12">
              <div class="form-group" id='risk_description'>
                <label class = "font-weight-bold text-muted" for="description" >Description</label>
                <textarea class="form-control" name="description" id="description" maxlength=100><?=
                isset($member['description']) ? trim($member['description']) : ''
                ?></textarea>
              </div>
            </div>

            <div class="col-12">
              <div class="form-group">
              <label class = "font-weight-bold text-muted" for="information">Information</label>
              <input type="text" class="form-control" name="information" id="information"
              value="<?= isset($member['information']) ? $member['information'] : '' ?>" >
              </div>
            </div>

            <div class="col-12">
              <div class="form-group">
                <label class = "font-weight-bold text-muted" for="severity">Severity</label>
                  <select class="form-control  selectpicker" data-live-search="true" data-size="8" onchange="calculateRPNValue()" name="severity" id="severity" >
                    <option value="" disabled <?= isset($member['severity']) ? '' : 'selected' ?>>
                      Select
                    </option>
                    <?php foreach ($severityListOptions as $key=>$value): ?>
                      <option 
                        <?= isset($member['severity']) ? (($member['severity'] == $key) ? 'selected': '') : '' ?>
                        value="<?=  $key ?>" ><?=  $value ?></option>
                    <?php endforeach; ?>                
                  </select>
              </div>
            </div>

            <div>
                <div id="severity-desc"></div>
            </div>

            <div class="col-12">
              <div class="form-group">
                <label class = "font-weight-bold text-muted" for="occurrence">Occurrence</label>
                  <select class="form-control  selectpicker" data-live-search="true" data-size="8" onchange="calculateRPNValue()" name="occurrence" id="occurrence" >
                    <option value="" disabled <?= isset($member['occurrence']) ? '' : 'selected' ?>>
                      Select
                    </option>
                    <?php foreach ($occurrenceListOptions as $key=>$value): ?>
                      <option 
                        <?= isset($member['occurrence']) ? (($member['occurrence'] == $key) ? 'selected': '') : '' ?>
                        value="<?=  $key ?>" ><?=  $value ?></option>
                    <?php endforeach; ?>                
                  </select>
              </div>
            </div>

            <div>
                <div id="occurrence-desc"></div>
            </div>

            <div class="col-12">
              <div class="form-group">
                <label class = "font-weight-bold text-muted" for="detectability">Detectability</label>
                  <select class="form-control  selectpicker" data-live-search="true" data-size="8" onchange="calculateRPNValue()" name="detectability" id="detectability" >
                    <option value="" disabled <?= isset($member['detectability']) ? '' : 'selected' ?>>
                      Select
                    </option>
                    <?php foreach ($detectabilityListOptions as $key=>$value): ?>
                      <option 
                        <?= isset($member['detectability']) ? (($member['detectability'] == $key) ? 'selected': '') : '' ?>
                        value="<?=  $key ?>" ><?=  $value ?></option>
                    <?php endforeach; ?>                
                  </select>
              </div>
            </div>

            <div>
                <div id="detectability-desc"></div>
            </div>

            <div class="col-12">
              <div class="form-group">
              <label class = "font-weight-bold text-muted" for="rpn">Risk Priority Number (RPN)</label>
              <input type="text" class="form-control" name="rpn" id="rpn" readonly
              value="<?= isset($member['rpn']) ? $member['rpn'] : '' ?>" >
              </div>
            </div>

          </div>
          <div class="row mt-sm-2">
            <div class="col-12 col-sm-8">
                <div class="form-group">
                <label class = "font-weight-bold text-muted" for="status">Status</label>
                    <select class="form-control  selectpicker" data-live-search="true" data-size="8" name="status" id="status">
                      <option value="" disabled <?= isset($member['status']) ? '' : 'selected' ?>>
                          Select
                      </option>
                      <?php foreach ($riskStatus as $value): ?>
                        <option 
                          <?= isset($member['status']) ? (($member['status'] == $value) ? 'selected': '') : '' ?>
                          value="<?=  $value ?>" ><?=  $value ?></option>
                      <?php endforeach; ?>
                      
                    </select>

                </div>
            </div>
          </div>

          <br/><br/><br/>
          <div class="row">
            <div class="col-12 col-sm-4">
              <button type="submit" class="btn btn-primary">Submit</button>
            </div>
          </div>

        </form>
      </div>

    </div>
  </div>

<script>
// $('#risk_type_selection, #risk_description, #risk_name').css('pointer-events', 'none');
function calculateRPNValue() {
  var severityList = {
    5: 'Hazardous Catastrophic Involves noncompliance with regulatory safety operation requirement of the medical device. Failure mode of the device exposes the patient to greater harm.',
		4: 'Loss of monitoring function or patient experiences very high discomfort due to failure, or user extremely dissatisfied, non-critical injury to patient.',
		3: 'Recoverable loss of monitoring function, or failure mode noticeable causing inconvenience, user dissatisfied.',
		2: 'Negligible loss of monitoring function, reduced level of system performance, user somewhat dissatisfied.',
		1: 'No recognizable effect.'
  };
  var occurrenceList = {
    5: 'Failures are certain to occur Failures occur at least 3 times in 10 events.',
		4: 'Frequent occurrence Failures occur once in 10 events.',
		3: 'Failures occasionally occur Failures occur once in 100 events.',
		2: 'Failures are unlikely Failures occur once in 1,000 events.',
		1: 'Failures are extremely rare Failures occur once in 10,000 events'
  };
  var detectabilityList = {
    5: 'Defect is obvious and will be detected, thereby preventing the failure effect. Defect criteria are measurable, have a requirement and 100% testing is performed using non-visual criteria.',
		4: 'Defect is relatively apparent and will most likely be detected, thereby preventing the failure effect. Defect criteria are measurable, have a requirement but not 100% tested or is 100% tested using visual criteria.',
		3: 'Defect may not be detected in time to prevent the failure effect. Defect criteria have subtle interpretations and may not always be detected in-process or prior to use.',
		2: 'High likelihood that the defect will not be detected in time to prevent the failure effect. Defect criteria are vague, not measurable/visible in the final assembly and are subject to wide interpretation.',
		1: 'Very high likelihood that the defect will not be detected in time to prevent the failure effect.'
  };
  var sv, ov, dv, severityNumber=1,occurrenceNumber=1,detectabilityNumber=1;
  severityNumber = $("#severity").val();
  if(severityNumber == null || severityNumber == undefined){
    severityNumber = 1;
    $("#severity-desc").html(''); 
  }else{
    $("#severity-desc").html(severityList[severityNumber]+"<br/><br/>"); 
  }

  occurrenceNumber = $("#occurrence").val();
  if(occurrenceNumber == null || occurrenceNumber == undefined){
      occurrenceNumber = 1;
    $("#occurrence-desc").html(''); 
  }else{
    $("#occurrence-desc").html(occurrenceList[occurrenceNumber]+"<br/><br/>"); 
  }
  detectabilityNumber = $("#detectability").val();
  if(detectabilityNumber == null || detectabilityNumber == undefined){
    detectabilityNumber = 1;
    $("#detectability-desc").html(''); 
  }else{
    $("#detectability-desc").html(detectabilityList[detectabilityNumber]+"<br/><br/>");
  }

  var rpn = severityNumber * occurrenceNumber * detectabilityNumber;
  $('#rpn').val(severityNumber * occurrenceNumber * detectabilityNumber);
}

</script>
