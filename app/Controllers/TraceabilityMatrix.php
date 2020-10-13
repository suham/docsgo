<?php namespace App\Controllers;

use App\Models\TraceabilityMatrixModel;
use App\Models\RequirementsModel;
use App\Models\TestCasesModel;

class TraceabilityMatrix extends BaseController
{
	public function index()
    {
		$data = [];
		$data['pageTitle'] = 'Traceability Matrix';
		$data['addBtn'] = True;
		$data['addUrl'] = "/traceability-matrix/add";

		$data1 = [];
		$model = new RequirementsModel();
		$data1 = $model->orderBy('type', 'asc')->findAll();	
		$data['CNCRList'] = $this->requirementsTypeData($data1,'CNCR', 0);
		$data['systemList'] = $this->requirementsTypeData($data1,'System', 0);
		$data['subSystemList'] = $this->requirementsTypeData($data1,'Subsystem', 0);
		$data['testCases'] = $this->getTestCases(0);
		$model = new TraceabilityMatrixModel();
		$data['data'] = $model->orderBy('id', 'asc')->findAll();	

		echo view('templates/header');
		echo view('templates/pageTitle', $data);
		echo view('TraceabilityMatrix/list',$data);
		echo view('templates/footer');
	}

	private function returnParams(){
		$uri = $this->request->uri;
		$id = $uri->getSegment(3);
		if($id != ""){
			$id = intval($id);
		}
		return $id;
	}


	public function add(){

		$id = $this->returnParams();

		helper(['form']);
		$model = new TraceabilityMatrixModel();
		$data = [];
		$data['pageTitle'] = 'Traceability Matrix';
		$data['addBtn'] = False;
		$data['backUrl'] = "/traceability-matrix";

		$rules = [
			'cncr' => 'required',
			'sysreq' => 'required',
			'subsysreq' => 'required',
			'design' => 'required|min_length[3]|max_length[64]',
			'code' => 'required|min_length[3]|max_length[64]',
			'testcase' => 'required'
		];

		if($id == ""){
			$data['action'] = "add";
			$data['formTitle'] = "Add Traceability Matrix";
		}else{
			$data['action'] = "add/".$id;
			$data['formTitle'] = "Update";
			$data['member'] = $model->where('id',$id)->first();	
			
			// if($data['member']['cncr']) {
			// 	$model = new RequirementsModel();
			// 	$data1 = $model->where('id', $data['member']['cncr'])->where('type', 'CNCR')->first();
			// 	// print_r ($data1);
			// 	if($data1 && count($data1) >= 0){
			// 	} else {
			// 		// print_r ("eleleleelle");
			// 		$data['member']['cncr'] = '';
			// 	}
			// }	
			// $data['member']['cncr'] = $model->where('id',$id)->first();	
			// $data['member']['sysreq'] = $model->where('id',$id)->first();	
			// $data['member']['subsysreq'] = $model->where('id',$id)->first();		
		}
		
		if ($this->request->getMethod() == 'post') {
			$currentTime = gmdate("Y-m-d H:i:s");
			$newData = [
				'cncr' => $this->request->getVar('cncr'),
				'sysreq' => $this->request->getVar('sysreq'),
				'subsysreq' => $this->request->getVar('subsysreq'),
				'design' => $this->request->getVar('design'),
				'code' => $this->request->getVar('code'),
				'testcase' => $this->request->getVar('testcase'),
				'update_date' => $currentTime,
			];

			$data['member'] = $newData;
			if (! $this->validate($rules)) {
				$data['validation'] = $this->validator;
			}else{
				if($id > 0){
					$newData['id'] = $id;
					// date_default_timezone_set('Asia/Kolkata');
					// $timestamp = date("Y-m-d H:i:s");
					// $newData['update_date'] = $timestamp;
					$message = 'Traceability Matrix successfully updated.';
				}else{
					$message = 'Traceability Matrix successfully added.';
				}

				$model->save($newData);
				$session = session();
				$session->setFlashdata('success', $message);
			}
		}

		$data1 = [];
		$model = new RequirementsModel();
		$data1 = $model->orderBy('type', 'asc')->findAll();	
		$data['CNCRList'] = $this->requirementsTypeData($data1,'CNCR', 0);
		$data['systemList'] = $this->requirementsTypeData($data1,'System', 0);
		$data['subSystemList'] = $this->requirementsTypeData($data1,'Subsystem', 0);
		$data['testCases'] = $this->getTestCases(0);

		echo view('templates/header');
		echo view('templates/pageTitle', $data);
		echo view('TraceabilityMatrix/form', $data);
		echo view('templates/footer');
	}

	private function getTestCases($id){
        $testCasesModel = new TestCasesModel();
        $data = $testCasesModel->findAll();	
		$testcases = [];
		foreach($data as $key=>$list){
			$id_desc = $list['id'].'_desc';
			$testcases[$list['id']] = $list['testcase'];
			if($id != 0 ){
				$testcases[$id_desc] = $list['description'];			
			}
		}
		if($id !=0) {
			$idDesc = $id.'_desc';
			return $testcases[$idDesc];
		}else {
			return $testcases;
		}
	}

	public function requirementsTypeData($params, $type, $id) {
		$sysData = [];
		foreach ($params as $key=>$list){
			if($type == $list['type']){
				$id_desc = $list['id'].'_desc';
				$sysData[$list['id']] = $list['requirement'];
				if($id != 0)
					$sysData[$id_desc] = $list['description'];
			}
		}
		if($id !=0) {
			$idDesc = $id.'_desc';
			return $sysData[$idDesc];
		}else {
			return $sysData;
		}
	}

	public function delete(){
		if (session()->get('is-admin')){
			$id = $this->returnParams();
			$model = new TraceabilityMatrixModel();
			$model->delete($id);
			$response = array('success' => "True");
			echo json_encode( $response );
		}
		else{
			$response = array('success' => "False");
			echo json_encode( $response );
		}
	}

	private function returnParamsAjax(){
		$uri = $this->request->uri;
		$id = $uri->getSegment(3);
		$type = $uri->getSegment(4);
		return [$id, $type];
	}


	public function getIDDescription(){
		if (session()->get('is-admin')){	
			$params = $this->returnParamsAjax();
			$id = $params[0];
			$typeNO = $params[1];
			switch($typeNO) {
				case 1 :
					$type='CNCR';
					break;
				case 2 :
					$type='System';
					break;
				case 3 :
					$type='Subsystem';
					break;
			}
			$data1 = [];
			$model = new RequirementsModel();
			$data1 = $model->orderBy('type', 'asc')->findAll();	
			$dataDescription = $this->requirementsTypeData($data1, $type, $id);
	
			$response = array('success' => "True", 'description'=>$dataDescription);
			echo json_encode( $response );
		}
		else{
			$response = array('success' => "False");
			echo json_encode( $response );
		}
	}
	
	public function getTestCaseDescription(){
		if (session()->get('is-admin')){	
			$id = $this->returnParams();
			$dataDescription = $this->getTestCases($id);
	
			$response = array('success' => "True", 'description'=>$dataDescription);
			echo json_encode( $response );
		}
		else{
			$response = array('success' => "False");
			echo json_encode( $response );
		}
	}
}