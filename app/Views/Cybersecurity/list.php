
<div class="container1">
<?php if (count($data) == 0): ?>

  <div class="alert alert-warning" role="alert">
    No records found.
  </div>

  <?php else: ?>

    <table class="table table-striped table-hover table-responsive1">
      <thead class="thead-dark">
      <tr>
          <th scope="col">#</th>
          <th scope="col">Project</th>
          <th scope="col">Reference</th>
          <th scope="col">Description</th>
          <th scope="col">Established Control</th>
          <th scope="col">Status</th>
          <th scope="col" style="width:125px">Last update</th>
          <th scope="col" style="width:125px">Action</th>
        </tr>
      </thead>
      <tbody  class="bg-white">
        <?php foreach ($data as $key=>$row): ?>
            <tr scope="row" id="<?php echo $row['id'];?>">
                <td><?php echo $key+1; ?></td>
                <td><?php echo $projects[$row['project_id']];?></td>
                <td><?php echo $row['reference'];?></td>
                <td><?php echo $row['description'];?></td>
                <td><?php echo $row['control'];?></td>
                <td><?php echo $row['status'];?></td>
                <td><?php $timestamp = strtotime($row['update_date']) + (330*60); echo date("Y-m-d h:i A", $timestamp);?></td>
                <td>
                    <a href="/cybersecurity/add/<?php echo $row['id'];?>" class="btn btn-warning">
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
           url: '/cybersecurity/delete/'+id,
           type: 'GET',
           success: function(response){
              console.log(response);
              console.log('/cybersecurity/delete/'+id);
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

