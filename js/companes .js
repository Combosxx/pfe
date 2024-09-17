document.addEventListener('DOMContentLoaded', function () {
    // Handle company modal operations
    const addCompanyBtn = document.getElementById('addCompanyBtn');
    const addCompanyModal = document.getElementById('addCompanyModal');
    const closeAddCompany = document.getElementById('closeAddCompany');
    const addCompanyForm = document.getElementById('addCompanyForm');
    const companyList = document.getElementById('companyList');

    addCompanyBtn.onclick = () => {
        addCompanyModal.style.display = 'flex';
    };

    closeAddCompany.onclick = () => {
        addCompanyModal.style.display = 'none';
    };

    window.onclick = (event) => {
        if (event.target == addCompanyModal) {
            addCompanyModal.style.display = 'none';
        }
    };

    addCompanyForm.onsubmit = async (event) => {
        event.preventDefault();
        const formData = new FormData(addCompanyForm);
        const data = {};
        formData.forEach((value, key) => (data[key] = value));

        try {
            const response = await fetch('company_api.php', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                },
                body: JSON.stringify(data),
            });
            const result = await response.json();
            if (result.message) {
                alert(result.message);
                addCompanyModal.style.display = 'none';
                loadCompanies();
            } else {
                alert(result.error);
            }
        } catch (error) {
            console.error('Error:', error);
        }
    };

    async function loadCompanies() {
        try {
            const response = await fetch('company_api.php');
            const companies = await response.json();
            companyList.innerHTML = '';
            companies.forEach(company => {
                companyList.innerHTML += `
                    <div>
                        <h3>${company.CompanyName}</h3>
                        <p>${company.Address}</p>
                        <p>${company.Email}</p>
                        <p>${company.PhoneNumber}</p>
                    </div>
                `;
            });
        } catch (error) {
            console.error('Error:', error);
        }
    }

    loadCompanies();

    // Handle pricing updates
    const servicesList = document.getElementById("servicesList");
    const pricingForm = document.getElementById("pricingForm");
    const priceUpdateMessage = document.getElementById("priceUpdateMessage");

    // Populate the services list
    const services = [
        { id: 1, name: "Air Freight" },
        { id: 2, name: "Sea Freight" },
        { id: 3, name: "Road Freight" },
        { id: 4, name: "House Moving" },
        { id: 5, name: "Personal Driver" }
    ];

    services.forEach(service => {
        const li = document.createElement("li");
        li.textContent = service.name;
        servicesList.appendChild(li);
    });

    // Handle the pricing form submission
    pricingForm.addEventListener("submit", async function (e) {
        e.preventDefault();

        const userType = document.getElementById("userType").value;
        const userId = document.getElementById("userId").value;
        const serviceId = document.getElementById("serviceSelect").value;
        const pricePerHour = document.getElementById("pricePerHour").value;
        const pricePerTrip = document.getElementById("pricePerTrip").value;

        try {
            const response = await fetch('updatePricing.php', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json'
                },
                body: JSON.stringify({
                    userType: userType,
                    userId: userId,
                    serviceId: serviceId,
                    pricePerHour: pricePerHour,
                    pricePerTrip: pricePerTrip
                })
            });

            const data = await response.json();
            if (data.status === "success") {
                priceUpdateMessage.textContent = "Pricing updated successfully!";
                priceUpdateMessage.style.display = "block";
            } else {
                alert("Error updating pricing. Please try again.");
            }
        } catch (error) {
            console.error('Error:', error);
        }
    });
});
//handle the shipmnet table 
document.addEventListener('DOMContentLoaded', function () {
    const shipmentTable = document.getElementById('shipmentTable');
    
    async function fetchShipments() {
        try {
            const userId = getLoggedInUserId(); // Function to get logged-in user's ID
            const response = await fetch(`get_shipments.php?userId=${userId}`);
            const shipments = await response.json();
            shipmentTable.innerHTML = '';
            shipments.forEach(shipment => {
                shipmentTable.innerHTML += `
                    <tr>
                        <td>${shipment.ShipmentId}</td>
                        <td>${shipment.Customer}</td>
                        <td>${shipment.Service}</td>
                        <td>${shipment.Status}</td>
                        <td>${new Date(shipment.EstimatedDeliveryDate).toLocaleDateString()}</td>
                    </tr>
                `;
            });
        } catch (error) {
            console.error('Error fetching shipments:', error);
        }
    }

    function getLoggedInUserId() {
        // Replace with actual logic to get logged-in user ID
        return 1; // Example static user ID
    }

    fetchShipments();
});
document.addEventListener('DOMContentLoaded', function () {
    const profileForm = document.getElementById('profileForm');
    const updateMessage = document.getElementById('updateMessage');

    // Fetch and populate profile information
    async function loadProfile() {
        try {
            const response = await fetch('getCompanyProfile.php');
            const data = await response.json();

            if (data) {
                document.getElementById('companyName').value = data.companyName;
                document.getElementById('email').value = data.email;
                document.getElementById('phoneNumber').value = data.phoneNumber;
                document.getElementById('address').value = data.address;
                document.getElementById('bankName').value = data.bankName;
                document.getElementById('rib').value = data.rib;
                document.getElementById('profileImg').src = data.profileImage;
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
            const response = await fetch('updateCompanyProfile.php', {
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
