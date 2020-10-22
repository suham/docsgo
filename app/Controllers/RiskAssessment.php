<?php namespace App\Controllers;

use App\Models\ProjectModel;
use App\Models\TeamModel;
use App\Models\RiskAssessmentModel;
use App\Models\StatusOptionsModel;
use CodeIgniter\I18n\Time;
class RiskAssessment extends BaseController
{
	public function index()
    {
		$data = [];

		$data['pageTitle'] = 'Risk Assessment';
		$data['addBtn'] = true;
		$data['addUrl'] = "/risk-assessment/add";
		$data['backUrl'] = '/risk-assessment';

		$status = $this->request->getVar('status');

		$model = new RiskAssessmentModel();
		$data["data"] = $model->getRisks($status);

		echo view('templates/header');
		echo view('templates/pageTitle', $data);
		echo view('RiskAssessment/list',$data);
		echo view('templates/footer');
	}


	 function add(){
		$id = $this->request->getVar('id');
		//handling the backUrl view, Which is selected previously 
		$backUrl = '/risk-assessment';
		if(isset($_SERVER['HTTP_REFERER'])){
			$urlStr = $_SERVER['HTTP_REFERER'];
			if (strpos($urlStr, 'status')) {
				$urlAr = explode("=", $urlStr);
				$backUrl = '/risk-assessment?status='.$urlAr[count($urlAr)-1];
			}
		}
		helper(['form']);
		$model = new RiskAssessmentModel();
		$data = [];
		$data['pageTitle'] = 'Risk Assessment';
		$data['addBtn'] = False;
		$data['backUrl'] = $backUrl;
		$dataList = [];
		$data['riskCategory'] = ['Issue', 'Observation','Security','SOUP'];
		$data['riskStatus'] = ['Open', 'Close'];
		$data['projects'] = $this->getProjects();

		$rules = [
			'project'=> 'required',
			'category'=> 'required',
			'name' => 'required|min_length[3]|max_length[64]',
			'description' => 'min_length[3]|max_length[500]',
			'information' => 'required|min_length[3]|max_length[20]',
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
			$data['action'] = "add?id=".$id;
			$data['member'] = $model->where('id',$id)->first();		
			$data['formTitle'] = $data['member']["name"];
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
	

	private function getProjects(){
        $projectModel = new ProjectModel();
        $data = $projectModel->findAll();	
		$projects = [];
		foreach($data as $project){
			$projects[$project['project-id']] = $project['name'];
		}
		return $projects;
	}

	public function delete(){
		if (session()->get('is-admin')){
			$id = $this->request->getVar('id');
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