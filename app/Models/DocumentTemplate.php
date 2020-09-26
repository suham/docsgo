<?php  namespace App\Models;

use CodeIgniter\Model;

class DocumentTemplate extends Model{
    protected $table = 'docsgo-document-template';
    protected $allowedFields = ['id', 'type', 'template-json-object'];
    
}