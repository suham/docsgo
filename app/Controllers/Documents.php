<?php namespace App\Controllers;

use App\Models\DocumentModel;
use App\Models\ProjectModel;
use App\Models\TeamModel;
use App\Models\DocumentTemplateModel;
use App\Models\ReviewModel;
use App\Models\DocumentsMasterModel;

class Documents extends BaseController
{
    public function index()
    {
        $data = [];
		$data['pageTitle'] = 'Documents';
		$data['addBtn'] = True;
		$data['addUrl'] = "/documents/add";

		$data['data'] = $this->getExistingDocs();
		$data['projects'] = $this->getProjects();
		// $data['templates'] = $this->getTemplates();

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
		// $data['templates'] = $this->getTemplates();
		
		$data['pageTitle'] = $data['projects'][$id].' Documents';
		echo view('templates/header');
		echo view('templates/pageTitle', $data);
		echo view('ProjectDocuments/list',$data);
		echo view('templates/footer');
	}

	private function getExistingDocs($type = ""){
		$model = new DocumentModel();
		if($type == ""){
			$documents= $model->orderBy('update-date', 'desc')->findAll();	
		}else{
			$documents= $model->where('type',$type)->orderBy('update-date', 'desc')->findAll();	
		}
		
		for($i=0; $i<count($documents);$i++){
			$documents[$i]['json-object'] = json_decode($documents[$i]['json-object'], true);
		}
		return $documents;
	}
	
	public function getJson(){
		$model = new DocumentModel();
		$data = $model->where('status',"Approved")->findAll();	
		$documents = [];
		foreach($data as $document){
			$documents[$document['id']] = $document['json-object'];
		}
		return json_encode($documents);
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
		}else{
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
		$model = new DocumentModel();
		$params = $this->returnParams();
		$type = $params[0];
		$id = $params[1];

		helper(['form']);
		
		$data = [];
		$data['pageTitle'] = 'Documents';
		$data['addBtn'] = False;
		$data['backUrl'] = "/documents";
		$data['planStatus'] = ['Draft', 'Approved', 'Rejected'];
		$data['projects'] = $this->getProjects();
		$data['template'] = "";
		$data['type'] = $type;

		$templateModel = new DocumentTemplateModel();
		$existingTypes = $templateModel->getTypes();
		$data['documentType'] = $existingTypes;

		if($type != ""){
			$templates = $this->getTemplates($type);
			$data['jsonTemplate'] = $templates['template-json-object'];
			$decodedJson = json_decode($templates['template-json-object'], true);
			
			$sections = $decodedJson[$type]["sections"];
			$data["sections"] = $sections;
			$data['projectDocument']["type"] = $type;
			$data['existingDocs'] = $this->getExistingDocs($type);
			foreach ($sections as $section){
				if(array_key_exists('type', $section)){
					if($section['type'] == 'database'){
						if(!array_key_exists($section['tableName'] , $data)){
							$data[$section['tableName']] = $this->getTablesData($section['tableName']);
						}
					}
				}
			}
		}else{
			$data['projectDocument']["type"] = null;
			$data['type'] = null;
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
			$data['formTitle'] = "Update";

			$data['projectDocument'] = $model->where('id',$id)->first();	
			$data['jsonTemplate'] = $data['projectDocument']['json-object'];	
			$decodedJson = json_decode($data['jsonTemplate'], true);
			
			$sections = $decodedJson[$type]["sections"];
			$data["sections"] = $sections;
		}

		if ($this->request->getMethod() == 'post') {
			
			$rules = [
				'type' => 'required',
				'project-id' => 'required',
				'author' =>'required|min_length[3]|max_length[20]',
                'status' => 'required',
			];	

			$data['type'] = $this->request->getVar('type');

			$newData = [
				'project-id' => $this->request->getVar('project-id'),
				'type' => $this->request->getVar('type'),
				'author' => $this->request->getVar('author'),
                'file-name' => $this->request->getVar('file-name'),
				'status' => $this->request->getVar('status'),
				'json-object' => $this->request->getVar('json-object')
			];
			$data['jsonTemplate'] = $this->request->getVar('json-object');
			$decodedJson = json_decode($data['jsonTemplate'], true);
			
			$sections = $decodedJson[$type]["sections"];
			$data["sections"] = $sections;
			$data['projectDocument'] = $newData;

			if (! $this->validate($rules)) {
				$session = session();
				$data['validation'] = $this->validator;
			}else{
				
				if($id > 0){
					$newData['id'] = $id;
					date_default_timezone_set('Asia/Kolkata');
					$timestamp = date("Y-m-d H:i:s");
					$newData['update-date'] = $timestamp;
					$message = 'Plan successfully updated.';
				}else{
					$message = 'Plan successfully added.';
				}
				
				$model->save($newData);
				$session = session();
				$session->setFlashdata('success', 'Plan successfully added.');
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