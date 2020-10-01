<?php  namespace App\Models;

use CodeIgniter\Model;

class ReviewModel extends Model{
    protected $table = 'docsgo-reviews';
    protected $allowedFields = ["assigned-to","context","description","id","project-id",
                                "review-by","review-name","review-ref","status"];

                                
}