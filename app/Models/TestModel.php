<?php
namespace App\Models;
use CodeIgniter\Model;

class TestModel extends Model {
    protected $db;

    function __construct() {
        $session = session();
        $this->db = db_connect();
    }

    public function getKunden() {
        $kunden = [];

        $builder = $this->db->table('kunden');
        $builder->orderB<('Name');
        $query = $builder->get();

        if ($query->getNumRows() > 0) {
            $z = 0;
            foreach ($query->getResult() as $row) {
                $kunden[$z]['KundenID'] = $row->KundenID;
                $kunden[$z]['Name'] = $row->Name;
                $kunden[$z]['Vorname'] = $row->Vorname;
                $kunden[$z]['Strasse'] = $row->Strasse;
                $kunden[$z]['PLZ'] = $row->PLZ;
                $kunden[$z]['Ort'] = $row->Ort;
                $kunden[$z]['Land'] = $row->Land;
                $kunden[$z]['Telefon'] = $row->Telefon;
                $kunden[$z]['Email'] = $row->Email;
                $kunden[$z]['Geburtsdatum'] = $row->Geburtsdatum;
                $kunden[$z]['Geschlecht'] = $row->Geschlecht;
                $kunden[$z]['Kundengruppe'] = $row->Kundengruppe;
                $kunden[$z]['Anrede'] = $row->Anrede;
                $kunden[$z]['Titel'] = $row->Titel;
                $kunden[$z]['Firma'] = $row->Firma;
                $kunden[$z]['AnzahlBestellungen'] = $row->AnzahlBestellungen;
            }
        }
        return $kunden;
    }
} 