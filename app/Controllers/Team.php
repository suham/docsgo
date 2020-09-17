<?php namespace App\Controllers;

class Team extends BaseController
{
	public function index()
    {
        $data = [];

		echo view('templates/header', $data);
		echo view('team');
		echo view('templates/footer');
    }
}