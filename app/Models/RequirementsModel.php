<?php  namespace App\Models;

use CodeIgniter\Model;

class RequirementsModel extends Model{
    protected $table = 'docsgo-requirements';
    protected $allowedFields = ['type', 'requirement', 'description', 'update_date'];

}