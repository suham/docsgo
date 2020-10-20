
<div class="fluid-container">
<?php if (count($data) == 0): ?>

  <div class="alert alert-warning" role="alert">
    No records found.
  </div>

  <?php else: ?>

    <div class="">
      
        <table class="table table-striped table-hover" id="traceability-list" >
          <thead >
            <tr>
              <th scope="col">#</th>
              <th scope="col">User Needs</th>
              <th scope="col">System</th>
              <th scope="col">Subsystem</th>
              <th scope="col">Test</th>
              <th scope="col">Design</th>
              <th scope="col">Code</th>
              <th scope="col" style="width:125px">Action</th>
            </tr>
          </thead>
          <tbody  class="bg-white">
            <?php $count=1; foreach ($data as $key=>$row): ?>
                <tr scope="row" id="<?php echo $row['id'];?>">
                    <td><?php echo $count++; ?></td>
                    <td><?php echo $row['cncr'];?></td>
                    <td><?php if(isset($row['system'])) { echo $row['system']; } ?></td>
                    <td><?php if(isset($row['subsysreq'])) { echo $row['subsysreq']; }?></td>
                    <td><?php if(isset($row['testcase'])) { echo $row['testcase']; }?></td>
                    <td><?php echo $row['design']; ?></td>
                    <td><?php echo $row['code'];?></td>
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
</div>

<script>

$(document).ready( function () {
    $('#traceability-list').DataTable({
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
              console.log(response);
              console.log('/traceability-matrix/delete/'+id);
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
