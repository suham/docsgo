
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
          <th scope="col">Name</th>
          <th scope="col">Active</th>
          <th scope="col">Start Date</th>
          <th scope="col">End Date</th>
          <th scope="col">Manager</th>
          <th scope="col">Actions</th>
        </tr>
      </thead>
      <tbody>
        <?php foreach ($data as $key=>$row): ?>
            <tr scope="row" id="<?php echo $row['project-id'];?>">
                <td><?php echo $key+1; ?></td>
                <td><?php echo $row['name'];?></td>
                <td><?php echo $row['is-active'];?></td>
                <td><?php echo $row['start-date'];?></td>
                <td><?php echo $row['end-date'];?></td>
                <td><?php echo $teamMembers[$row['manager-id']];?></td>
                <td>
                    <a href="/projects/add/<?php echo $row['project-id'];?>" class="btn btn-warning">
                        <i class="fa fa-edit"></i>
                    </a>
                    <a onclick="deleteProject(<?php echo $row['project-id'];?>)" class="btn btn-danger ml-2">
                        <i class="fa fa-trash text-light"></i>
                    </a>
                </td>
            </tr>
        <?php endforeach; ?>
      </tbody>
    </table>

<?php endif; ?>
  
</div>

<script>
 function deleteProject(id){

    bootbox.confirm("Do you really want to delete the project?", function(result) {
      if(result){
        $.ajax({
           url: '/projects/delete/'+id,
           type: 'GET',
           success: function(response){
              console.log(response);
              response = JSON.parse(response);
              if(response.success == "True"){
                  $("#"+id).fadeOut(800)
              }else{
                 bootbox.alert('Project not deleted.');
              }
            }
         });
      }else{
        console.log('Delete Cancelled');
      }

    });

 }

</script>

