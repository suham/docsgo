<?php  namespace App\Models;

use CodeIgniter\Model;

class RequirementsModel extends Model{
    protected $table = 'docsgo-requirements';
    protected $allowedFields = ['type', 'requirement', 'description', 'update_date'];

    public function bulkInsert($data){
        $db      = \Config\Database::connect();
        $builder = $db->table('docsgo-requirements');
        $builder->insertBatch($data);
		
    }

}