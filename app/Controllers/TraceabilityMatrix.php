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
		$data['data'] = $this->setQueryData(1);

		$data['pageTitle'] = 'Traceability Matrix';
		$data['addBtn'] = True;
		$data['addUrl'] = "/traceability-matrix/add";
		$data['listView'] = true;
		$data['gapView'] = false;

				// $data1 = [];
		// $model = new RequirementsModel();
		// $data1 = $model->orderBy('type', 'asc')->findAll();	

		// // $data = $this->setQueryData(2);
		// /*
		// Get tha all CNCR/User Needs List from the `RequirementsModel` table and stored into CNCRList
		// Get tha all system List from the `RequirementsModel` table and stored into systemList
		// Get tha all Subsystem List from the `RequirementsModel` table and stored into subSystemList
		// Passed params represented like $data1: all table data,type:enum values ,0: (either return name or description)
		// */
		// $data['CNCRList'] = $this->requirementsTypeData($data1,'User Needs', 0);
		// $data['systemList'] = $this->requirementsTypeData($data1,'System', 0);
		// $data['subSystemList'] = $this->requirementsTypeData($data1,'Subsystem', 0);
		// $data['testCases'] = $this->getTestCases(0);

		// $model = new TraceabilityOptionsModel();
		// $data['cncrKeys'] = $model->select('requirement_id')->where('traceability_id', $id)->where('type', 'User Needs')->findAll();
		// $data['systemKeys'] = $model->select('requirement_id')->where('traceability_id', $id)->where('type', 'System')->findAll();
		// $data['subsystemKeys'] = $model->select('requirement_id')->where('traceability_id', $id)->where('type', 'Subsystem')->findAll();

		// // $model = new RequirementsModel();
		// // $data['issues'] = $model->select('a.id, a.issue,a.issue_description,a.status,b.risk_type, b.severity,b.occurrence,b.detectability,b.rpn,b.update_date')
		// // ->from('docsgo-issues a')
		// // ->join('docsgo-risk-assessment b', 'a.id = b.issue_id', 'left')
		// // ->groupBy('a.id')
		// // ->findAll();

		
		// $model = new TraceabilityMatrixModel();
		// $data['data'] = $model->orderBy('id', 'asc')->findAll();	


		$data['checkedVals'] = array('TraceabilityRDBtn1' => 1, "TraceabilityRDBtn2"=> 0);
		
		
		
		echo view('templates/header');
		echo view('templates/pageTitle', $data);
		echo view('TraceabilityMatrix/list',$data);
		echo view('templates/footer');
	}

	

	private function setQueryData($type) {
		if($type == 1){

			// $model = new TraceabilityMatrixModel();
			// // $data['newList'] = $model->select('a.id, a.design, a.code, b.traceability_id, b.type, b.requirement_id, c.requirement')
			// $data['newList'] = $model->select('a.id, a.design, a.code, b.traceability_id, b.type, b.requirement_id')
			// ->from('docsgo-traceability a')
			// ->join('docsgo-traceability-options b', 'a.id = b.traceability_id', 'left')
			// // ->join('docsgo-requirements c', 'c.id = b.requirement_id', 'left')
			// // ->groupBy('b.requirement_id')
			// ->findAll();

			$db      = \Config\Database::connect();
			$sql = "SELECT  a.id, a.design, a.code, b.traceability_id, b.type, b.requirement_id, c.requirement,d.testcase
			FROM `docsgo-traceability` AS a
			LEFT JOIN `docsgo-traceability-options` AS b ON a.`id` = b.`traceability_id`
			LEFT JOIN `docsgo-requirements` AS c ON c.`id` = b.`requirement_id` AND b.type != 'testcase'
			LEFT JOIN `docsgo-test-cases` AS d ON b.`requirement_id` = d.`id`  AND b.type = 'testcase';";

			$query = $db->query($sql);

			$data = $query->getResult('array');
			 
			// print_r ($data);
			$mainData = [];
			foreach($data as $key=>$data){
				$idx = -1;	
				$idList = array_column($mainData, 'id');
				foreach($idList as $key1=>$data1){
					if($data1 == $data['id']){
						$idx = $key1;
					}
				}
				if($idx >= 0) {
					if($data['type'] == 'User Needs'){
						$mainData[$idx]['User Needs'] = $data['requirement'];
					}
					if($data['type'] == 'System' && $data['requirement'] !=''){
						$mainData[$idx]['System'][] = array('id'=>$data['requirement_id'], 'requirement'=>$data['requirement']);
					}
					if($data['type'] == 'Subsystem' && $data['requirement'] !=''){
						$mainData[$idx]['Subsystem'][] = array('id'=>$data['requirement_id'], 'requirement'=>$data['requirement']);
					}
					if($data['type'] == 'testcase' && $data['testcase'] !=''){
						$mainData[$idx]['testcase'][] = array('id'=>$data['requirement_id'], 'requirement'=>$data['testcase']);
					}
				}else{
					$dataList = [];
					$dataList['id'] = $data['id'];
					$dataList['design'] = $data['design'];
					$dataList['code'] = $data['code'];
					$dataList['System'] = [];
					$dataList['Subsystem']  = [];
					$dataList['testcase'] = [];
					if($data['type'] == 'User Needs'){
						$dataList['User Needs'] = $data['requirement'];
					}
					if($data['type'] == 'System' && $data['requirement'] !=''){
						$dataList['System'] = array('id'=>$data['requirement_id'], 'requirement'=>$data['requirement']);
					}
					if($data['type'] == 'Subsystem' && $data['requirement'] !=''){
						$dataList['Subsystem'] = array('id'=>$data['requirement_id'], 'requirement'=>$data['requirement']);
					}
					if($data['type'] == 'testcase' && $data['testcase'] !=''){
						$dataList['testcase'] = array('id'=>$data['requirement_id'], 'requirement'=>$data['testcase']);
					}
					$mainData[] = $dataList;						
				}
			}
			// print_r ('final DATATATATTATATA:');
			// echo "<pre>";
			// print_r ($mainData);

			return $mainData;

			// $data1 = [];
			// $model = new RequirementsModel();
			// $data1 = $model->orderBy('type', 'asc')->findAll();	
	
			// $data = $this->setQueryData(2);
			/*
			Get tha all CNCR/User Needs List from the `RequirementsModel` table and stored into CNCRList
			Get tha all system List from the `RequirementsModel` table and stored into systemList
			Get tha all Subsystem List from the `RequirementsModel` table and stored into subSystemList
			Passed params represented like $data1: all table data,type:enum values ,0: (either return name or description)
			*/
			// $data['CNCRList'] = $this->requirementsTypeData($data1,'User Needs', 0);
			// $data['systemList'] = $this->requirementsTypeData($data1,'System', 0);
			// $data['subSystemList'] = $this->requirementsTypeData($data1,'Subsystem', 0);
			// $data['testCases'] = $this->getTestCases(0);
	
	
			// $model = new RequirementsModel();
			// $data['issues'] = $model->select('a.id, a.issue,a.issue_description,a.status,b.risk_type, b.severity,b.occurrence,b.detectability,b.rpn,b.update_date')
			// ->from('docsgo-issues a')
			// ->join('docsgo-risk-assessment b', 'a.id = b.issue_id', 'left')
			// ->groupBy('a.id')
			// ->findAll();
	
			
			// $model = new TraceabilityMatrixModel();
			// $data['data'] = $model->orderBy('id', 'asc')->findAll();	
			// return $data;
		}else {
			$model = new TraceabilityMatrixModel();
			$data['data'] = $model->orderBy('id', 'asc')->findAll();	
			return $data;

		}
	}

	// private function setQueryData($type) {
	// 	if($type == 1){
	// 		$data1 = [];
	// 		$model = new RequirementsModel();
	// 		$data1 = $model->orderBy('type', 'asc')->findAll();	
	
	// 		// $data = $this->setQueryData(2);
	// 		/*
	// 		Get tha all CNCR/User Needs List from the `RequirementsModel` table and stored into CNCRList
	// 		Get tha all system List from the `RequirementsModel` table and stored into systemList
	// 		Get tha all Subsystem List from the `RequirementsModel` table and stored into subSystemList
	// 		Passed params represented like $data1: all table data,type:enum values ,0: (either return name or description)
	// 		*/
	// 		$data['CNCRList'] = $this->requirementsTypeData($data1,'User Needs', 0);
	// 		$data['systemList'] = $this->requirementsTypeData($data1,'System', 0);
	// 		$data['subSystemList'] = $this->requirementsTypeData($data1,'Subsystem', 0);
	// 		$data['testCases'] = $this->getTestCases(0);
	
	
	// 		// $model = new RequirementsModel();
	// 		// $data['issues'] = $model->select('a.id, a.issue,a.issue_description,a.status,b.risk_type, b.severity,b.occurrence,b.detectability,b.rpn,b.update_date')
	// 		// ->from('docsgo-issues a')
	// 		// ->join('docsgo-risk-assessment b', 'a.id = b.issue_id', 'left')
	// 		// ->groupBy('a.id')
	// 		// ->findAll();
	
			
	// 		$model = new TraceabilityMatrixModel();
	// 		$data['data'] = $model->orderBy('id', 'asc')->findAll();	
	// 		return $data;
	// 	}else {
	// 		$model = new TraceabilityMatrixModel();
	// 		$data['data'] = $model->orderBy('id', 'asc')->findAll();	
	// 		return $data;

	// 	}
	// }

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
			// 'cncr' => 'required',
			// 'sysreq' => 'required',
			// 'subsysreq' => 'required',
			'design' => 'required|min_length[3]|max_length[64]',
			'code' => 'required|min_length[3]|max_length[64]',
			// 'testcase' => 'required'
		];

		if($id == ""){
			$data['action'] = "add";
			$data['formTitle'] = "Add Traceability Matrix";
		}else{
			$data['action'] = "add/".$id;
			$data['formTitle'] = "Update Traceability Matrix";
			$data['member'] = $model->where('id',$id)->first();	
			
			// if($data['member']['cncr']) {
			// 	$model = new RequirementsModel();
			// 	$data1 = $model->where('id', $data['member']['cncr'])->where('type', 'CNCR')->first();
			// 	if($data1 && count($data1) >= 0){
			// 	} else {
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
				// 'cncr' => $this->request->getVar('cncr'),
				// 'sysreq' => $this->request->getVar('sysreq'),
				// 'subsysreq' => $this->request->getVar('subsysreq'),
				'design' => $this->request->getVar('design'),
				'code' => $this->request->getVar('code'),
				// 'testcase' => $this->request->getVar('testcase'),
				'update_date' => $currentTime,
			];
			//Get all selected cncr/User Needs/System/Subsystem value's ids
			$cncrList = []; $sysreqList = [];  $subsysreqList = []; $testcaseList = [];

			$cncrList = $this->request->getVar('cncr');
			$sysreqList = $this->request->getVar('sysreq');
			$subsysreqList = $this->request->getVar('subsysreq');
			$testcaseList = $this->request->getVar('testcase');
			
			$data['member'] = $newData;
			if (! $this->validate($rules)) {
				$data['validation'] = $this->validator;
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

				// $lastid = $model->insert_id();

				// if($id == ''){
				// 	$lastid = $this->$model->insert_id();
				// 	$this->db->insert_id(); 
				// }else{
				// 	$lastid = $id;
				// }

				
				//After saving/updating the traceability matrix, we need to store/update the selected all requirements(User Needs/System/Subsystem)
				$model = new TraceabilityOptionsModel();
				if(($cncrList)){
					$model->where('traceability_id', $lastid)->where('type', 'User Needs')->delete();
					// foreach($cncrList as $key=>$list){
						$newData1 = [
							'traceability_id' => $lastid,
							'type' => 'User Needs',
							'requirement_id' => $this->request->getVar('cncr')
						];	
						$model->save($newData1);
					// }
				}
				if(count($sysreqList) > 0){
					$model->where('traceability_id', $lastid)->where('type', 'System')->delete();
					foreach($sysreqList as $key=>$list){
						$newData1 = [
							'traceability_id' => $lastid,
							'type' => 'System',
							'requirement_id' => $list
						];	
						$model->save($newData1);
					}
				}
				if(count($subsysreqList) > 0){
					$model->where('traceability_id', $lastid)->where('type', 'Subsystem')->delete();
					foreach($subsysreqList as $key=>$list){
						$newData1 = [
							'traceability_id' => $lastid,
							'type' => 'Subsystem',
							'requirement_id' => $list
						];	
						$model->save($newData1);
					}
				}
				if(count($testcaseList) > 0){	
					$model->where('traceability_id', $lastid)->where('type', 'testcase')->delete();
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
		$data['CNCRList'] = $this->requirementsTypeData($data1,'User Needs', 0);
		$data['systemList'] = $this->requirementsTypeData($data1,'System', 0);
		$data['subSystemList'] = $this->requirementsTypeData($data1,'Subsystem', 0);
		$data['testCases'] = $this->getTestCases(0);

		$model = new TraceabilityOptionsModel();
		$dt= array();
		$keyData = $model->select('requirement_id')->where('traceability_id', $id)->where('type', 'User Needs')->findAll();
		foreach($keyData as $key=>$list){
			array_push($dt,$list['requirement_id']);	
		}
		$data['cncrKeys'] = $dt;
		$dt=[];
		$keyData = $model->select('requirement_id')->where('traceability_id', $id)->where('type', 'System')->findAll();
		foreach($keyData as $key=>$list){
			array_push($dt,$list['requirement_id']);
			// array_push($data['systemKeys'],$list['requirement_id']);	
		}
		$data['systemKeys'] = $dt;
		$dt=[];

		$keyData = $model->select('requirement_id')->where('traceability_id', $id)->where('type', 'Subsystem')->findAll();
		foreach($keyData as $key=>$list){
			array_push($dt,$list['requirement_id']);

			// array_push($data['subsystemKeys'],$list['requirement_id']);	
		}
		$data['subsystemKeys'] = $dt;

		$keyData = $model->select('requirement_id')->where('traceability_id', $id)->where('type', 'testcase')->findAll();
		foreach($keyData as $key=>$list){
			array_push($dt,$list['requirement_id']);

			// array_push($data['subsystemKeys'],$list['requirement_id']);	
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

	public function view() {
		$id = $this->returnParams();
		if($id == 1){

			$data = [];
			$data = $this->setQueryData(1);
			$data['pageTitle'] = 'Traceability Matrix';
			$data['addBtn'] = True;
			$data['addUrl'] = "/traceability-matrix/add";
			$data['listView'] = true;
			$data['gapView'] = false;
			$data['checkedVals'] = array('TraceabilityRDBtn1' => 1, "TraceabilityRDBtn2"=> 0);

			echo view('templates/header');
			echo view('templates/pageTitle', $data);
			echo view('TraceabilityMatrix/list',$data);
			echo view('templates/footer');

		}else{
			$data = [];
			$data = $this->setQueryData(2);
			$data['pageTitle'] = 'Traceability Matrix';
			$data['addBtn'] = True;
			$data['addUrl'] = "/traceability-matrix/add";
			$data['listView'] = false;
			$data['gapView'] = true;
			$data['checkedVals'] = array('TraceabilityRDBtn1' => 0, "TraceabilityRDBtn2"=> 1);

			echo view('templates/header');
			echo view('templates/pageTitle', $data);
			echo view('TraceabilityMatrix/list',$data);
			echo view('templates/footer');

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
		// if (session()->get('is-admin')){	
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
		// }
		// else{
		// 	$response = array('success' => "False");
		// 	echo json_encode( $response );
		// }
	}
	
	public function getTestCaseDescription(){
		// if (session()->get('is-admin')){	
			$id = $this->returnParams();
			$dataDescription = $this->getTestCases($id);
	
			$response = array('success' => "True", 'description'=>$dataDescription);
			echo json_encode( $response );
		// }
		// else{
		// 	$response = array('success' => "False");
		// 	echo json_encode( $response );
		// }
	}
}