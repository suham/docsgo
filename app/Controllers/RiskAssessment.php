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
		// $this->load->helper('date');
		$data = [];



		// $data = $this->setQueryData(3);
		$data = $this->setQueryData(3);
		$data['pageTitle'] = 'Risk Assessment List';
		$data['addBtn'] = false;
		$data['backUrl'] = false;
		$data['checkedVals'] = array('RDanchor1' => 0, "RDanchor2"=> 0, "RDanchor3"=> 1);

		// echo date('Y-m-d H:i:s');

		echo view('templates/header');
		echo view('templates/pageTitle', $data);
		echo view('RiskAssessment/list',$data);
		echo view('templates/footer');

	}

	public function setQueryData($type) {
		if($type == 1)
			$statusAt = 'All';
		if($type == 2)
			$statusAt = 'Open';
		if($type == 3)
			$statusAt = 'Close';

		$data['issues'] = [];
		$data['cybersecurity'] = [];
		$data['soup'] = [];
		// helper(['form']);
		$data['statusOptions'] = $this->getStatusOprions();

		if($statusAt == 'All'){
			$model = new IssueModel();
			$data['issues'] = $model->select('a.id, a.issue,a.issue_description,a.status,b.risk_type, b.severity,b.occurrence,b.detectability,b.rpn,b.update_date')
			->from('docsgo-issues a')
			->join('docsgo-risk-assessment b', 'a.id = b.issue_id', 'left')
			->groupBy('a.id')
			->findAll();

			$model = new SoupModel();
			$data['soup'] = $model->select('a.id, a.soup,a.purpose,a.status,b.risk_type,b.severity,b.occurrence,b.detectability,b.rpn,b.update_date')
			->from('docsgo-soup a')
			->join('docsgo-risk-assessment b', 'a.id = b.soup_id', 'left')
			->groupBy('a.id')
			->findAll();

			$model = new CybersecurityModel();
			$data['cybersecurity'] = $model->select('a.id, a.reference,a.description,a.status,b.risk_type,b.severity,b.occurrence,b.detectability,b.rpn,b.update_date')
			->from('docsgo-cybersecurity a')
			->join('docsgo-risk-assessment b', 'a.id = b.cybersecurity_id', 'left')
			->groupBy('a.id')
			->findAll();
		}else{
			$model = new IssueModel();
			$data['issues'] = $model->select('a.id, a.issue,a.issue_description,a.status,b.risk_type, b.severity,b.occurrence,b.detectability,b.rpn,b.update_date')
			->from('docsgo-issues a')
			->where('a.status',$statusAt)
			->join('docsgo-risk-assessment b', 'a.id = b.issue_id', 'left')
			->groupBy('a.id')
			->findAll();

			$model = new SoupModel();
			$data['soup'] = $model->select('a.id, a.soup,a.purpose,a.status,b.risk_type,b.severity,b.occurrence,b.detectability,b.rpn,b.update_date')
			->from('docsgo-soup a')
			->where('a.status', $statusAt)
			->join('docsgo-risk-assessment b', 'a.id = b.soup_id', 'left')
			->groupBy('a.id')
			->findAll();

			$model = new CybersecurityModel();
			$data['cybersecurity'] = $model->select('a.id, a.reference,a.description,a.status,b.risk_type,b.severity,b.occurrence,b.detectability,b.rpn,b.update_date')
			->from('docsgo-cybersecurity a')
			->where('a.status',$statusAt)
			->join('docsgo-risk-assessment b', 'a.id = b.cybersecurity_id', 'left')
			->groupBy('a.id')
			->findAll();
		}
		return $data;
	}

	private function returnParams($param){
		$uri = $this->request->uri;
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

	public function add(){

		$id = $this->returnParams('id');
		$type = $this->returnParams('type');

		helper(['form']);
		$model = new RiskAssessmentModel();
		$data = [];
		$data['pageTitle'] = 'Risk Assessment List';
		$data['addBtn'] = False;
		$data['backUrl'] = "/risk-assessment";
		$dataList = [];
		$data['riskAssessmentStatus'] = ['open-issue', 'soup', 'cybersecurity'];

		$issue_id = ''; $cybersecurity_id =''; $soup_id ='';
		switch ($type) {
			case 1:
				$issue_id = $id;
				$data['member'] = $model->where('issue_id',$id)->first();	
				$risk_type = 'open-issue';
				$list =[];
				$model1 = new IssueModel();
				$list = $model1->where('id',$id)->first();
				$data['member']['risk_type'] = 'open-issue';
				$data['member']['issue'] = $list['issue'];
				$data['member']['description'] = $list['issue_description'];
				break;
			case 2:
				$cybersecurity_id = $id;
				$data['member'] = $model->where('cybersecurity_id',$id)->first();	
				$risk_type = 'cybersecurity';	
				$list =[];
				$model1 = new CybersecurityModel();
				$list = $model1->where('id',$id)->first();
				$data['member']['risk_type'] = 'cybersecurity';
				$data['member']['issue'] = $list['reference'];
				$data['member']['description'] = $list['description'];
				break;
			case 3:
				$soup_id = $id;
				$data['member'] = $model->where('soup_id',$id)->first();
				$risk_type = 'soup';	
				$list =[];
				$model1 = new SoupModel();
				$list = $model1->where('id',$id)->first();
				$data['member']['risk_type'] = 'soup';
				$data['member']['issue'] = $list['soup'];
				$data['member']['description'] = $list['purpose'];
				break;
		}
		$retriveData = [];
		$retriveData['issue'] = $data['member']['issue'];
		$retriveData['description'] = $data['member']['description'];

		if($id == ""){
			$data['action'] = "add";
			$data['formTitle'] = "Risk Assessment";

			$rules = [
				'severity' => 'required',
				'occurrence' => 'required',
				'detectability' => 'required',
				'rpn' => 'required',
			];

		}else{
			$data['action'] = "add/".$type."/".$id;
			$data['formTitle'] = "Update";

			$rules = [
				'severity' => 'required',
				'occurrence' => 'required',
				'detectability' => 'required',
				'rpn' => 'required',
			];	
		}

		if ($this->request->getMethod() == 'post') {
			$newData = [
				'risk_type' => $risk_type,
				'severity' => $this->request->getVar('severity'),
				'occurrence' => $this->request->getVar('occurrence'),
				'detectability' => $this->request->getVar('detectability'),
				'rpn' => $this->request->getVar('rpn'),
				'issue_id' => $issue_id,
				'cybersecurity_id' => $cybersecurity_id,
				'soup_id' => $soup_id
			];
			//Setting the existing data to member, if id is already exist(means its update action) getting that id to pass for update query
			$data['member'] = $newData;
			$data['member']['issue'] = $retriveData['issue'];
			$data['member']['description'] = $retriveData['description'];
	

			if (! $this->validate($rules)) {
				$data['validation'] = $this->validator;
			}else{
				if($id > 0){
					$list = [];
					date_default_timezone_set('Asia/Kolkata');
					$timestamp = date("Y-m-d H:i:s");
					$newData['update_date'] = $timestamp;
			
					switch ($type) {
						case 1:
							$list = $model->where('issue_id',$id)->first();	
							if($list && count($list) > 0){
								if($list['id'] != 0){
									$newData['id'] = $list['id'];
								}
							}
							break;
						case 2:
							$list = $model->where('cybersecurity_id',$id)->first();	
							if($list && count($list) > 0 ){
								if($list['id'] != 0){
									$newData['id'] = $list['id'];
								}
							}
							break;
						case 3:
							$list = $model->where('soup_id',$id)->first();	
							if($list && count($list) > 0 ){
								if($list['id'] != 0){
									$newData['id'] = $list['id'];
								}
							}
							break;
					}
					$message = 'Risk Assessment successfully updated.';
				}else{
					$message = 'Risk Assessment successfully added.';
				}
				$model->save($newData);
				$session = session();
				$session->setFlashdata('success', $message);
			}
		}

		$data['statusOptions'] = $this->getStatusOprions();
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

	public function view() {
		$type = $this->returnParams('id');
		$id = $this->returnParams('type');
		$data = [];
		$data = $this->setQueryData($type);
		$data['pageTitle'] = 'Risk Assessment List';
		$data['addBtn'] = false;
		$data['backUrl'] = false;

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
		// $this->index();

		$data = [];
		$data['pageTitle'] = 'Risk Assessment List';
		$data['addBtn'] = false;
		$data['backUrl'] = false;


		$response = array('success' => "True");
		// echo json_encode( $response );



		// if (session()->get('is-admin')){
		// 	$id = $this->returnParams();
		// 	$model = new IssueModel();
		// 	$model->delete($id);
		// 	$response = array('success' => "True");
		// 	echo json_encode( $response );
		// }
		// else{
		// 	$response = array('success' => "False");
		// 	echo json_encode( $response );
		// }
	}


}