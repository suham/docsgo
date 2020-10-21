<?php
  $uri = service('uri');
?>
<div class="container-old">

    <div class="row mb-3">
    <div class="col-12">
      <div class="btn-group btn-group-toggle" data-toggle="buttons">
        <label onclick="javascript:window.location.href='/risk-assessment';" 
               class="btn <?= ((!strpos($uri,'?')) ? " btn-primary" : "btn-secondary") ?>">
          <input type="radio" name="options"  autocomplete="off" checked> All
        </label>
        <label onclick="javascript:window.location.href='/risk-assessment?status=Open';"
                class="btn <?= ((strpos($uri,'/risk-assessment?status=Open'))  ? " btn-primary" : "btn-secondary") ?>">
          <input type="radio" name="options"  autocomplete="off"> Open
        </label>
        <label onclick="javascript:window.location.href='/risk-assessment?status=Close';"
                class="btn <?= ((strpos($uri,'/risk-assessment?status=Close')) ? " btn-primary" : "btn-secondary") ?>">
          <input type="radio" name="options" autocomplete="off"> Close
        </label>
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
                  <td><?php echo $row['severity'];?></td>
                <?php else: ?>
                  <td></td>
                <?php endif; ?>
                <?php if (isset($row['occurrence'])): ?>
                  <td><?php echo $row['occurrence'];?></td>
                <?php else: ?>
                  <td></td>
                <?php endif; ?>
                <?php if (isset($row['detectability'])): ?>
                  <td><?php echo $row['detectability'];?></td>
                <?php else: ?>
                  <td></td>
                <?php endif; ?>
                <td><?php echo $row['rpn'];?></td>
                <td><?php echo $row['status'];?></td>
                <td>
                    <a href="/risk-assessment/add?id=<?php echo $row['id'];?>" class="btn btn-warning">
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
           url: '/risk-assessment/delete?id='+id,
           type: 'GET',
           success: function(response){
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

