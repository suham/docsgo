
<div class="container-old">
<div class="row">
      <div class="col-12">
          <div class="form-group" readonly="readonly">

              <!-- <input type="radio" name="issues-status-type" id="RDanchor1" onclick="javascript:window.location.href='/risk-assessment/view/1/1';" checked="<?php //echo $checkedVals['RDanchor1']; ?>"/> All 
              <input type="radio" name="issues-status-type" id="RDanchor2" onclick="javascript:window.location.href='/risk-assessment/view/1/2';" checked="<?php //echo $checkedVals['RDanchor2']; ?>"/> Open
              <input type="radio" name="issues-status-type" id="RDanchor3" onclick="javascript:window.location.href='/risk-assessment/view/1/3';" checked="<?php //echo $checkedVals['RDanchor3']; ?>"/> Close -->

              <input type="radio" name="issues-status-type" id="RDanchor1" 
              onclick="javascript:window.location.href='/risk-assessment/view/1/1';" <?php echo ($checkedVals['RDanchor1']) == 1 ? "checked" : ""; ?> /> All 
              <input type="radio" name="issues-status-type" id="RDanchor2" 
              onclick="javascript:window.location.href='/risk-assessment/view/1/2';"  <?php echo ($checkedVals['RDanchor2']) == 1 ? "checked" : ""; ?> /> Open
              <input type="radio" name="issues-status-type" id="RDanchor3" 
              onclick="javascript:window.location.href='/risk-assessment/view/1/3';" <?php echo ($checkedVals['RDanchor3']) == 1 ? "checked" : ""; ?> /> Close

          </div>
      </div>
    </div>
<?php if (count($data) == 0): ?>

  <div class="alert alert-warning" role="alert">
    No records found.
  </div>

  <?php else: ?>

    <table class="table table-striped table-hover risk-assessment">
      <thead >
        <tr>
          <th scope="col">Category</th>
          <th scope="col">Name</th>
          <th scope="col">Description</th>
          <th scope="col">Information</th>
          <th scope="col">Severity</th>
          <th scope="col">Occurrence</th>
          <th scope="col">Detectability</th>
          <th scope="col">RPN</th>
          <th scope="col">Status</th>
          <th scope="col" style="width:125px">Action</th>
        </tr>
      </thead>
      <tbody  class="bg-white">
        <?php foreach ($data as $key=>$row): ?>
            <tr scope="row" id="<?php echo $row['id'];?>">
                <td><?php echo $row['category'];?> </td>
                <td><?php echo $row['name'];?></td>
                <td><?php echo $row['description'];?></td>
                <td><?php echo $row['information'];?></td>
                <?php if (isset($row['severity'])): ?>
                  <td><?php echo $severityListOptions[$row['severity']];?></td>
                <?php else: ?>
                  <td></td>
                <?php endif; ?>
                <?php if (isset($row['occurrence'])): ?>
                  <td><?php echo $occurrenceListOptions[$row['occurrence']];?></td>
                <?php else: ?>
                  <td></td>
                <?php endif; ?>
                <?php if (isset($row['detectability'])): ?>
                  <td><?php echo $detectabilityListOptions[$row['detectability']];?></td>
                <?php else: ?>
                  <td></td>
                <?php endif; ?>
                <td><?php echo $row['rpn'];?></td>
                <td><?php echo $row['status'];?></td>
                <td>
                    <a href="/risk-assessment/add/1/<?php echo $row['id'];?>" class="btn btn-warning">
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
 function deleteItem(id){

    bootbox.confirm("Do you really want to delete record?", function(result) {
      if(result){
        $.ajax({
           url: '/risk-assessment/delete/'+id,
           type: 'GET',
           success: function(response){
              console.log(response);
              console.log('/risk-assessment/delete/'+id);
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

