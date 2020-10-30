<?php
  $uri = service('uri');
?>
<div class="container-old">
  <div class="row">
      <div class="col-3">
        <div class="form-group mb-0">
          <select class="form-control selectpicker" onchange="getData()" id="projects" name="projects" data-style="btn-secondary" data-live-search="true" data-size="8" >
            <option value="" disabled >
              Select Project
            </option>
            <?php foreach ($projects as $key=>$value): ?>
              <option  <?= (($selectedProject == $key) ? "selected" : "") ?> value="<?=  $key ?>"><?=  $value ?></option>
            <?php endforeach; ?>
          </select>
        </div>
      </div>

      <div class="row mb-3">
        <div class="col-12">
          <a href="#" onclick="getData()"
              class="btn <?= (($isSyncEnabled) ? " btn-primary" : "btn-secondary") ?>">
            Sync
          </a>
        </div>
      </div>
      &nbsp;
      <div class="row mb-3">
      <div class="col-12">
        <div class="btn-group btn-group-toggle" >
          <a href="/risk-assessment" 
            class="btn <?= ((!strpos($uri,'?')) ? " btn-primary" : "btn-secondary") ?>">
            All
          </a>
          <a href="/risk-assessment?status=Open"
              class="btn <?= ((strpos($uri,'/risk-assessment?status=Open'))  ? " btn-primary" : "btn-secondary") ?>">
            Open
          </a>
          <a href="/risk-assessment?status=Close"
              class="btn <?= ((strpos($uri,'/risk-assessment?status=Close')) ? " btn-primary" : "btn-secondary") ?>">
            Close
          </a>
        </div>
      </div>
    </div>
  </div>

<?php if (count($data) == 0): ?>

  <div class="alert alert-warning" role="alert">
    No records found.
  </div>

  <?php else: ?>

    <table class="table table-striped table-hover risk-assessment" id="risk-assessment-list">
      <thead >
        <tr>
          <th scope="col">#</th>
          <th scope="col">Risk Type</th>
          <th scope="col">Risk</th>
          <th scope="col">Mitigation</th>
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
                <td><?php echo $row['mitigation'];?></td>
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

function getData(){
  console.log("getDatagetData");
  var selectedView = $("input[name='view']:checked").val();
  var selectedProjectId = $("#projects").val();
  var url = `risk-assessment?status=sync&project_id=${selectedProjectId}`
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

