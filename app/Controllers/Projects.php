<?php namespace App\Controllers;

class Projects extends BaseController
{
	public function index()
    {
        $data = [];

		echo view('templates/header', $data);
		echo view('projects');
		echo view('templates/footer');
    }
}