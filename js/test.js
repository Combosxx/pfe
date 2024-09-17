document.addEventListener('DOMContentLoaded', () => {
    const usernameElement = document.getElementById('username');
    const shipmentsElement = document.getElementById('shipments');
    const servicesElement = document.getElementById('services');
    const userContentElement = document.getElementById('user-content');

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
                shipmentCard.className = 'card';
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
                serviceCard.className = 'card';
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
                contentCard.className = 'card';
                contentCard.innerHTML = `
                    <h3>${item.Title}</h3>
                    <p>${item.Content}</p>
                    <p>Date: ${item.CreationDate}</p>
                `;
                userContentElement.appendChild(contentCard);
            });
        });
});
