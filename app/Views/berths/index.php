<!-- application/views/berths/index.php -->
<div class="container mx-auto px-4 py-6">
    <!-- Berth Grid -->
    <div class="grid grid-cols-4 gap-4 mb-6">
        <?php foreach ($berths as $berth): ?>
            <div class="relative bg-white p-4 rounded-lg shadow hover:shadow-md transition-shadow cursor-pointer <?= getBerthStatusClass($berth['status']) ?>"
                 onclick="showBerthDetails(<?= $berth['id'] ?>)">
                <h3 class="font-bold text-lg mb-2">Liegeplatz <?= $berth['berth_number'] ?></h3>
                <div class="text-sm">
                    <p>Status: <?= translateStatus($berth['status']) ?></p>
                    <p>Preis/Tag: <?= number_format($berth['price_per_day'], 2) ?>€</p>
                </div>
            </div>
        <?php endforeach; ?>
    </div>

    <!-- Legend -->
    <div class="bg-white p-4 rounded-lg shadow mb-6">
        <h3 class="font-bold mb-2">Legende</h3>
        <div class="grid grid-cols-4 gap-4">
            <div class="flex items-center space-x-2">
                <div class="w-4 h-4 rounded-full bg-green-200"></div>
                <span>Verfügbar</span>
            </div>
            <div class="flex items-center space-x-2">
                <div class="w-4 h-4 rounded-full bg-red-200"></div>
                <span>Belegt</span>
            </div>
            <div class="flex items-center space-x-2">
                <div class="w-4 h-4 rounded-full bg-yellow-200"></div>
                <span>Reserviert</span>
            </div>
            <div class="flex items-center space-x-2">
                <div class="w-4 h-4 rounded-full bg-gray-200"></div>
                <span>Gesperrt</span>
            </div>
        </div>
    </div>

    <!-- Rented Boats -->
    <div class="bg-white p-4 rounded-lg shadow">
        <h3 class="font-bold mb-4">Gemietete Boote</h3>
        <div class="grid grid-cols-3 gap-4">
            <?php foreach ($rentedBoats as $boat): ?>
                <div class="border p-4 rounded-lg">
                    <h4 class="font-bold">Boot #<?= $boat['id'] ?></h4>
                    <p class="text-sm"><?= $boat['name'] ?></p>
                    <p class="text-sm"><?= $boat['type'] ?></p>
                </div>
            <?php endforeach; ?>
        </div>
    </div>
</div>

<!-- Berth Details Modal -->
<div id="berthDetailsModal" class="hidden fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center">
    <div class="bg-white rounded-lg p-6 max-w-md w-full mx-4">
        <h2 class="text-xl font-bold mb-4">Boot Details</h2>
        <div id="berthDetailsContent">
            <!-- Dynamically filled via JavaScript -->
        </div>
        <div class="mt-4 space-y-2">
            <button onclick="rentBerth()" class="w-full bg-blue-600 text-white py-2 rounded hover:bg-blue-700">Mieten</button>
            <button onclick="cancelRental()" class="w-full bg-red-600 text-white py-2 rounded hover:bg-red-700">Kündigen</button>
            <button onclick="reserveBerth()" class="w-full bg-yellow-600 text-white py-2 rounded hover:bg-yellow-700">Reservieren</button>
            <button onclick="toggleBerthStatus()" class="w-full bg-gray-600 text-white py-2 rounded hover:bg-gray-700">Sperren/Freigeben</button>
        </div>
    </div>
</div>

<script>
function getBerthStatusClass(status) {
    const classes = {
        'frei': 'bg-green-100',
        'belegt': 'bg-red-100',
        'reserviert': 'bg-yellow-100',
        'gesperrt': 'bg-gray-100'
    };
    return classes[status] || 'bg-white';
}

function translateStatus(status) {
    const translations = {
        'frei': 'Verfügbar',
        'belegt': 'Belegt',
        'reserviert': 'Reserviert',
        'gesperrt': 'Gesperrt'
    };
    return translations[status] || status;
}

function showBerthDetails(berthId) {
    fetch(`<?= site_url('berths/details/') ?>${berthId}`)
        .then(response => response.json())
        .then(data => {
            document.getElementById('berthDetailsContent').innerHTML = `
                <p><strong>Name:</strong> ${data.boat?.name || '-'}</p>
                <p><strong>Länge:</strong> ${data.boat?.length || '-'}m</p>
                <p><strong>Tiefgang:</strong> ${data.boat?.draft || '-'}m</p>
                <p><strong>Mieter:</strong> ${data.user?.vorname || '-'}</p>
                <p><strong>Mietdauer:</strong> ${data.rental?.start_date || '-'} - ${data.rental?.end_date || '-'}</p>
            `;
            document.getElementById('berthDetailsModal').classList.remove('hidden');
        });
}

// Close modal when clicking outside
document.getElementById('berthDetailsModal').addEventListener('click', (e) => {
    if (e.target === e.currentTarget) {
        e.target.classList.add('hidden');
    }
});
</script>