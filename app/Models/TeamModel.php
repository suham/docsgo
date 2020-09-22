<?php  namespace App\Models;

use CodeIgniter\Model;

class TeamModel extends Model{
    protected $table = 'docsgo-team-master';
    protected $allowedFields = ['name', 'role', 'responsibility', 'email'];
    
}