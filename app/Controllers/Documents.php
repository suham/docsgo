<?php namespace App\Controllers;

use App\Models\DocumentModel;
use App\Models\ProjectModel;
use App\Models\TeamModel;
use App\Models\DocumentTemplateModel;

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
		$data['templates'] = $this->getTemplates();

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
		$data['templates'] = $this->getTemplates();
		
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
		$data = $model->findAll();	
		$documents = [];
		foreach($data as $document){
			$documents[$document['id']] = $document['json-object'];
		}
		return json_encode($documents);
	}

    public function getTeamMembers(){
		$teamModel = new TeamModel();
		$data = $teamModel->findAll();	
		$team = [];
		foreach($data as $member){
			$team[$member['id']] = $member['name'];
		}
		return $team;
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

	public function getTemplates(){
        $templateModel = new DocumentTemplateModel();
        $data = $templateModel->findAll();	
		$templates = [];
		foreach($data as $project){
			$templates[$project['type']] = $project;
		}
		return $templates;
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
	
	public function updateTemplate() {
		if ($this->request->getMethod() == 'post') {
			
			
			$type = $this->request->getVar('type');
			$templates = $this->getTemplates();
			if (array_key_exists($type,$templates)){
				$entireTemplate = $templates[$type];
				$template = json_decode($templates[$type]['template-json-object'], true);
				$template[$type]['cp-line3'] = $this->request->getVar('cp-line3');
				$template[$type]['cp-line4'] = $this->request->getVar('cp-line4');
				$template[$type]['cp-line5'] = $this->request->getVar('cp-line5');
				$template[$type]['cp-approval-matrix'] = $this->request->getVar('cp-approval-matrix');
				$template[$type]['cp-change-history'] = $this->request->getVar('cp-change-history');

				$sections = array();

				foreach ($template[$type]['sections'] as $section){
					$temp["id"] = $section["id"];
					$temp["title"] = $section["title"];
					$temp["content"] = $this->request->getVar($section["id"]);

					array_push($sections, $temp);
				}
				$template[$type]['sections'] = $sections;
				$entireTemplate['template-json-object'] = json_encode($template);
				$templateModel = new DocumentTemplateModel();
				$templateModel->save($entireTemplate);
				$response = array('success' => "True");

			}else{
				$response = array('success' => "False");
			}
			echo json_encode( $response );
		}
		
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
		$data['documentType'] = array("project-plan"=>"Project Plan", "reviews"=>"Reviews", "test-plan"=> "Test Plan", "impact-analysis"=>"Impact Analysis" );
		$data['projects'] = $this->getProjects();
		$data['template'] = "";
		$data['type'] = $type;

		if($type != ""){
			$templates = $this->getTemplates();
			if (array_key_exists($type,$templates)){
				$template = json_decode($templates[$type]['template-json-object'], true);
				$data['template'] = $template[$type];
				$data['sections'] = $template[$type]['sections'];
				$data['projectDocument']["type"] = $type;
				$data['existingDocs'] = $this->getExistingDocs($type);
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
			$template = json_decode($data['projectDocument']["json-object"], true);		
			$data['template'] = $template[$type];
			$data['sections'] = $template[$type]['sections'];
		}

		if ($this->request->getMethod() == 'post') {
			
			$rules = [
				'type' => 'required',
				'project-id' => 'required',
                'status' => 'required',
			];	

			$data['type'] = $this->request->getVar('type');

			$newData = [
				'project-id' => $this->request->getVar('project-id'),
				'type' => $this->request->getVar('type'),
                'file-name' => $this->request->getVar('file-name'),
                'status' => $this->request->getVar('status'),
			];

			$template[$type]['cp-line3'] = $this->request->getVar('cp-line3');
			$template[$type]['cp-line4'] = $this->request->getVar('cp-line4');
			$template[$type]['cp-line5'] = $this->request->getVar('cp-line5');
			$template[$type]['cp-approval-matrix'] = $this->request->getVar('cp-approval-matrix');
			$template[$type]['cp-change-history'] = $this->request->getVar('cp-change-history');

			$sections = array();

			foreach ($data['sections'] as $section){
				$temp["id"] = $section["id"];
				$temp["title"] = $section["title"];
				$temp["content"] = $this->request->getVar($section["id"]);

				array_push($sections, $temp);
			}

			$template[$type]['sections'] = $sections;
			$data['template'] = $template[$type];
			$data['sections'] = $sections;
			$data['projectDocument'] = $newData;

			if (! $this->validate($rules)) {
				$session = session();
				$data['validation'] = $this->validator;
			}else{
				
				$newData['json-object'] = json_encode($template);

				if($id > 0){
					$newData['id'] = $id;
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