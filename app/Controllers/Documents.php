<?php namespace App\Controllers;

use App\Models\DocumentModel;
use App\Models\ProjectModel;
use App\Models\TeamModel;
use App\Models\DocumentTemplateModel;
use App\Models\ReviewModel;
use App\Models\DocumentsMasterModel;
use App\Models\RequirementsModel;
use App\Models\TraceabilityMatrixModel;
use App\Models\RiskAssessmentModel;
use App\Models\AcronymsModel;
use App\Models\SettingsModel;
class Documents extends BaseController
{
    public function index()
    {
        $data = [];
		$data['pageTitle'] = 'Documents';
		$data['addBtn'] = False;
		$data['titleDD'] = True;
		$data['addUrl'] = "/documents/add";

		//Projects Dropdown
		$projectModel = new ProjectModel();
		$data['projects'] = $projectModel->getProjects();

		//Status Radio Buttons
		$settingsModel = new SettingsModel();		
		$documentStatusOptions =  $settingsModel->getConfig("documentStatus");
		$data["documentStatus"] = $documentStatusOptions;

		//Document Type List for adding new documents
		$templateModel = new DocumentTemplateModel();
		$existingTypes = $templateModel->getTypes();
		$data['documentType'] = $existingTypes;

		$view = $this->request->getVar('view');
		$project_id = $this->request->getVar('project_id');

		$selectedStatus = null;
		if($view == '' || $project_id == ''){
			//Initial Case
			$projectModel = new ProjectModel();
			$activeProject = $projectModel->where("status","Active")->first();	
			if($activeProject == ""){
				$activeProject = $projectModel->first();	
				if($activeProject == ""){
					$data['data'] = [];
					echo view('templates/header');
					echo view('templates/pageTitle', $data);
					echo view('ProjectDocuments/list',$data);
					echo view('templates/footer');
					exit(0);
				}
			}
			$selectedProject = $activeProject['project-id'];

			if($documentStatusOptions != null){
				$selectedStatus = $documentStatusOptions[0];
			}

		}else{
			$selectedProject = $project_id;
			$selectedStatus = $view;
		}

		if($selectedStatus != null){
			session()->set('prevUrl', '');
			
			$data['selectedProject'] = $selectedProject;
			$data['selectedStatus'] = $selectedStatus;

			$whereCondition = "WHERE docs.`status` = '".$selectedStatus."' and docs.`project-id` = ".$selectedProject;
			$documentModel = new DocumentModel();
			$data['data']  = $documentModel->getDocuments($whereCondition);	
			$data['documentsCount'] = $documentModel->getDocumentsCount($selectedProject);
		}else{
			$data['data'] = [];
		}

		echo view('templates/header');
		echo view('templates/pageTitle', $data);
		echo view('ProjectDocuments/list',$data);
		echo view('templates/footer');
	}

	// Used for generating documents
	// Will be deprecated soon
	public function getJson(){
		// Type can be document or project
		$type = $this->request->getVar('type');
		$id = $this->request->getVar('id');
		$model = new DocumentModel();
		if($type == "" && $id == ""){			
			$data = $model->where('status',"Approved")->findAll();	
			return json_encode($data);
		}else{
			if(($type == "document") || ($type == "project")){
				if($id != ""){
					if($type == "document"){
						$data = $model->where('status',"Approved")->where('id',$id)->findAll();
					}else if($type == "project"){
						$data = $model->where('status',"Approved")->where('project-id',$id)->findAll();
					}					
					$documents = [];
					foreach($data as $document){
						$temp['file-name'] = $document['file-name'];
						$temp['json-object'] = $document['json-object'];
						$documents[$document['id']] = $temp;
					}
					return json_encode($documents);
				}else{
					echo "id not defined";
				}
			}else{
				echo "Type not defiend";
			}
		}
		
	}

	private function getTablesData($tableName, $project_id){
		if($tableName == 'teams'){
			$teamModel = new TeamModel();
			$data = $teamModel->orderBy('name', 'asc')->findAll();	
			return $data;
		}else if($tableName == 'reviews'){
			$condition = " WHERE rev.`project-id` = ".$project_id;
			$reviewModel = new ReviewModel();
			$data = $reviewModel->getMappedRecords($condition);
			return $data;
		}else if($tableName == 'documentMaster'){
			$references = new DocumentsMasterModel();
			$data = $references->getRefrences();	
			return $data;
		}else if($tableName == 'requirements'){
			$requirements = new RequirementsModel();
			$data = $requirements->findAll();	
			return $data;
		}else if($tableName == 'traceabilityMatrix'){
			$traceabilityMatrix = new TraceabilityMatrixModel();
			$data = $traceabilityMatrix->getTraceabilityData();	
			return $data;
		}else if($tableName == 'documents'){
			$condition = " WHERE docs.`project-id` = ".$project_id;
			$documents = new DocumentModel();
			$data = $documents->getDocuments($condition);	
			return $data;
		}else if($tableName == 'riskAssessment'){
			$condition = " WHERE `project_id` = ".$project_id;
			$riskAssessment = new RiskAssessmentModel();
			$data = $riskAssessment->getRisksForDocuments($condition);	
			return $data;
		}else if($tableName == 'acronyms'){
			$acronymsModel = new AcronymsModel();
			$data = $acronymsModel->orderBy('acronym')->findAll();	
			return $data;
		}
		else{
			return [];
		}
	}
    
	private function getJsonTemplate($type){
        $templateModel = new DocumentTemplateModel();
		$data = $templateModel->where('type', $type)->first();	
		$template["name"] = $data["name"];
		$template["jsonObject"] = json_decode($data['template-json-object'], true);
		return $template;
	}

	private function getExistingDocs($type = ""){
		$documentModel = new DocumentModel();
		$data = [];
	
		// Get 10 latest exisiting Docs related to the type
		//All Documents
		$limit = "LIMIT 10";
		$whereCondition = "WHERE docs.`type` = '".$type."' ";
		$existingDocs = $documentModel->getDocuments($whereCondition, $limit);
		if(!count($existingDocs)) $data["all"] = [];
		for($i=0; $i<count($existingDocs);$i++){
			$data["all"][$i]["id"] = $existingDocs[$i]["id"];
			$data["all"][$i]["title"] = $existingDocs[$i]["title"];
		}
		
		//Logged In User Docs
		$whereCondition .= "AND docs.`author-id` = ".session()->get('id')." ";
		$existingDocs = $documentModel->getDocuments($whereCondition, $limit);
		if(!count($existingDocs)) $data["my"] = [];
		for($i=0; $i<count($existingDocs);$i++){
			$data["my"][$i]["id"] = $existingDocs[$i]["id"];
			$data["my"][$i]["title"] = $existingDocs[$i]["title"];
		}
			
		return $data;
	}
	
	
	public function add(){
		helper(['form']);
		$documentModel = new DocumentModel();
		$data = [];
		$data['pageTitle'] = 'Documents';
		$data['addBtn'] = False;

		$teamModel = new TeamModel();
		$data['teams']= $teamModel->getMembers();	
		

		//Handling the back page navigation url
		if(isset($_SERVER['HTTP_REFERER'])){
			$urlStr = $_SERVER['HTTP_REFERER'];
			if (strpos($urlStr, '?view')) {
				$urlAr = explode("?view", $urlStr);
				$backUrl = '/documents?view'.$urlAr[count($urlAr)-1];
				session()->set('prevUrl', $backUrl);
			}else{
				if(session()->get('prevUrl') == ''){
					session()->set('prevUrl', '/documents');
				}
			}
		}else{
			session()->set('prevUrl', '/documents');
		}
		$data['backUrl'] =  session()->get('prevUrl');

		$settingsModel = new SettingsModel();
		
		$data["documentStatus"] =  $settingsModel->getConfig("documentStatus");
		$data["reviewCategory"] =  $settingsModel->getConfig("reviewCategory");

		if ($this->request->getMethod() == 'get') {
			$id = $this->request->getVar('id');
			if($id == ""){
				
				// Request for new document
				$type = $this->request->getVar('type');
				$project_id = $this->request->getVar('project_id');
				$existing_id = $this->request->getVar('existing_id');

				if($project_id == "null"){
					$session = session();
					$session->setFlashdata('alert', "danger");
					$session->setFlashdata('message', "Create a project first!");
					return redirect()->to('/documents');
				}
				// Populating Existing Docs Dropdown
				$existingDocs = $this->request->getVar('allExistingDocs');
				if($existingDocs == "" || $existingDocs == "no"){
					$data['allExistingDocs'] = "FALSE";
				}else{
					$data['allExistingDocs'] = "TRUE";
				}

				if($existing_id != "" && $project_id != "" ){
					// Return requested template
					$existingDoc = $documentModel->where('id',$existing_id)->first();
					$data['selectedExistingDocId'] = $existing_id;
					if($existingDoc["author-id"] != session()->get('id')){
						$data['allExistingDocs'] = "TRUE";
					}
					$type = $existingDoc["type"];
					// $existingDoc = $this->getExistingDocs("",$existing_id);
					// $type = $existingDoc["type"];
					$template = $this->getJsonTemplate($type);
					$templateName = $template["name"];
					$existingDoc['json-object'] =json_decode($existingDoc['json-object'],true);
					$data['jsonObject'] = $existingDoc['json-object'][$type];
					
				}else if($type != "" && $project_id != "" ){

					$template = $this->getJsonTemplate($type);
					$templateName = $template["name"];
					
					$data['jsonObject'] = $template['jsonObject'][$type];
				
				}else{
					
					return redirect()->to('/documents');
					
				}

				$data["type"] = $type;
				
				$projectModel = new ProjectModel();
				$projects = $projectModel->getProjects();
				$data['project_name'] = $projects[$project_id];
				$data['project_id'] = $project_id;
				$data['formTitle'] = $templateName;
				$data['docTitle'] = $templateName.",".$data['project_name'];
				// Get Lookup tables as per template sections
				$sections = $data['jsonObject']["sections"];
				$data["lookUpTables"] = [];
				foreach ($sections as $section){
					if(array_key_exists('type', $section)){
						if($section['type'] == 'database'){
							if(!array_key_exists($section['tableName'] , $data["lookUpTables"])){
								$data["lookUpTables"][$section['tableName']] = $this->getTablesData($section['tableName'], $project_id);
							}
						}
					}
				}

				
				$data['existingDocs'] = $this->getExistingDocs($type);
				
			}else{
				// Return an existing document
				$data['projectDocument'] = $documentModel->where('id',$id)->first();
				$type = $data['projectDocument']["type"];
				$project_id = $data['projectDocument']["project-id"];

				$projectModel = new ProjectModel();
				$projects = $projectModel->getProjects();
				$data['project_name'] = $projects[$project_id];
				$data['project_id'] = $project_id;
				
				
				$data['jsonObject'] = json_decode($data['projectDocument']['json-object'], true);
				$data['jsonObject'] = $data['jsonObject'][$type];

				// Get Lookup tables as per template sections
				$sections = $data['jsonObject']["sections"];
				$data["lookUpTables"] = [];
				foreach ($sections as $section){
					if(array_key_exists('type', $section)){
						if($section['type'] == 'database'){
							if(!array_key_exists($section['tableName'] , $data["lookUpTables"])){
								$data["lookUpTables"][$section['tableName']] = $this->getTablesData($section['tableName'], $project_id);
							}
						}
					}
				}

				//Get Review Comment
				$reviewModel = new ReviewModel();
				$data['documentReview'] = $reviewModel->where('id',$data['projectDocument']['review-id'])->first();
			}
		}

		echo view('templates/header');
		echo view('templates/pageTitle', $data);
		echo view('ProjectDocuments/form', $data);
		echo view('templates/footer');
	}

	public function save(){
		$response = array();

		$fileName =  $this->request->getVar('cp-line3');
		$fileName =  str_replace(' ', '', $fileName);
		$fileName =  str_replace(',', '_', $fileName);
		$currentTime = gmdate("Y-m-d H:i:s");

		//Updating JSON template
		$type = $this->request->getVar('type');
		$template = $this->getJsonTemplate($type);
		$jsonObject = $template['jsonObject'];
		
		$jsonObject[$type]['cp-line3'] =$this->request->getVar('cp-line3');
		$jsonObject[$type]['cp-line4'] =$this->request->getVar('cp-line4');
		$jsonObject[$type]['cp-line5'] =$this->request->getVar('cp-line5');
		$jsonObject[$type]['cp-change-history'] =$this->request->getVar('cp-change-history');
		$jsonObject[$type]['cp-approval-matrix'] =$this->request->getVar('cp-approval-matrix');
		$sections = $jsonObject[$type]['sections'];

		
		foreach($sections as $key=>$section){
			$sectionId = $sections[$key]["id"];
			$sections[$key]["content"] = $this->request->getVar($sectionId);
		}
		$jsonObject[$type]["sections"] = $sections;

		$postData = [
			'project-id' => $this->request->getVar('project-id'),
			'type' => $type,
			'category' => $jsonObject[$type]["template-category"],
			'author-id' => session()->get('id'),
			'reviewer-id' => $this->request->getVar('reviewer-id'),
			'file-name' => $fileName,
			'status' => $this->request->getVar('status'),
			'update-date' => $currentTime,
			'json-object' => json_encode($jsonObject),
		];

		$documentModel = new DocumentModel();
		$id = $this->request->getVar('id');
		$revision["dateTime"] = $currentTime;
		$revision["who"] = session()->get("name");
		
		if($id == ""){
			//Creating Document Revision JSON
			$revision["type"] = "Created";
			$revision["log"] = "Document created.";
			$revisionHistory["revision-history"] = array();
			
			array_push($revisionHistory["revision-history"], $revision);

			$postData["revision-history"] = json_encode($revisionHistory);
			
			//Insert
			$id = $documentModel->insert($postData);
			$session = session();
			$session->setFlashdata('success', "Document Created successfully!");
		}else{
			//Updating Document Revision
			$doc = $documentModel->where('id',$id)->first();
			
			$oldJsonObject = json_decode($doc['json-object'], true);
			$diff = $this->arrayDiff( $jsonObject[$type], $oldJsonObject[$type]);

			if($doc["reviewer-id"] != $postData["reviewer-id"]){
				if(strlen($diff)){
					$diff .= ", ";
				}
				$diff .= "Reviewer";
			}

			if($doc["status"] != $postData["status"]){
				if(strlen($diff)){
					$diff .= ", ";
				}
				$diff .= "Status";
			}

			$revisionHistory = $doc["revision-history"];
			if($revisionHistory != null){
				$revisionHistory = json_decode($revisionHistory, true);
			}else{
				$revisionHistory["revision-history"] = array();
			}
			if(strlen($diff)){
				$revision["type"] = "Edited";
				$revision["log"] = $diff." was updated.";
				array_push($revisionHistory["revision-history"], $revision);
			}
	

			$postData["revision-history"] = json_encode($revisionHistory);
			$response["revisionHistory"] = json_encode($revisionHistory);
			
			//Update Document
			$documentModel->update($id, $postData);
		}

		
		$response["success"] = "True";
		$response["id"] = $id;
		$response["fileName"] = $fileName;
		
		echo json_encode($response);
		
	}

	public function arrayDiff($aArray1, $aArray2) { 
		$aReturn = array(); 
	
		foreach ($aArray1 as $mKey => $mValue) { 
			if (array_key_exists($mKey, $aArray2)) { 
				if (is_array($mValue)) { 
					foreach ($mValue as $sKey => $sValue){
						if ($sValue != $aArray2[$mKey][$sKey]) { 
							array_push($aReturn, $aArray2[$mKey][$sKey]["title"]. " Section" );
						} 
					}
					
				} else { 
					if ($mValue != $aArray2[$mKey]) { 
						array_push($aReturn, $mKey );
					} 
				} 
			} else { 
				array_push($aReturn, $mKey );
			} 
		} 

		if(count($aReturn)){
			$diff = implode(", ",$aReturn);
			$diff = str_replace("cp-line3","Title",$diff);
			$diff = str_replace("cp-line4","Document ID",$diff);
			$diff = str_replace("cp-line5","Revision",$diff);
			$diff = str_replace("cp-approval-matrix","Approval Matrix",$diff);
			$diff = str_replace("cp-change-history","Change History",$diff);
			return $diff;
		}else{
			return ""; 
		}
	
		
	}

	public function delete(){
		if (session()->get('is-admin')){
			$uri = $this->request->uri;
			$id = $uri->getSegment(3);

			$model = new DocumentModel();
			$model->delete($id);
			$response = array('success' => "True");
			echo json_encode( $response );
		}
		else{
			$response = array('success' => "False");
			echo json_encode( $response );
		}
	}


}