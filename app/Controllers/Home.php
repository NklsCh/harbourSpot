<?php
namespace App\Controllers;

class Home extends BaseController
{
    public function index()
    {
        try {
            $db = \Config\Database::connect();
            
            // Aktuelle Session-Daten des Users
            $user_data = [
                'user_id' => session()->get('user_id') ?? 1,  // Fallback auf Test-User
                'user_name' => session()->get('user_name') ?? 'Max Mustermann',
                'user_role' => session()->get('user_role') ?? 'kunde'
            ];

            // Alle Liegeplätze mit Status
            $berths = $db->query("
                SELECT 
                    b.*,
                    COALESCE(br.status, b.status) as current_status
                FROM berths b
                LEFT JOIN berth_rentals br ON b.id = br.berth_id 
                    AND br.status = 'aktiv'
                    AND CURRENT_DATE BETWEEN br.start_date AND br.end_date
                ORDER BY b.berth_number
            ")->getResult();

            // Gemietete Boote des aktuellen Users
            $rented_boats = $db->query("
                SELECT 
                    hb.*,
                    br.start_date,
                    br.end_date
                FROM harbor_boats hb
                JOIN boat_rentals br ON hb.id = br.harbor_boat_id
                WHERE br.user_id = ? 
                AND br.status = 'aktiv'
                AND CURRENT_DATE BETWEEN br.start_date AND br.end_date
            ", [$user_data['user_id']])->getResult();

            // Eigene Boote des Users
            $owned_boats = $db->query("
                SELECT *
                FROM owned_boats
                WHERE owner_id = ?
            ", [$user_data['user_id']])->getResult();

            // Aktive Vermietungen für den aktuellen Tag
            $active_rentals = $db->query("
                SELECT 
                    br.*,
                    b.berth_number,
                    COALESCE(ob.name, hb.name) as boat_name,
                    u.vorname,
                    u.nachname
                FROM berth_rentals br
                JOIN berths b ON br.berth_id = b.id
                JOIN users u ON br.user_id = u.id
                LEFT JOIN owned_boats ob ON br.owned_boat_id = ob.id
                LEFT JOIN boat_rentals bor ON br.boat_rental_id = bor.id
                LEFT JOIN harbor_boats hb ON bor.harbor_boat_id = hb.id
                WHERE br.status = 'aktiv'
                AND CURRENT_DATE BETWEEN br.start_date AND br.end_date
                ORDER BY br.start_date DESC
            ")->getResult();

            // Wetterdaten (Mock - könnte später durch echte API ersetzt werden)
            $weather = [
                'temperature' => 20,
                'condition' => 'sunny',
                'wind_speed' => 12
            ];

            return view('dashboard', [
                'user' => $user_data,
                'berths' => $berths,
                'rented_boats' => $rented_boats,
                'owned_boats' => $owned_boats,
                'active_rentals' => $active_rentals,
                'weather' => $weather
            ]);

        } catch (\Exception $e) {
            log_message('error', $e->getMessage());
            return view('error', ['message' => 'Datenbankfehler: ' . $e->getMessage()]);
        }
    }

    public function getBerthStatus($date = null)
    {
        try {
            $db = \Config\Database::connect();
            
            // Logging für Debugging
            log_message('debug', 'Requested date: ' . ($date ?? 'null'));
            
            // Sicherstellen, dass das Datum korrekt formatiert ist
            $requestDate = $date ? date('Y-m-d', strtotime($date)) : date('Y-m-d');
            
            log_message('debug', 'Formatted date: ' . $requestDate);
            
            $query = $db->query("
                SELECT 
                    b.*,
                    COALESCE(br.status, b.status) as current_status
                FROM berths b
                LEFT JOIN berth_rentals br ON b.id = br.berth_id 
                    AND br.status = 'aktiv'
                    AND ? BETWEEN br.start_date AND br.end_date
                ORDER BY b.berth_number
            ", [$requestDate]);

            $result = $query->getResult();
            
            log_message('debug', 'Query result count: ' . count($result));
            
            return $this->response->setJSON($result);
            
        } catch (\Exception $e) {
            log_message('error', 'getBerthStatus error: ' . $e->getMessage());
            return $this->response->setJSON([
                'error' => $e->getMessage(),
                'date' => $date,
                'trace' => $e->getTraceAsString()
            ])->setStatusCode(500);
        }
    }
}