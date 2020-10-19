
<div class="container">
<?php if (count($data) == 0): ?>

  <div class="alert alert-warning" role="alert">
    No records found.
  </div>

  <?php else: ?>

    <table class="table table-striped table-hover"  id="documents-list">
      <thead class="thead-dark">
        <tr>
          <th scope="col">#</th>
          <th scope="col">Project</th>
          <th scope="col">Title</th>
          <th scope="col">Author</th>
          <th scope="col">Status</th>
          <th scope="col" style="min-width: 125px;">Update Date</th>
          <th scope="col" style="min-width: 175px;">Actions</th>
        </tr>
      </thead>
      <tbody class="bg-white">
        <?php foreach ($data as $key=>$row): ?>
            <tr scope="row" id="<?php echo $row['id'];?>">
                <td><?php echo $key+1; ?></td>
                <td><?php echo $projects[$row['project-id']];?></td>
                <td><?php  echo $row['json-object'][$row['type']]['cp-line3'];?></td>
                <td><?php echo $row['author'];?></td>
                <td><?php echo $row['status'];?></td>
                <td><?php $timestamp = strtotime($row['update-date']) + (330*60); echo date("Y-m-d h:i A", $timestamp); ?></td>
                <td>
                    <a title="Edit" href="/documents/add/<?php echo $row['type']."/".$row['id'];?>" class="btn btn-warning">
                        <i class="fa fa-edit"></i>
                    </a>
                    <a title="Download" href="docsgen/generateDocument.php?id=<?php echo $row['id'];?>&type=<?php echo $row['type'];?>" 
                    class="btn btn-primary ml-2 <?= $row['status']!= 'Approved' ? 'disabled': '';?>">
                        <i class="fa fa-download"></i>
                    </a>
                  <?php if (session()->get('is-admin')): ?>
                    <a title="Delete" onclick="deletePlanDocument(<?php echo $row['id'];?>)" class="btn btn-danger ml-2">
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
  $(document).ready( function () {
    var table = $('#documents-list').DataTable({
      "responsive": true,
      "scrollX": true,
      "fixedHeader": true,
    });
  });

  
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

