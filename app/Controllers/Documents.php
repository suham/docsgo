<?php namespace App\Controllers;

use App\Models\DocumentModel;
use App\Models\ProjectModel;
use App\Models\TeamModel;
use App\Models\DocumentTemplate;

class Documents extends BaseController
{
    public function index()
    {
        $data = [];
		$data['pageTitle'] = 'Documents';
		$data['addBtn'] = True;
		$data['addUrl'] = "/documents/add";

		$model = new DocumentModel();
		$data['data'] = $model->findAll();	
		$data['projects'] = $this->getProjects();

		echo view('templates/header');
		echo view('templates/pageTitle', $data);
		echo view('ProjectDocuments/list',$data);
		echo view('templates/footer');
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
        $templateModel = new DocumentTemplate();
        $data = $templateModel->findAll();	
		$templates = [];
		foreach($data as $project){
			// $templates[$project['type']] = $project['template-json-object'];
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
				$templateModel = new DocumentTemplate();
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
				'file-name' => 'required',
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
		$uri = $this->request->uri;
		$id = $uri->getSegment(3);

		$model = new DocumentModel();
		$model->delete($id);
		$response = array('success' => "True");
		echo json_encode( $response );
	}


}