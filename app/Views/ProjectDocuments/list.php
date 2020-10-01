
<div class="container">
<?php if (count($data) == 0): ?>

  <div class="alert alert-warning" role="alert">
    No records found.
  </div>

  <?php else: ?>

    <table class="table table-striped table-hover">
      <thead class="thead-dark">
        <tr>
          <th scope="col">#</th>
          <th scope="col">Project</th>
          <th scope="col">Title</th>
          <!-- <th scope="col">Type</th> -->
          <th scope="col">Status</th>
          <th scope="col">Update Date</th>
          <th scope="col">Actions</th>
        </tr>
      </thead>
      <tbody>
        <?php foreach ($data as $key=>$row): ?>
            <tr scope="row" id="<?php echo $row['id'];?>">
                <td><?php echo $key+1; ?></td>
                <td><?php echo $projects[$row['project-id']];?></td>
                <td><?php  echo $row['json-object'][$row['type']]['cp-line3'];?></td>
                <!-- <td><?php //echo $templates[$row['type']]['name'];?></td> -->
                <td><?php echo $row['status'];?></td>
                <td><?php echo $row['update-date'];?></td>
                <td>
                    <a href="/documents/add/<?php echo $row['type']."/".$row['id'];?>" class="btn btn-warning">
                        <i class="fa fa-edit"></i>
                    </a>
                  <?php if (session()->get('is-admin')): ?>
                    <a onclick="deletePlanDocument(<?php echo $row['id'];?>)" class="btn btn-danger ml-2">
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
 function deletePlanDocument(id){

    bootbox.confirm("Do you really want to delete the plan document?", function(result) {
      if(result){
        $.ajax({
           url: '/documents/delete/'+id,
           type: 'GET',
           success: function(response){
              console.log(response);
              response = JSON.parse(response);
              if(response.success == "True"){
                  $("#"+id).fadeOut(800)
              }else{
                 bootbox.alert('Document not deleted.');
              }
            }
         });
      }else{
        console.log('Delete Cancelled');
      }

    });

 }

</script>

