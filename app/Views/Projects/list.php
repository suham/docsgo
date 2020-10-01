
<div class="container">
  <?php if (count($data) == 0): ?>

    <div class="alert alert-warning" role="alert">
      No records found.
    </div>

    <?php else: ?>
    <div class="row">

      <?php foreach ($data as $key=>$row): ?>
        <div class="col-md-4 mt-2">
          <div class="card ">
            <div class="card-header bg-<?php echo $row['is-active'] == 'Active' ? 'primary' : 'secondary';?> text-white">
              <h5><?php echo $row['is-active'];?></h5>
            </div>

            <div class="card-body text-center  ">
              <h5 class="card-title"><?php echo $row['name'];?></h5>
              <p class="card-text"><?php echo $row['description'];?></p>
              <a title="Edit" href="/projects/add/<?php echo $row['project-id'];?>" class="btn btn-warning">
                  <i class="fa fa-edit"></i>
              </a>
              <?php if (session()->get('is-admin')): ?>
                <a title="Delete" onclick="deleteProject(<?php echo $row['project-id'];?>)" class="btn btn-danger ml-4">
                    <i class="fa fa-trash text-light"></i>
                </a>
              <?php endif; ?>
              <hr />
              <p class="card-text">
              <span class="badge  badge-pill badge-dark"><?php echo $row['start-date'];?></span> /
              <span class="badge  badge-pill badge-dark"><?php echo $row['end-date'];?></span>
                
              </p>
            </div>

            <div class="card-footer text-muted text-center">
              <div class="row">
                <div class="col">
                  <a href="/reviews/project/<?php echo $row['project-id'];?>" title="Reviews">
                    <i class="fas fa-clipboard-list text-muted fa-lg"></i>
                  </a>
                </div>
                <!-- <div class="col">
                  <a href="" title="Observations"><i class="fas fa-sticky-note text-muted fa-lg"></i></a>
                </div> -->
                <div class="col">
                  <a href="/documents/project/<?php echo $row['project-id'];?>" title="Documents">
                    <i class="fas fa-folder-open text-muted fa-lg"></i>
                  </a>
                </div>
              </div>
            </div>

          </div>
        </div>

      <?php endforeach; ?>

    </div>

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

