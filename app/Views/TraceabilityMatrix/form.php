
  <div class="row">
    <div class="col-12 col-sm8- offset-sm-2 col-md-6 offset-md-3 mt-1 pt-3 pb-3 bg-white from-wrapper">
      <div class="container11">
        <h3><?= $formTitle ?></h3>
        <hr>
        <?php if (session()->get('success')): ?>
          <div class="alert alert-success" role="alert">
            <?= session()->get('success') ?>
          </div>
        <?php endif; ?>
        <!-- Submit action -->
        <form class="" action="/traceability-matrix/<?= $action ?>" method="post">
          <div class="row">
            <?php if (isset($validation)): ?>
              <div class="col-12 ">
                <div class="alert alert-danger" role="alert">
                  <?= $validation->listErrors() ?>
                </div>
              </div>
            <?php endif; ?>
            
            <div class="col-12 col-sm-6">
              <div class="form-group">
              <label class = "font-weight-bold text-muted" for="userNeeds">User Needs</label>
              
              <select class="form-control fstdropdown-select" name="userNeeds[]" id="userNeeds" onchange="getIDDescription('#userNeeds')">
              <option value="" disabled <?= isset($member['userNeeds']) ? '' : 'selected' ?>>
                    Select User Needs
                </option>
                  <?php foreach ($userNeedsList as $key=>$value): ?>
                  <option 
                    <?= isset($userNeedsListKeys) ? ((in_array($key, $userNeedsListKeys)) ? 'selected': '') : '' ?>
                    value="<?=  $key ?>" ><?=  $value ?></option>
                <?php endforeach; ?>
              </select>
              </div>
            </div>

            <div class="col-12  col-sm-6">
              <div class="form-group">
                <div id="userNeeds_description"></div>
              </div>
            </div>  

            <div class="col-12 col-sm-6">
              <div class="form-group">
              <label class = "font-weight-bold text-muted" for="sysreq">System</label>
              <select class="form-control selectpicker" data-live-search="true" multiple id="multiple-select-form2" name="sysreq[]" id="sysreq">
                  <option disabled value> Select System </option>
                  <?php foreach ($systemList as $key=>$value): ?>
                  <option 
                    <?= isset($systemKeys) ? ((in_array($key, $systemKeys)) ? 'selected': '') : '' ?>
                    value="<?=  $key ?>" ><?=  $value ?></option>
                <?php endforeach; ?>
              </select>
              </div>
            </div>

            <div class="col-12  col-sm-6">
              <div class="form-group">
                <div id="sysreq_description"></div>
              </div>
            </div>  


            <div class="col-12   col-sm-6">
              <div class="form-group">
              <label class = "font-weight-bold text-muted" for="subsysreq">Subsystem</label>
              <select class="form-control selectpicker" data-live-search="true" multiple id="multiple-select-form2" name="subsysreq[]" id="subsysreq">
                  <option disabled value> Select Subsystem </option>
                  <?php foreach ($subSystemList as $key=>$value): ?>
                  <option 
                    <?= isset($subsystemKeys) ? ((in_array($key, $subsystemKeys)) ? 'selected': '') : '' ?>
                    value="<?=  $key ?>" ><?=  $value ?></option>
                <?php endforeach; ?>
              </select>
              </div>
            </div>

            <div class="col-12  col-sm-6">
              <div class="form-group">
                <div id="subsysreq_description"></div>
              </div>
            </div>  

            <div class="col-12">
              <div class="form-group">
              <label class = "font-weight-bold text-muted" for="design">Design</label>
              <input type="text" class="form-control" name="design" id="design"
              value="<?= isset($member['design']) ? $member['design'] : '' ?>" >
              </div>
            </div>

            <div class="col-12">
              <div class="form-group">
              <label class = "font-weight-bold text-muted" for="code">Code</label>
              <input type="text" class="form-control" name="code" id="code"
              value="<?= isset($member['code']) ? $member['code'] : '' ?>" >
              </div>
            </div>

            <div class="col-12 col-sm-6">
              <div class="form-group">
              <label class = "font-weight-bold text-muted" for="testcase">Test</label>
              <select class="form-control selectpicker" data-live-search="true" multiple id="multiple-select-form2" name="testcase[]" id="testcase">
                  <option disabled value>Select Testcase</option>
                  <?php foreach ($testCases as $key=>$value): ?>
                  <option 
                    <?= isset($testcaseKeys) ? ((in_array($key, $testcaseKeys)) ? 'selected': '') : '' ?>
                    value="<?=  $key ?>" ><?=  $value ?></option>
                <?php endforeach; ?>
              </select>
              </div>
            </div>

            <div class="col-12  col-sm-6" >
              <div class="form-group">
                <div id="testcase_description" style="border: 1ps solid black;"></div>
              </div>
            </div>  

          </div>

          <br/><br/><br/><br/>
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


 function getIDDescription(type){
    var id = $(type).val();
    var typeUrl = 1;
    var descID = type+'_description';
    var result = true;
      if(id){
        $.ajax({
           url: '/traceability-matrix/getIDDescription/'+id+'/'+typeUrl,
           type: 'GET',
           success: function(response){
              response = JSON.parse(response);
              if(response.success == "True"){
                  $(descID).html(response.description);
                  setTimeout(function(){
                    $(descID).css('border', '2px solid #CCCCCC');
                  },100);
              }
              else{
                 bootbox.alert('Data not existed.');
              }
            }
         });
      }else{
        $(descID).html('').css('border', 'none');
      }
 }
</script>
