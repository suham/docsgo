<div class="row p-0 p-md-4 justify-content-center">

    <div class="col-12 pt-3 mb-4 pt-md-0 pb-md-0">
        <div class="btn-group btn-group-toggle ">
            <button onclick="getTableRecords('my')" class="btn btn-primary myDiagrams">My</button>
            <button onclick="getTableRecords('all')" class="btn btn-secondary allDiagrams">All</button>
        </div>
    </div>

    <div class="col-12">
        <div class="alert alert-warning d-none" role="alert">
            No records found.
        </div>
    </div>

    <div class="col-12">
        <table class="table  table-hover" id="diagrams-list">
            <thead class="thead-dark">
                <tr>
                    <th scope="col">#</th>
                    <th scope="col">Name</th>
                    <th scope="col">Author</th>
                    <th scope="col">Update date</th>
                    <th scope="col" style="width:175px">Actions</th>
                </tr>
            </thead>
            <tbody class="bg-white " id ="tbody"></tbody>
        </table>
    </div>


  
</div>

<!-- <div class="alert bg-success text-light box-shadow-left success-alert d-none"  style="z-index:9999" role="alert"></div> -->

<script>
    var prevUrlType = "";
    var diagramsList;   
    var userId;

    $(document).ready( function () {
        userId = <?= session()->get('id') ?>;
        $('#diagrams-list').DataTable({
            "responsive": true,
            "autoWidth": false,
        });

        <?php if(isset($_SESSION['PREV_URL'])): ?>

            prevUrl = JSON.parse(`<?= json_encode($_SESSION['PREV_URL']) ?>`);
            if(prevUrl.name == "diagramsList"){
                prevUrlType = prevUrl.vars.type;
            }
            
        <?php endif; ?>
        getTableRecords(prevUrlType);
        
    });

    $(document).on({
        ajaxStart: function(){
            $("#loading-overlay").show();
        },
        ajaxStop: function(){ 
            $("#loading-overlay").hide();
        }    
    });

    function getTableRecords(type = ""){
        let url = '/diagrams/getDiagrams?type=';
        if(type != ""){
            url += type; 
            $(".btn-group button").removeClass("btn-primary").addClass("btn-secondary");
            $(`.${type}Diagrams`).removeClass("btn-secondary").addClass("btn-primary");
        }else{
            url += "my"; 
        }

        makeRequest(url)
            .then((response) => {
                diagramsList = response.diagrams;
                populateTable(diagramsList);
            })
            .catch((err) => {
                console.log(err);
                showPopUp('Error', "An unexpected error occured on server.");
            })
    }

    function populateTable(diagramsList){
        $('#tbody').html("");
        if(diagramsList.length){
            $("#diagrams-list").show();
            diagramsList.forEach((diagram, index)=> {
                let deleteButton = "";
                if(diagram.author_id == userId){
                    deleteButton = `
                        <a title="Delete" onclick="deleteDiagram(${diagram.id})" class="btn btn-danger ml-2">
                            <i class="fa fa-trash text-light"></i>
                        </a>`;
                }

                $('#tbody').append(
                    `<tr id="${diagram.id}"> 
                        <td>${++index}</td> 
                        <td>${diagram.diagram_name}</td> 
                        <td>${diagram.author}</td> 
                        <td>${formatDate(diagram.updated_at)}</td>
                        <td class="text-center">
                            <button title="Preview" class="btn btn-info" onclick="previewImage('${diagram.diagram_name}', '${diagram.link}')" >
                                <i class="fa fa-eye"></i>
                            </button>
                        
                            <a title="Edit" href="/diagrams/draw?id=${diagram.id}" class="btn btn-warning ml-2">
                                <i class="fa fa-edit"></i>
                            </a>
                            
                            ${deleteButton}
                            
                        </td>
                    </tr>`
                );

            
            });

        }
        else{
            $('#tbody').append(
            `<td valign="top" colspan="5" class="dataTables_empty">No data available</td>`
            );
        }


    }

    function deleteDiagram(id){
        bootbox.confirm("Do you really want to delete the diagram?", function(result) {
            if(result){
                const object = {id};
                makePOSTRequest('/diagrams/delete', object)
                    .then((response)=>{
                        $("#"+object.id).fadeOut(800, function() { $(this).remove(); });
                    })
                    .catch((err) => {
                        console.log(err);
                        showPopUp('Error', "An unexpected error occured on server.");
                    })
            }            
        });
        
    }

  

</script>

