<style>


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
        /* z-index: 1; */
        background-color: #ccc;
        border-color: 1px solid #ccc;
    }

    @keyframes cardEntrance {
        from{
            opacity: 0;
            transform: translate(-100%, 50%) rotate(15deg) translate(100%, -50%);
        }
        to{
            opacity: 1;
            transform: rotate(0deg);
        }
    }

    /* task styles */
    .newTask{
        animation: cardEntrance 500ms ease-out;
        animation-fill-mode: backwards;
    }

    .newTask:hover {
        box-shadow: rgba(19,19,19,0.6) 0px 0.35em 1.175em, rgba(19,19,19,0.2) 0px 0.175em 0.5em;
        transform: translateY(-3px) scale(1.05);
        transition: transform 1000ms;
      }

    .truncate {
        width: 136px;
        white-space: nowrap;
        overflow: hidden;
        text-overflow: ellipsis;
    }

   
    .newTask_textarea {
        height: 110px;
    }

    /* Draggable style */
    .ui-helper {
        width: 100% !important;
    }

 
    /* Comment Styles */
    .counter.counter-lg {        
        font-size: 10px;
        color: #f8f9fa;
        font-weight: bold;
        text-align: center;
        padding-top: 1px;
    }

    .sec {
        position: relative;
        top: -14px;
        right: -4px;
    }

    .dot {
        height: 16px;
        width: 15px;
        background-color: #cc650f;
        border-radius: 50%;
        display: inline-block;
        margin-left: -15px;
    }

    .modal-lg{
        max-width:80vw;
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

            <div class="card">
                <div class="card-header bg-dark text-light">
                    Todo
                </div>

                <div class="card-body task-parent scroll scroll-dark" id="column_Todo">
                    <div class="input-group">
                        <input type="text" class="form-control" name="column_Todo_title" id="column_Todo_title" 
                            placeholder="Quick Add - Title Only" />
                        <div class="ml-2">
                            <button class="btn btn-outline-dark" data-toggle="popover" data-placement="bottom" data-content="Add Task" 
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
                    Under Verification
                </div>
                <div class="card-body  task-parent scroll scroll-purple " id="column_UnderVerification">
                    <div class="input-group">
                        <input type="text" class="form-control" name="column_UnderVerification_title" id="column_UnderVerification_title" 
                            placeholder="Quick Add - Title Only" />
                        <div class="ml-2">
                            <button class="btn btn-outline-purple"  data-toggle="popover" data-placement="bottom" data-content="Add Task"
                            onclick="addTask('Under Verification', document.getElementById('column_UnderVerification_title').value)">
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

        <div class="col-12 col-md-2 tasks-column" >

            <div class="card">
                <div class="card-header  bg-warning text-dark">
                    Observations
                </div>
                <div class="card-body  task-parent scroll scroll-warning " id="column_Observations">
                    <div class="input-group">
                        <input type="text" class="form-control" name="column_Observations_title" id="column_Observations_title" 
                            placeholder="Quick Add - Title Only" />
                        <div class="ml-2">
                            <button class="btn btn-outline-warning"  data-toggle="popover" data-placement="bottom" data-content="Add Task"
                            onclick="addTask('Observations', document.getElementById('column_Observations_title').value)">
                                <i class="fas fa-plus "></i>
                            </button>
                        </div>
                    </div>
                </div>
            </div>

        </div>

    </div>
</div>


<script>
    var teamMembers, project_id, teamMemberOptions = "", tasksArr = [];
    var defaultZIndex =3;
   

    $(document).ready(function () {
        $('[data-toggle="popover"]').popover({trigger: "hover" });
        $(".fluid-container").parents().css("overflow", "visible")
        $("body").css("overflow-x", "hidden");

        teamMembers = <?= json_encode($teamMembers) ?>;
        <?php foreach($teamMembers as $key => $name) : ?>
            teamMemberOptions += `<option value="<?= $key ?>"><?= $name ?></option>`; 
        <?php endforeach; ?>

        project_id = '<?= $project_id ?>';

        makeColumnsDroppable();

        <?php if(isset($tasksArr)): ?>
            tasksArr = <?= json_encode($tasksArr) ?>;
            tasksArr.forEach((task,i)=>{
                
                if(task.comments != null){
                    tasksArr[i].comments = JSON.parse(task.comments);
                }
                addTaskToDocument(task);
            });
        <?php endif ?>

        
    });

    $(document).on({
        ajaxStart: function(){
            $("#loading-overlay").show();
        },
        ajaxStop: function(){ 
            $("#loading-overlay").hide();
        }    
    });

    function makeColumnsDroppable(){
        const columns = [ "Todo", "In Progress", "Under Verification", "Observations", "Complete"];
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
                message: `<form id="taskForm">
                        <input type="hidden" name="id" value='${taskId}' />
                        <input type="hidden" name="project_id" value='${project_id}' />
                        <div class="row">
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
                                            Select
                                        </option>
                                        ${teamMemberOptions}
                                    </select>
                                </div>
                            </div>
                            <div class="col-12 col-md-6">
                                <div class="form-group">
                                    <label class = "font-weight-bold text-muted" for="newTask_verifier">Verified By</label>
                                    <select class="form-control selectpicker" data-live-search="true" data-size="8" name="newTask_verifier" id="newTask_verifier">
                                        <option value="" disabled selected>
                                            Select
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
                                        <option value="Under Verification" >
                                            Under Verification
                                        </option>
                                        <option value="Complete" >
                                            Complete
                                        </option>
                                        <option value="Observations" >
                                            Observations
                                        </option>
                                    </select>
                                </div>
                            </div>
                            
                            <div class="col-12">

                                <div class="input-group">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text" id="inputGroupFileAddon01">Upload</span>
                                    </div>
                                    <div class="custom-file">
                                        <input class="custom-file-input" type="file" id="newTask_attachments" name="attachments[]" accept="image/*,video/*" multiple>
                                        <label class = "custom-file-label" for="newTask_attachments">Attachments</label>
                                    </div>
                                </div>
                               
                            </div>
                            
                        </div>
                        </form>
                        
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

                            const taskTitle = $('#newTask_title').val();
                            let taskForm = new FormData(document.getElementById("taskForm"));

                            if(taskTitle != ""){
                                if(taskId == ""){
                                    //Add Task
                                    updateTaskInDB('/taskboard/addTask', "add", taskForm,true);
                                }else{
                                    //Update Task
                                    updateTaskInDB('/taskboard/addTask', "update", taskForm,true);
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
                $('#newTask_verifier').val(task.verifier);
                $('#newTask_category').val(task.task_category);
                $('#newTask_column').val(task.task_column);
                const formFooter = `<footer class="blockquote-footer text-right mt-3">Created by <cite>${teamMembers[task.creator]}</cite></footer>`;
                $('.modal-body').append(formFooter);
            }else{
                $("#newTask_column").val(column);
            }


            $(".custom-file-input").change(function(){
                var files = $("#newTask_attachments")[0].files;
                if(files.length < 1){
                    $(".custom-file-label").text("Attachments")
                }else if(files.length > 1){
                    $(".custom-file-label").text(files.length+" Files")
                }else{
                    $(".custom-file-label").text(files[0].name)
                }
            })
           
            $('.selectpicker').selectpicker('refresh');
            
        }else{

            let taskForm = new FormData();
            taskForm.append('project_id', project_id);
            taskForm.append('newTask_title', title);
            taskForm.append('newTask_category', "Task");
            taskForm.append('newTask_column', column);

            updateTaskInDB('/taskboard/addTask', "add", taskForm, true);

            
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

        var commentsCount = "";
        var commentCountClass = "d-none";
        if(newTask.comments != null){
            commentsCount = newTask.comments.length;
            commentCountClass = "";
        }

        var assignee = (newTask.task_column == "Under Verification" ? newTask.verifier : newTask.assignee);
        if(assignee != "" && assignee != null){
            assignee = teamMembers[assignee];
        }else{
            assignee = "Unassigned";
        }
        var attachmentsHtml = "";
        if(newTask.attachments != null){
            jsonAttachments = newTask.attachments;
            attachmentsCount = JSON.parse(newTask.attachments).length;
            attachmentsHtml +=`<button data-toggle="popover" data-placement="bottom" data-content="View Attachments" type="button" 
                                        class="btn btn-sm btn-purple box-shadow-right" onclick="attachmentSlider('T${newTask.id} Attachments', getCarouselHtml(${newTask.id}) )" >
                                    <i class="fas fa-paperclip"></i>
                                </button>
                                <span id="attachmentCount_${newTask.id}" class="dot sec counter counter-lg">${attachmentsCount}</span>`;
        }
        var taskHtml = `
                        <div class=" text-muted">
                            <div class="float-left pl-2 pt-2">
                                <span class="badge bg-teal p-2 box-shadow-left" style="font-size:16px;cursor:default;">T${newTask.id}</span>
                                
                            </div>
                            <div class="float-right pt-2 pr-2">
                                ${attachmentsHtml}
                                <button data-toggle="popover" data-placement="bottom" data-content="Add Comment" type="button" class="ml-1 btn btn-sm btn-orange box-shadow-right" onclick="addComment(${newTask.id})">
                                    <i class="fas fa-comment"></i>
                                </button>
                                <span id="commentCount_${newTask.id}" class="dot sec counter counter-lg ${commentCountClass}">${commentsCount}</span>
                                <button data-toggle="popover" data-placement="bottom" data-content="Edit Task" type="button" class="ml-1 btn btn-sm box-shadow-right btn-sm-primary btn-primary" onclick="addTask('', '', ${newTask.id})">
                                    <i class="fa fa-pencil-alt" aria-hidden="true"></i>
                                </button>
                            </div>
                        </div>
                        <div class="card-body">
                            <p data-toggle="popover" data-placement="top" data-content="${newTask.description}" class="card-text task_title">${newTask.title}</p>
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

    function getCarouselHtml(taskId){
        const temp = getTaskFromArray(taskId);
        const existingTask = temp[1];
        const attachments = JSON.parse(existingTask.attachments);
        let carouselIndicators = "";
        let carouselItems = "";
        attachments.forEach((attachment, index) =>{

            const activeClass = (index == 0) ? 'active' : '';
            carouselIndicators += `<li data-target="#carouselExampleIndicators" data-slide-to="${index}" class="${activeClass}"></li>`;
            if(attachment.type.includes('image')){
                carouselItems += `<div class="carousel-item ${activeClass} ">
                                    <img class="d-block img-fluid rounded mx-auto d-block" style="max-height: 80vh;" src="${attachment.link}" >
                                </div>`;
                
            }else if(attachment.type.includes('video')){
                carouselItems += `<div class="carousel-item ${activeClass}">
                                    <video class="video-fluid d-block w-100" style="max-height: 80vh;" autoplay controls >
                                        <source src="${attachment.link}" type="${attachment.type}" />
                                    </video>
                                </div>`;
            }else if(attachment.type.includes('pdf')){
                carouselItems += `<div class="carousel-item ${activeClass}">
                                    <embed src="${attachment.link}" type="application/pdf" width="100%" style="min-height:80vh" />
                                </div>`;
            }
            else{
                carouselItems += `<div style="min-height: 200px;margin-top: 100px;" class="carousel-item text-center ${activeClass}">
                                    <a  href="${attachment.link}" download >Attachment</a>
                                </div>`;
            }
        });
        return [carouselIndicators, carouselItems];
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
                $( ".ui-draggable" ).not( ui.helper.css( "z-index", "1" ) )
                            .css( "z-index", "0" );
            }
        });
    }

    function updateTaskInDB(url, type, taskObject,fileData = false){

        makePOSTRequest(url, taskObject, fileData)
            .then((data) => {                
                if(data.success == "True"){
                    if(type == "add"){
                    
                        // taskObject.id = data.task;
                        tasksArr.push(data.task);
                        
                        addTaskToDocument(data.task);
                        showFloatingAlert(`T${data.task.id} task added successfully!`);

                    }else if(type == "update"){

                        const temp = getTaskFromArray(data.task.id);
                        const existingTaskLoc = temp[0];
                        const existingTask = temp[1];
                        var task = new Task();
                        task = data.task;
                        task.comments = existingTask.comments;
                        tasksArr[existingTaskLoc] = task;
                        $(`#${task.id}`).html(getTaskHtml(task));
                        $('[data-toggle="popover"]').popover({trigger: "hover" });

                        if(existingTask.task_column != task.task_column){
                            var div_column = task.task_column.replace(" ", "");
                            $(`#${task.id}`).appendTo($("#column_"+div_column));
                        }
                        showFloatingAlert(`T${task.id} task updated successfully!`);

                    }else if(type == "addComment"){

                        const temp = getTaskFromArray(taskObject.id);
                        const existingTaskLoc = temp[0];
                        const existingTask = temp[1];

                        if(existingTask.comments == null){ 
                            existingTask.comments = []; 
                           
                        }
                        existingTask.comments.push(JSON.parse(data.jsonComment));
                        tasksArr[existingTaskLoc] = existingTask;

                        $(`#commentCount_${taskObject.id}`).removeClass('d-none');
                        $(`#commentCount_${taskObject.id}`).text(existingTask.comments.length);
                        
                        showFloatingAlert(`Comment added to T${taskObject.id} successfully!`);
                    }else if(type == "delete"){
                        
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
                        $('[data-toggle="popover"]').popover({trigger: "hover" });
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

</script>