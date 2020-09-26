<?php  namespace App\Models;

use CodeIgniter\Model;

class DocumentModel extends Model{
    protected $table = 'docsgo-documents';
    protected $allowedFields = ["project-id","type","update-date","json-object","file-name","status"];
    
}