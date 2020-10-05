<?php
namespace App\Validation;
use App\Models\UserModel;

class UserRules
{

  public function validateUser(string $str, string $fields, array $data){
    $model = new UserModel();
    $user = $model->where('email', $data['email'])
                  ->first();

    if(!$user)
      return false;

    return password_verify($data['password'], $user['password']);
  }

  public function validatePassCode(string $str){
    $pass_code = getenv('PASS_CODE');
    if($str == $pass_code){
      return true;
    }else{
      return false;
    }
  }

}
