
<div class="container">
<?php if (count($data) == 0): ?>

  <div class="alert alert-warning" role="alert">
    No records found.
  </div>

  <?php else: ?>
    <div class="table-responsive">
      <table class="table table-striped table-hover">
        <thead class="thead-dark">
          <tr>
            <th scope="col">#</th>
            <th scope="col">Name</th>
            <th scope="col">Category</th>
            <th scope="col">Version</th>
            <th scope="col">Status</th>
            <th scope="col">Actions</th>
          </tr>
        </thead>
        <tbody class="bg-white ">
          <?php foreach ($data as $key=>$row): ?>
              <tr scope="row" id="<?php echo $row['id'];?>">
                  <td><?php echo $key+1; ?></td>
                  <td><?php echo $row['name'];?></td>
                  <td><?php echo $row['category'];?></td>
                  <td><?php echo $row['version'];?></td>
                  <td><?php echo $row['status'];?></td>
                  <td>
                      <a href="/documents-master/add/<?php echo $row['id'];?>" class="btn btn-warning">
                          <i class="fa fa-edit"></i>
                      </a>
                      <a onclick="deleteDocument(<?php echo $row['id'];?>)" class="btn btn-danger ml-2">
                          <i class="fa fa-trash text-light"></i>
                      </a>
                  </td>
              </tr>
          <?php endforeach; ?>
        </tbody>
      </table>
    </div>

<?php endif; ?>
  
</div>

<script>
 function deleteDocument(id){

    bootbox.confirm("Do you really want to delete the document?", function(result) {
      if(result){
        $.ajax({
           url: '/documents-master/delete/'+id,
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

