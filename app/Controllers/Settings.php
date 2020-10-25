<?php namespace App\Controllers;

use App\Models\DropdownSettingsModel;

class Settings extends BaseController
{
    public function index()
    {
        $data = [];

        $data['pageTitle'] = 'Settings';
        $data['addBtn'] = false;
        $data['backUrl'] = '/projects';

        $model = new DropdownSettingsModel();
        $data['dropdownData'] = $model->where('type', 'dropdown')->findAll();		
        $data['configData'] = $model->where('type', 'url')->findAll();	

        echo view('templates/header');
        echo view('templates/pageTitle', $data);
        echo view('Admin/Settings/list', $data);
        echo view('templates/footer');

    }

    public function addEnums()
    {
        if (session()->get('is-admin')) {
            if ($this->request->getMethod() == 'post') {
                $id = $this->request->getVar('id');
                $identifier = $this->request->getVar('identifier');
                $options =  $this->request->getVar('options');

                $rules = [
                    "id" => "required",
                    "identifier" => 'required',
                    "options" => 'required',
                ];
                $validation =  \Config\Services::validation();
                $validation->setRules($rules);

                if (! $this->validate($rules)) {
                    echo json_encode($validation->getErrors());
                }else{
                    $newData = ["id" => $id, "identifier" => $identifier, "options" => $options];
                    $model = new DropdownSettingsModel();
                    $model->save($newData);
                    $response = array('success' => "True");
                    echo json_encode($response);
                }
            }
        } else {
            $response = array('success' => "False");
            $response["error"] = "You are not authorized to perform this task.";
            echo json_encode($response);
        }
    
    }

    

}
