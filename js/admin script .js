document.addEventListener('DOMContentLoaded', () => {
    setupEventListeners();
    showTable('users'); // Default view
});

function setupEventListeners() {
    document.getElementById('showUsers').addEventListener('click', () => showTable('users'));
    document.getElementById('showDrivers').addEventListener('click', () => showTable('drivers'));
    document.getElementById('showCompanies').addEventListener('click', () => showTable('companies'));
    document.getElementById('showShipments').addEventListener('click', () => showTable('shipments'));

    document.getElementById('actionFilter').addEventListener('change', handleAction);
    document.getElementById('applyFilters').addEventListener('click', applyFilters);
    document.getElementById('saveRecord').addEventListener('click', saveRecord);
    document.getElementById('updateRecord').addEventListener('click', updateRecord);
    document.getElementById('confirmDelete').addEventListener('click', deleteRecord);

    document.getElementById('closeAddModal').addEventListener('click', () => document.getElementById('addModal').style.display = 'none');
    document.getElementById('closeModifyModal').addEventListener('click', () => document.getElementById('modifyModal').style.display = 'none');
    document.getElementById('closeDeleteModal').addEventListener('click', () => document.getElementById('deleteModal').style.display = 'none');
}

function showTable(table) {
    const tables = ['users', 'drivers', 'companies', 'shipments'];
    tables.forEach(tbl => document.getElementById(`${tbl}Table`)?.remove()); // Remove existing tables
    fetchData(`get${capitalize(table)}`, table);
}

function fetchData(action, tableId) {
    fetch(`api.php?action=${action}`)
        .then(response => response.json())
        .then(data => populateTable(data, tableId))
        .catch(error => console.error('Error:', error));
}

function populateTable(data, tableId) {
    const tableContainer = document.getElementById('tables');
    let tableHtml = `
        <div class="card">
            <h3>${capitalize(tableId)}</h3>
            <table id="${tableId}Table">
                <thead>
                    <tr>
                        ${generateTableHeaders(tableId)}
                    </tr>
                </thead>
                <tbody>
                    ${generateTableRows(data, tableId)}
                </tbody>
            </table>
        </div>
    `;
    tableContainer.innerHTML = tableHtml;
}

function generateTableHeaders(tableId) {
    const headers = {
        users: ['ID', 'Name', 'Email', 'Status', 'Actions'],
        drivers: ['ID', 'Name', 'Email', 'Phone', 'Service', 'Status', 'Actions'],
        companies: ['ID', 'Name', 'Email', 'Phone', 'Service', 'Status', 'Actions'],
        shipments: ['ID', 'Customer ID', 'Service', 'Date', 'Driver Type', 'Cost', 'Status', 'Actions']
    };
    return headers[tableId].map(header => `<th>${header}</th>`).join('');
}

function generateTableRows(data, tableId) {
    return data.map(record => `
        <tr>
            ${Object.values(record).map(value => `<td>${value}</td>`).join('')}
            <td>
                <button onclick="showModifyModal('${tableId}', ${record.id})">Modify</button>
                <button onclick="showDeleteModal('${tableId}', ${record.id})">Delete</button>
            </td>
        </tr>
    `).join('');
}

function handleAction() {
    const action = document.getElementById('actionFilter').value;
    const tableId = document.querySelector('.card')?.id.split('Table')[0]; // Get currently shown table
    switch (action) {
        case 'consult':
            showTable(tableId);
            break;
        case 'add':
            showAddModal();
            break;
        case 'modify':
        case 'delete':
            // Handle modify/delete actions
            break;
    }
}

function applyFilters() {
    handleAction();
}

function showAddModal() {
    document.getElementById('modalContent').innerHTML = generateForm('add');
    document.getElementById('addModal').style.display = 'block';
}

function showModifyModal(tableId, id) {
    fetch(`api.php?action=get${capitalize(tableId.slice(0, -5))}ById&id=${id}`)
        .then(response => response.json())
        .then(data => {
            document.getElementById('modalModifyContent').innerHTML = generateForm('modify', data);
            document.getElementById('modifyModal').style.display = 'block';
        })
        .catch(error => console.error('Error:', error));
}

function showDeleteModal(tableId, id) {
    document.getElementById('deleteId').value = id;
    document.getElementById('deleteModal').style.display = 'block';
}

function generateForm(action, data = {}) {
    let formHtml = '';
    const fields = {
        add: {
            users: ['name', 'email', 'status'],
            drivers: ['name', 'email', 'phone', 'service', 'status'],
            companies: ['name', 'email', 'phone', 'service', 'status'],
            shipments: ['customerId', 'service', 'date', 'driverType', 'cost', 'status']
        },
        modify: {
            users: ['name', 'email', 'status'],
            drivers: ['name', 'email', 'phone', 'service', 'status'],
            companies: ['name', 'email', 'phone', 'service', 'status'],
            shipments: ['customerId', 'service', 'date', 'driverType', 'cost', 'status']
        }
    };

    const fieldsForAction = fields[action][data.table] || [];
    
    fieldsForAction.forEach(field => {
        formHtml += `<label for="${field}">${capitalize(field)}:</label>
                     <input type="text" id="${field}" value="${data[field] || ''}">
                     <br>`;
    });

    if (action === 'modify') {
        formHtml += `<input type="hidden" id="modifyId" value="${data.id}">
                     <input type="hidden" id="modifyTable" value="${data.table}">`;
    }

    return formHtml;
}

function capitalize(string) {
    return string.charAt(0).toUpperCase() + string.slice(1);
}

function collectFormData(action) {
    const data = {};
    const fields = {
        user: ['name', 'email', 'status'],
        driver: ['name', 'email', 'phone', 'service', 'status'],
        company: ['name', 'email', 'phone', 'service', 'status'],
        shipment: ['customerId', 'service', 'date', 'driverType', 'cost', 'status']
    };

    fields[action].forEach(field => {
        data[field] = document.getElementById(`${action}${capitalize(field)}`).value;
    });

    if (action === 'modify') {
        data.id = document.getElementById('modifyId').value;
        data.table = document.getElementById('modifyTable').value;
    }

    return data;
}

function saveRecord() {
    const action = document.getElementById('actionFilter').value;
    const data = collectFormData('add');
    fetch(`api.php?action=add${capitalize(action)}`, {
        method: 'POST',
        headers: { 'Content-Type': 'application/json' },
        body: JSON.stringify(data)
    })
    .then(response => response.json())
    .then(result => {
        alert(result.message);
        closeModals();
        showTable(action.toLowerCase() + 's');
    })
    .catch(error => console.error('Error:', error));
}

function updateRecord() {
    const data = collectFormData('modify');
    fetch(`api.php?action=update${capitalize(data.table)}`, {
        method: 'POST',
        headers: { 'Content-Type': 'application/json' },
        body: JSON.stringify(data)
    })
    .then(response => response.json())
    .then(result => {
        alert(result.message);
        closeModals();
        showTable(data.table);
    })
    .catch(error => console.error('Error:', error));
}

function deleteRecord() {
    const id = document.getElementById('deleteId').value;
    const action = document.getElementById('actionFilter').value;
    fetch(`api.php?action=delete${capitalize(action)}&id=${id}`, {
        method: 'POST'
    })
    .then(response => response.json())
    .then(result => {
        alert(result.message);
        closeModals();
        showTable(action.toLowerCase() + 's');
    })
    .catch(error => console.error('Error:', error));
}

function closeModals() {
    document.getElementById('addModal').style.display = 'none';
    document.getElementById('modifyModal').style.display = 'none';
    document.getElementById('deleteModal').style.display = 'none';
}
