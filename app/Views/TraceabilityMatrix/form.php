
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
              <label class = "font-weight-bold text-muted" for="cncr">User Needs</label>
               <select class="form-control fstdropdown-select" name="cncr" id="cncr" onchange="getIDDescription('#cncr')">
                <option value="" disabled <?= isset($member['cncr']) ? '' : 'selected' ?>>
                    Select
                </option>
                <?php foreach ($CNCRList as $key=>$value): ?>
                  <option 
                    <?= isset($member['cncr']) ? (($member['cncr'] == $key) ? 'selected': '') : '' ?>
                    value="<?=  $key ?>" ><?=  $value ?></option>
                <?php endforeach; ?>
              </select>
              </div>
            </div>

            <div class="col-12  col-sm-6" style='display: block'>
              <div class="form-group">
                <div id="cncr_description"></div>
              </div>
            </div>  

            <div class="col-12  col-sm-6">
              <div class="form-group">
              <label class = "font-weight-bold text-muted" for="sysreq">System</label>
               <select class="form-control fstdropdown-select" name="sysreq" id="sysreq" onchange="getIDDescription('#sysreq')">
                <option value="" disabled <?= isset($member['sysreq']) ? '' : 'selected' ?>>
                    Select
                </option>
                <?php foreach ($systemList as $key=>$value): ?>
                  <option 
                    <?= isset($member['sysreq']) ? (($member['sysreq'] == $key) ? 'selected': '') : '' ?>
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
               <select class="form-control fstdropdown-select" name="subsysreq" id="subsysreq" onchange="getIDDescription('#subsysreq')">
                <option value="" disabled <?= isset($member['subsysreq']) ? '' : 'selected' ?>>
                    Select
                </option>
                <?php foreach ($subSystemList as $key=>$value): ?>
                  <option 
                    <?= isset($member['subsysreq']) ? (($member['subsysreq'] == $key) ? 'selected': '') : '' ?>
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
               <select class="form-control fstdropdown-select" name="testcase" id="testcase" onchange="getTestCaseDescription('#testcase')">
                <option value="" disabled <?= isset($member['testcase']) ? '' : 'selected' ?>>
                    Select
                </option>
                <?php foreach ($testCases as $key=>$value): ?>
                  <option 
                    <?= isset($member['testcase']) ? (($member['testcase'] == $key) ? 'selected': '') : '' ?>
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
    var typeUrl='';
    switch(type) {
      case  '#cncr':
          typeUrl = 1;
          break;
      case  '#sysreq':
          typeUrl = 2;
          break;
      case  '#subsysreq':
          typeUrl = 3;
          break;
    }
    var result = true;
      if(result){
        $.ajax({
           url: '/traceability-matrix/getIDDescription/'+id+'/'+typeUrl,
           type: 'GET',
           success: function(response){
              console.log("FORM respone:", response);
              response = JSON.parse(response);
              if(response.success == "True"){
                console.log("response:", response);
                var descID = type+'_description';
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
        console.log('Delete Cancelled');
      }
 }

function getTestCaseDescription(type) {
  var id = $(type).val();
    var result = true;
      if(result){
        $.ajax({
           url: '/traceability-matrix/getTestCaseDescription/'+id,
           type: 'GET',
           success: function(response){
              // console.log("FORM respone:", response);
              response = JSON.parse(response);
              if(response.success == "True"){
                console.log("response:", response);
                var descID = type+'_description';
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
        console.log('Delete Cancelled');
      }
}
</script>
