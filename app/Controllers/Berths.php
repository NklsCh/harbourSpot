<?php
// application/controllers/Berths.php

namespace App\Controllers;

use CodeIgniter\Controller;
use App\Models\BerthModel;
use App\Models\BoatRentalModel;
use App\Models\HarborBoatModel;
use App\Models\BerthRentalModel;
use App\Models\UserModel;

class Berths extends BaseController
{
    protected $berthModel;
    protected $boatRentalModel;
    protected $harborBoatModel;
    protected $berthRentalModel;
    protected $userModel;

    public function __construct()
    {
        $this->berthModel = new BerthModel();
        $this->boatRentalModel = new BoatRentalModel();
        $this->harborBoatModel = new HarborBoatModel();
        $this->berthRentalModel = new BerthRentalModel();
        $this->userModel = new UserModel();
    }

    public function index()
    {
        // Prüfen ob User eingeloggt ist
        if (!session()->get('logged_in')) {
            return redirect()->to('/login');
        }

        // Hole alle aktiven Liegeplätze
        $berths = $this->berthModel->findAll();

        // Hole alle aktiven Bootsvermietungen
        $rentedBoats = $this->harborBoatModel
            ->where('availability_status', 'vermietet')
            ->findAll();

        // Hole Wetterdaten (Mock - könnte später durch echte API ersetzt werden)
        $weather = [
            'temperature' => 20,
            'condition' => 'sunny'
        ];

        // Hole User Daten
        $userData = $this->userModel->find(session()->get('user_id'));

        $data = [
            'title' => 'Liegeplätze',
            'berths' => $berths,
            'rentedBoats' => $rentedBoats,
            'weather' => $weather,
            'user' => $userData
        ];

        // Lade die Views
        return view('templates/header', $data)
            . view('berths/index', $data)
            . view('templates/footer');
    }

    public function details($id = null)
    {
        if (!session()->get('logged_in')) {
            return $this->response->setJSON(['error' => 'Unauthorized']);
        }

        if ($id === null) {
            return $this->response->setJSON(['error' => 'No berth ID provided']);
        }

        // Hole aktuelle Vermietung für diesen Liegeplatz
        $currentRental = $this->berthRentalModel
            ->where('berth_id', $id)
            ->where('status', 'aktiv')
            ->first();

        $response = [
            'berth' => $this->berthModel->find($id)
        ];

        if ($currentRental) {
            $response['rental'] = $currentRental;
            $response['user'] = $this->userModel->find($currentRental['user_id']);
            
            if ($currentRental['owned_boat_id']) {
                $response['boat'] = $this->ownedBoatModel->find($currentRental['owned_boat_id']);
            } else if ($currentRental['boat_rental_id']) {
                $boatRental = $this->boatRentalModel->find($currentRental['boat_rental_id']);
                $response['boat'] = $this->harborBoatModel->find($boatRental['harbor_boat_id']);
            }
        }

        return $this->response->setJSON($response);
    }

    public function rent()
    {
        if (!session()->get('logged_in')) {
            return $this->response->setJSON(['error' => 'Unauthorized']);
        }

        // Validiere Request
        $rules = [
            'berth_id' => 'required|numeric',
            'start_date' => 'required|valid_date',
            'end_date' => 'required|valid_date',
            'boat_id' => 'required|numeric',
            'boat_type' => 'required|in_list[owned,harbor]'
        ];

        if (!$this->validate($rules)) {
            return $this->response->setJSON(['error' => $this->validator->getErrors()]);
        }

        // Erstelle neue Vermietung
        $rentalData = [
            'berth_id' => $this->request->getPost('berth_id'),
            'user_id' => session()->get('user_id'),
            'start_date' => $this->request->getPost('start_date'),
            'end_date' => $this->request->getPost('end_date'),
            'status' => 'aktiv'
        ];

        // Setze Boot-ID basierend auf Typ
        if ($this->request->getPost('boat_type') === 'owned') {
            $rentalData['owned_boat_id'] = $this->request->getPost('boat_id');
        } else {
            $rentalData['boat_rental_id'] = $this->request->getPost('boat_id');
        }

        // Berechne Gesamtpreis
        $berth = $this->berthModel->find($rentalData['berth_id']);
        $days = (strtotime($rentalData['end_date']) - strtotime($rentalData['start_date'])) / (60 * 60 * 24);
        $rentalData['total_price'] = $berth['price_per_day'] * $days;

        // Speichere Vermietung
        $this->berthRentalModel->insert($rentalData);

        // Aktualisiere Liegeplatz-Status
        $this->berthModel->update($rentalData['berth_id'], ['status' => 'belegt']);

        return $this->response->setJSON(['success' => true]);
    }

    public function cancel($id)
    {
        if (!session()->get('logged_in')) {
            return $this->response->setJSON(['error' => 'Unauthorized']);
        }

        $rental = $this->berthRentalModel->find($id);

        if (!$rental) {
            return $this->response->setJSON(['error' => 'Rental not found']);
        }

        // Prüfe Berechtigung
        if ($rental['user_id'] != session()->get('user_id') && 
            !in_array(session()->get('role'), ['mitarbeiter', 'verwaltung'])) {
            return $this->response->setJSON(['error' => 'Unauthorized']);
        }

        // Aktualisiere Vermietung und Liegeplatz
        $this->berthRentalModel->update($id, ['status' => 'storniert']);
        $this->berthModel->update($rental['berth_id'], ['status' => 'frei']);

        return $this->response->setJSON(['success' => true]);
    }

    public function toggleStatus($id)
    {
        if (!session()->get('logged_in') || 
            !in_array(session()->get('role'), ['mitarbeiter', 'verwaltung'])) {
            return $this->response->setJSON(['error' => 'Unauthorized']);
        }

        $berth = $this->berthModel->find($id);

        if (!$berth) {
            return $this->response->setJSON(['error' => 'Berth not found']);
        }

        // Toggle zwischen gesperrt und frei
        $newStatus = $berth['status'] === 'gesperrt' ? 'frei' : 'gesperrt';
        $this->berthModel->update($id, ['status' => $newStatus]);

        return $this->response->setJSON(['success' => true, 'new_status' => $newStatus]);
    }
}