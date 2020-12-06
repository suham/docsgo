<?php  namespace App\Models;

use CodeIgniter\Model;

class SettingsModel extends Model{
    protected $table = 'docsgo-settings';
    protected $allowedFields = ['type', 'identifier', 'options'];

    public function getSettings($identifier = ""){
        $db      = \Config\Database::connect();
        $whereCondition = "";
        if($identifier != ""){
            $whereCondition = " WHERE settings.identifier = '".$identifier."' ";
        }

        $sql = "SELECT settings.id, settings.type, settings.identifier, settings.options
        FROM `docsgo-settings` settings
        ".$whereCondition.";";

        $query = $db->query($sql);
        $data = $query->getResult('array');
        
        return $data;
    }

    public function getConfig($identifier){
        $db      = \Config\Database::connect();
        $builder = $db->table('docsgo-settings');
        $builder->select('options');
        $builder->where('identifier', $identifier);
        $query = $builder->get();
        $result = $query->getResult('array');
        $options = $result[0]["options"];

        $data = [];
        if( $options != null){
            $options = json_decode( $options, true );
            foreach($options as $option){
                $data[$option['key']] = $option['value'];
            }
		}else{
			$data = [];
        }
        
        return $data;
    }

}