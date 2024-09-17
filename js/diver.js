document.addEventListener('DOMContentLoaded', () => {
    const driversElement = document.getElementById('drivers');

    fetch('/api/getIndependentDrivers.php')
        .then(response => response.json())
        .then(drivers => {
            drivers.forEach(driver => {
                const driverCard = document.createElement('div');
                driverCard.className = 'driver-card';
                driverCard.innerHTML = `
                    <h3>${driver.name}</h3>
                    <p>Vehicle: ${driver.vehicle}</p>
                    <p>Location: ${driver.location}</p>
                    <p>Rating: ${driver.rating}</p>
                `;
                driversElement.appendChild(driverCard);
            });
        });
});
