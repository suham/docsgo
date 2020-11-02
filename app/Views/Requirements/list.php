<div class="row p-2 p-md-4 mb-3">
    <div class="col-3">
      <div class="form-group mb-0">
        <select class="form-control selectpicker" onchange="getSelectedStatusData()" data-live-search="true" data-size="8" name="requirementType" id="requirementType" data-style="btn-secondary">
            <option value=""  <?= (isset($requirementSelected) && ($requirementSelected != '')) ? '' : 'selected' ?>>
                Select Type
            </option>
            <?php foreach ($requirementStatus as $key=>$value): ?>
              <option 
                <?= isset($requirementSelected) ? (($requirementSelected == $key) ? 'selected': '') : '' ?>
                value="<?=  $key ?>" ><?=  $value ?></option>
            <?php endforeach; ?>
        </select>
      </div>
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
      <table class="table  table-hover table-responsive" id="requirements-list" >
        <thead>
          <tr>
            <th scope="col">#</th>
            <th scope="col">Requirement</th>
            <th scope="col">Description</th>
            <th scope="col" style="width:125px">Update Date</th>
            <th scope="col" style="width:125px">Action</th>
          </tr>
        </thead>
        <tbody  class="bg-white">
          <?php foreach ($data as $key=>$row): ?>
              <tr scope="row" id="<?php echo $row['id'];?>">
                  <td><?php echo $key+1; ?></td>
                  <td><?php echo $row['requirement'];?></td>
                  <td><?php echo $row['description'];?></td>
                  <td><?php $timestamp = strtotime($row['update_date']) + (330*60); echo date("Y-m-d h:i A", $timestamp); ?></td>
                  <td>
                      <a href="/requirements/add/<?php echo $row['id'];?>" class="btn btn-warning">
                          <i class="fa fa-edit"></i>
                      </a>
                      <?php if (session()->get('is-admin')): ?>
                      <a onclick="deleteRequirements(<?php echo $row['id'];?>)" class="btn btn-danger ml-2">
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
  $(document).ready( function () {
    $('#requirements-list').DataTable({
      "responsive": true,
      "scrollX": true,
      "fixedHeader": true,
    });
  });

 function deleteRequirements(id){

    bootbox.confirm("Do you really want to delete record?", function(result) {
      if(result){
        $.ajax({
           url: '/requirements/delete/'+id,
           type: 'GET',
           success: function(response){
              console.log(response);
              console.log('/requirements/delete/'+id);
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

 function getSelectedStatusData(id) {
  var url, requirementType;
  requirementType = $("#requirementType").val();
  console.log("requirementType:", requirementType);
  if(requirementType == '') {
    requirementType = 'All';
  }
  url = `requirements?status=${requirementType}`;
  window.location = url;
}

</script>

