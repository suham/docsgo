
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
                <label class = "font-weight-bold text-muted" for="risk_type">Risk Type</label>
                <select class="form-control fstdropdown-select" name="risk_type" id="risk_type" disabled readonly="readonly" disabled="disabled" >
                  <option value="" disabled <?= isset($member['risk_type']) ? '' : 'selected' ?>>
                      Select
                  </option>
                  <?php foreach ($riskAssessmentStatus as $value): ?>
                    <option 
                      <?= isset($member['risk_type']) ? (($member['risk_type'] == $value) ? 'selected': '') : '' ?>
                      value="<?=  $value ?>" ><?=  $value ?></option>
                  <?php endforeach; ?>                      
                </select>
              </div>
            </div>

            <div class="col-12">
              <div class="form-group" id="risk_name">
              <label class = "font-weight-bold text-muted" for="issue" >Risk</label>
              <input type="text" class="form-control" name="issue" id="issue"
              value="<?= isset($member['issue']) ? $member['issue'] : '' ?>" >
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
                <label class = "font-weight-bold text-muted" for="severity">Severity</label>
                  <select class="form-control fstdropdown-select" onchange="calculateRPNValue()" name="severity" id="severity" >
                    <option value="" disabled <?= isset($member['severity']) ? '' : 'selected' ?>>
                      Select
                    </option>
                    <?php foreach ($statusOptions as $key=>$value): ?>
                      <option 
                        <?= isset($member['severity']) ? (($member['severity'] == $key) ? 'selected': '') : '' ?>
                        value="<?=  $key ?>" ><?=  $value ?></option>
                    <?php endforeach; ?>                
                  </select>
              </div>
            </div>

            <div class="col-12">
              <div class="form-group">
                <label class = "font-weight-bold text-muted" for="occurrence">Occurrence</label>
                  <select class="form-control fstdropdown-select" onchange="calculateRPNValue()" name="occurrence" id="occurrence" >
                    <option value="" disabled <?= isset($member['occurrence']) ? '' : 'selected' ?>>
                      Select
                    </option>
                    <?php foreach ($statusOptions as $key=>$value): ?>
                      <option 
                        <?= isset($member['occurrence']) ? (($member['occurrence'] == $key) ? 'selected': '') : '' ?>
                        value="<?=  $key ?>" ><?=  $value ?></option>
                    <?php endforeach; ?>                
                  </select>
              </div>
            </div>

            <div class="col-12">
              <div class="form-group">
                <label class = "font-weight-bold text-muted" for="detectability">Detectability</label>
                  <select class="form-control fstdropdown-select" onchange="calculateRPNValue()" name="detectability" id="detectability" >
                    <option value="" disabled <?= isset($member['detectability']) ? '' : 'selected' ?>>
                      Select
                    </option>
                    <?php foreach ($statusOptions as $key=>$value): ?>
                      <option 
                        <?= isset($member['detectability']) ? (($member['detectability'] == $key) ? 'selected': '') : '' ?>
                        value="<?=  $key ?>" ><?=  $value ?></option>
                    <?php endforeach; ?>                
                  </select>
              </div>
            </div>

            <div class="col-12">
              <div class="form-group">
              <label class = "font-weight-bold text-muted" for="rpn">Risk Priority Number (RPN)</label>
              <input type="text" class="form-control" name="rpn" id="rpn" readonly
              value="<?= isset($member['rpn']) ? $member['rpn'] : '' ?>" >
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
$('#risk_type_selection, #risk_description, #risk_name').css('pointer-events', 'none');
function calculateRPNValue() {
  var sv, ov, dv, severityNumber=1,occurrenceNumber=1,detectabilityNumber=1;
  severityNumber = $("#severity").val();
  if(severityNumber == null || severityNumber == undefined)
    severityNumber = 1;

  occurrenceNumber = $("#occurrence").val();
  if(occurrenceNumber == null || occurrenceNumber == undefined)
    occurrenceNumber = 1;

  detectabilityNumber = $("#detectability").val();
  if(detectabilityNumber == null || detectabilityNumber == undefined)
    detectabilityNumber = 1;

  var rpn = severityNumber * occurrenceNumber * detectabilityNumber;
  $('#rpn').val(severityNumber * occurrenceNumber * detectabilityNumber);
}

</script>
