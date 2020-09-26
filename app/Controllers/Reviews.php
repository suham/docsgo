<?php namespace App\Controllers;

use App\Models\ReviewModel;

class Reviews extends BaseController
{
    public function index()
    {
        $data = [];
		$data['pageTitle'] = 'Reviews';
		$data['addBtn'] = True;
		$data['addUrl'] = "/reviews/add";

		$model = new ReviewModel();
		$data['data'] = $model->findAll();	
		
		echo view('templates/header');
		echo view('templates/pageTitle', $data);
		echo view('Reviews/list',$data);
		echo view('templates/footer');
	}
}