<?php
  $uri = service('uri');
?>
  <div class="row p-0 p-md-4">
    <div class="col-1">
      <div class="btn-group btn-group-toggle">
        <a href="/traceability-matrix" 
          class="btn <?= ( ( (!strpos($uri,'?')) || (strpos($uri,'/traceability-matrix?type=User')) || (strpos($uri,'/traceability-matrix?type=Standards')) || (strpos($uri,'/traceability-matrix?type=Guidance')) ) ? " btn-primary" : "btn-secondary") ?>">
           List
        </a>
        <a href="/traceability-matrix?view=gap"
          class="btn <?= ( (strpos($uri,'/traceability-matrix?view=gap'))  ? " btn-primary" : "btn-secondary") ?>">
           Gap
        </a>
      </div>
    </div>
    <div class="col-2">
      <select class="form-control selectpicker" onchange="getSelectedStatusData()" data-live-search="true" data-size="8" name="requirementType" id="requirementType" data-style="btn-secondary">
        <option value="Select Type"  <?= (isset($selectedCategory) && ($selectedCategory != '')) ? '' : 'selected' ?>>
            Select Type
        </option>
        <?php foreach ($requirementCategory as $reqCat): ?>
            <option 
              <?= isset($selectedCategory) ? (($selectedCategory == $reqCat["value"]) ? 'selected': '') : '' ?>
              value="<?=  $reqCat["value"] ?>" ><?=  $reqCat["value"] ?></option>
        <?php endforeach; ?>
      </select>
    </div>
    
  </div>

  <div class="row p-0 p-md-4">
    <?php if ((count($data) == 0) && ($listViewDisplay == true)): ?>
      <div class="col-12">
        <div class="alert alert-warning" role="alert">
          No records found.
        </div>
      </div>
      <?php else: ?>
        <?php if (($listViewDisplay == true)): ?>
          <div class="col-12">
          
            <table class="table  table-hover" id="traceability-list" >
              <thead >
                <tr>
                  <th scope="col">#</th>
                  <th class="<?php echo (($activeTableFirstHeader == 1) ? '': 'd-none') ;?>" scope="col" id="headerLabel1">User Needs</th>
                  <th class="<?php echo (($activeTableFirstHeader == 2) ? '': 'd-none') ;?>" scope="col" id="headerLabel2">Standards</th>
                  <th class="<?php echo (($activeTableFirstHeader == 3) ? '': 'd-none') ;?>" scope="col" id="headerLabel3">Guidance</th>
                  <th scope="col">System</th>
                  <th scope="col">Subsystem</th>
                  <th scope="col">Test</th>
                  <th scope="col" style="width:125px">Action</th>
                </tr>
              </thead>
              <tbody  class="bg-white">
                <?php $count=1; foreach ($data as $key=>$row): ?>
                    <tr scope="row" id="<?php echo $row['id'];?>">
                        <td><?php echo $count++; ?></td>
                        <td class="<?php echo (($activeTableFirstHeader == 1) ? '': 'd-none') ;?>"><?php echo ($activeTableFirstHeader == 1) ? $row['cncr'] : '' ;?></td>
                        <td class="<?php echo (($activeTableFirstHeader == 2) ? '': 'd-none') ;?>"><?php if(isset($row['standards'])) { echo $row['standards']; }?></td>
                        <td class="<?php echo (($activeTableFirstHeader == 3) ? '': 'd-none') ;?>"><?php if(isset($row['guidance'])) { echo $row['guidance']; }?></td>
                        <td><?php if(isset($row['system'])) { echo $row['system']; } ?></td>
                        <td><?php if(isset($row['subsysreq'])) { echo $row['subsysreq']; }?></td>
                        <td><?php if(isset($row['testcase'])) { echo $row['testcase']; }?></td>
                      
                        <td style="width:125px">
                            <a href="/traceability-matrix/add/<?php echo $row['id'];?>" class="btn btn-warning">
                                <i class="fa fa-edit"></i>
                            </a>
                            <?php if (session()->get('is-admin')): ?>
                            <a onclick="deleteTraceabilityMatrix(<?php echo $row['id'];?>)" class="btn btn-danger ml-2">
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
    <?php endif; ?>

    <?php if ($listViewDisplay == false): ?>
      <?php if (!count($data)): ?>
        <div class="col-12">
          <div class="alert alert-warning" role="alert">
            No records found.
          </div>
        </div>
      <?php else: ?>  
        <div class="col-12">
            <table class="table  table-hover" id="traceability-gaps" >
              <thead >
                <tr>
                  <th scope="col">User Needs</th>
                  <th scope="col">System</th>
                  <th scope="col">Subsystem</th>
                  <th scope="col">Test</th>
                </tr>
              </thead>
              <tbody  class="bg-white">
                    <tr scope="row">
                    <td><?php if(isset($data['User Needs'])) { echo $data['User Needs']; } ?></td>
                    <td><?php if(isset($data['System'])) { echo $data['System']; }?></td>
                    <td><?php if(isset($data['Subsystem'])) { echo $data['Subsystem']; }?></td>
                    <td><?php if(isset($data['testcase'])) { echo $data['testcase']; }?></td>
                    </tr>
              </tbody>
            </table>
        </div>
      <?php endif; ?>
      <?php endif; ?>

  </div>

<script>

$(document).ready( function () {
    $('#traceability-list').DataTable({
      "responsive": true,
      "autoWidth": false,
      "fixedHeader": true,
    });
    $('#traceability-gaps').DataTable({
      "responsive": true,
      "autoWidth": false,
      "fixedHeader": true,
    });
});

 function deleteTraceabilityMatrix(id){

    bootbox.confirm("Do you really want to delete record?", function(result) {
      if(result){
        $.ajax({
           url: '/traceability-matrix/delete/'+id,
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

 function getSelectedStatusData() {
  var categoryType,url;
  categoryType = $("#requirementType").val();
  url = `traceability-matrix?type=${categoryType}`
  window.location = url;
}


</script>
