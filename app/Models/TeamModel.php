<?php  namespace App\Models;

use CodeIgniter\Model;

class TeamModel extends Model{
    protected $table = 'docsgo-team-master';
    protected $allowedFields = ['name', 'role', 'responsibility', 'email', 'is-manager'];


    public function getManagers(){
        $db      = \Config\Database::connect();
        $builder = $db->table('docsgo-team-master');
        $builder->select('id, name');
        $builder->where('is-manager', 1);
        $builder->orderBy('name', 'ASC');
        $query = $builder->get();
        $data = $query->getResult('array');
        $team = [];
		foreach($data as $member){
			$team[$member['id']] = $member['name'];
		}
		return $team;
    }

    public function getMembers(){
        $db      = \Config\Database::connect();
        $builder = $db->table('docsgo-team-master');
        $builder->select('id, name');
        $builder->orderBy('name', 'ASC');
        $query = $builder->get();
        $data = $query->getResult('array');
        $team = [];
		foreach($data as $member){
			$team[$member['id']] = $member['name'];
		}
		return $team;
    }

}