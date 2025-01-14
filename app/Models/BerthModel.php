<?php
namespace App\Models;

use CodeIgniter\Model;

class BerthModel extends Model {
    protected $table = 'berths';
    protected $primaryKey = 'id';
    protected $allowedFields = [
        'berth_number',
        'status',
        'price_per_day',
        'description'
    ];

    protected $returnType = 'object';

    public function isAvailable($berthId, $startDate, $endDate) {
        // Implementiere die Verfügbarkeitsprüfung
        $query = $this->db->table('berth_rentals')
            ->where('berth_id', $berthId)
            ->where('status', 'aktiv')
            ->where('start_date <=', $endDate)
            ->where('end_date >=', $startDate)
            ->get();

        return $query->getNumRows() === 0;
    }
}