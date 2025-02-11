<?php
namespace App\Controllers;

class Home extends BaseController
{
    public function indexHome()
    {
        try {
            $db = \Config\Database::connect();

            if (!session()->get('logged_in')) {
                return redirect()->to('/login');
            }
            
            // Aktuelle Session-Daten des Users
            $user = $db->query("
                SELECT *
                FROM users
                WHERE user_id = ?
            ", [session()->get('user_id')])->getRowArray();

            $user_data = $user;

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
                    u.user_name,
                    u.user_surname
                FROM berth_rentals br
                JOIN berths b ON br.berth_id = b.id
                JOIN users u ON br.user_id = u.user_id
                LEFT JOIN owned_boats ob ON br.owned_boat_id = ob.id
                LEFT JOIN boat_rentals bor ON br.boat_rental_id = bor.id
                LEFT JOIN harbor_boats hb ON bor.harbor_boat_id = hb.id
                WHERE br.status = 'aktiv'
                AND CURRENT_DATE BETWEEN br.start_date AND br.end_date
                ORDER BY br.start_date DESC
            ")->getResult();

            // Wetterdaten (Mock - könnte später durch echte API ersetzt werden)
            $weather = $this->getWeatherData('Krefeld'); 

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


    private function getWeatherData($location)
    {
        $apiKey = '0334c18c428a4fb69d8111613241009'; // Replace with your actual WeatherAPI key
        $apiUrl = 'http://api.weatherapi.com/v1/current.json';

        $url = $apiUrl . "?key=$apiKey&q=" . urlencode($location);

        try {
            $curl = curl_init();
            curl_setopt_array($curl, [
                CURLOPT_URL => $url,
              CURLOPT_RETURNTRANSFER => true,
            ]);

            $response = curl_exec($curl);
            if ($response === false) {
                throw new \Exception('WeatherAPI request failed: ' . curl_error($curl));
            }

            curl_close($curl);

            $data = json_decode($response, true);

            if (isset($data['error'])) {
                throw new \Exception('WeatherAPI error: ' . $data['error']['message']);
            }

            return [
                'temperature' => $data['current']['temp_c'],
                'condition' => $data['current']['condition']['text'],
                'wind_speed' => $data['current']['wind_kph']
            ];

        } catch (\Exception $e) {
            log_message('error', 'WeatherAPI Error: ' . $e->getMessage());
            return [
                'temperature' => null,
                'condition' => 'unknown',
                'wind_speed' => null
            ];
        }
    }
}
