<?php  namespace App\Models;

use CodeIgniter\Model;

class SoupModel extends Model{
    protected $table = 'docsgo-soup';
    protected $allowedFields = ['project_id', 'soup', 'version', 'url', 'purpose', 'validation', 'update_date', 'status'];

}