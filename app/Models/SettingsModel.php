<?php  namespace App\Models;

use CodeIgniter\Model;

class SettingsModel extends Model{
    protected $table = 'docsgo-settings';
    protected $allowedFields = ['type', 'identifier', 'options'];
}