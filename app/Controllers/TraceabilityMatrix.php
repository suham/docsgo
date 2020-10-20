<?php namespace App\Controllers;

use App\Models\TraceabilityMatrixModel;
use App\Models\RequirementsModel;
use App\Models\TestCasesModel;
use App\Models\TraceabilityOptionsModel;

class TraceabilityMatrix extends BaseController
{
	public $mapData = array();
	public function index()
    {
		$data = [];
		$data['pageTitle'] = 'Traceability Matrix';
		$data['addBtn'] = True;
		$data['addUrl'] = "/traceability-matrix/add";
		
		$model = new TraceabilityMatrixModel();
		$data['data'] = $model->getTraceabilityData();

		
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
			'userNeeds' => 'required',
		];

		if($id == ""){
			$data['action'] = "add";
			$data['formTitle'] = "Add Traceability Matrix";
		}else{
			$data['action'] = "add/".$id;
			$data['formTitle'] = "Update Traceability Matrix";
			$data['member'] = $model->where('id',$id)->first();	
			
		}
		
		if ($this->request->getMethod() == 'post') {
			$currentTime = gmdate("Y-m-d H:i:s");
			$newData = [
				'design' => $this->request->getVar('design'),
				'code' => $this->request->getVar('code'),
				'update_date' => $currentTime,
			];
			//Get all selected User Needs/System/Subsystem value's ids
			$userNeedsList = []; $sysreqList = [];  $subsysreqList = []; $testcaseList = [];

			$userNeedsList = $this->request->getVar('userNeeds');
			$sysreqList = $this->request->getVar('sysreq');
			$subsysreqList = $this->request->getVar('subsysreq');
			$testcaseList = $this->request->getVar('testcase');
			
			$data['member'] = $newData;
			if (! $this->validate($rules)) {
				$data['validation'] = $this->validator;
				$session = session();
				$session->setFlashdata('success'. '');
			}else{
				if($id > 0){
					$newData['id'] = $id;
					$message = 'Traceability Matrix successfully updated.';
				}else{
					$message = 'Traceability Matrix successfully added.';
				}
				$model->save($newData);

				if($id > 0){
					$lastid = $id;
				} else {
					$lastid = $model->insertID();
				}

				//After saving/updating the traceability matrix, we need to store/update the selected all requirements(User Needs/System/Subsystem)
				$model = new TraceabilityOptionsModel();
				if(($userNeedsList)){
					$model->where('traceability_id', $lastid)->where('type', 'User Needs')->delete();
					$newData1 = [
						'traceability_id' => $lastid,
						'type' => 'User Needs',
						'requirement_id' => $this->request->getVar('userNeeds')
					];	
					$model->save($newData1);
				}
				$model->where('traceability_id', $lastid)->where('type', 'System')->delete();
				if(!empty($sysreqList) && count($sysreqList) > 0){
					foreach($sysreqList as $key=>$list){
						$newData1 = [
							'traceability_id' => $lastid,
							'type' => 'System',
							'requirement_id' => $list
						];	
						$model->save($newData1);
					}
				}
				$model->where('traceability_id', $lastid)->where('type', 'Subsystem')->delete();
				if(!empty($subsysreqList) && count($subsysreqList) > 0){
						foreach($subsysreqList as $key=>$list){
						$newData1 = [
							'traceability_id' => $lastid,
							'type' => 'Subsystem',
							'requirement_id' => $list
						];	
						$model->save($newData1);
					}
				}
				$model->where('traceability_id', $lastid)->where('type', 'testcase')->delete();
				if(!empty($testcaseList) && count($testcaseList) > 0){	
						foreach($testcaseList as $key=>$list){
						$newData1 = [
							'traceability_id' => $lastid,
							'type' => 'testcase',
							'requirement_id' => $list
						];	
						$model->save($newData1);
					}
				}		

				$session = session();
				$session->setFlashdata('success', $message);
			}
		}

		$data1 = [];
		$model = new RequirementsModel();
		$data1 = $model->orderBy('type', 'asc')->findAll();	
		$data['userNeedsList'] = $this->requirementsTypeData($data1,'User Needs', 0);
		$data['systemList'] = $this->requirementsTypeData($data1,'System', 0);
		$data['subSystemList'] = $this->requirementsTypeData($data1,'Subsystem', 0);
		$data['testCases'] = $this->getTestCases(0);

		$model = new TraceabilityOptionsModel();
		$dt= array(); $check = array('traceability_id' => $id, 'type' => 'User Needs');
		$keyData = $model->select('requirement_id')->where($check)->findAll();
		foreach($keyData as $key=>$list){
			array_push($dt,$list['requirement_id']);	
		}
		$data['userNeedsListKeys'] = $dt;

		$dt=[]; $check = array('traceability_id' => $id, 'type' => 'System');
		$keyData = $model->select('requirement_id')->where($check)->findAll();
		foreach($keyData as $key=>$list){
			array_push($dt,$list['requirement_id']);
		}
		$data['systemKeys'] = $dt;

		$dt=[]; $check = array('traceability_id' => $id, 'type' => 'Subsystem');
		$keyData = $model->select('requirement_id')->where($check)->findAll();
		foreach($keyData as $key=>$list){
			array_push($dt,$list['requirement_id']);
		}
		$data['subsystemKeys'] = $dt;

		$dt=[]; $check = array('traceability_id' => $id, 'type' => 'testcase');
		$keyData = $model->select('requirement_id')->where($check)->findAll();
		foreach($keyData as $key=>$list){
			array_push($dt,$list['requirement_id']);
		}
		$data['testcaseKeys'] = $dt;


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
			$model = new TraceabilityOptionsModel();
			$model->where('traceability_id', $id)->delete();
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
			$params = $this->returnParamsAjax();
			$id = $params[0];
			$typeNO = $params[1];
			switch($typeNO) {
				case 1 :
					$type='User Needs';
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
	
}