document.addEventListener('DOMContentLoaded', () => {
    const addShipmentBtn = document.getElementById('addShipmentBtn');
    const addShipmentModal = document.getElementById('addShipmentModal');
    const closeAddShipment = document.getElementById('closeAddShipment');
    const addShipmentForm = document.getElementById('addShipmentForm');
    const filterService = document.getElementById('filterService');
    const filterCompany = document.getElementById('filterCompany');
    const filterDriver = document.getElementById('filterDriver');
    const filterVehicle = document.getElementById('filterVehicle');
    const applyFilters = document.getElementById('applyFilters');
    const shipmentsTable = document.getElementById('shipmentsTable').querySelector('tbody');

    // Show add shipment modal
    addShipmentBtn.onclick = () => {
        addShipmentModal.style.display = 'flex';
    };

    // Close the modal
    closeAddShipment.onclick = () => {
        addShipmentModal.style.display = 'none';
    };

    // Apply filters
    applyFilters.onclick = async () => {
        const service = filterService.value;
        const company = filterCompany.value;
        const driver = filterDriver.value;
        const vehicle = filterVehicle.value;

        const response = await fetch('customer_dashboard_api.php', {
            method: 'POST',
            headers: { 'Content-Type': 'application/json' },
            body: JSON.stringify({ service, company, driver, vehicle })
        });

        const shipments = await response.json();
        populateShipmentsTable(shipments);
    };

    // Populate shipments table
    function populateShipmentsTable(shipments) {
        shipmentsTable.innerHTML = '';
        shipments.forEach(shipment => {
            shipmentsTable.innerHTML += `
                <tr>
                    <td>${shipment.ShipmentId}</td>
                    <td>${shipment.Service}</td>
                    <td>${shipment.CompanyOrDriver}</td>
                    <td>${shipment.Vehicle}</td>
                    <td>${shipment.StartAddress}</td>
                    <td>${shipment.EndAddress}</td>
                    <td>${shipment.Date}</td>
                    <td>${shipment.Status}</td>
                </tr>
            `;
        });
    }

    // Handle adding shipment form submission
    addShipmentForm.onsubmit = async (e) => {
        e.preventDefault();

        const formData = new FormData(addShipmentForm);
        const data = {};
        formData.forEach((value, key) => {
            data[key] = value;
        });

        const response = await fetch('add_shipment_api.php', {
            method: 'POST',
            headers: { 'Content-Type': 'application/json' },
            body: JSON.stringify(data)
        });

        const result = await response.json();
        if (result.message) {
            alert(result.message);
            addShipmentModal.style.display = 'none';
            applyFilters.click();  // Refresh shipments table
        } else {
            alert(result.error);
        }
    };
});
