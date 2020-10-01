<?php namespace App\Models;

use CodeIgniter\Model;

class UserModel extends Model{
  protected $table = 'docsgo-users';
  protected $allowedFields = ['name', 'email', 'password', 'updated_at', 'is-admin'];
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

  public function getUsers(){
    $db      = \Config\Database::connect();
    $builder = $db->table('docsgo-users');
    $builder->select('id, name, email, is-admin');
    $builder->orderBy('name', 'ASC');
    $query = $builder->get();
    return $query->getResult('array');
  }

  public function updateAdminStatus($id, $status){
    $db      = \Config\Database::connect();
    $builder = $db->table('docsgo-users');
    $builder->set('is-admin', $status);
    $builder->where('id', $id);
    $builder->update();    
  }


}
