<?php
  $uri = service('uri');
  ?>

  <div class="row p-2 p-md-4 mb-3">
      <div class="col-3">
        <div class="form-group mb-0">
          <select class="form-control selectpicker" id="projects" name="projects" data-style="btn-secondary" data-live-search="true" data-size="8" >
            <option value="" disabled >
              Select Project
            </option>
            <?php foreach ($projects as $key=>$value): ?>
              <option  <?= (($selectedProject == $key) ? "selected" : "") ?> value="<?=  $key ?>"><?=  $value ?></option>
            <?php endforeach; ?>
          </select>
        </div>
      </div>

      <div class="col-3">
        <div class="form-group mb-0">
          <select class="form-control selectpicker" onchange="getSelectedStatusData(0)" id="riskTypes" name="riskTypes" data-style="btn-secondary" data-live-search="true" data-size="8" >
            <option value="" disabled >
              Select Project
            </option>
            <?php foreach ($riskCategory as $value): ?>
              <option  <?= (($riskCategorySelected == $value) ? "selected" : "") ?> value="<?=  $value ?>"><?=  $value ?></option>
            <?php endforeach; ?>
          </select>
        </div>
      </div>

   
      
        <div class="col-4">
          <div class="btn-group btn-group-toggle" >
          <!-- -->
          <div id="data-open-issue-soup-matrix">
                <div  class="col-12">
                    <div class="form-group">
                      <div class="btn-group btn-group-toggle btn-security-toggle" id="listblock" >
                      <div class="btn <?= ( (!strpos($uri,'?') || (strpos($uri, 'status=All')) || (strpos($uri, 'status=sync'))) ? "btn-primary" : "btn-secondary") ?> id="RDanchor" title="" onclick="getSelectedStatusData(1)">
                            <input type="radio" name="status-type" value="All" id="status-type1" /> All
                          </div>
                          <div class="btn <?= (strpos($uri, 'status=Open') ? "btn-primary" : "btn-secondary") ?>" id="RDanchor" title="" onclick="getSelectedStatusData(2)">
                            <input type="radio" name="status-type" value="Open"  id="status-type2"/> Open
                          </div>
                          <div class="btn <?= (strpos($uri, 'status=Close') ? "btn-primary" : "btn-secondary") ?>" id="RDanchor" title="" onclick="getSelectedStatusData(3)">
                            <input type="radio" name="status-type" value="Close"  id="status-type3"/> Close
                          </div>
                      </div>
                    </div>
                </div>
            </div>
          </div>
        </div>
     

      
        <div class="col-2">
          <a href="#" onclick="getSyncData()"
              class="btn <?= (($isSyncEnabled) ? " btn-primary" : "btn-secondary") ?>">
            Sync
          </a>
        </div>
      

  </div>

  <div class="row p-0 p-md-4">
    <?php if (count($data) == 0): ?>
      <div class="col-12">
        <div class="alert alert-warning" role="alert">
          No records found.
        </div>
      </div>

      <?php else: ?>
        <div class="col-12">
          <table class="table table-striped table-hover risk-assessment" id="risk-assessment-list">
            <thead >
              <tr>
                <th scope="col">#</th>
                <th scope="col">Risk Type</th>
                <th scope="col">Risk</th>
                <th scope="col">Base Score</th>
                <th scope="col">RPN</th>
                <th scope="col">Status</th>
                <th scope="col" style="width:125px">Action</th>
              </tr>
            </thead>
            <tbody  class="bg-white">
              <?php foreach ($data as $key=>$row): ?>
                  <tr scope="row" id="<?php echo $row['id'];?>">
                      <td><?php echo $key+1; ?></td>
                      <td><?php echo $row['risk_type'];?> </td>
                      <td><?php echo $row['risk'];?></td>
                      <?php if (isset($row['base_score']) && $row['base_score'] !=0 ): ?>
                        <td><?php echo $row['base_score'];?></td>
                      <?php else: ?><td> -- </td><?php endif; ?>
                      <?php if (isset($row['rpn']) && $row['rpn'] !=0 ): ?>
                        <td><?php echo $row['rpn'];?></td>
                      <?php else: ?><td> -- </td><?php endif; ?>
                      <td><?php echo $row['status'];?></td>
                      <td>
                          <a href="/risk-assessment/add?id=<?php echo $row['id'];?>" class="btn btn-warning">
                              <i class="fa fa-edit"></i>
                          </a>
                          <?php if (session()->get('is-admin')): ?>
                          <a onclick="deleteItem(<?php echo $row['id'];?>)" class="btn btn-danger ml-2">
                              <i class="fa fa-trash text-light"></i>
                          </a>
                          <?php endif; ?>
                      </td>
                  </tr>
              <?php endforeach; ?>

            </tbody>
          </table>
        </div>

    <?php endif; ?>
  </div>


<script>
$(document).ready(function(){
  var table = $('#risk-assessment-list').DataTable({
      "responsive": true,
      "autoWidth": false,
      "fixedHeader": true,
    });
});

function getSyncData(){
  var selectedProjectId = $("#projects").val();
  var url = `risk-assessment?status=sync&project_id=${selectedProjectId}`
  console.log("url:", url);
  window.location = url;
}

function getSelectedRiskTypeData() {
  var selectedRisk = $("#riskTypes").val();
  var url = `risk-assessment?type=${selectedRisk}`
  console.log("url:", url);
  window.location = url;
}

function getSelectedStatusData(id) {
  var idVal,obj,status,riskType,url;
  riskType = $("#riskTypes").val();
  if(id != 0){
    $('#listblock  div').removeClass('btn-primary').addClass('btn-secondary');
    idVal = "#status-type"+id;
    $(idVal).parent().removeClass("btn-secondary").addClass('btn-primary');
    obj = {1:"All", 2:"Open", 3:"Close"};
    status = obj[id];
    url = `risk-assessment?status=${status}&type=${riskType}`
  }else{
    url = `risk-assessment?status=All&type=${riskType}`
  }
  console.log("url:", url);
  window.location = url;
}

 function deleteItem(id){
    bootbox.confirm("Do you really want to delete record?", function(result) {
      if(result){
        $.ajax({
           url: '/risk-assessment/delete?id='+id,
           type: 'GET',
           success: function(response){
              response = JSON.parse(response);
              if(response.success == "True"){
                  $("#"+id).fadeOut(800)
              }else{
                 bootbox.alert('Record not deleted.');
              }
            }
         });
      }else{
        console.log('Delete Cancelled');
      }
    });
 }

</script>

