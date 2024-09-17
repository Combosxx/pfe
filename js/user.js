document.addEventListener('DOMContentLoaded', () => {
    const usernameElement = document.getElementById('username');
    const shipmentsElement = document.getElementById('shipments');
    const servicesElement = document.getElementById('services');
    const userContentElement = document.getElementById('user-content');
    const driversContainer = document.getElementById('drivers-container');
    const companiesContainer = document.getElementById('companies-container');

    // Fetch the username and display it
    fetch('/api/getUserDetails.php')
        .then(response => response.json())
        .then(data => {
            usernameElement.textContent = data.username;
        });

    // Fetch and display recent shipments
    fetch('/api/getUserShipments.php')
        .then(response => response.json())
        .then(shipments => {
            shipments.forEach(shipment => {
                const shipmentCard = document.createElement('div');
                shipmentCard.className = 'shipment-card';
                shipmentCard.innerHTML = `
                    <h3>Shipment to ${shipment.endLocation}</h3>
                    <p>Status: ${shipment.status}</p>
                    <p>Estimated Delivery: ${shipment.estimatedDeliveryDate}</p>
                    <p>Cost: $${shipment.cost}</p>
                `;
                shipmentsElement.appendChild(shipmentCard);
            });
        });

    // Fetch and display available services
    fetch('/api/getAvailableServices.php')
        .then(response => response.json())
        .then(services => {
            services.forEach(service => {
                const serviceCard = document.createElement('div');
                serviceCard.className = 'service-card';
                serviceCard.innerHTML = `
                    <h3>${service.ServiceName}</h3>
                    <p>${service.Description}</p>
                `;
                servicesElement.appendChild(serviceCard);
            });
        });

    // Fetch and display user content
    fetch('/api/getUserContent.php')
        .then(response => response.json())
        .then(content => {
            content.forEach(item => {
                const contentCard = document.createElement('div');
                contentCard.className = 'content-card';
                contentCard.innerHTML = `
                    <h3>${item.Title}</h3>
                    <p>${item.Content}</p>
                    <p>Date: ${item.CreationDate}</p>
                `;
                userContentElement.appendChild(contentCard);
            });
        });

    // Fetch and display independent drivers
    fetch('/api/getDriversCompanies.php')
        .then(response => response.json())
        .then(data => {
            data.drivers.forEach(driver => {
                const driverCard = document.createElement('div');
                driverCard.className = 'card';
                driverCard.innerHTML = `
                    <img src="${driver.VehicleImage}" alt="Vehicle Image">
                    <div class="card-body">
                        <h3>${driver.FirstName} ${driver.LastName}</h3>
                        <p>Email: ${driver.Email}</p>
                        <p>Phone: ${driver.PhoneNumber}</p>
                        <p>Vehicle: ${driver.VehicleType}</p>
                        <p>License Plate: ${driver.LicensePlate}</p>
                        <p>Capacity: ${driver.Capacity} kg</p>
                    </div>
                `;
                driversContainer.appendChild(driverCard);
            });

            // Fetch and display companies
            data.companies.forEach(company => {
                const companyCard = document.createElement('div');
                companyCard.className = 'card';
                companyCard.innerHTML = `
                    <div class="card-body">
                        <h3>${company.CompanyName}</h3>
                        <p>Email: ${company.Email}</p>
                        <p>Phone: ${company.PhoneNumber}</p>
                        <p>Address: ${company.Address}</p>
                        <p>Number of Vehicles: ${company.NumVehicles}</p>
                        <p>Number of Drivers: ${company.NumDrivers}</p>
                    </div>
                `;
                companiesContainer.appendChild(companyCard);
            });
        })
        .catch(error => console.error('Error fetching data:', error));
});
