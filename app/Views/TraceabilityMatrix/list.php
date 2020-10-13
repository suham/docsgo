
<div class="container1">
<?php if (count($data) == 0): ?>

  <div class="alert alert-warning" role="alert">
    No records found.
  </div>

  <?php else: ?>

    <table class="table table-striped table-hover table-responsive" style="display: inline-table;">
      <thead class="thead-dark">
        <tr>
          <th scope="col">#</th>
          <th scope="col">CNCR</th>
          <th scope="col">System Req</th>
          <th scope="col">Subsystem Req</th>
          <th scope="col">Design</th>
          <th scope="col">Code</th>
          <th scope="col">Testcase</th>
          <th scope="col" style="width:125px">Update Date</th>
          <th scope="col" style="width:125px">Action</th>
        </tr>
      </thead>
      <tbody  class="bg-white">
        <?php foreach ($data as $key=>$row): ?>
            <tr scope="row" id="<?php echo $row['id'];?>">
                <td><?php echo $key+1; ?></td>
                <td><?php echo $CNCRList[$row['cncr']];?></td>
                <td><?php echo $systemList[$row['sysreq']];?></td>
                <td><?php echo $subSystemList[$row['subsysreq']];?></td>
                <td><?php echo $row['design']; ?></td>
                <td><?php echo $row['code'];?></td>
                <td><?php echo $testCases[$row['testcase']];?></td>
                <td><?php $timestamp = strtotime($row['update_date']) + (330*60); echo date("Y-m-d h:i A", $timestamp); ?></td>
                <td>
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

<?php endif; ?>
  
</div>

<script>
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

