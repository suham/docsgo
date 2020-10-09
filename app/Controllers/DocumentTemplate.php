<?php namespace App\Controllers;

use App\Models\DocumentTemplateModel;

class DocumentTemplate extends BaseController
{
	
	public function index()
    {
        $data = [];
		$data['pageTitle'] = 'Templates';
		$data['addBtn'] = True;
		$data['addUrl'] = "/documents-templates/add";
		

		$model = new DocumentTemplateModel();
		$data['data'] = $model->findAll();	

		echo view('templates/header');
		echo view('templates/pageTitle', $data);
		echo view('DocumentTemplates/list',$data);
		
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

	public function addTemplate(){
		if ($this->request->getMethod() == 'post') {
			$id = $this->request->getVar('id');
			$name = $this->request->getVar('name');
			$type = $this->request->getVar('type');
			$json = $this->request->getVar('template-json-object');
			
			$newData = [
				'name' => $name ,
				'type' => $type,
                'template-json-object' => $json
			];
			
			if($id != ""){
				$newData["id"] = $id;
			}

			$model = new DocumentTemplateModel();
			$model->save($newData);

			$response = array('success' => "True");
			
			echo json_encode( $response );
		}
	}

	public function add(){
		$id = $this->returnParams();
		helper(['form']);
		$model = new DocumentTemplateModel();
		$data = [];
		$data['pageTitle'] = 'Templates';
		$data['addBtn'] = False;
		$data['backUrl'] = "/documents-templates";
		$data['existingTypes'] =  join(",",$model->getTypes());

		if($id == ""){
			$data['action'] = "add";
			$data['formTitle'] = "Add Template";
		}else{
			$data['action'] = "add/".$id;
			$data['formTitle'] = "Update Template";

			$documentTemplate = $model->where('id',$id)->first();	
			$data['documentTemplate'] = $documentTemplate;
			$template = json_decode($data['documentTemplate']["template-json-object"], true);		
			$data['template'] = $template[$documentTemplate['type']];
		}

		$data['tablesLayout'] = json_encode($this->returnTablesLayout());
		echo view('templates/header');
		echo view('templates/pageTitle', $data);
		echo view('DocumentTemplates/form', $data);
		echo view('templates/footer');
	}

	private function returnTablesLayout(){
		$tables = array();
		$tables['References']['name'] = "docsgo-document-master";
		$tables['References']['columns'] = "name,category,description,location,ref,status,version";
		$tables['Teams']['name'] = "docsgo-team-master";
		$tables['Teams']['columns'] = "name,email,responsibility,role";
		$tables['Reviews']['name'] = "docsgo-reviews";
		$tables['Reviews']['columns'] = "review-name,context,assigned-to,description,project-id,review-by,review-ref,status";
		return $tables;
	}

	public function delete(){
		if (session()->get('is-admin')){
			$uri = $this->request->uri;
			$id = $uri->getSegment(3);

			$model = new DocumentTemplateModel();
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