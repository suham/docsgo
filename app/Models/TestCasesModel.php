<?php  namespace App\Models;

use CodeIgniter\Model;

class TestCasesModel extends Model{
    protected $table = 'docsgo-test-cases';
    protected $allowedFields = ['testcase', 'description', 'update_date'];

    public function bulkInsert($data){
        $db      = \Config\Database::connect();
        $builder = $db->table('docsgo-test-cases');
        $builder->insertBatch($data);		
    }

}