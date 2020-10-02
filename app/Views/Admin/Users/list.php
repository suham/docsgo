
<div class="row justify-content-center">
<div class="col-auto">
    <?php if (count($data) == 0): ?>
    
        <div class="alert alert-warning" role="alert">
            No records found.
        </div>

    <?php else: ?>

        <table class="table rounded table-striped table-hover table-responsive">
            <thead class="thead-dark">
                <tr>
                <th scope="col">#</th>
                <th scope="col">Name</th>
                <th scope="col">Email id</th>
                <th scope="col">Admin</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($data as $key=>$row): ?>
                    <tr scope="row" >
                        <td><?php echo $key+1; ?></td>
                        <td><?php echo $row ['name'];?></td>
                        <td><?php echo $row['email'];?></td>
                        <td><input id="<?php echo $row ['id'];?>" 
                                    data-on="Yes" data-off="No"
                                    type="checkbox" <?php echo $row['is-admin'] ? 'checked' : '';?>
                                    data-toggle="toggle" onchange="changeStatus(<?php echo $row ['id'];?>)">
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>

    <?php endif; ?>
</div>
  
</div>

<script>
function changeStatus(id){

    console.log('change '+id );
    $.ajax({
        url: '/admin/users/updateStatus',
        type: 'POST',
        data: { id: id} ,
        success: function (response) {
            console.log(response);
        },
        error: function () {
            alert("error");
        }
    }); 
}
</script>