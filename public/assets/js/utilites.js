/*jshint esversion: 6 */

class Diagram {
    constructor() {
        this.id = null;
        this.diagram_name = null;
        this.markdown = null;
        this.author = null;
        this.link = null;
        this.updated_at = null;
    }
}

class Task {
    constructor() {
        this.project_id = '';
        this.id = '';
        this.title = '';
        this.description = '';
        this.assignee = '';
        this.verifier = '';
        this.task_category = '';
        this.task_column = '';
        this.comments = null; // [{'comment':'', timestamp: '', by:''}]
    }
}

function makeRequest(url){
    return new Promise((resolve, reject) => {
        $.ajax({
            type: 'GET',
            url: url,
            success: function (response) {    
                try{
                    response = JSON.parse(response);
                }catch(e){
                    showPopUp('Error', 'Session timed out! Login Again.');
                    return false;
                }   
                resolve(response);
            },
            error: function (err) {
                reject(err);
            }
        });
    })
    
}

function makePOSTRequest(url, data){
    return new Promise((resolve, reject) => {
        $.ajax({
            type: 'POST',
            url: url,
            data: data,
            success: function (response) {  
                try{
                    response = JSON.parse(response);
                }catch(e){
                    showPopUp('Error', 'Session timed out! Login Again.');
                    return false;
                }     
                resolve(response);
            },
            error: function (err) {
                reject(err);
            }
        });
    });
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

function showFloatingAlert(message , bgClass = "bg-success"){
    $(".floating-alert").addClass(bgClass);
    $(".floating-alert").text(message);
    
    $('.floating-alert').show('slide', {direction: 'right'}, 1000);

    window.setTimeout(function() {
        $('.floating-alert').hide('slide', {direction: 'right'}, 2000);
    
    }, 3000);
}

function copyToClipboard(link, location = "body") {    
    $(`${location}`).append(`<input value="${link}" id="copyToClipboard" style="opacity:0">`);
    var input = $("#copyToClipboard");

    input.focus();
    input.select();
    document.execCommand('copy');
    input.remove();

    showFloatingAlert("Success: Link Copied!");
}

function previewImage(name, link){
    var protocol = location.protocol;
    var slashes = protocol.concat("//");
    var host = slashes.concat(window.location.hostname);

    bootbox.dialog({
        title: `${name}`,
        message: `<div class="text-center">
                    <img style="max-width:100%" src='${link}' />
                    </div> `,
        size: 'large',
        buttons: {
            ok: {
                label: "OK",
                className: 'btn-primary'
            }
        }
        
    });
    $(".modal-footer").append(`<div style='left: 10px;position: absolute;'>
                                    <button class="btn btn-orange ml-2" onclick="copyToClipboard('${host}${link}', '.modal-body')" 
                                        data-toggle="popover" data-placement="left" data-content="Copy to clipboard" >
                                        <i class="fas fa-clipboard"></i>
                                    </button>
                                    <a download href="${link}"  
                                        data-toggle="popover" data-placement="right" data-content="Download Image"
                                        class="download-link btn btn-purple ml-2" >
                                        <i class="fa fa-download"></i>
                                    </a>
                                </div>`);
    $('[data-toggle="popover"]').popover({trigger: "hover" });
}

function getHTMLtable(data, dataInfo){
    let tbody = "";

    if(data.length){
        data.forEach((record, index)=> {

            let columns = "";
            dataInfo.requiredFields.forEach(value => {
                let storedVal = record[value];
                if(dataInfo.dateFields.includes(value)){
                    storedVal = formatDate(record[value]);
                }

                columns += `<td>${storedVal}</td>`;
            });

            let actionButtons = "";
            dataInfo.action.forEach(actionObject => {
                
                let clickParams = "";
                actionObject.clickParams.forEach( (param, i) => {
                    clickParams += `'${record[param]}'`;
                    if(i < (actionObject.clickParams.length-1)){
                        clickParams += ",";
                    }
                });

                let includeButton = true;
                if ('condition' in actionObject){
                    if(actionObject.condition.with != record[actionObject.condition.on]){
                        includeButton = false;
                    }
                }

                if(includeButton){
                    const button = `<button title="${actionObject.title}" class="ml-2 ${actionObject.buttonClass}" onclick="${actionObject.clickTrigger}(${clickParams})" >
                                    <i class="${actionObject.iconClass}"></i>
                                </button>`;
                    actionButtons += button;
                }
                
                
            });

            columns += `<td class="text-center">${actionButtons}</td>`;

            let row = `<tr id="${record[dataInfo.rowId]}"><td>${++index}</td>${columns}</tr>`;
            tbody += row;
        });

    }else{
        let row = `<tr><td valign="top" colspan="${(dataInfo.requiredFields.length+2)}" class="dataTables_empty">No data available</td></tr>`;
        tbody += row;
        showFloatingAlert("No data available." , "bg-warning");
    }    

    return tbody;
}