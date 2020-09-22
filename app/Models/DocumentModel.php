<?php  namespace App\Models;

use CodeIgniter\Model;

class DocumentModel extends Model{
    protected $table = 'docsgo-document-master';
    protected $allowedFields = ['name', 'category', 'version', 'description', 'ref', 'location', 'status'];
    
}