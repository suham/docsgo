<?php namespace App\Controllers;

use App\Models\RequirementsModel;

class BulkInsert extends BaseController
{
	public function index()
    {   // Expected Url Format
        // /bulk-insert?fileName=CNCR.csv&tableName=requirements
        $fileName = $this->request->getVar('fileName');
        $tableName = $this->request->getVar('tableName'); 
        
        $res = $this->bulkInsert($fileName, $tableName);
        $response = array();
     
        if($res){
            $response['success'] = 'true';
        }else{
            $response['success'] = 'false';
        }
        return json_encode($response);
       
    }
   
    public function bulkInsert($fileName, $tableName){		
        if($fileName != '' && $tableName != ''){
            helper('Helpers\csv_to_array');
            $data =  csvToArray($fileName);
            // echo json_encode($data);
            if($tableName == 'requirements'){
                $model = new RequirementsModel();
                $model->bulkInsert($data);
                return true;
            }else{
                return false;
            }
        }
		
	}
}