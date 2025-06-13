// Reload
if (window.history.replaceState) {
    window.history.replaceState(null, null, window.location.href);
}

document.addEventListener('DOMContentLoaded', function() {

    // Dummy info
    let bloodInventory = [
        { type: 'O-', units: 2, expiration: '2025-06-15', status: 'Critical' },
        { type: 'O+', units: 45, expiration: '2025-07-20', status: 'Good' },
        { type: 'A-', units: 3, expiration: '2025-06-10', status: 'Critical' },
        { type: 'A+', units: 32, expiration: '2025-07-15', status: 'Good' },
        { type: 'B+', units: 28, expiration: '2025-07-18', status: 'Good' },
        { type: 'B-', units: 12, expiration: '2025-06-25', status: 'Low' },
        { type: 'AB-', units: 1, expiration: '2025-06-05', status: 'Critical' },
        { type: 'AB+', units: 18, expiration: '2025-07-22', status: 'Good' }
    ];

    let appointments = [];

    fetch('_appointments.json')
    .then(res => res.json())
    .then(data => {
        appointments = data;
    });

    let donationHistory = [];

    fetch('_blood-bank-history.json')
    .then(res => res.json())
    .then(data => {
        donationHistory = data;
        updateDashboard(); 
    });

    // Dummy info
    let urgentRequests = [
        { id: 1, title: 'Emergency Surgery - Type O+', needed: '2025-05-15', quantity: 5, status: 'pending' },
        { id: 2, title: 'Cardiac Bypass - Type A-', needed: '2025-05-18', quantity: 3, status: 'pending' }
    ];

    // Inventory button
    addToInventoryBtn = document.getElementById('addToInventory');
    addToInventoryBtn.onclick = function(e) {
        e.preventDefault();
        alert('not implemented yet');
    }

    // Navigation and UI setup
    const navLinks = document.querySelectorAll('.hospital-sidebar a');
    navLinks.forEach(link => {
        link.addEventListener('click', function(e) {
            e.preventDefault();
            
            navLinks.forEach(navLink => {
                navLink.classList.remove('active');
            });
            
            this.classList.add('active');
            
            document.querySelectorAll('.content-section').forEach(section => {
                section.classList.remove('active');
            });
                
            const sectionId = this.getAttribute('data-section');
            document.getElementById(sectionId).classList.add('active');
            
            if (sectionId === 'inventory') {
                renderInventory();
            } else if (sectionId === 'appointments') {
                renderAppointments();
            } else if (sectionId === 'donation-history') {
                renderDonationHistory();
            } else if (sectionId === 'dashboard') {
                updateDashboard();
            } else if (sectionId === 'update-inventory') {
                document.getElementById('inventory-form')?.reset();
            }
        });
    });
   
    document.addEventListener('click', function(e) {
        if (window.innerWidth <= 768 && sidebar.classList.contains('active') && 
            !e.target.closest('.sidebar') && !e.target.closest('.sidebar-toggle')) {
            sidebar.classList.remove('active');
        }
    });
    
    // Tab functionality
    const tabButtons = document.querySelectorAll('.tab-btn');
    tabButtons.forEach(button => {
        button.addEventListener('click', function() {
            tabButtons.forEach(btn => btn.classList.remove('active'));
            document.querySelectorAll('.tab-content').forEach(content => {
                content.classList.remove('active');
            });
            
            this.classList.add('active');
            const tabId = this.getAttribute('data-tab');
            document.getElementById(tabId).classList.add('active');
        });
    });
    
    // Blood inventory
    function renderInventory() {
        const tableBody = document.querySelector('.inventory-table tbody');
        if (!tableBody) return;
        
        tableBody.innerHTML = '';
        
        const row = document.createElement('tr');
        row.innerHTML = `<td colspan="4" class="no-results">not implemented yet</td>`;
        tableBody.appendChild(row);
        return;

        /* if (bloodInventory.length === 0) {
            const row = document.createElement('tr');
            row.innerHTML = `<td colspan="4" class="no-results">No blood inventory records found</td>`;
            tableBody.appendChild(row);
            return;
        }
        
        bloodInventory.forEach(item => {
            const row = document.createElement('tr');
            if (item.status === 'Critical') {
                row.classList.add('critical');
            }
            
            row.innerHTML = `
                <td>${item.type}</td>
                <td>${item.units}</td>
                <td>${formatDate(item.expiration)}</td>
                <td>${item.status}</td>
            `;
            
            tableBody.appendChild(row);
        }); */
    }

    // Blood type filter
    /* const bloodTypeFilter = document.getElementById('blood-type-filter');
    if (bloodTypeFilter) {
        bloodTypeFilter.addEventListener('change', function() {
            const selectedType = this.value;
            const rows = document.querySelectorAll('.inventory-table tbody tr');
            let hasVisibleRows = false;
            
            rows.forEach(row => {
                if (row.classList.contains('no-results')) {
                    row.style.display = 'none';
                    return;
                }
                
                const rowType = row.cells[0].textContent;
                if (selectedType === 'all' || rowType === selectedType) {
                    row.style.display = '';
                    hasVisibleRows = true;
                } else {
                    row.style.display = 'none';
                }
            });
            
            if (!hasVisibleRows) {
                const noResultsRow = document.querySelector('.inventory-table .no-results') || 
                    document.createElement('tr');
                noResultsRow.innerHTML = `<td colspan="4" class="no-results">No matching blood types found</td>`;
                noResultsRow.style.display = '';
                
                if (!document.querySelector('.inventory-table .no-results')) {
                    document.querySelector('.inventory-table tbody').appendChild(noResultsRow);
                }
            } else {
                const noResultsRow = document.querySelector('.inventory-table .no-results');
                if (noResultsRow) {
                    noResultsRow.remove();
                }
            }
        });
    } */
    
    // Inventory Form Submission [For Later]
    const inventoryForm = document.getElementById('inventory-form');
    if (inventoryForm) {
        /* inventoryForm.addEventListener('submit', function(e) {
            e.preventDefault();
            
            const bloodType = document.getElementById('blood-type').value;
            const quantity = parseInt(document.getElementById('quantity').value);
            const expiration = document.getElementById('expiration').value;
            const source = document.getElementById('source').value;
            const donorId = document.getElementById('donor-id').value;
            
            if (!bloodType || isNaN(quantity) || !expiration) {
                showToast('Please fill all required fields', 'error');
                return;
            }
            
            const existingIndex = bloodInventory.findIndex(item => item.type === bloodType);
            
            if (existingIndex !== -1) {
                bloodInventory[existingIndex].units += quantity;
                
                if (bloodInventory[existingIndex].units <= 3) {
                    bloodInventory[existingIndex].status = 'Critical';
                } else if (bloodInventory[existingIndex].units <= 15) {
                    bloodInventory[existingIndex].status = 'Low';
                } else {
                    bloodInventory[existingIndex].status = 'Good';
                }
            } else {
                let status = 'Good';
                if (quantity <= 3) {
                    status = 'Critical';
                } else if (quantity <= 15) {
                    status = 'Low';
                }
                
                bloodInventory.push({
                    type: bloodType,
                    units: quantity,
                    expiration: expiration,
                    status: status
                });
            }
            
            if (source === 'donation' && donorId) {
                const donorName = "New Donor";
                
                donationHistory.unshift({
                    name: donorName,
                    bloodType: bloodType,
                    date: new Date().toISOString().split('T')[0],
                    units: quantity,
                    status: 'Processing'
                });
            }
            
            renderInventory();
            updateDashboard();
            this.reset();
            showToast('Inventory updated successfully!');
        }); */
    }

    // Appointments functions
    function renderAppointments() {
        const hospitalName = document.getElementById('hospital-name').innerHTML;
        const appointmentList = document.querySelector('.appointment-list');
        if (!appointmentList) return;
        
        appointmentList.innerHTML = '';
        const noResults = document.createElement('div');
        noResults.className = 'no-results';

        const statusFilter = document.getElementById('appointment-status')?.value || 'all';
        const bloodTypeFilter = document.getElementById('appointment-blood-type')?.value || 'all';

        if (appointments == null) {
            noResults.textContent = 'No requests yet';
            appointmentList.appendChild(noResults);
            return;
        }
        
        const filteredAppointments = appointments.filter(appointment => {
            const statusMatch = statusFilter === 'all' || appointment.status === statusFilter;
            const bloodTypeMatch = bloodTypeFilter === 'all' || appointment.blood_type === bloodTypeFilter;
            return statusMatch && bloodTypeMatch;
        });
        
        if (filteredAppointments === null) {
            noResults.textContent = 'No requests yet';
            appointmentList.appendChild(noResults);
            return;
        }

        if (filteredAppointments.length === 0) {
            noResults.textContent = 'No appointments found matching your criteria';
            appointmentList.appendChild(noResults);
            return;
        }
        
        filteredAppointments.forEach(appointment => {
            const appointmentItem = document.createElement('div');
            appointmentItem.classList.add('appointment-item', appointment.status);
            appointmentItem.dataset.donation_id = appointment.donation_id;
            appointmentItem.dataset.hospital_id = appointment.hospital_id;
            appointmentItem.dataset.donor_id = appointment.donor_id;
            appointmentItem.dataset.donor_email = appointment.email;
            
            let actionsHTML = '';
            if (appointment.status === 'Pending') {
                actionsHTML = `
                    <button class="btn-approve" data-id="${appointment.donation_id}">Approve</button>
                    <button class="btn-reject" data-id="${appointment.donation_id}">Decline</button>
                `;
            } else if (appointment.status === 'Approved') {
                actionsHTML = `
                    <button class="btn-complete" data-id="${appointment.donation_id}">Mark as Completed</button>
                    <button class="btn-cancel" data-id="${appointment.donation_id}">Cancel</button>
                `;
            }
            
            const formattedDate = formatDate(appointment.date_of_donation);

            if (appointment.status != 'Completed') {
                appointmentItem.innerHTML = `
                    <div class="appointment-info">
                        <h3>${appointment.donor_name}</h3>
                        <p><strong>Blood Type:</strong> ${appointment.blood_type}</p>
                        <p><strong>${appointment.status === 'Pending' ? 'Requested' : 
                                    appointment.status === 'Approved' ? 'Scheduled' : 'Donation'} Date:</strong> ${formattedDate}</p>
                        <p><strong>Preferred Time:</strong> ${appointment.preferred_time}</p>
                        <p><strong>Status:</strong> ${capitalizeFirstLetter(appointment.status)}</p>
                        <p><strong>Additional Information:</strong> ${capitalizeFirstLetter(appointment.additional_info)}</p>
                    </div>
                    <div class="appointment-actions">
                        ${actionsHTML}
                    </div>
                `;

                appointmentList.appendChild(appointmentItem);
            }

            if (appointmentList.innerHTML == '') {
                noResults.textContent = 'No pending requests';
                appointmentList.appendChild(noResults);
                return;
            }

            // Confirmation modals
            acceptBtn = document.querySelectorAll('.btn-approve');
            acceptBtn.forEach(button => {
                button.onclick = function(e) {
                    e.preventDefault();

                    const modal = document.getElementById('confirmModal');
                    const name = this.closest('.appointment-item').querySelector('h3').innerHTML;
                    const id = this.closest('.appointment-item').dataset.donation_id;

                    modal.innerHTML = `
                        <div class="modal-content">
                            <span class="close-modal">&times;</span>
                            <h2>Confirm</h2>
                            <div class="confirmation-message">
                                <p>Approve appointment for <b>${name}</b>?</p>
                            </div>
                            <div class="modal-actions">
                                <form method="GET" action="_functions.php">
                                    <input type="number" name="donation_id" value="${id}" style="display: none;">
                                    <button type="submit" name="approveAppointment" value="true">Confirm</button>
                                </form>
                            </div>
                        </div>
                    `;

                    modal.style.display = 'flex';

                    modal.querySelector('.close-modal').onclick = function(e) {
                        e.preventDefault();
                        modal.style.display = 'none';
                    }
                }
            });

            declineBtn = document.querySelectorAll('.btn-reject');
            declineBtn.forEach(button => {
                button.onclick = function(e) {
                    const modal = document.getElementById('confirmModal');
                    const name = this.closest('.appointment-item').querySelector('h3').innerHTML;
                    const id = this.closest('.appointment-item').dataset.donation_id;
                    const email = this.closest('.appointment-item').dataset.donor_email;

                    modal.innerHTML = `
                        <div class="modal-content">
                            <span class="close-modal">&times;</span>
                            <h2>Confirm</h2>
                            <div class="confirmation-message">
                                <p>Cancel appointment for <b>${name}</b>?</p>
                            </div>
                            <div class="modal-actions">
                                <form method="GET" action="_functions.php">
                                    <input type="text" name="name" value="${hospitalName}" style="display: none;">
                                    <input type="text" name="email" value="${email}" style="display: none;">
                                    <input type="text" name="donation_id" value="${id}" style="display: none;">
                                    <button type="submit" name="declineAppointment" value="true">Confirm</button>
                                </form>
                            </div>
                        </div>
                    `;

                    modal.style.display = 'flex';

                    modal.querySelector('.close-modal').onclick = function(e) {
                        e.preventDefault();
                        modal.style.display = 'none';
                    }
                }
            });

            completeBtn = document.querySelectorAll('.btn-complete');
            completeBtn.forEach(button => {
                button.onclick = function(e) {
                    e.preventDefault();

                    const modal = document.getElementById('confirmModal');
                    const donation_id = this.closest('.appointment-item').dataset.donation_id;
                    const hospital_id = this.closest('.appointment-item').dataset.hospital_id;
                    const donor_id = this.closest('.appointment-item').dataset.donor_id;

                    modal.innerHTML = `
                        <div class="modal-content">
                            <span class="close-modal">&times;</span>
                            <h2>Confirm Completion</h2>
                            <div class="completion_form">
                                <p>Fill in the details of the donation</p>
                            </div>
                            <div class="modal-actions">
                                <form method="POST" action="_functions.php">
                                    <input type="text" name="donation_id" value="${donation_id}" style="display: none;">
                                    <input type="text" name="hospital_id" value="${hospital_id}" style="display: none;">
                                    <input type="text" name="donor_id" value="${donor_id}" style="display: none;">
                                    <p style="margin: 0.5rem;">Date/time of extraction:</p>
                                    <input type="datetime-local" name="extraction_datetime" step="1" required style="width: 100%;">
                                    <p style="margin: 0.5rem;">Units Extracted:</p>
                                    <input type="number" name="units" value="1" min="1" required style="width: 100%;">
                                    <p style="margin: 0.5rem;">Blood Form Factor:</p>
                                    <select name="blood_component" required style="width: 100%;">
                                        <option value="Whole Blood" selected>Whole Blood</option>
                                        <option value="Red Blood Cells">RBC</option>
                                        <option value="Platelets">Platelets</option>
                                        <option value="Plasma">Plasma</option>
                                    </select>
                                    <button type="submit" name="finalizeAppointment" style="margin-top: 1.5rem;">Submit</button>
                                </form>
                            </div>
                        </div>
                    `;
                    
                    modal.style.display = 'flex';

                    modal.querySelector('.close-modal').onclick = (e) => {
                        e.preventDefault();
                        modal.style.display = 'none';
                    }
                }
            });

            cancelBtn = document.querySelectorAll('.btn-cancel');
            cancelBtn.forEach(button => {
                button.onclick = function(e) {
                    e.preventDefault();

                    const modal = document.getElementById('confirmModal');
                    const name = this.closest('.appointment-item').querySelector('h3').innerHTML;
                    const id = this.closest('.appointment-item').dataset.donation_id;
                    const email = this.closest('.appointment-item').dataset.donor_email;

                    modal.innerHTML = `
                        <div class="modal-content">
                            <span class="close-modal">&times;</span>
                            <h2>Confirm</h2>
                            <div class="confirmation-message">
                                <p>Cancel appointment for <b>${name}</b>?</p>
                            </div>
                            <div class="modal-actions">
                                <form method="GET" action="_functions.php">
                                    <input type="text" name="name" value="${hospitalName}" style="display: none;">
                                    <input type="text" name="email" value="${email}" style="display: none;">
                                    <input type="number" name="donation_id" value="${id}" style="display: none;">
                                    <button type="submit" name="cancelAppointmentBB" value="true">Confirm</button>
                                </form>
                            </div>
                        </div>
                    `;

                    modal.style.display = 'flex';

                    modal.querySelector('.close-modal').onclick = (e) => {
                        e.preventDefault();
                        modal.style.display = 'none';
                    }
                }
            });
            
            const modal = document.getElementById('confirmModal');
            document.addEventListener('keydown', function(e) { // Close modal escape key
                if (e.key === 'Escape' && modal.style.display === 'flex') {
                    modal.style.display = 'none';
                }
            });


        });
    }
    
    // Appointment filters
    const appointmentStatusFilter = document.getElementById('appointment-status');
    const appointmentBloodTypeFilter = document.getElementById('appointment-blood-type');
    
    if (appointmentStatusFilter) {
        appointmentStatusFilter.addEventListener('change', renderAppointments);
    }
    
    if (appointmentBloodTypeFilter) {
        appointmentBloodTypeFilter.addEventListener('change', renderAppointments);
    }
    
    // Donation history functions
    function renderDonationHistory() {
        const tableBody = document.querySelector('.history-table tbody');
        if (!tableBody) return;
        
        tableBody.innerHTML = '';
        
        const searchValue = document.getElementById('donor-search').value;
        const bloodType = document.getElementById('history-blood-type').value;
        const dateValue = document.getElementById('history-date').value;

        if (donationHistory == null) {
            const row = document.createElement('tr');
            row.innerHTML = `<td colspan="5" class="no-results">No donation records found</td>`;
            tableBody.appendChild(row);
            return;
        }

        let filteredHistory = donationHistory.filter(item => {
            const nameMatch = !searchValue || item.donor_name.toLowerCase().includes(searchValue.toLowerCase());
            const typeMatch = bloodType === 'all' || item.blood_type === bloodType;
            const dateMatch = !dateValue || item.extraction_datetime.substring(0, 10) === dateValue;
            return nameMatch && typeMatch && dateMatch;
        });
        
        if (filteredHistory.length === 0) {
            const row = document.createElement('tr');
            row.innerHTML = `<td colspan="5" class="no-results">No donation records found</td>`;
            tableBody.appendChild(row);
            return;
        }
        
        filteredHistory.forEach(item => {
            if (item.hidden != 1) {
                const row = document.createElement('tr');
                row.innerHTML = `
                    <td>${item.donor_name}</td>
                    <td>${item.blood_type}</td>
                    <td>${formatDateTime(item.extraction_datetime)}</td>
                    <td>${item.component}</td>
                    <td>${item.units_collected}</td>
                    <td>
                        <form method="GET" action="_functions.php">
                            <input type="text" name="hide_history_id" value="${item.history_id}" style="display: none;">
                            <button type="submit" class="delete-record"><i class="fas fa-trash"></i></button>
                        </form>
                    </td>
                `;
                tableBody.appendChild(row);
            }

            deleteBtn = document.querySelectorAll('.delete-record');
            deleteBtn.forEach(button => {
                button.onclick = function(e) {
                    e.preventDefault();
                    if (confirm("Delete donation record?") == true) {
                        this.parentElement.submit();
                    }
                }
            });
        });

        if (tableBody.innerHTML === '') {
            const row = document.createElement('tr');
            row.innerHTML = `<td colspan="5" class="no-results">No donation records found</td>`;
            tableBody.appendChild(row);
            return;   
        }
    }

    // Donation history filters
    document.getElementById('donor-search')?.addEventListener('input', renderDonationHistory);
    document.getElementById('history-blood-type')?.addEventListener('change', renderDonationHistory);
    document.getElementById('history-date')?.addEventListener('change', renderDonationHistory);
    
    // Dashboard functions
    function updateDashboard() {
        const totalUnits = bloodInventory.reduce((sum, item) => sum + item.units, 0);
        const criticalTypes = bloodInventory.filter(item => item.status === 'Critical');

        let pendingAppointments = [];

        if (appointments != null) {
            pendingAppointments = appointments.filter(a => a.status === 'Pending' || a.status === 'Approved');
        }
        
        document.querySelectorAll('.stat-card').forEach(card => {
            const title = card.querySelector('h3').textContent;
            
            if (title === 'Current Blood Supply') {
                card.querySelector('.stat-value').textContent = `${totalUnits} units`;
            } else if (title === 'Critical Levels') {
                card.querySelector('.stat-value').textContent = `${criticalTypes.length} types`;
                card.querySelector('.stat-info').textContent = `not implemented yet`;/* criticalTypes.map(item => item.type).join(', ') || 'None'; */
            } else if (title === 'Pending Appointments') {
                card.querySelector('.stat-value').textContent = pendingAppointments.length.toString();
                card.querySelector('.stat-info').textContent = `${pendingAppointments.filter(r => r.status === 'Approved').length} approved request`;
            }
        });
        
        const recentDonationsContainer = document.querySelector('.content-box:nth-of-type(2)');
        if (recentDonationsContainer) {
            if (donationHistory == null || filteredDonationHistory.length == 0) {
                const noResults = document.createElement('div');
                noResults.className = 'no-results';
                noResults.textContent = 'no recent donations';
                recentDonationsContainer.appendChild(noResults);
                return;
            }

            const filteredDonationHistory = donationHistory.filter(a => a.hidden === '0');
            const recentDonations = donationHistory.slice(0, 2);
            
            var count = 0;

            recentDonations.forEach(donation => {
                if (count < 1) {
                    if (donation.hidden != 1) {
                        const donationItem = document.createElement('div');
                        donationItem.className = 'donation-item';
                        
                        donationItem.innerHTML = `
                            <h3>${donation.donor_name}</h3>
                            <p>Type: ${donation.blood_type}</p>
                            <p>Date: ${formatDateTime(donation.extraction_datetime)}</p>
                            <p>Component Extracted: ${donation.component}</p>
                            <p>Quantity: ${donation.units_collected} unit(s)</p>
                        `;
                        
                        recentDonationsContainer.appendChild(donationItem);
                        count++;
                    }
                }
            });
        }
    }
    
    // Logout functionality
    const logoutBtn = document.getElementById('logout-btn');
    const logoutModal = document.getElementById('logoutModal');
    const confirmLogout = document.getElementById('confirmLogout');
    const cancelLogout = document.getElementById('cancelLogout');
    const closeModal = document.querySelector('.close-modal');

    if (logoutBtn && logoutModal) {

        logoutBtn.addEventListener('click', function(e) {
        e.preventDefault();
        logoutModal.style.display = 'flex';
        });

        if (confirmLogout) {
            confirmLogout.addEventListener('click', function() {
                logoutModal.style.display = 'none';
                this.parentElement.submit();
            });
        }

        if (cancelLogout) {
            cancelLogout.addEventListener('click', function(e) {
                e.preventDefault();
                logoutModal.style.display = 'none';
            });
        }

        if (closeModal) {
            closeModal.addEventListener('click', function() {
                logoutModal.style.display = 'none';
            });
        }

        logoutModal.addEventListener('click', function(e) {
            if (e.target === logoutModal) {
                logoutModal.style.display = 'none';
            }
        });

        document.addEventListener('keydown', function(e) {
            if (e.key === 'Escape' && logoutModal.style.display === 'flex') {
                logoutModal.style.display = 'none';
            }
        });
    }
    
    function formatDate(dateString) {
        if (!dateString) return 'N/A';
        const date = new Date(dateString);
        return date.toLocaleDateString('en-US', { month: '2-digit', day: '2-digit', year: 'numeric' });
    }
    
    function formatDateTime(dateTimeString) {
        if (!dateTimeString) return 'N/A';
        const date = new Date(dateTimeString);
        return date.toLocaleDateString('en-US', { 
            month: 'long', 
            day: '2-digit', 
            year: 'numeric',
            hour: '2-digit',
            minute: '2-digit',
            second: '2-digit'
        });
    }
    
    function capitalizeFirstLetter(string) {
        return string.charAt(0).toUpperCase() + string.slice(1);
    }
    
    renderInventory();
    renderAppointments();
    renderDonationHistory();
});