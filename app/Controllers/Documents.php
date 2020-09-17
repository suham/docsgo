<?php namespace App\Controllers;

class Documents extends BaseController
{
	public function index()
    {
        $data = [];

		echo view('templates/header', $data);
		echo view('documents');
		echo view('templates/footer');
    }
}