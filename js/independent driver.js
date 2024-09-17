window.onload = function() {
    const servicesList = document.getElementById("servicesList");
    const shipmentTable = document.getElementById("shipmentTable");
    const driverId = 1; // This should be dynamically set based on the logged-in driver

    // Populate the services list for the driver
    const services = [
        { id: 1, name: "Personal Driver" },
        { id: 2, name: "House Moving" }
    ];

    services.forEach(service => {
        const li = document.createElement("li");
        li.textContent = service.name;
        servicesList.appendChild(li);
    });

    // Load the shipments for the driver
    fetch(`getDriverShipments.php?driverId=${driverId}`)
    .then(response => response.json())
    .then(data => {
        shipmentTable.innerHTML = '';
        data.forEach(shipment => {
            const row = document.createElement("tr");
            row.innerHTML = `
                <td>${shipment.ShipmentId}</td>
                <td>${shipment.CustomerName}</td>
                <td>${shipment.ServiceName}</td>
                <td>${shipment.Status}</td>
                <td>${shipment.Date}</td>
            `;
            shipmentTable.appendChild(row);
        });
    })
    .catch(error => console.error('Error:', error));

    // Handle the pricing form submission
    document.getElementById("pricingForm").addEventListener("submit", function(e) {
        e.preventDefault();

        const serviceId = document.getElementById("serviceSelect").value;
        const pricePerHour = document.getElementById("pricePerHour").value;
        const pricePerTrip = document.getElementById("pricePerTrip").value;

        // Make an AJAX request to update the pricing for the selected service
        fetch('updateDriverPricing.php', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json'
            },
            body: JSON.stringify({
                serviceId: serviceId,
                pricePerHour: pricePerHour,
                pricePerTrip: pricePerTrip
            })
        })
        .then(response => response.json())
        .then(data => {
            if (data.status === "success") {
                document.getElementById("priceUpdateMessage").style.display = "block";
            } else {
                alert("Error updating pricing. Please try again.");
            }
        })
        .catch(error => console.error('Error:', error));
    });
};
document.addEventListener('DOMContentLoaded', function () {
    const profileForm = document.getElementById('profileForm');
    const updateMessage = document.getElementById('updateMessage');
    const vehicleSelect = document.getElementById('vehicleId');

    // Fetch and populate profile information and vehicle options
    async function loadProfile() {
        try {
            const response = await fetch('getProfile.php');
            const data = await response.json();

            if (data) {
                document.getElementById('firstName').value = data.firstName;
                document.getElementById('lastName').value = data.lastName;
                document.getElementById('email').value = data.email;
                document.getElementById('phoneNumber').value = data.phoneNumber;
                document.getElementById('bankName').value = data.bankName;
                document.getElementById('rib').value = data.rib;
                document.getElementById('profileImg').src = data.profileImage;

                // Populate vehicle select options
                data.vehicles.forEach(vehicle => {
                    const option = document.createElement('option');
                    option.value = vehicle.VehicleId;
                    option.textContent = `${vehicle.VehicleType} (${vehicle.LicensePlate})`;
                    vehicleSelect.appendChild(option);
                });

                // Set selected vehicle
                vehicleSelect.value = data.vehicleId;
            }
        } catch (error) {
            console.error('Error loading profile:', error);
        }
    }

    loadProfile();

    // Handle form submission
    profileForm.addEventListener('submit', async function (e) {
        e.preventDefault();

        const formData = new FormData(profileForm);
        const data = {};
        formData.forEach((value, key) => (data[key] = value));

        try {
            const response = await fetch('updateProfile.php', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                },
                body: JSON.stringify(data),
            });

            const result = await response.json();
            if (result.status === 'success') {
                updateMessage.style.display = 'block';
            } else {
                alert('Error updating profile. Please try again.');
            }
        } catch (error) {
            console.error('Error:', error);
        }
    });
});
