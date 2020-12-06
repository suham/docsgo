<?php namespace App\Controllers;

use App\Models\TraceabilityMatrixModel;
use App\Models\RequirementsModel;
use App\Models\TestCasesModel;
use App\Models\SettingsModel;
use App\Models\TraceabilityOptionsModel;

class TraceabilityMatrix extends BaseController
{
	public function index()
    {
		$data = [];
		$data['pageTitle'] = 'Traceability Matrix';
		$data['addBtn'] = True;
		$data['addUrl'] = "/traceability-matrix/add";

		$model = new TraceabilityMatrixModel();
		//status->[List/GAP] type->[User Needs/Standards/Guidance]
		$status = $this->request->getVar('status');
		$type = $this->request->getVar('type');
		if($type == '')
			$data['selectedCategory'] = "User Needs";
		else
			$data['selectedCategory'] = $type;

		if($status == 'Gap'){
			$data['data'] = $model->getunmapedList();
			$data['listViewDisplay'] = false;
		}else{
			$data['listViewDisplay'] = true;
			$data['data'] = $model->getTraceabilityDataList($data['selectedCategory']);
		}
		//Display selected category as root-traceability, show/hide the columns [User Needs/Standards/Guidance]
		$rootTraceabilityColumn = 1;
		switch($data['selectedCategory']){
			case 'User Needs':
				$rootTraceabilityColumn = 1;
			break;
			case 'Standards':
				$rootTraceabilityColumn = 2;
			break;
			case 'Guidance':
				$rootTraceabilityColumn = 3;
			break;
		}
		$data['rootTraceabilityColumn'] = $rootTraceabilityColumn;
		$data['isEditForm'] = false;
		$data['requirementCategory'] = $this->getRequirementCategoryEnums();
		session()->set('prevUrl', '');

		echo view('templates/header');
		echo view('templates/pageTitle', $data);
		echo view('TraceabilityMatrix/list',$data);
		echo view('templates/footer');
	}

	private function getRequirementCategoryEnums() {
		$settingsModel = new SettingsModel;
		$requirementCategory = $settingsModel->where("identifier","requirementsCategory")->first();
		if($requirementCategory["options"] != null){
			$dataList = json_decode( $requirementCategory["options"], true );
			$requirementCategory = [];
			foreach($dataList as $key=>$list){
				if($list['isRoot']){
					$requirementCategory[] = $dataList[$key];
				}
			}
		}else{
			$requirementCategory = [];
		}
		return $requirementCategory;
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
		$data['requirementCategory'] = $this->getRequirementCategoryEnums();
		//Handling the back page navigation url
		if(isset($_SERVER['HTTP_REFERER'])){
			$urlStr = $_SERVER['HTTP_REFERER'];
			if (strpos($urlStr, 'status')) {
				$urlAr = explode("status", $urlStr);
				$backUrl = '/traceability-matrix?status'.$urlAr[count($urlAr)-1];
				session()->set('prevUrl', $backUrl);
			}else{
				if(session()->get('prevUrl') == ''){
					session()->set('prevUrl', '/traceability-matrix');
				}
			}
		}else{
			session()->set('prevUrl', '/traceability-matrix');
		}
		$data['backUrl'] =  session()->get('prevUrl');
		
		$rules = [
			'Traceability-to' => 'required'
		];

		if($id == ""){
			$data['action'] = "add";
			$data['formTitle'] = "Add Traceability";
			$data['isEditForm'] = false;
		}else{
			$data['action'] = "add/".$id;
			$data['isEditForm'] = true;
			$data['formTitle'] = "Update Traceability";
			$data['member'] = $model->where('id',$id)->first();	
			
		}
		
		if ($this->request->getMethod() == 'post') {
			$currentTime = gmdate("Y-m-d H:i:s");
			$newData = [
				'design' => $this->request->getVar('design'),
				'code' => $this->request->getVar('code'),
				'description' => $this->request->getVar('description'),
				'root_requirement' => $this->request->getVar('Traceability-to'),
				'update_date' => $currentTime,
			];
			//Get all selected User Needs/System/Subsystem value's ids
			$userNeedsList = []; $sysreqList = [];  $subsysreqList = []; $testcaseList = []; $standardsList = []; $guidanceList = [];

			$rootRequirement = $this->request->getVar('Traceability-to');
			switch($rootRequirement) {
				case 'User Needs':
					$userNeedsList = $this->request->getVar('userNeeds');
					$rules = [
						'Traceability-to' => 'required',
						'userNeeds' => 'required',
					];
					break;
				case 'Standards':
					$standardsList = $this->request->getVar('standards');
					$rules = [
						'Traceability-to' => 'required',
						'standards' => 'required',
					];
				break;
				case 'Guidance':
					$guidanceList = $this->request->getVar('guidance');
					$rules = [
						'Traceability-to' => 'required',
						'guidance' => 'required',
					];
				break;
			}
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
				$optionsList = array('System'=>$sysreqList, 'Subsystem'=>$subsysreqList, 'Standards'=>$standardsList, 'Guidance'=>$guidanceList,'testcase'=>$testcaseList);
				foreach($optionsList as $key=>$val){
					$this->handleNewExistingOptions($val, $lastid, $key);
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
		$data['standardsList'] = $this->requirementsTypeData($data1,'Standards', 0);
		$data['guidanceList'] = $this->requirementsTypeData($data1,'Guidance', 0);
		$data['testCases'] = $this->getTestCases(0);

		$data['userNeedsListKeys'] = $this->extraceOptionListKeys($id, 'User Needs');
		$data['systemKeys'] = $this->extraceOptionListKeys($id, 'System');
		$data['subsystemKeys'] = $this->extraceOptionListKeys($id, 'Subsystem');
		$data['standardsKeys'] = $this->extraceOptionListKeys($id, 'Standards');
		$data['guidanceKeys'] = $this->extraceOptionListKeys($id, 'Guidance');
		$data['testcaseKeys'] = $this->extraceOptionListKeys($id, 'testcase');

		echo view('templates/header');
		echo view('templates/pageTitle', $data);
		echo view('TraceabilityMatrix/form', $data);
		echo view('templates/footer');
	}

	function extraceOptionListKeys($id, $type) {
		$dt=[]; $check = array('traceability_id' => $id, 'type' => $type);
		$model = new TraceabilityOptionsModel();
		$keyData = $model->select('requirement_id')->where($check)->findAll();
		foreach($keyData as $key=>$list){
			array_push($dt,$list['requirement_id']);
		}
		return $dt;
	}

	function handleNewExistingOptions($dataList, $lastid, $type){
		$model = new TraceabilityOptionsModel();
		$model->where('traceability_id', $lastid)->where('type', $type)->delete();
		if(!empty($dataList) && count($dataList) > 0){
			foreach($dataList as $key=>$list){
				$newData = [
					'traceability_id' => $lastid,
					'type' => $type,
					'requirement_id' => $list
				];	
				$model->save($newData);
			}
		}
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
					$type='Standards';
					break;
				case 3 :
					$type='Guidance';
					break;
			}
			$data1 = [];
			$model = new RequirementsModel();
			$check = array('type' => $type, 'id' => $id);
			$data = $model->select('description')->where($check)->findAll();
			$response = array('success' => "True", 'description'=> $data);
			echo json_encode( $response );
	}
	
}