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
		$data['addBtn'] = True;
		$data['addUrl'] = "/documents/add";

		$settingsModel = new SettingsModel();
		$documentStatus = $settingsModel->where("identifier","documentStatus")->first();
		if($documentStatus["options"] != null){
			$documentStatusOptions = json_decode( $documentStatus["options"], true );
			$data["documentStatus"] = $documentStatusOptions;
		}else{
			$data["documentStatus"] = [];
		}

		$view = $this->request->getVar('view');
		$project_id = $this->request->getVar('project_id');

		if($view == '' || $project_id == ''){
			//Initial Case
			$projectModel = new ProjectModel();
			$activeProject = $projectModel->where("status","Active")->first();	
			if($activeProject == ""){
				$activeProject = $projectModel->first();	
			}
			$selectedProject = $activeProject['project-id'];
			$data['selectedProject'] = $selectedProject;

			// $documentStatusOptions = json_decode( $documentStatus["options"], true );
			if($documentStatusOptions != null){
				$selectedStatus = $documentStatusOptions[0]["value"];
				$data['data'] = $this->getExistingDocs("",$selectedStatus,$selectedProject);			
				$data['selectedStatus'] = $selectedStatus;
			}

		}else{
			$data['data'] = $this->getExistingDocs("",$view,$project_id);	
			$data['selectedProject'] = $project_id;
			$data['selectedStatus'] = $view;
		}
		
		$data['projects'] = $this->getProjects();

		echo view('templates/header');
		echo view('templates/pageTitle', $data);
		echo view('ProjectDocuments/list',$data);
		echo view('templates/footer');
	}

	public function projectDocument()
    {
		$uri = $this->request->uri;
		$id = $uri->getSegment(3);

        $data = [];
	
		$data['addBtn'] = True;
		$data['addUrl'] = "/documents/add";

		$model = new DocumentModel();
		$documents = $model->where('project-id',$id)->orderBy('update-date', 'desc')->findAll();	
		for($i=0; $i<count($documents);$i++){
			$documents[$i]['json-object'] = json_decode($documents[$i]['json-object'], true);
		}

		$data['data'] = $documents;
		$data['projects'] = $this->getProjects();
		
		$data['pageTitle'] = $data['projects'][$id].' Documents';
		echo view('templates/header');
		echo view('templates/pageTitle', $data);
		echo view('ProjectDocuments/list',$data);
		echo view('templates/footer');
	}

	private function getExistingDocs($type = "", $status = "", $project_id = ""){
		$model = new DocumentModel();
		$documents= $model->getProjects($type, $status, $project_id);
		for($i=0; $i<count($documents);$i++){
			$documents[$i]['json-object'] = json_decode($documents[$i]['json-object'], true);
		}
		return $documents;
	}
	
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

	private function getTablesData($tableName){
		if($tableName == 'teams'){
			$teamModel = new TeamModel();
			$data = $teamModel->orderBy('name', 'asc')->findAll();	
			return $data;
		}else if($tableName == 'reviews'){
			$reviewModel = new ReviewModel();
			$data = $reviewModel->getMappedRecords();
			return $data;
		}else if($tableName == 'documentMaster'){
			$references = new DocumentsMasterModel();
			$data = $references->findAll();	
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
			$documents = new DocumentModel();
			$data = $documents->getProjects();	
			return $data;
		}else if($tableName == 'riskAssessment'){
			$riskAssessment = new RiskAssessmentModel();
			$data = $riskAssessment->getRisksForDocuments();	
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
    
    public function getProjects(){
        $projectModel = new ProjectModel();
        $data = $projectModel->findAll();	
		$projects = [];
		foreach($data as $project){
			$projects[$project['project-id']] = $project['name'];
		}
		return $projects;
	}

	public function getTemplates($type){
        $templateModel = new DocumentTemplateModel();
		$data = $templateModel->where('type', $type)->first();	
		return $data;
	}
	
	private function returnParams(){
		$uri = $this->request->uri;
		$id = "";
		$type = "";
		$total = $uri->getTotalSegments();

		if ($total >= 3)
		{
			$type = $uri->getSegment(3);
		}

		if ($total >= 4)
		{
			$id = $uri->getSegment(4);
		}
		
		return [$type, $id];
	}
	
	public function add(){
		//Temporary fix to ensure security
		//Need to clean up this code ASAP
		if(session()->get('id') == ""){
			return redirect()->to('/'); 
		}

		$model = new DocumentModel();
		$params = $this->returnParams();
		$type = $params[0];
		$id = $params[1];

		helper(['form']);
		
		$data = [];
		$data['pageTitle'] = 'Documents';
		$data['addBtn'] = False;
		$data['backUrl'] = "/documents";
		$settingsModel = new SettingsModel();
		$documentStatus = $settingsModel->where("identifier","documentStatus")->first();
		if($documentStatus["options"] != null){
			$data["documentStatus"] = json_decode( $documentStatus["options"], true );
		 }else{
			$data["documentStatus"] = [];
		 }
		// $data['planStatus'] = ['Draft', 'Approved', 'Rejected'];
		$data['projects'] = $this->getProjects();
		$data['template'] = "";
		$data['type'] = $type;

		$templateModel = new DocumentTemplateModel();
		$existingTypes = $templateModel->getTypes();
		$data['documentType'] = $existingTypes;
		// $data['reviewCategoryList'] = ["User Needs", "Plan", "Requirements", "Design",
		//  "Code", "Verification", "Validation", "Release", "Risk Management", "Traceability"];

		 
		 $reviewCategory = $settingsModel->where("identifier","reviewCategory")->first();
		 if($reviewCategory["options"] != null){
			 $reviewCategoryOptions = json_decode( $reviewCategory["options"], true );
			 $data["reviewCategory"] = $reviewCategoryOptions;
		 }else{
		 	$data["reviewCategory"] = [];
		 }

		if($type != ""){
			$templates = $this->getTemplates($type);
			$data['jsonTemplate'] = $templates['template-json-object'];
			$decodedJson = json_decode($templates['template-json-object'], true);
			
			$sections = $decodedJson[$type]["sections"];
			$data["sections"] = $sections;
			$data['projectDocument']["type"] = $type;
			if($id == ""){
				$data['existingDocs'] = $this->getExistingDocs($type);
			}else{
				$data['existingDocs'] = [];
			}
			foreach ($sections as $section){
				if(array_key_exists('type', $section)){
					if($section['type'] == 'database'){
						if(!array_key_exists($section['tableName'] , $data)){
							// $data[$section['tableName']] = $this->getTablesData($section['tableName']);
							$data["lookUpTables"][$section['tableName']] = $this->getTablesData($section['tableName']);
						}
					}
				}
			}
		}else{
			$data['projectDocument']["type"] = null;
			$data['type'] = null;
		}

		//Filling for authors
		if(!isset($data['teams'])){
			$data['teams'] = $this->getTablesData('teams');
		}

		if($id == ""){
			if($type == ""){
				$data['action'] = "add";
			}else{
				$data['action'] = "add/".$type;
			}
			$data['formTitle'] = "Add Document";
		}else{
			$data['action'] = "add/".$type."/".$id;

			$data['projectDocument'] = $model->where('id',$id)->first();	
			$data['jsonTemplate'] = $data['projectDocument']['json-object'];	
			$decodedJson = json_decode($data['jsonTemplate'], true);
			$data['formTitle'] = 	$data['projectDocument']['file-name'];		
			$sections = $decodedJson[$type]["sections"];
			$data["sections"] = $sections;

			$reviewId = $data['projectDocument']['review-id'];
			if($reviewId != null){
				$reviewModel = new ReviewModel();
				$data["documentReview"] = $reviewModel->find($reviewId);
			}
		}

		if ($this->request->getMethod() == 'post') {
			
			$rules = [
				'type' => 'required',
				'project-id' => 'required',
				'cp-line3' => 'required|max_length[60]',
				'status' => 'required',
				'reviewer-id' => 'required'
			];	

			$errors = [
				'cp-line3' => [
					'required' => 'Title is required.',
					'max_length' => 'Title should not be more than 60 characters',
				],
				'reviewer-id' => [
					'required' => 'Reviewer is required.'
				]
			];

			$data['type'] = $this->request->getVar('type');
			$title =  $this->request->getVar('cp-line3');
			$title =  str_replace(' ', '', $title);
			$title =  str_replace(',', '_', $title);
			$currentTime = gmdate("Y-m-d H:i:s");

			$jsonObject = $this->request->getVar('json-object');
			$decodedJson = json_decode($jsonObject, true);
			$sections = $decodedJson[$type]["sections"];
			foreach($sections as $key=>$section){
				if(isset($section["type"])){
					if($section["type"] == "differential"){
						$sectionValue = $this->request->getVar($section["id"]);
						$sections[$key]["content"] = $sectionValue;
					}
				}

				
			}
			$decodedJson[$type]["sections"] = $sections;
			$jsonObject = json_encode($decodedJson);
			
			$newData = [
				'project-id' => $this->request->getVar('project-id'),
				'type' => $this->request->getVar('type'),
				'author-id' => session()->get('id'),
				'reviewer-id' => $this->request->getVar('reviewer-id'),
                'file-name' => $title,
				'status' => $this->request->getVar('status'),
				'update-date' => $currentTime,
				'json-object' => $jsonObject,
			];

			$data['jsonTemplate'] = $jsonObject;
			$data["sections"] = $sections;
			$data['projectDocument'] = $newData;

			if (! $this->validate($rules, $errors)) {
				$session = session();
				$data['validation'] = $this->validator;
			}else{
				
				if($id > 0){
					$newData['id'] = $id;
					$message = 'Plan successfully updated.';
				}else{
					$documentCategory = $decodedJson[$type]["template-category"];
					$newData['category'] = $documentCategory;
					$message = 'Plan successfully added.';
				}
				
				$model->save($newData);
				$session = session();
				$session->setFlashdata('success', $message);
			}
		
		}

		echo view('templates/header');
		echo view('templates/pageTitle', $data);
		echo view('ProjectDocuments/form', $data);
		echo view('templates/footer');

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