
<div class="container1">
<!-- <div class="row">
      <div class="col-12">
          <div class="form-group" readonly="readonly">

              <input type="radio" name="issues-status-type" id="TraceabilityRDBtn1" 
              onclick="javascript:window.location.href='/traceability-matrix/view/1';" <?php //echo ($checkedVals['TraceabilityRDBtn1']) == 1 ? "checked" : ""; ?> /> List 
              <input type="radio" name="issues-status-type" id="TraceabilityRDBtn2" 
              onclick="javascript:window.location.href='/traceability-matrix/view/2';"  <?php //echo ($checkedVals['TraceabilityRDBtn2']) == 1 ? "checked" : ""; ?> /> Gaps

          </div>
      </div>
    </div> -->

<?php if (count($data) == 0): ?>

  <div class="alert alert-warning" role="alert">
    No records found.
  </div>

  <?php else: ?>

    <?php if (($listView)): ?>
    <table class="table table-striped table-hover table-responsive" id="table1" style="display: inline-table;">
      <thead class="thead-dark">
        <tr>
          <th scope="col">#</th>
          <th scope="col">User Needs</th>
          <th scope="col">System</th>
          <th scope="col">Subsystem</th>
          <th scope="col">Test</th>
          <th scope="col">Design</th>
          <th scope="col">Code</th>
          <!-- <th scope="col" style="width:125px">Update Date</th> -->
          <th scope="col" style="width:125px">Action</th>
        </tr>
      </thead>
      <tbody  class="bg-white">
        <?php foreach ($data as $key=>$row): ?>
            <tr scope="row" id="<?php echo $row['id'];?>">
                <td><?php echo $key+1; ?></td>
                <td><?php echo $row['User Needs'];?></td>
                <td>
                  <div>
                  <?php foreach ($row['System'] as $key1=>$row1 ): ?>
                  <div>
                    <div><?php echo $row1['requirement'];?></div>
                  </div>
                  <?php endforeach; ?>
                  </div>
                </td>
                <td>
                  <div>
                  <?php foreach ($row['Subsystem'] as $key1=>$row1 ): ?>
                  <div>
                    <div><?php echo $row1['requirement'];?></div>
                  </div>
                  <?php endforeach; ?>
                  </div>
                </td>
                <td>
                  <div>
                  <?php foreach ($row['testcase'] as $key1=>$row1 ): ?>
                  <div>
                    <div><?php echo $row1['requirement'];?></div>
                  </div>
                  <?php endforeach; ?>
                  </div>
                </td>
                <td><?php echo $row['design']; ?></td>
                <td><?php echo $row['code'];?></td>
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

<?php if (($gapView)): ?>
  <table class="table table-striped table-hover table-responsive"  id="table2" style="display: inline-table;">
  <thead class="thead-dark">
    <tr>
      <th scope="col">#</th>
      <th scope="col">Category</th>
      <th scope="col">Name</th>
      <th scope="col">Description</th>
    </tr>
  </thead>
  <tbody  class="bg-white">
    
  </tbody>
</table>
<?php endif; ?>
<?php endif; ?>
  
</div>

<script>
$(document).ready( function () {
    $('#table1').DataTable();
    $('#table2').DataTable();
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

