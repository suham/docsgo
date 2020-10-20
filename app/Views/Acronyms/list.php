
<div class="container">
<?php if (count($data) == 0): ?>

  <div class="alert alert-warning" role="alert">
    No records found.
  </div>

  <?php else: ?>


    <div class="table-responsive">

    <table class="table table-striped table-hover" id="acronyms-list">
      <thead class="thead-dark">
        <tr>
          <th scope="col">#</th>
          <th scope="col">Acronym</th>
          <th scope="col">Description</th>
          <th scope="col" style="width:125px">Update Date</th>
          <th scope="col" style="width:125px">Action</th>
        </tr>
      </thead>
      <tbody class="bg-white">
        <?php foreach ($data as $key=>$row): ?>
            <tr scope="row" id="<?php echo $row['id'];?>">
                <td><?php echo $key+1; ?></td>
                <td><?php echo $row['acronym'];?> </td>
                <td><?php echo $row['description'];?></td>
                <td><?php $timestamp = strtotime($row['update_date']) + (330*60); echo date("Y-m-d h:i A", $timestamp); ?></td>

                <td>
                    <a title="Edit" href="/documents-acronyms/add/<?php echo $row['id'];?>" class="btn btn-warning">
                        <i class="fa fa-edit"></i>
                    </a>
                    <?php if (session()->get('is-admin')): ?>
                    <a title="Delete" onclick="deleteItem(<?php echo $row['id'];?>)" class="btn btn-danger ml-2">
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
  $(document).ready( function () {
    var table = $('#acronyms-list').DataTable({
      "responsive": true,
      "autoWidth": false,
      "fixedHeader": true,
    });
  });

 function deleteItem(id){

    bootbox.confirm("Do you really want to delete record?", function(result) {
      if(result){
        $.ajax({
           url: '/documents-acronyms/delete/'+id,
           type: 'GET',
           success: function(response){
              console.log(response);
              console.log('/documents-acronyms/delete/'+id);
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

