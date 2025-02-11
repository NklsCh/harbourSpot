<?php
namespace App\Models;

use CodeIgniter\Model;

class BerthRentalModel extends Model {
    protected $table = 'berth_rentals';
    protected $primaryKey = 'id';
    protected $allowedFields = [
        'berth_id',
        'owned_boat_id',
        'boat_rental_id',
        'user_id',
        'start_date',
        'end_date',
        'status',
        'total_price',
        'created_at',
    ];

    protected $returnType = 'object';
}