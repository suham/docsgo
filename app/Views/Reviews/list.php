

<div class="row">
<?php if (count($data) == 0): ?>

  <div class="alert alert-warning" role="alert">
    No records found.
  </div>

  <?php else: ?>
    <div class="col-12">
      <table class="table table-striped table-hover" id="reviews-list">
        <thead>
          <tr>
            <th scope="col" >#</th>
            <th scope="col">Project</th>
            <th scope="col" style="max-width:125px;word-wrap: break-word;">Name</th>
            <th scope="col" style="max-width:570px;word-wrap: break-word;"> Context</th>
            <th scope="col" style="min-width:120px;">Assigned To</th>
            <th scope="col">Category</th>
            <th scope="col">Status</th>
            <th scope="col" style="min-width:120px;">Reviewed By</th>
            <th scope="col" style="min-width: 100px;">Actions</th>
          </tr>
        </thead>
        <tbody class="bg-white ">
          <?php foreach ($data as $key=>$row): ?>
              <tr scope="row" id="<?php echo $row['id'];?>">
                  <td><?php echo $key+1; ?></td>
                  <td><?php echo $projects[$row['project-id']];?></td>
                  <td style="max-width:125px;word-wrap: break-word;"><?php echo $row['review-name'];?></td>
                  <td style="max-width:570px;word-wrap: break-word;"><?php echo $row['context'];?></td>
                  <td><?php echo $teamMembers[$row['assigned-to']];?></td>
                  <td><?php echo $row['category'];?></td>
                  <td>
                    <button type="button" 
                            style="cursor: unset;"
                            class=" mt-1 btn btn-sm btn-outline-<?php
                            echo $row['status'] == 'Accepted' ? 'success' : ($row['status'] == 'Request Change' ? 'danger' : 'info');
                            //  echo $row['status'] == 'Accepted' ? 'success' : ($row['status'] == 'Rejected' ? 'danger' : 'info');
                            ?>">
                            <?php echo $row['status'];?>
                    </button>
                  </td>
                  <td><?php echo $teamMembers[$row['review-by']];?></td>
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
    
    </div>

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

    $(document).ready( function () {
      $('#reviews-list').DataTable({
        "responsive": true,
        "scrollX": true,
        "fixedHeader": true,
        "autoWidth": false
      });
    });


</script>

