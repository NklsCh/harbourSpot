<?php
namespace App\Models;

use CodeIgniter\Model;

class BoatRentalModel extends Model {
    protected $table = 'boat_rentals';
    protected $primaryKey = 'id';
    protected $allowedFields = [
        'harbor_boat_id',
        'user_id',
        'start_date',
        'end_date',
        'status',
        'total_price',
        'created_at',
        'notes',
    ];

    protected $returnType = 'object';
}