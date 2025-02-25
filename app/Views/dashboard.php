<?php
// app/Views/dashboard.php
?>
<!DOCTYPE html>
<html lang="de">
<head>
    <meta charset="UTF-8">
    <title>HarbourSpot Dashboard</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.0/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.7.2/font/bootstrap-icons.css">
    <style>
        :root {
            --primary-blue: #007AFF;
            --secondary-blue: #5856D6;
            --success-green: #34C759;
            --warning-yellow: #FFD60A;
            --danger-red: #FF3B30;
            --gray-1: #8E8E93;
            --gray-2: #C7C7CC;
            --gray-3: #F2F2F7;
            --water-blue: #BCE6FF;
        }

        body {
            background-color: var(--gray-3);
            color: #1c1c1e;
        }

        /* Modernere Navigationsleiste */
        .nav-tabs {
            border: none;
            background: white;
            border-radius: 12px;
            padding: 4px;
            box-shadow: 0 2px 6px rgba(0,0,0,0.05);
        }

        .nav-tabs .nav-link {
            border: none;
            border-radius: 8px;
            color: var(--gray-1);
            padding: 8px 16px;
            transition: all 0.2s ease;
        }

        .nav-tabs .nav-link.active {
            background: var(--primary-blue);
            color: white;
            font-weight: 500;
        }



        .harbor-layout {
            background: linear-gradient(180deg, #BCE6FF 0%, #D4F1FF 100%);
            border: none;
            border-radius: 16px;
            padding: 20px;
            box-shadow: 0 4px 12px rgba(0,0,0,0.08);
            position: relative;
            overflow: hidden;
        }

        .harbor-layout::before {
            content: "";
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: url('data:image/svg+xml,<svg width="100" height="20" xmlns="http://www.w3.org/2000/svg"><path d="M0 10 Q25 20 50 10 T100 10" fill="none" stroke="rgba(255,255,255,0.1)" /></svg>');
            animation: wave 8s linear infinite;
            opacity: 0.6;
        }

        @keyframes wave {
            0% { background-position: 0 0; }
            100% { background-position: 100% 0; }
        }

        /* Stege */
        .pier-horizontal {
            height: 12px;
            background: linear-gradient(90deg, #8B4513 0%, #A0522D 100%);
            margin: 15px 0;
            border-radius: 4px;
            box-shadow: 0 2px 4px rgba(0,0,0,0.1);
        }

        .pier-vertical {
            width: 16px;
            background: linear-gradient(180deg, #8B4513 0%, #A0522D 100%);
            border-radius: 4px;
            box-shadow: 0 2px 4px rgba(0,0,0,0.1);
        }

        /* Liegeplätze */
        .berth {
            height: 70px;
            border: 2px solid rgba(255,255,255,0.8);
            background: white;
            border-radius: 12px;
            box-shadow: 0 2px 8px rgba(0,0,0,0.08);
            font-size: 0.9rem;
            font-weight: 500;
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        }

        .berth:hover {
            transform: translateY(-2px);
            box-shadow: 0 4px 12px rgba(0,0,0,0.12);
        }

        .berth.available { 
            border-color: var(--success-green);
            background: rgba(52, 199, 89, 0.1);
        }

        .berth.occupied { 
            border-color: var(--danger-red);
            background: rgba(255, 59, 48, 0.1);
        }

        .berth.reserved { 
            border-color: var(--warning-yellow);
            background: rgba(255, 214, 10, 0.1);
        }

        .berth.blocked { 
            border-color: var(--gray-1);
            background: rgba(142, 142, 147, 0.1);
        }

        /* Wetter Widget */
        .weather-widget {
            backdrop-filter: blur(10px);
            background: rgba(255, 255, 255, 0.8);
            border: 1px solid rgba(255, 255, 255, 0.4);
            padding: 8px 16px;
            font-weight: 500;
            gap: 8px;
        }

        /* Boot Karten */
        .boats-container {
            background: white;
            border-radius: 16px;
            box-shadow: 0 4px 12px rgba(0,0,0,0.08);
            padding: 20px;
        }

        .boat-card {
            background: white;
            border-radius: 12px;
            padding: 12px;
            box-shadow: 0 2px 8px rgba(0,0,0,0.06);
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        }

        .boat-card:hover {
            transform: translateY(-4px);
            box-shadow: 0 8px 16px rgba(0,0,0,0.12);
        }

        .boat-image-placeholder {
            font-size: 48px;
            height: 80px;
            display: flex;
            align-items: center;
            justify-content: center;
            background: var(--gray-3);
            border-radius: 8px;
            margin-bottom: 12px;
        }

        /* Kalender */
        .calendar-container {
            gap: 1px;
            margin-top: 8px;
        }

        .calendar-day {
            font-size: 0.8rem;
            height: 28px;
            border-radius: 6px;
        }

        .calendar-day.active {
            background: var(--primary-blue);
        }

        /* Detail Panel Buttons */
        .btn {
            border-radius: 8px;
            font-weight: 500;
            padding: 8px 16px;
            transition: all 0.2s ease;
        }

        .btn-primary {
            background: var(--primary-blue);
            border: none;
        }

        .btn-danger {
            background: var(--danger-red);
            border: none;
        }

        .btn-warning {
            background: var(--warning-yellow);
            border: none;
        }

        .btn-secondary {
            background: var(--gray-1);
            border: none;
        }
        .harbor-layout {
            background: #f8f9fa;
            border: 1px solid #dee2e6;
            border-radius: 8px;
            padding: 15px;
            position: relative;
            margin-bottom: 20px;
        }

        .pier-horizontal {
            height: 10px;
            background: #8B4513;
            margin: 8px 0;
        }

        .pier-vertical {
            width: 20px;
            background: #8B4513;
            position: absolute;
            left: 50%;
            transform: translateX(-50%);
            top: 20px;
            bottom: 20px;
            z-index: 0;
        }

        .berth {
            border: 2px dashed #ccc;
            padding: 15px;
            text-align: center;
            cursor: pointer;
            height: 80px;
            display: flex;
            align-items: center;
            justify-content: center;
            transition: all 0.2s;
            background: white;
            position: relative;
            z-index: 1;
            margin: 5px;
        }

        .berth.selected {
            box-shadow: 0 0 0 3px #0d6efd;
        }

        .berth.frei { 
            border-color: #28a745; 
            background-color: rgba(40, 167, 69, 0.1); 
        }
        .berth.belegt { 
            border-color: #dc3545; 
            background-color: rgba(220, 53, 69, 0.1); 
        }
        .berth.reserviert { 
            border-color: #ffc107; 
            background-color: rgba(255, 193, 7, 0.1); 
        }
        .berth.gesperrt { 
            border-color: #6c757d; 
            background-color: rgba(108, 117, 125, 0.1); 
        }

        .weather-widget {
            position: absolute;
            top: 1rem;
            right: 1rem;
            padding: 0.5rem 1rem;
            background: white;
            border-radius: 20px;
            box-shadow: 0 2px 4px rgba(0,0,0,0.1);
            z-index: 2;
        }

        .legend-item {
            display: flex;
            align-items: center;
            margin-right: 1rem;
        }

        .legend-color {
            width: 15px;
            height: 15px;
            border-radius: 50%;
            margin-right: 8px;
        }

        .boats-container {
            border: 1px solid #dee2e6;
            border-radius: 8px;
            padding: 15px;
            background: white;
        }

        .boat-card {
            cursor: pointer;
            transition: all 0.2s;
            text-align: center;
        }

        .boat-card:hover {
            transform: translateY(-2px);
        }

        .boat-image-placeholder {
            width: 100%;
            height: 120px;
            background: #e9ecef;
            border-radius: 4px;
            margin-bottom: 8px;
        }

        .calendar-container {
            display: grid;
            grid-template-columns: repeat(7, 1fr);
            gap: 2px;
        }

        .calendar-header {
            display: grid;
            grid-template-columns: repeat(7, 1fr);
            gap: 2px;
            margin-bottom: 5px;
        }

        .calendar-header span {
            text-align: center;
            font-size: 0.8rem;
            color: #6c757d;
            padding: 5px;
        }

        .calendar-day {
            aspect-ratio: 1;
            display: flex;
            align-items: center;
            justify-content: center;
            cursor: pointer;
            border-radius: 50%;
            font-size: 0.9rem;
            transition: all 0.2s;
        }

        .calendar-day:hover {
            background: #e9ecef;
        }

        .calendar-day.active {
            background: #0d6efd;
            color: white;
        }

        .calendar-day.empty {
            cursor: default;
        }

        .action-button {
            width: 100%;
            margin-bottom: 0.5rem;
        }

        .btn:disabled {
            opacity: 0.3;
            cursor: not-allowed;
            filter: grayscale(100%);
        }

        .user-info {
            position: relative;
            cursor: pointer;
        }

        .user-box {
            display: flex;
            align-items: center;
            padding: 5px 10px;
            background-color: #f2f2f7;
            border-radius: 20px;
            border: 1px solid #dee2e6;
        }

        .logout-button {
            display: none;
            position: absolute;
            top: 100%;
            right: 0;
            margin-top: 5px;
            z-index: 1000;
        }

        .logout-button .btn {
            width: 100%;
            text-align: center;
        }
    </style>
</head>
<body class="bg-light">
    <div class="container-fluid">
        <!-- Navigation -->
        <nav class="navbar navbar-expand-lg navbar-light bg-white border-bottom">
            <div class="container-fluid">
                <ul class="nav nav-tabs flex-grow-1">
                    <li class="nav-item">
                        <a class="nav-link active" href="#">
                            <i class="bi bi-grid"></i> Liegeplätze
                        </a>
                    </li>
                </ul>
                <div class="d-flex align-items-center">
            <div class="user-info">
                <div class="user-box" onclick="document.getElementById('logout-button').style.display = document.getElementById('logout-button').style.display === 'block' ? 'none' : 'block';">
                    <span class="me-2"><?= esc($user->user_name . " ". esc($user->user_surname)) ?></span>
                    <span class="badge bg-secondary"><?= esc($user->user_role) ?></span>
                </div>
                <div id="logout-button" class="logout-button">
                    <a href="/logout" class="btn btn-danger btn-sm">Logout</a>
                </div>
            </div>
        </div>
            </div>
        </nav>

        <div class="container-fluid py-4">
            <div class="row">
                <!-- Hauptbereich -->
                <div class="col-md-8">
                    <!-- Liegeplatz Canvas -->
                    <div class="harbor-layout">
                        <!-- Wetter Widget -->
                        <div class="weather-widget">
                            <i class="bi bi-sun-fill text-warning"></i>
                            <span><?= $weather['temperature'] ?>°C</span>
                            <span class="text-muted">|</span>
                            <span><?= $weather['wind_speed'] ?> km/h</span>
                        </div>

                        <!-- Vertikaler Steg -->
                        <div class="pier-vertical"></div>

                        <!-- Liegeplätze Grid -->
                        <div class="row g-1">
                            <?php 
                            $berthCount = 0;
                            foreach ($berths as $i => $berth): 
                                // Steg nach Reihe A und C
                                if ($berthCount % 4 === 0 && ($berthCount === 4 || $berthCount === 12)): 
                            ?>
                                <div class="col-12"><div class="pier-horizontal"></div></div>
                                <!-- Zusätzlicher Abstand nach Reihe B -->
                                <?php if ($berthCount === 8): ?>
                                    <div class="col-12" style="margin: 15px 0;"></div>
                                <?php endif; ?>
                            <?php 
                                endif; 
                            ?>
                                <div class="col-md-3">
                                    <div class="berth <?= esc($berth->current_status) ?>" 
                                        data-berth-id="<?= $berth->id ?>"
                                        data-berth-number="<?= esc($berth->berth_number) ?>">
                                        <small class="text-muted">Liegeplatz</small><br>
                                        <?= esc($berth->berth_number) ?>
                                    </div>
                                </div>
                            <?php 
                                $berthCount++;
                            endforeach; 
                            ?>
                        </div>

                        <!-- Legende -->
                        <div class="card mt-3 d-inline-block">
                            <div class="card-body">
                                <h6 class="mb-3">Legende</h6>
                                <div class="d-flex flex-wrap">
                                    <div class="legend-item">
                                        <span class="legend-color bg-success"></span>
                                        <span>Verfügbar</span>
                                    </div>
                                    <div class="legend-item">
                                        <span class="legend-color bg-danger"></span>
                                        <span>Belegt</span>
                                    </div>
                                    <div class="legend-item">
                                        <span class="legend-color bg-warning"></span>
                                        <span>Reserviert</span>
                                    </div>
                                    <div class="legend-item">
                                        <span class="legend-color bg-secondary"></span>
                                        <span>Gesperrt</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Gemietete Boote -->
                    <div class="boats-container">
                        <h5 class="mb-3">Gemietete Boote</h5>
                        <div class="row g-3">
                            <?php foreach (array_merge($rented_boats, $owned_boats) as $boat): ?>
                                <div class="col-md-3">
                                    <div class="boat-card" 
                                        data-boat-id="<?= $boat->id ?>"
                                        data-length="<?= esc($boat->length) ?>"
                                        data-draft="<?= esc($boat->draft) ?>"
                                        data-renter="<?= esc($boat->renter ?? 'Max Mustermann') ?>"
                                        data-rental-period="<?= esc($boat->rental_period ?? '01.10.-06.10.24') ?>">
                                        <div class="boat-image-placeholder">
                                            <?= $boat->type === 'segelyacht' ? '⛵' : '🚤' ?>
                                        </div>
                                        <div class="boat-title"><?= esc($boat->name) ?></div>
                                    </div>
                                </div>
                            <?php endforeach; ?>
                        </div>
                    </div>
                </div>

                <!-- Rechte Spalte -->
                <div class="col-md-4">
                    <!-- Kalender -->
                    <div class="card mb-4">
                        <div class="card-body">
                            <div class="d-flex justify-content-between align-items-center mb-3">
                                <select class="form-select w-auto" id="month-select">
                                    <?php
                                    $months = ['Januar', 'Februar', 'März', 'April', 'Mai', 'Juni', 
                                               'Juli', 'August', 'September', 'Oktober', 'November', 'Dezember'];
                                    $currentMonth = intval(date('n'));
                                    foreach ($months as $i => $month):
                                    ?>
                                        <option value="<?= $i + 1 ?>" <?= ($currentMonth === $i + 1) ? 'selected' : '' ?>>
                                            <?= $month ?>
                                        </option>
                                    <?php endforeach; ?>
                                </select>
                                <div class="d-flex align-items-center gap-2">
                                    <span id="year-display"><?= date('Y') ?></span>
                                    <div class="btn-group-vertical btn-group-sm">
                                        <button class="btn btn-outline-secondary py-0" id="year-up">▲</button>
                                        <button class="btn btn-outline-secondary py-0" id="year-down">▼</button>
                                    </div>
                                </div>
                            </div>

                            <!-- Kalendertage -->
                            <div class="calendar-header">
                                <?php
                                $weekdays = ['Mo', 'Di', 'Mi', 'Do', 'Fr', 'Sa', 'So'];
                                foreach ($weekdays as $day):
                                ?>
                                    <span><?= $day ?></span>
                                <?php endforeach; ?>
                            </div>
                            <div id="calendar-grid" class="calendar-container">
                                <!-- Wird durch JavaScript gefüllt -->
                            </div>
                        </div>
                    </div>

                    <!-- Details Panel -->
                    <div class="card">
                        <div class="card-body">
                            <h5 class="card-title" id="details-title">Details</h5>
                            <div id="details-content" class="mb-4">
                                <p class="text-muted text-center">
                                    Wählen Sie ein Boot oder einen Liegeplatz aus
                                </p>
                            </div>
                            <div class="d-grid gap-2">
                                <button class="btn btn-primary" id="btn-rent">Mieten</button>
                                <button class="btn btn-danger" id="btn-cancel">Kündigen</button>
                                <button class="btn btn-warning text-white" id="btn-reserve">Reservieren</button>
                                <button class="btn btn-secondary" id="btn-block">Sperren/Freigeben</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.0/js/bootstrap.bundle.min.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Kalender initialisieren
            function updateCalendar(month, year) {
                const container = document.getElementById('calendar-grid');
                container.innerHTML = '';
                
                const daysInMonth = new Date(year, month, 0).getDate();
                const firstDay = new Date(year, month - 1, 1).getDay();
                
                // Leere Zellen für die Tage vor dem ersten Tag des Monats
                for (let i = 0; i < (firstDay === 0 ? 6 : firstDay - 1); i++) {
                    const emptyDay = document.createElement('div');
                    emptyDay.className = 'calendar-day empty';
                    container.appendChild(emptyDay);
                }
                
                // Tage des Monats
                for (let i = 1; i <= daysInMonth; i++) {
                    const dayElement = document.createElement('div');
                    dayElement.className = 'calendar-day';
                    if (i === new Date().getDate() && 
                        month === new Date().getMonth() + 1 && 
                        year === new Date().getFullYear()) {
                        dayElement.classList.add('active');
                    }
                    dayElement.textContent = i;
                    dayElement.addEventListener('click', function() {
                        document.querySelectorAll('.calendar-day').forEach(d => d.classList.remove('active'));
                        this.classList.add('active');
                        updateSelectedDate(year, month, i);
                    });
                    container.appendChild(dayElement);
                }
            }

            function updateSelectedDate(year, month, day) {
    // Datum im SQL-Format YYYY-MM-DD formatieren
    const formattedDate = `${year}-${String(month).padStart(2, '0')}-${String(day).padStart(2, '0')}`;

    
/*     // Wetterdaten aktualisieren (Mock-Daten)
    let weatherData = {
        temperature: Math.floor(Math.random() * (30 - 10) + 10),
        condition: ['sunny', 'cloudy', 'rainy'][Math.floor(Math.random() * 3)],
        windSpeed: Math.floor(Math.random() * 30)
    };
    
    // Wetter-Widget aktualisieren
    const weatherWidget = document.querySelector('.weather-widget');
    let weatherIcon = 'bi-sun-fill text-warning';
    if (weatherData.condition === 'cloudy') weatherIcon = 'bi-cloud-fill text-secondary';
    if (weatherData.condition === 'rainy') weatherIcon = 'bi-cloud-rain-fill text-primary';
    
    weatherWidget.innerHTML = `
        <i class="bi ${weatherIcon}"></i>
        <span>${weatherData.temperature}°C</span>
        <span class="text-muted">|</span>
        <span>${weatherData.windSpeed} km/h</span>
    `; */
    
    console.log('Requesting berth status for date:', formattedDate); // Debug-Log

    // Liegeplatz-Status aus der Datenbank laden
    fetch(`/index.php/berth-status/${formattedDate}`)
        .then(response => {
            if (!response.ok) {
                return response.json().then(err => Promise.reject(err));
            }
            return response.json();
        })
        .then(berths => {
            berths.forEach(berth => {
                const berthElement = document.querySelector(`.berth[data-berth-number="${berth.berth_number}"]`);
                if (berthElement) {
                    berthElement.className = `berth ${berth.current_status}`;
                }
            });
        })
        .catch(error => {
            console.error('Detailed error:', error);
            alert('Fehler beim Laden der Liegeplatz-Status: ' + (error.message || 'Unbekannter Fehler'));
        });
}



// Event Listener für Kalender-Navigation
document.getElementById('month-select').addEventListener('change', function() {
    updateCalendar(parseInt(this.value), parseInt(document.getElementById('year-display').textContent));
});

document.getElementById('year-up').addEventListener('click', function() {
    const yearDisplay = document.getElementById('year-display');
    const newYear = parseInt(yearDisplay.textContent) + 1;
    yearDisplay.textContent = newYear;
    updateCalendar(parseInt(document.getElementById('month-select').value), newYear);
});

document.getElementById('year-down').addEventListener('click', function() {
    const yearDisplay = document.getElementById('year-display');
    const newYear = parseInt(yearDisplay.textContent) - 1;
    yearDisplay.textContent = newYear;
    updateCalendar(parseInt(document.getElementById('month-select').value), newYear);
});

// Boot und Liegeplatz Interaktivität
document.querySelectorAll('.berth').forEach(berth => {
    berth.addEventListener('click', function() {
        // Alle Selektierungen zurücksetzen
        document.querySelectorAll('.berth').forEach(b => b.classList.remove('selected'));
        document.querySelectorAll('.boat-card').forEach(b => b.classList.remove('selected'));
        
        // Aktuellen Liegeplatz selektieren
        this.classList.add('selected');
        
        // Details Panel aktualisieren
        const detailsTitle = document.getElementById('details-title');
        const detailsContent = document.getElementById('details-content');
        const berthStatus = this.className.match(/(?:available|occupied|reserved|blocked)/)[0];
        
        detailsTitle.textContent = `Liegeplatz ${this.dataset.berthNumber}`;
        updateDetailsPanel(this.dataset.berthNumber, berthStatus);
    });
});

document.querySelectorAll('.boat-card').forEach(boat => {
    boat.addEventListener('click', function() {
        // Alle Selektierungen zurücksetzen
        document.querySelectorAll('.boat-card').forEach(b => b.style.transform = 'translateY(0)');
        document.querySelectorAll('.berth').forEach(b => b.classList.remove('selected'));
        
        // Boot hervorheben
        this.style.transform = 'translateY(-5px)';
        
        // Details anzeigen
        updateDetailsPanel(null, 'boat', {
            id: this.dataset.boatId,
            name: this.querySelector('.boat-title').textContent
        });
    });
});

// Close the logout button if clicked outside
document.addEventListener('click', function(event) {
    const userInfo = document.querySelector('.user-info');
    const logoutButton = document.getElementById('logout-button');
    if (!userInfo.contains(event.target)) {
        logoutButton.style.display = 'none';
    }
});

function updateDetailsPanel(berthNumber, status, boatData = null) {
    const detailsContent = document.getElementById('details-content');
    const btnRent = document.getElementById('btn-rent');
    const btnCancel = document.getElementById('btn-cancel');
    const btnReserve = document.getElementById('btn-reserve');
    const btnBlock = document.getElementById('btn-block');
    
    // Alle Buttons standardmäßig deaktivieren
    [btnRent, btnCancel, btnReserve, btnBlock].forEach(btn => btn.disabled = false);
    
    let detailsHtml = '';
    
    // Liegeplatz-Details, wenn ein Liegeplatz ausgewählt ist
    if (berthNumber) {
        let statusText = '';
        switch(status) {
            case 'available': 
                statusText = 'Verfügbar';
                btnRent.disabled = false;
                btnReserve.disabled = false;
                btnBlock.disabled = false;
                break;
            case 'occupied': 
                statusText = 'Belegt';
                btnCancel.disabled = false;
                break;
            case 'reserved': 
                statusText = 'Reserviert';
                btnCancel.disabled = false;
                btnRent.disabled = false;
                break;
            case 'blocked': 
                statusText = 'Gesperrt';
                btnBlock.disabled = false;
                break;
        }
        
        detailsHtml += `
            <div class="mb-4">
                <h6>Liegeplatz Details</h6>
                <div class="row mb-2">
                    <div class="col-4">Status:</div>
                    <div class="col-8">${statusText}</div>
                </div>
                <div class="row mb-2">
                    <div class="col-4">Nummer:</div>
                    <div class="col-8">${berthNumber}</div>
                </div>
            </div>
        `;
    }
    
    // Boot-Details, wenn ein Boot ausgewählt ist
    if (boatData) {
        const boatEmoji = document.querySelector(`.boat-card[data-boat-id="${boatData.id}"] .boat-image-placeholder`).innerHTML;
        detailsHtml += `
            <div class="mb-3">
                <h6>Boot Details</h6>
                <div class="text-center mb-3">
                    <div class="boat-image-placeholder mb-2">
                        ${boatEmoji}
                    </div>
                    <strong>${boatData.name}</strong>
                </div>
                <div class="row mb-2">
                    <div class="col-4">Länge:</div>
                    <div class="col-8">${boatData.length || '12'}m</div>
                </div>
                <div class="row mb-2">
                    <div class="col-4">Tiefgang:</div>
                    <div class="col-8">${boatData.draft || '2.5'}m</div>
                </div>
                <div class="row mb-2">
                    <div class="col-4">Mieter:</div>
                    <div class="col-8">${boatData.renter || 'Max Mustermann'}</div>
                </div>
                <div class="row mb-2">
                    <div class="col-4">Mietdauer:</div>
                    <div class="col-8">${boatData.rentalPeriod || '01.10.-06.10.24'}</div>
                </div>
            </div>
        `;
    }
    
    // Wenn keine Auswahl getroffen wurde
    if (!detailsHtml) {
        detailsHtml = `
            <p class="text-muted text-center">
                Wählen Sie ein Boot oder einen Liegeplatz aus
            </p>
        `;
    }
    
    detailsContent.innerHTML = detailsHtml;
}

// Initialen Kalender anzeigen
const currentMonth = new Date().getMonth() + 1;
const currentYear = new Date().getFullYear();
updateCalendar(currentMonth, currentYear);

// Buttons Event Listener
document.getElementById('btn-rent').addEventListener('click', function() {
    alert('Vermietung wird gestartet...');
});

document.getElementById('btn-cancel').addEventListener('click', function() {
    alert('Stornierung wird eingeleitet...');
});

document.getElementById('btn-reserve').addEventListener('click', function() {
    alert('Reservierung wird erstellt...');
});

document.getElementById('btn-block').addEventListener('click', function() {
    alert('Status wird geändert...');
});
});
</script>
</body>
</html>
