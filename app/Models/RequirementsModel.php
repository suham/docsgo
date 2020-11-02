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

    function getRequirements($status = '') {
        $db      = \Config\Database::connect();
        $whereCondition = "";
        if($status != ""){
            $whereCondition = " WHERE type = '".$status."' ";
        }
        $sql = "SELECT * from `docsgo-requirements` ". $whereCondition . "ORDER BY update_date;";
        $query = $db->query($sql);
        $data = $query->getResult('array');
        return $data;
    }

}