
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
          <th scope="col">Name</th>
          <th scope="col">Context</th>
          <th scope="col">Reviewed By</th>
          <th scope="col">Status</th>
          <th scope="col">Actions</th>
        </tr>
      </thead>
      <tbody>
        <?php foreach ($data as $key=>$row): ?>
            <tr scope="row" id="<?php echo $row['id'];?>">
                <td><?php echo $key+1; ?></td>
                <td><?php echo $projects[$row['project-id']];?></td>
                <td><?php echo $row['review-name'];?></td>
                <td><?php echo $row['context'];?></td>
                <td><?php echo $teamMembers[$row['review-by']];?></td>
                <td>
                  <button type="button" 
                          style="cursor: unset;"
                          class="btn btn-sm btn-outline-<?php
                           echo $row['status'] == 'Accepted' ? 'success' : ($row['status'] == 'Rejected' ? 'danger' : 'info');
                           ?>">
                          <?php echo $row['status'];?>
                  </button>
                </td>
                <td>
                    <a href="/reviews/add/<?php echo $row['id'];?>" class="btn btn-warning">
                        <i class="fa fa-edit"></i>
                    </a>
                    <?php if (session()->get('is-admin')): ?>
                    <a onclick="deleteReview(<?php echo $row['id'];?>)" class="btn btn-danger ml-2">
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
 function deleteReview(id){

    bootbox.confirm("Do you really want to delete the review?", function(result) {
      if(result){
        $.ajax({
           url: '/reviews/delete/'+id,
           type: 'GET',
           success: function(response){
              console.log(response);
              response = JSON.parse(response);
              if(response.success == "True"){
                  $("#"+id).fadeOut(800)
              }else{
                 bootbox.alert('Review not deleted.');
              }
            }
         });
      }else{
        console.log('Delete Cancelled');
      }

    });

 }

</script>

