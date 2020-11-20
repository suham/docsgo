
<?php
  $uri = service('uri');
?>


  <div class="row p-2 p-md-4 mb-3">

      <div class="col-3" >

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

      <div class="col-7">
        <div class="btn-group btn-group-toggle">
          <?php foreach ($documentStatus as $docStatus): ?>
            <label onclick="getData()" class="btn <?= (($selectedStatus == $docStatus) ? " btn-primary" : "btn-secondary") ?>">
              <input type="radio" name="view" value="<?=  $docStatus ?>" autocomplete="off" <?= (($selectedStatus == $docStatus) ? "checked" : "") ?>>  <?=  $docStatus ?>
              <?php if(isset($documentsCount[$docStatus])): ?>
                <span class="badge badge-light ml-1"><?= $documentsCount[$docStatus] ?></span>
              <?php endif ?>  
            </label>
          <?php endforeach; ?>
        </div>
        
      </div>

      <div class="col-2" >
        
        <div class="form-group mb-0">

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
      <table class="table  table-hover"  id="documents-list">
        <thead class="thead-dark">
          <tr>
            <th scope="col">#</th>
            <th scope="col">Title</th>
            <th scope="col">Author</th>
            <th scope="col">Reviewer</th>
            <th scope="col" style="min-width: 125px;">Update Date</th>
            <th scope="col" style="min-width: 175px;">Actions</th>
          </tr>
        </thead>
        <tbody class="bg-white">
          <?php foreach ($data as $key=>$row): ?>
              <tr scope="row" id="<?php echo $row['id'];?>">
                  <td><?php echo $key+1; ?></td>
                  <td><?php  echo $row['title'];?></td>
                  <td><?php echo $row['author'];?></td>
                  <td><?php echo $row['reviewer'];?></td>
                  <td><?php $timestamp = strtotime($row['update-date']) + (330*60); echo date("Y-m-d h:i A", $timestamp); ?></td>
                  <td>
                    <?php 
                      if($row['author'] == (session()->get('name')) ){
                        $editTitle = "Edit";
                        $editClass = "fa-edit";
                        $editButton = "btn-warning";
                      }else{
                        $editTitle = "View";
                        $editClass = "fa-eye";
                        $editButton = "btn-info";
                      } 
                    ?>
                      <a title="<?= $editTitle ?>" href="/documents/add/?id=<?= $row['id'] ?>" class="btn <?= $editButton ?>">
                          <i class="fa <?= $editClass ?>"></i>
                      </a>
                      <a title="Download" href="docsgen/generateDocument.php?type=document&id=<?php echo $row['id'];?>" 
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
    </div>

  <?php endif; ?>
  
</div>

<script>
  $(document).ready( function () {
    var table = $('#documents-list').DataTable({
      "responsive": true,
      "stateSave": true,
      "autoWidth": false
    });
    $('.l-navbar .nav__link, #footer-icons').on('click', function () {
      table.state.clear();
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

  function getData(){
    var selectedView = $("input[name='view']:checked").val();
    var selectedProjectId = $("#projects").val();
    var url = `documents?view=${selectedView}&project_id=${selectedProjectId}`
    window.location = url;
  }

  $("#newDoc").change(function(){
    const type = $(this).val()
    const project_id = $("#projects").val();
    const url = `/documents/add?type=${type}&project_id=${project_id}`;
    location.href = url;
  })

  function generateDocuments(id){
    var url =  '/generate-documents/downloadDocuments/1/'+id;

    $.ajax({
      url: url,
      beforeSend: function() {
        console.log("before senddddd");
      },
      complete: function(){
        console.log("completion of the ajax");
      },
      success: function(response){
        if(response != undefined) {
          response = JSON.parse(response);
          console.log("res:", response);
          if(response.success == "True"){
              bootbox.alert(response.description);
          }else{
              bootbox.alert(response.description);
          }
        }
      },
      ajaxError: function (error) {
        console.log("Something worng:", error);
      }
    });

  }

</script>

