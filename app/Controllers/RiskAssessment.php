<?php namespace App\Controllers;

use App\Models\ProjectModel;
use App\Models\TeamModel;
use App\Models\IssueModel;
use App\Models\SoupModel;
use App\Models\CybersecurityModel;
use App\Models\RiskAssessmentModel;
use App\Models\StatusOptionsModel;
use CodeIgniter\I18n\Time;
class RiskAssessment extends BaseController
{
	public function index()
    {
		$data = [];

		$data = $this->setQueryData(2);
		$data['pageTitle'] = 'Risk Assessment';
		$data['addBtn'] = true;
		$data['addUrl'] = "/risk-assessment/add";
		$data['backUrl'] = '/risk-assessment';
		$data['checkedVals'] = array('RDanchor1' => 0, "RDanchor2"=> 1, "RDanchor3"=> 0);

		echo view('templates/header');
		echo view('templates/pageTitle', $data);
		echo view('RiskAssessment/list',$data);
		echo view('templates/footer');
	}

	public function setQueryData($type) {
		$statusAt = "";
		switch ($type) {
			case 1:
					$statusAt = trim("All");
					break;
			case 2:
					$statusAt = trim("Open");
					break;
			case 3:
					$statusAt = trim("Close");
					break;
		}

		$statusAt = trim($statusAt);
		$statusAt = trim($statusAt, ' ');
		$statusAt =  str_replace(' ', '', $statusAt);
		$statusAt =  str_replace('  ','', $statusAt);

		$data['occurrenceListOptions'] = array( 5=> 'Very High', 4 => 'High', 3 => 'Moderate', 2 => 'Low', 1 => 'Rare');
		$data['severityListOptions'] = array( 5=> 'Very High', 4 => 'High', 3 => 'Moderate', 2 => 'Low', 1 => 'Minor/Minimal');
		$data['detectabilityListOptions'] = array( 5=> 'Almost Certain', 4 => 'High', 3 => 'Moderate', 2 => 'Very Low', 1 => 'Impossible');

		$model = new RiskAssessmentModel();
		if($statusAt == 'All') {
			$data['data'] = $model->orderBy('id', 'desc')->findAll();	
		}else{
			$data['data'] = $model->where('status', $statusAt)->orderBy('id', 'desc')->findAll();	
		}
		return $data;
	}

	private function returnParams($param){
		$uri = $this->request->uri;
		if(count($uri->getSegments()) <= 2){
			$uri = $this->request->uri;
			$id = $uri->getSegment(3);
			if($id != ""){
				$id = intval($id);
			}
			return $id;
		}else{
			$type = $uri->getSegment(3);
			$id = $uri->getSegment(4);
			if($id != ""){
				$id = intval($id);
			}
			if($param == 'id'){
				return $id;
			}
			if($param == 'type'){
				return $type;
			}
		}
	}

	private function returnParams1(){
		$uri = $this->request->uri;
		$id = $uri->getSegment(3);
		if($id != ""){
			$id = intval($id);
		}
		return $id;
	}

	public function add(){
		if(count($this->request->uri->getSegments()) <= 2){
			$id = $this->returnParams1();
		}else{
			$id = $this->returnParams('id');
			$type = $this->returnParams('type');
		}
		helper(['form']);
		$model = new RiskAssessmentModel();
		$data = [];
		$data['pageTitle'] = 'Risk Assessment';
		$data['addBtn'] = False;
		$data['backUrl'] = "/risk-assessment";
		$dataList = [];
		$data['riskCategory'] = ['Issue', 'Observation','Security','SOUP'];
		$data['riskStatus'] = ['Open', 'Close'];
		$data['projects'] = $this->getProjects();

		$rules = [
			'project'=> 'required',
			'category'=> 'required',
			'name' => 'required|min_length[3]|max_length[64]',
			'description' => 'min_length[3]|max_length[500]',
			'information' => 'required|min_length[5]|max_length[20]',
			'severity' => 'required',
			'occurrence' => 'required',
			'detectability' => 'required',
			'rpn' => 'required',
			'status' => 'required',
		];	

		if($id == ""){
			$data['action'] = "add";
			$data['formTitle'] = "Add Risk Assessment";
			$data['member']['status'] = 'Open';

		}else{
			$data['action'] = "add/".$type."/".$id;
			$data['formTitle'] = "Update Risk Assessment";//.$risk_type;
			$data['member'] = $model->where('id',$id)->first();		
		}

		if ($this->request->getMethod() == 'post') {
			$newData = [
				'project_id' => $this->request->getVar('project'),
				'category' => $this->request->getVar('category'),
				'name' => $this->request->getVar('name'),
				'description' => $this->request->getVar('description'),
				'information' => $this->request->getVar('information'),
				'severity' => $this->request->getVar('severity'),
				'occurrence' => $this->request->getVar('occurrence'),
				'detectability' => $this->request->getVar('detectability'),
				'rpn' => $this->request->getVar('rpn'),
				'status' => $this->request->getVar('status')
			];
			//Setting the existing data to member, if id is already exist(means its update action) getting that id to pass for update query
			$data['member'] = $newData;
	
			if (! $this->validate($rules)) {
				$data['validation'] = $this->validator;
			}else{
				if($id > 0){
					$list = [];
					$currentTime = gmdate("Y-m-d H:i:s");
					$newData['id'] = $id;
					$newData['update_date'] = $currentTime;
					$message = 'Risk Assessment successfully updated.';
				}else{
					$message = 'Risk Assessment successfully added.';
				}
				$model->save($newData);
				$session = session();
				$session->setFlashdata('success', $message);
			}
		}

		$data['occurrenceListOptions'] = array( 5=> 'Very High', 4 => 'High', 3 => 'Moderate', 2 => 'Low', 1 => 'Rare');
		$data['severityListOptions'] = array( 5=> 'Very High', 4 => 'High', 3 => 'Moderate', 2 => 'Low', 1 => 'Minor/Minimal');
		$data['detectabilityListOptions'] = array( 5=> 'Almost Certain', 4 => 'High', 3 => 'Moderate', 2 => 'Very Low', 1 => 'Impossible');

		echo view('templates/header');
		echo view('templates/pageTitle', $data);
		echo view('RiskAssessment/form', $data);
		echo view('templates/footer');
	}
	
	private function getStatusOprions(){
        $projectModel = new StatusOptionsModel();
        $data = $projectModel->findAll();	
		$optionList = [];
		foreach($data as $option){
			$optionList[$option['value']] = $option['name'];
		}
		return $optionList;
	}

	private function getProjects(){
        $projectModel = new ProjectModel();
        $data = $projectModel->findAll();	
		$projects = [];
		foreach($data as $project){
			$projects[$project['project-id']] = $project['name'];
		}
		return $projects;
	}


	public function view() {
		$type = $this->returnParams('id');
		$id = $this->returnParams('type');
		$data = [];
		$data = $this->setQueryData($type);
		$data['pageTitle'] = 'Risk Assessment';
		$data['addBtn'] = true;
		$data['addUrl'] = "/risk-assessment/add";
		$data['backUrl'] = '/risk-assessment';


		if($type == 1){
			$data['checkedVals'] = array('RDanchor1' => 1, "RDanchor2"=> 0, "RDanchor3"=> 0);
		}
		if($type == 2){
			$data['checkedVals'] = array('RDanchor1' => 0, "RDanchor2"=> 1, "RDanchor3"=> 0);
		}
		if($type == 3){
			$data['checkedVals'] = array('RDanchor1' => 0, "RDanchor2"=> 0, "RDanchor3"=> 1);
		}
		echo view('templates/header');
		echo view('templates/pageTitle', $data);
		echo view('RiskAssessment/list',$data);
		echo view('templates/footer');

	}

	public function delete(){
		if (session()->get('is-admin')){
			$id = $this->returnParams1();
			$model = new RiskAssessmentModel();
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