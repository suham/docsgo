
<?php
  $uri = service('uri');
?>
<div class="row p-2 p-md-4">
   
    <div class="col-12 col-md-3" >
      <div class="form-group mb-0">
        <select class="form-control selectpicker" onchange="getData()" id="projects"  data-style="btn-secondary" data-live-search="true" data-size="8" >
          <option value="" disabled >
            Select Project
          </option>
          <?php foreach ($projects as $key=>$value): ?>
            <option  <?= (($selectedProject == $key) ? "selected" : "") ?> value="<?=  $key ?>"><?=  $value ?></option>
          <?php endforeach; ?>
        </select>
      </div>

    </div>

    <div class="col-12 col-md-9 pt-3 pb-3 pt-md-0 pb-md-0">
      <div class="btn-group btn-group-toggle ">
        <?php foreach ($reviewStatus as $revStatus): ?>
          <label onclick="getData()" class="btn <?= (($selectedStatus == $revStatus["value"]) ? " btn-primary" : "btn-secondary") ?>">
            <input type="radio" name="view" value="<?=  $revStatus["value"] ?>" autocomplete="off" <?= (($selectedStatus == $revStatus["value"]) ? "checked" : "") ?>>  <?=  $revStatus["value"] ?>
          </label>
        <?php endforeach; ?>
      </div>
      
    </div>
</div>

<div class="row p-0 p-md-4">

<?php if (count($data) == 0): ?>

  <div class="col-12">
    <div class="alert alert-warning" role="alert">
      No records found.
    </div>
  </div>

  <?php else: ?>
    <div class="col-12">
      <table class="table  table-hover" id="reviews-list">
        <thead>
          <tr>
            <th scope="col" >#</th>
            <th scope="col" style="max-width:125px;word-wrap: break-word;">Name</th>
            <th scope="col" style="max-width:570px;word-wrap: break-word;">Review Item</th>
            <th scope="col" style="min-width:120px;">Author</th>
            <th scope="col" style="min-width:120px;">Reviewer</th>
            <th scope="col" style="min-width: 125px;">Update Date</th>
            <th scope="col" style="min-width: 100px;">Actions</th>
          </tr>
        </thead>
        <tbody class="bg-white ">
          <?php foreach ($data as $key=>$row): ?>
              <tr scope="row" id="<?php echo $row['id'];?>">
                  <td><?php echo $key+1; ?></td>
                  <td style="max-width:125px;word-wrap: break-word;"><?php echo $row['review-name'];?></td>
                  <td style="max-width:570px;word-wrap: break-word;"><?php echo $row['context'];?></td>
                  <td><?php echo $teamMembers[$row['assigned-to']];?></td>
                  <td><?php echo $teamMembers[$row['review-by']];?></td>
                  <td><?php $timestamp = strtotime($row['updated-at']) + (330*60); echo date("Y-m-d h:i A", $timestamp); ?></td>
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
        "autoWidth": false
      });
    });

  function getData(){
    var selectedView = $("input[name='view']:checked").val();
    var selectedProjectId = $("#projects").val();
    var url = `reviews?view=${selectedView}&project_id=${selectedProjectId}`
    window.location = url;
  }


</script>

