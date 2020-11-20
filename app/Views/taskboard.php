<style>
    .bg-purple {
        background-color: #6f42c1;
        color: #fff;   
    }

    .btn-outline-purple {
        color: #6f42c1;
        background-color: transparent;
        background-image: none;
        border-color: #6f42c1;
    }
    .btn-outline-purple:hover {
        background-color: #6f42c1;
        color: #fff;
    }

    .bg-orange {
        background-color: #fd7e14;
        color: #fff;   
    }

    .bg-teal{
        background-color: #20c997;
        color: #fff; 
    }

    .bg-pink{
        background-color: #e83e8c;
        color: #fff; 
    }

    .btn-sm-orange {
        background-color: #fd7e14;
        color: #fff;
    }

    .btn-sm-orange:hover {
        background-color: #dee2e6;
        color: #e8700c;
    }

    .btn-sm-primary:hover {
        background-color: #dee2e6;
        color: #007bff;
        border-color: #dee2e6;
    }

    .success-alert{
        position: fixed;
        right: 10px;
        bottom: 20%;
        z-index: 10;
        opacity: 0.75;
    }

    
    .breadcrumb-item {
        font-size: 24px;
    }

    .arr-right .breadcrumb-item+.breadcrumb-item::before {
        content: "›";
        vertical-align: top;
        font-size: 45px;
        line-height: 18px;
        margin-top: 4px;
    }

    .tasks-column{
        padding-left:5px;
        padding-right:5px;
        min-width: 20% !important;
    }

    .task-parent {
        max-height: 93vh;
        overflow-y: auto;
        padding: 0.3rem;
        min-height: 30vh;
        z-index: 1;
    }

    .newTask:hover {
        box-shadow: 0 14px 28px rgba(0,0,0,0.05), 0 10px 10px rgba(0,0,0,0.10);
    }

    .truncate {
        width: 136px;
        white-space: nowrap;
        overflow: hidden;
        text-overflow: ellipsis;
    }

    /* New task styles */
    .newTask_textarea {
        height: 110px;
    }

    /* Draggable style */
    .ui-helper {
        width: 100% !important;
    }

    .scroll {
        overflow: scroll;
        overflow-x: hidden;
    }

    .scroll::-webkit-scrollbar {
        width: 0.25rem;
    }

    .scroll::-webkit-scrollbar-track {
        width: #007bff;
    }

    .scroll-dark::-webkit-scrollbar-thumb {
        background: #343a40;
    }

    .scroll-info::-webkit-scrollbar-thumb {
        background: #17a2b8;
    }

    .scroll-warning::-webkit-scrollbar-thumb {
        background: #ffc107;
    }

    .scroll-success::-webkit-scrollbar-thumb {
        background: #28a745;
    }

    .scroll-orange::-webkit-scrollbar-thumb {
        background: #fd7e14;
    }

    .scroll-purple::-webkit-scrollbar-thumb {
        background: #6f42c1;
    }

    .box-shadow-left{
        box-shadow: -4px 4px 4px 0px rgba(0,0,0,0.32);
    }

    .box-shadow-right{
        box-shadow: 4px 4px 4px 0px rgba(0,0,0,0.32);
    }
    
</style>

<div class="fluid-container">
    <nav aria-label="breadcrumb ">
        <ol class="breadcrumb  arr-right">
            <li class="breadcrumb-item text-primary" aria-current="page"> Taskboard </li>
            <li class="breadcrumb-item active" aria-current="page"><?= $title ?></li>
            <li class="ml-auto">
                <a class="btn btn-secondary text-light" href="/projects">
                    <i class="fa fa-chevron-left"></i> Back
                </a>

            </li>
        </ol>

    </nav>

    <div class="row" style="padding-left:1rem;padding-right:1rem; ">
        <div class="col-12 col-md-2 tasks-column" >

            <div class="card" style="padding-left:5px;">
                <div class="card-header bg-dark text-light">
                    Todo
                </div>

                <div class="card-body task-parent scroll scroll-dark" id="column_Todo">
                    <div class="input-group">
                        <input type="text" class="form-control" name="column_Todo_title" id="column_Todo_title" 
                            placeholder="Quick Add - Title Only" />
                        <div class="ml-2">
                            <button class="btn btn-outline-dark"  data-toggle="popover" data-placement="bottom" data-content="Add Task" 
                            onclick="addTask('Todo', document.getElementById('column_Todo_title').value)">
                                <i class="fas fa-plus "></i>
                            </button>
                        </div>
                    </div>
                </div>

            </div>

        </div>
        <div class="col-12 col-md-2 tasks-column" >

            <div class="card ">
                <div class="card-header  bg-info  text-light">
                    In Progress
                </div>
                <div class="card-body task-parent scroll scroll-info " id="column_InProgress">
                    <div class="input-group">
                        <input type="text" class="form-control" name="column_InProgress_title" id="column_InProgress_title" 
                            placeholder="Quick Add - Title Only" />
                        <div class="ml-2">
                            <button class="btn btn-outline-info"  data-toggle="popover" data-placement="bottom" data-content="Add Task" 
                            onclick="addTask('In Progress', document.getElementById('column_InProgress_title').value)">
                                <i class="fas fa-plus "></i>
                            </button>
                        </div>
                    </div>
                </div>
            </div>

        </div>
        <div class="col-12 col-md-2 tasks-column" >

            <div class="card">
                <div class="card-header bg-purple">
                    Under QA
                </div>
                <div class="card-body  task-parent scroll scroll-purple " id="column_UnderQA">
                    <div class="input-group">
                        <input type="text" class="form-control" name="column_UnderQA_title" id="column_UnderQA_title" 
                            placeholder="Quick Add - Title Only" />
                        <div class="ml-2">
                            <button class="btn btn-outline-purple"  data-toggle="popover" data-placement="bottom" data-content="Add Task"
                            onclick="addTask('Under QA', document.getElementById('column_UnderQA_title').value)">
                                <i class="fas fa-plus "></i>
                            </button>
                        </div>
                    </div>
                </div>
            </div>

        </div>
        <div class="col-12 col-md-2 tasks-column" >

            <div class="card">
                <div class="card-header  bg-warning text-dark">
                    On Hold
                </div>
                <div class="card-body  task-parent scroll scroll-warning " id="column_OnHold">
                    <div class="input-group">
                        <input type="text" class="form-control" name="column_OnHold_title" id="column_OnHold_title" 
                            placeholder="Quick Add - Title Only" />
                        <div class="ml-2">
                            <button class="btn btn-outline-warning"  data-toggle="popover" data-placement="bottom" data-content="Add Task"
                            onclick="addTask('On Hold', document.getElementById('column_OnHold_title').value)">
                                <i class="fas fa-plus "></i>
                            </button>
                        </div>
                    </div>
                </div>
            </div>

        </div>
        <div class="col-12 col-md-2 tasks-column" >

            <div class="card">
                <div class="card-header  bg-success text-light">
                    Complete
                </div>
                <div class="card-body  task-parent scroll scroll-success " id="column_Complete">
                    <div class="input-group">
                        <input type="text" class="form-control" name="column_Complete_title" id="column_Complete_title" 
                            placeholder="Quick Add - Title Only" />
                        <div class="ml-2">
                            <button class="btn btn-outline-success"  data-toggle="popover" data-placement="bottom" data-content="Add Task"
                            onclick="addTask('Complete', document.getElementById('column_Complete_title').value)">
                                <i class="fas fa-plus "></i>
                            </button>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>
</div>

<div class="alert bg-success text-light box-shadow-left success-alert d-none" role="alert">
    
</div>

<script>
    var teamMembers, teamMemberOptions = "", tasksArr = [];
    
    class Task {
        constructor() {
            this.project_id = '<?= $project_id ?>';
            this.id = '';
            this.title = '';
            this.description = '';
            this.assignee = '';
            this.qa = '';
            this.task_category = '';
            this.task_column = '';
            this.comments = null; // [{'comment':'', timestamp: '', by:''}]
        }
    }

    $(document).ready(function () {
        $('[data-toggle="popover"]').popover({trigger: "hover" });
        $(".fluid-container").parents().css("overflow", "visible")
        $("body").css("overflow-x", "hidden");

        teamMembers = <?= json_encode($teamMembers) ?>;
        <?php foreach($teamMembers as $key => $name) : ?>
            teamMemberOptions += `<option value="<?= $key ?>"><?= $name ?></option>`; 
        <?php endforeach; ?>

        makeColumnsDroppable();

        <?php if(isset($tasksArr)): ?>
            tasksArr = <?= json_encode($tasksArr) ?>;
            tasksArr.forEach((task,i)=>{
                addTaskToDocument(task);
                if(task.comments != null){
                    tasksArr[i].comments = JSON.parse(task.comments);
                }
                
            });
        <?php endif ?>

        
    });

    function makeColumnsDroppable(){
        const columns = [ "Todo", "In Progress", "Under QA", "On Hold", "Complete"];
        columns.forEach((columnName)=>{
            const columnId = "#column_"+columnName.replace(" ", "");
            var $column = $(columnId);

            $column.droppable({
                drop: function( event, ui ) {
                    $column.append(ui.draggable);
                    const $task = $(ui.draggable)[0];
                    const taskId = $task.id;
                    updateTaskColumn(taskId, columnName);  
                }
            });

        });
    }
   
    function addTask(column, title, taskId = "") {
        if(title == ""){
            var formTitle = "Add Task", buttonText = "Add";
            
            if(taskId != ""){
                formTitle = "Edit Task", buttonText = "Update";
            }

            var dialog = bootbox.dialog({
                title: formTitle,
                message: `<div class="row">
                            <div class="col-12">
                                <div class="form-group">
                                    <label class = "font-weight-bold text-muted" for="newTask_title">Title</label>
                                    <input type="text" class="form-control" name="newTask_title" id="newTask_title" placeholder="Task Title" />
                                </div>
                            </div>
                            <div class="col-12">
                                <div class="form-group">
                                    <label class = "font-weight-bold text-muted" for="newTask_description">Description</label>
                                    <textarea class="form-control newTask_textarea" name="newTask_description" id="newTask_description" placeholder="What needs to get done?" ></textarea>
                                </div>
                            </div>
                            <div class="col-12 col-md-6">
                                <div class="form-group">
                                    <label class = "font-weight-bold text-muted" for="newTask_assignee">Assigned To</label>
                                    <select class="form-control selectpicker" data-live-search="true" data-size="8" name="newTask_assignee" id="newTask_assignee">
                                        <option value="" disabled selected>
                                            Select Assingee
                                        </option>
                                        ${teamMemberOptions}
                                    </select>
                                </div>
                            </div>
                            <div class="col-12 col-md-6">
                                <div class="form-group">
                                    <label class = "font-weight-bold text-muted" for="newTask_qa">QA</label>
                                    <select class="form-control selectpicker" data-live-search="true" data-size="8" name="newTask_qa" id="newTask_qa">
                                        <option value="" disabled selected>
                                            Select Assingee
                                        </option>
                                        ${teamMemberOptions}
                                    </select>
                                </div>
                            </div>
                            <div class="col-12 col-md-6">
                                <div class="form-group">
                                    <label class = "font-weight-bold text-muted" for="newTask_category">Category</label>
                                    <select class="form-control selectpicker" name="newTask_category" id="newTask_category">                                    
                                        <option value="Improvement" >
                                            Improvement
                                        </option>
                                        <option value="Task" selected>
                                            Task
                                        </option>
                                        <option value="New Feature" >
                                            New Feature
                                        </option>
                                        <option value="Bug" >
                                            Bug
                                        </option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-12 col-md-6">
                                <div class="form-group">
                                    <label class = "font-weight-bold text-muted" for="newTask_column">Column</label>
                                    <select class="form-control selectpicker" name="newTask_column" id="newTask_column">
                                        <option value="Todo" selected>
                                            Todo
                                        </option>
                                        <option value="In Progress" >
                                            In Progress
                                        </option>
                                        <option value="Under QA" >
                                            Under QA
                                        </option>
                                        <option value="On Hold" >
                                            On Hold
                                        </option>
                                        <option value="Complete" >
                                            Complete
                                        </option>
                                    </select>
                                </div>
                            </div>
                            
                        </div>
                        `,
                buttons: {
                    delete: {
                        label: "Delete",
                        className: 'btn-danger mr-auto d-none deleteTask',
                        callback: function(){
                                bootbox.confirm({
                                    title: 'Delete',
                                    message: `Are you sure you want to delete task T${taskId} ?`,
                                    buttons: {
                                        cancel: {
                                            label: '<i class="fa fa-times"></i> Cancel'
                                        },
                                        confirm: {
                                            label: '<i class="fa fa-check"></i> Confirm'
                                        }
                                    },
                                    callback: function (result) {
                                        if(result){
                                            const object = {id:taskId};
                                            updateTaskInDB('/taskboard/deleteTask', "delete", object);
                                            
                                        }else{
                                            console.log('Delete Cancelled');
                                        }
                                    }
                                });
                                                        
                        }
                    },
                    cancel: {
                        label: "Cancel",
                        className: 'btn-secondary'
                    },
                    ok: {
                        label: buttonText,
                        className: "btn-primary",
                        callback: function () {

                            var taskObject = new Task();

                            taskObject.title = $('#newTask_title').val();
                            if(taskObject.title != ""){
                                taskObject.description = $('#newTask_description').val();
                                taskObject.assignee = $('#newTask_assignee').val();
                                taskObject.qa = $('#newTask_qa').val();
                                taskObject.task_category = $('#newTask_category').val();
                                taskObject.task_column = $('#newTask_column').val();

                                if(taskId == ""){
                                    //Add Task
                                    updateTaskInDB('/taskboard/addTask', "add", taskObject);
                                    
                                }else{
                                    //Update Task
                                    const temp = getTaskFromArray(taskId);
                                    var existingTask = temp[1];
                                    taskObject.id = existingTask.id;
                                    taskObject.comments = existingTask.comments;

                                    updateTaskInDB('/taskboard/addTask', "update", taskObject);

                                }
                            }else{
                                showPopUp("Validation Error", "Title of a task cannot be empty!")
                            }
                            
                            
                            
                        }
                    }
                    
                }
            });

            if(taskId != ""){
                $(".deleteTask").removeClass("d-none");
                const task = tasksArr.find(x => parseInt(x.id) === taskId);
                $('#newTask_title').val(task.title);
                $('#newTask_description').val(task.description);
                $('#newTask_assignee').val(task.assignee);
                $('#newTask_qa').val(task.qa);
                $('#newTask_category').val(task.task_category);
                $('#newTask_column').val(task.task_column);
            }else{
                $("#newTask_column").val(column);
            }

            
            $('.selectpicker').selectpicker('refresh');
            
        }else{
            var newTask = new Task();
            newTask.title = title;
            newTask.task_category = "Task";
            newTask.task_column = column;

            updateTaskInDB('/taskboard/addTask', "add", newTask);

            
        }
 
    }

    function getTaskFromArray(taskId){
        var existingTask, existingTaskLoc;
        tasksArr.some((task, index) => {
            if(task.id == taskId){
                existingTask = task;
                existingTaskLoc = index;
                
                return true;
            }
        });
        return [existingTaskLoc, existingTask];
    }

    function updateTaskColumn(taskId, updatedColumn){
        const temp = getTaskFromArray(taskId);
        const existingTaskLoc = temp[0];
        const existingTask = temp[1];

        if(existingTask.task_column != updatedColumn ){
            const object = {id: taskId, task_column:updatedColumn };
            updateTaskInDB('/taskboard/updateTaskColumn', 'updateTaskColumn', object);
        }
        
    }

    function addComment(taskId){
        const temp = getTaskFromArray(taskId);
        const existingTask = temp[1];
        
        if(existingTask.comments == null){ 
            existingTask.comments = []; 
        }
        var commentsHtml = "";
        
        existingTask.comments.forEach((commentData, i) => {
            if (i == 0){
                commentsHtml += `<ul class="list-group scroll scroll-orange" style="max-height: 300px;overflow-y: auto;">`;
            }
            commentsHtml += `<li class="list-group-item list-group-item-action">
                                        ${commentData.comment}
                                    <footer class="blockquote-footer text-right">By <cite>${commentData.by}</cite> at ${formatDate(commentData.timestamp)}</footer>
                                </li>`;
            if(i == (existingTask.length-1)){
                commentsHtml += `</ul>`;
            }

        });

        var dialog = bootbox.dialog({
                title: "Add Comment",
                message: `<div class="row">
                            <div class="col-12">${commentsHtml}</div>
                            <div class="col-12 mt-2">
                                <div class="form-group">
                                    <label class = "font-weight-bold text-muted" for="newTask_comment">Comment</label>
                                    <textarea class="form-control newTask_textarea" name="newTask_comment" id="newTask_comment" placeholder="Task Update" ></textarea>
                                </div>
                            </div>
                        </div>
                        `,
                buttons: {
                    cancel: {
                        label: "Cancel",
                        className: 'btn-secondary'
                    },
                    ok: {
                        label: "Add",
                        className: 'bg-orange',
                        callback: function () {
                            const comment = $('#newTask_comment').val();
                            
                            if(comment != ""){
                                const object = {id:taskId, comment};
                                updateTaskInDB('/taskboard/addComment', 'addComment', object);
                            }
                            
                            
                        }
                    }
                }
            });

    }

    function getTaskHtml(newTask){
        var categoryColor;
        if(newTask.task_category == "Bug"){
            categoryColor = "badge-danger";
        }else if(newTask.task_category == "Improvement"){
            categoryColor = "badge-success";
        }else if(newTask.task_category == "Task"){
            categoryColor = "badge-dark";
        }else{
            categoryColor = "bg-pink"
        }

        var assignee = (newTask.task_column == "Under QA" ? newTask.qa : newTask.assignee);
        if(assignee != "" && assignee != null){
            assignee = teamMembers[assignee];
        }else{
            assignee = "Unassigned";
        }
        var taskHtml = `
                        <div class=" text-muted">
                            <div class="float-left pl-2 pt-2">
                                <span class="badge bg-teal p-2 box-shadow-left" style="font-size:16px;cursor:default;">T${newTask.id}</span>
                                
                            </div>
                            <div class="float-right pt-2 pr-2">
                                <button data-toggle="popover" data-placement="bottom" data-content="Add Comment" type="button" class="btn btn-sm btn-sm-orange box-shadow-right" onclick="addComment(${newTask.id})">
                                    <i class="fas fa-comment"></i>
                                </button>
                                <button data-toggle="popover" data-placement="bottom" data-content="Edit Task" type="button" class="ml-1 btn btn-sm box-shadow-right btn-sm-primary btn-primary" onclick="addTask('', '', ${newTask.id})">
                                    <i class="fa fa-pencil-alt" aria-hidden="true"></i>
                                </button>
                            </div>
                        </div>
                        <div class="card-body">
                            <p class="card-text task_title">${newTask.title}</p>
                        </div>
                        <div class="card-footer text-muted text-right pl-2 pr-2">
                            <div class="float-left">
                                <span class="task_category p-2 badge ${categoryColor}" style="cursor:default;">${newTask.task_category}</span>
                            </div>
                            <div class="float-right truncate">
                                <span data-toggle="popover" data-placement="bottom" data-content="${assignee}" class="task_assignee ">${assignee}</span>
                            </div>
                            
                        </div>
                    `;
        
        return taskHtml;
    }

    function addTaskToDocument(newTask) {

        const html = `
                    <div class="card mt-3 newTask"  style="display:none;" id="${newTask.id}">
                        ${getTaskHtml(newTask)}
                    </div>`;

        const column = newTask.task_column.replace(" ", "");
        var $column = $("#column_"+column);
        $(html).appendTo($column).fadeIn('slow');
        $('[data-toggle="popover"]').popover({trigger: "hover" });
        // $column.append(html);
        $( ".card", $column ).draggable({
            cancel: "button", 
            revert: "invalid", 
            containment: "document",
            helper: "clone",
            cursor: "move",
            start  : function(event, ui){
                $(ui.helper).addClass("ui-helper");
            }
        });
    }

    function updateTaskInDB(url, type, taskObject){
        makeRequest(url, taskObject)
            .then((data) => {
                try{
                    data = JSON.parse(data);
                }catch(e){
                    showPopUp('Error', 'Session timed out! Login Again.');
                    return false;
                }
                
                if(data.success == "True"){
                    if(type == "add"){
                    
                        taskObject.id = data.id;
                        tasksArr.push(taskObject);
                        
                        
                        addTaskToDocument(taskObject);
                        showAlert(`T${taskObject.id} task added successfully!`);

                    }else if(type == "update"){

                        const temp = getTaskFromArray(taskObject.id);
                        const existingTaskLoc = temp[0];
                        const existingTask = temp[1];
                    
                        tasksArr[existingTaskLoc] = taskObject;
                        $(`#${taskObject.id}`).html(getTaskHtml(taskObject));
                        
                        if(existingTask.task_column != taskObject.task_column){
                            var div_column = taskObject.task_column.replace(" ", "");
                            $(`#${taskObject.id}`).appendTo($("#column_"+div_column));
                        }
                        showAlert(`T${taskObject.id} task updated successfully!`);

                    }else if(type == "addComment"){

                        const temp = getTaskFromArray(taskObject.id);
                        const existingTaskLoc = temp[0];
                        const existingTask = temp[1];

                        if(existingTask.comments == null){ 
                            existingTask.comments = []; 
                        }
                        existingTask.comments.push(JSON.parse(data.jsonComment));
                        tasksArr[existingTaskLoc] = existingTask;
                        
                        showAlert(`Comment added to T${taskObject.id} successfully!`);
                    }else if(type == "delete"){
                        console.log('Delete button clicked '+taskObject.id);
                        $("#"+taskObject.id).fadeOut(800, function() { $(this).remove(); });
                        const temp = getTaskFromArray(taskObject.id);
                        const existingTaskLoc = temp[0];
                        tasksArr.splice(existingTaskLoc, 1);
                    }else if(type == "updateTaskColumn"){
                        const temp = getTaskFromArray(taskObject.id);
                        const existingTaskLoc = temp[0];
                        const existingTask = temp[1];

                        existingTask.task_column = taskObject.task_column;
                        tasksArr[existingTaskLoc] = existingTask;
                        $(`#${taskObject.id}`).html(getTaskHtml(existingTask));
                    }
                }else{
                    showPopUp('Error', data.errorMsg);
                }
                
              
                
            })
            .catch((err) => {
                console.log(err);
                
                showPopUp('Error', "An unexpected error occured on server.");
            })
    }

    function makeRequest(url, formData){
        return new Promise((resolve, reject) => {
            $.ajax({
                type: 'POST',
                url: url,
                data: formData,
                success: function (response) {       
                    resolve(response);
                },
                error: function (err) {
                    reject(err);
                }
            });
        })
        
    }

    function showPopUp(title, message){
        bootbox.alert({
                title: title, 
                message: message,
                centerVertical: true,
                backdrop: true
            });
    }

    function formatDate(utcDate) {
        let utc = new Date(utcDate)
        var ist = new Date(utc.getTime() + ( 5.5 * 60 * 60 * 1000 ));
        var date = ist;
        var year = date.getFullYear();
        var month = date.getMonth() + 1;
        var day = date.getDate();
        var hours = date.getHours();
        var minutes = date.getMinutes();
        var ampm = hours >= 12 ? 'pm' : 'am';
        hours = hours % 12;
        hours = hours ? hours : 12; // the hour '0' should be '12'
        minutes = minutes < 10 ? '0'+minutes : minutes;
        var strTime = hours + ':' + minutes + ' ' + ampm;
        return year+"-"+month+"-"+day+" "+strTime;
    }

    function showAlert(message){
        $(".success-alert").text(message);
        $(".success-alert").removeClass("d-none");
        $('.alert').show('slide', {direction: 'right'}, 1000);

        window.setTimeout(function() {
            $('.alert').hide('slide', {direction: 'right'}, 1000);
        
        }, 2000);
    }
</script>