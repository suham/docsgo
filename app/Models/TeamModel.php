<?php  namespace App\Models;

use CodeIgniter\Model;

class TeamModel extends Model{
    protected $table = 'docsgo-team-master';
    protected $allowedFields = ['name', 'role', 'responsibility',"password", 'email', 'is-manager',"created_at","is-admin","updated_at"];
    protected $beforeInsert = ['beforeInsert'];
    protected $beforeUpdate = ['beforeUpdate'];
  
    protected function beforeInsert(array $data){
      $data = $this->passwordHash($data);
      $data['data']['created_at'] = date('Y-m-d H:i:s');
  
      return $data;
    }
  
    protected function beforeUpdate(array $data){
      $data = $this->passwordHash($data);
      $data['data']['updated_at'] = date('Y-m-d H:i:s');
      return $data;
    }
  
    protected function passwordHash(array $data){
      if(isset($data['data']['password']))
        $data['data']['password'] = password_hash($data['data']['password'], PASSWORD_DEFAULT);
  
      return $data;
    }

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

    public function updateAdminStatus($id, $status){
        $db      = \Config\Database::connect();
        $builder = $db->table('docsgo-team-maste');
        $builder->set('is-admin', $status);
        $builder->where('id', $id);
        $builder->update();    
      }

}