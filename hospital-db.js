document.addEventListener('DOMContentLoaded', function() {
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

    let appointments = [
        { 
            id: 1,
            name: 'Juan Dela Cruz', 
            bloodType: 'O+', 
            date: '2025-05-15T10:00:00', 
            status: 'pending',
            units: null
        },
        { 
            id: 2,
            name: 'Maria Santos', 
            bloodType: 'A-', 
            date: '2025-05-16T14:00:00', 
            status: 'approved',
            units: null
        },
        { 
            id: 3,
            name: 'Pedro Reyes', 
            bloodType: 'B+', 
            date: '2025-05-10T09:00:00', 
            status: 'completed',
            units: 1
        }
    ];

    let donationHistory = [
        { name: 'Juan Dela Cruz', bloodType: 'O+', date: '2025-05-10', units: 1, status: 'Processed' },
        { name: 'Maria Santos', bloodType: 'A+', date: '2025-05-08', units: 1, status: 'Processed' },
        { name: 'Pedro Reyes', bloodType: 'B+', date: '2025-05-05', units: 1, status: 'Processed' },
        { name: 'Ana Lopez', bloodType: 'AB-', date: '2025-05-01', units: 1, status: 'Processed' },
        { name: 'Luis Garcia', bloodType: 'O-', date: '2025-04-28', units: 1, status: 'Processed' }
    ];

    let urgentRequests = [
        { id: 1, title: 'Emergency Surgery - Type O+', needed: '2025-05-15', quantity: 5, status: 'pending' },
        { id: 2, title: 'Cardiac Bypass - Type A-', needed: '2025-05-18', quantity: 3, status: 'pending' }
    ];

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
    
    // Blood inventory functions
    function renderInventory() {
        const tableBody = document.querySelector('.inventory-table tbody');
        if (!tableBody) return;
        
        tableBody.innerHTML = '';
        
        if (bloodInventory.length === 0) {
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
        });
    }

    // Blood type filter
    const bloodTypeFilter = document.getElementById('blood-type-filter');
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
    }
    
    // Inventory form submission
    const inventoryForm = document.getElementById('inventory-form');
    if (inventoryForm) {
        inventoryForm.addEventListener('submit', function(e) {
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
        });
    }
    
    // Appointments functions
    function renderAppointments() {
        const appointmentList = document.querySelector('.appointment-list');
        if (!appointmentList) return;
        
        appointmentList.innerHTML = '';
        
        const statusFilter = document.getElementById('appointment-status')?.value || 'all';
        const bloodTypeFilter = document.getElementById('appointment-blood-type')?.value || 'all';
        
        const filteredAppointments = appointments.filter(appointment => {
            const statusMatch = statusFilter === 'all' || appointment.status === statusFilter;
            const bloodTypeMatch = bloodTypeFilter === 'all' || appointment.bloodType === bloodTypeFilter;
            return statusMatch && bloodTypeMatch;
        });
        
        if (filteredAppointments.length === 0) {
            const noResults = document.createElement('div');
            noResults.className = 'no-results';
            noResults.textContent = 'No appointments found matching your criteria';
            appointmentList.appendChild(noResults);
            return;
        }
        
        filteredAppointments.forEach(appointment => {
            const appointmentItem = document.createElement('div');
            appointmentItem.classList.add('appointment-item', appointment.status);
            appointmentItem.dataset.id = appointment.id;
            
            let actionsHTML = '';
            if (appointment.status === 'pending') {
                actionsHTML = `
                    <button class="btn-approve" data-id="${appointment.id}">Approve</button>
                    <button class="btn-reject" data-id="${appointment.id}">Reject</button>
                `;
            } else if (appointment.status === 'approved') {
                actionsHTML = `
                    <button class="btn-complete" data-id="${appointment.id}">Mark as Completed</button>
                    <button class="btn-cancel" data-id="${appointment.id}">Cancel</button>
                `;
            }
            
            const formattedDate = formatDateTime(appointment.date);
            
            let unitsInfo = '';
            if (appointment.status === 'completed' && appointment.units) {
                unitsInfo = `<p><strong>Units Collected:</strong> ${appointment.units}</p>`;
            }
            
            appointmentItem.innerHTML = `
                <div class="appointment-info">
                    <h3>${appointment.name}</h3>
                    <p><strong>Blood Type:</strong> ${appointment.bloodType}</p>
                    <p><strong>${appointment.status === 'pending' ? 'Requested' : 
                                appointment.status === 'approved' ? 'Scheduled' : 'Donation'} Date:</strong> ${formattedDate}</p>
                    <p><strong>Status:</strong> ${capitalizeFirstLetter(appointment.status)}</p>
                    ${unitsInfo}
                </div>
                <div class="appointment-actions">
                    ${actionsHTML}
                </div>
            `;
            
            appointmentList.appendChild(appointmentItem);
        });
        
        appointmentList.querySelectorAll('button').forEach(button => {
            button.addEventListener('click', handleAppointmentAction);
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
    
    // Handle appointment actions
    function handleAppointmentAction(e) {
        const appointmentId = parseInt(this.getAttribute('data-id'));
        const appointmentIndex = appointments.findIndex(a => a.id === appointmentId);
        
        if (appointmentIndex === -1) return;
        
        const action = this.classList.contains('btn-approve') ? 'approved' :
                      this.classList.contains('btn-reject') ? 'rejected' :
                      this.classList.contains('btn-complete') ? 'completed' : 'cancelled';
        
        if (action === 'completed') {
            const appointment = appointments[appointmentIndex];
            const collectedUnits = 1;
            
            appointments[appointmentIndex].status = 'completed';
            appointments[appointmentIndex].units = collectedUnits;
            
            donationHistory.unshift({
                name: appointment.name,
                bloodType: appointment.bloodType,
                date: new Date().toISOString().split('T')[0],
                units: collectedUnits,
                status: 'Processed'
            });
            
            updateInventoryFromDonation(appointment.bloodType, collectedUnits);
            
        } else if (action === 'cancelled' || action === 'rejected') {
            appointments.splice(appointmentIndex, 1);
        } else {
            appointments[appointmentIndex].status = action;
        }
        
        renderAppointments();
        updateDashboard();
        renderDonationHistory();
        showToast(`Appointment ${capitalizeFirstLetter(action)}!`, action === 'rejected' || action === 'cancelled' ? 'error' : 'success');
    }
    
    // Update inventory from donation
    function updateInventoryFromDonation(bloodType, units) {
        const inventoryIndex = bloodInventory.findIndex(item => item.type === bloodType);
        
        if (inventoryIndex !== -1) {
            bloodInventory[inventoryIndex].units += units;
            
            if (bloodInventory[inventoryIndex].units > 15) {
                bloodInventory[inventoryIndex].status = 'Good';
            } else if (bloodInventory[inventoryIndex].units > 3) {
                bloodInventory[inventoryIndex].status = 'Low';
            }
            
        } else {
            const today = new Date();
            const expirationDate = new Date(today);
            expirationDate.setDate(today.getDate() + 42); 
            
            bloodInventory.push({
                type: bloodType,
                units: units,
                expiration: expirationDate.toISOString().split('T')[0],
                status: units <= 3 ? 'Critical' : units <= 15 ? 'Low' : 'Good'
            });
        }
        
        renderInventory();
    }
    
    // Donation history functions
    function renderDonationHistory() {
        const tableBody = document.querySelector('.history-table tbody');
        if (!tableBody) return;
        
        tableBody.innerHTML = '';
        
        const searchValue = document.getElementById('donor-search').value;
        const bloodType = document.getElementById('history-blood-type').value;
        const dateValue = document.getElementById('history-date').value;
        
        let filteredHistory = donationHistory.filter(item => {
            const nameMatch = !searchValue || item.name.toLowerCase().includes(searchValue.toLowerCase());
            const typeMatch = bloodType === 'all' || item.bloodType === bloodType;
            const dateMatch = !dateValue || item.date === dateValue;
            return nameMatch && typeMatch && dateMatch;
        });
        
        if (filteredHistory.length === 0) {
            const row = document.createElement('tr');
            row.innerHTML = `<td colspan="5" class="no-results">No donation records found</td>`;
            tableBody.appendChild(row);
            return;
        }
        
        filteredHistory.forEach(item => {
            const row = document.createElement('tr');
            row.innerHTML = `
                <td>${item.name}</td>
                <td>${item.bloodType}</td>
                <td>${formatDate(item.date)}</td>
                <td>${item.units}</td>
                <td>${item.status}</td>
            `;
            tableBody.appendChild(row);
        });
    }

    // Donation history filters
    document.getElementById('donor-search')?.addEventListener('input', renderDonationHistory);
    document.getElementById('history-blood-type')?.addEventListener('change', renderDonationHistory);
    document.getElementById('history-date')?.addEventListener('change', renderDonationHistory);
    
    // Profile form
    const profileForm = document.getElementById('profile-form');
    if (profileForm) {
        profileForm.addEventListener('submit', function(e) {
            e.preventDefault();
            showToast('Profile updated successfully!');
        });
    }
    
    // Password form
    const passwordForm = document.getElementById('password-form');
    if (passwordForm) {
        passwordForm.addEventListener('submit', function(e) {
            e.preventDefault();
            
            const currentPassword = document.getElementById('current-password').value;
            const newPassword = document.getElementById('new-password').value;
            const confirmPassword = document.getElementById('confirm-password').value;
            
            if (newPassword !== confirmPassword) {
                showToast('Passwords do not match!', 'error');
                return;
            }
            
            if (newPassword.length < 8) {
                showToast('Password must be at least 8 characters!', 'error');
                return;
            }
            
            this.reset();
            showToast('Password changed successfully!');
        });
    }
    
    // Urgent requests functions
    function setupUrgentRequests() {
        const requestContainer = document.querySelector('.content-box:first-of-type');
        if (!requestContainer) return;
        
        const existingRequests = requestContainer.querySelectorAll('.request-item');
        existingRequests.forEach(request => request.remove());
        
        const pendingRequests = urgentRequests.filter(request => request.status === 'pending');
        
        if (pendingRequests.length === 0) {
            const noResults = document.createElement('div');
            noResults.className = 'no-results';
            noResults.textContent = 'No pending urgent requests';
            requestContainer.appendChild(noResults);
            return;
        }
        
        pendingRequests.forEach(request => {
            const requestItem = document.createElement('div');
            requestItem.className = `request-item ${request.title.includes('Emergency') ? 'urgent' : ''}`;
            requestItem.dataset.id = request.id;
            
            requestItem.innerHTML = `
                <h3>${request.title}</h3>
                <p>Needed by: ${formatDate(request.needed)}</p>
                <p>Quantity: ${request.quantity} units</p>
                <div class="request-actions">
                    <button class="btn-accept" data-id="${request.id}">Accept</button>
                    <button class="btn-decline" data-id="${request.id}">Decline</button>
                </div>
            `;
            
            requestContainer.appendChild(requestItem);
        });
        
        requestContainer.querySelectorAll('.btn-accept, .btn-decline').forEach(button => {
            button.addEventListener('click', handleRequestAction);
        });
    }
    
    // Handle request actions
    function handleRequestAction() {
        const requestId = parseInt(this.getAttribute('data-id'));
        const isAccept = this.classList.contains('btn-accept');
        const requestIndex = urgentRequests.findIndex(r => r.id === requestId);
        
        if (requestIndex === -1) return;
        
        urgentRequests[requestIndex].status = isAccept ? 'accepted' : 'declined';
        
        if (isAccept) {
            const request = urgentRequests[requestIndex];
            const bloodType = request.title.split('Type ')[1];
            
            const inventoryIndex = bloodInventory.findIndex(item => item.type === bloodType);
            if (inventoryIndex !== -1) {
                bloodInventory[inventoryIndex].units -= request.quantity;
                
                if (bloodInventory[inventoryIndex].units <= 0) {
                    bloodInventory[inventoryIndex].units = 0;
                    bloodInventory[inventoryIndex].status = 'Critical';
                } else if (bloodInventory[inventoryIndex].units <= 3) {
                    bloodInventory[inventoryIndex].status = 'Critical';
                } else if (bloodInventory[inventoryIndex].units <= 15) {
                    bloodInventory[inventoryIndex].status = 'Low';
                }
            }
        }
        
        const requestItem = this.closest('.request-item');
        if (requestItem) {
            requestItem.remove();
        }
        
        const requestContainer = document.querySelector('.content-box:first-of-type');
        const remainingRequests = requestContainer.querySelectorAll('.request-item');
        if (remainingRequests.length === 0) {
            const noResults = document.createElement('div');
            noResults.className = 'no-results';
            noResults.textContent = 'No pending urgent requests';
            requestContainer.appendChild(noResults);
        }
        
        updateDashboard();
        showToast(`Request ${isAccept ? 'accepted' : 'declined'}`, isAccept ? 'success' : 'error');
    }
    
    // Dashboard functions
    function updateDashboard() {
        const totalUnits = bloodInventory.reduce((sum, item) => sum + item.units, 0);
        const criticalTypes = bloodInventory.filter(item => item.status === 'Critical');
        const pendingAppointments = appointments.filter(a => a.status === 'pending' || a.status === 'approved');
        
        document.querySelectorAll('.stat-card').forEach(card => {
            const title = card.querySelector('h3').textContent;
            
            if (title === 'Current Blood Supply') {
                card.querySelector('.stat-value').textContent = `${totalUnits} units`;
            } else if (title === 'Critical Levels') {
                card.querySelector('.stat-value').textContent = `${criticalTypes.length} types`;
                card.querySelector('.stat-info').textContent = criticalTypes.map(item => item.type).join(', ') || 'None';
            } else if (title === 'Pending Appointments') {
                card.querySelector('.stat-value').textContent = pendingAppointments.length.toString();
                card.querySelector('.stat-info').textContent = `${urgentRequests.filter(r => r.status === 'pending').length} urgent requests`;
            }
        });
        
        const recentDonationsContainer = document.querySelector('.content-box:nth-of-type(2)');
        if (recentDonationsContainer) {
            const existingDonations = recentDonationsContainer.querySelectorAll('.donation-item, .no-results');
            existingDonations.forEach(donation => donation.remove());
            
            if (donationHistory.length === 0) {
                const noResults = document.createElement('div');
                noResults.className = 'no-results';
                noResults.textContent = 'No recent donations';
                recentDonationsContainer.appendChild(noResults);
                return;
            }
            
            const recentDonations = donationHistory.slice(0, 2);
            
            recentDonations.forEach(donation => {
                const donationItem = document.createElement('div');
                donationItem.className = 'donation-item';
                
                donationItem.innerHTML = `
                    <h3>${donation.name}</h3>
                    <p>Type: ${donation.bloodType}</p>
                    <p>Date: ${formatDate(donation.date)}</p>
                    <p>Quantity: ${donation.units} unit</p>
                `;
                
                recentDonationsContainer.appendChild(donationItem);
            });
        }
    }
    
    // Logout functionality
    const logoutBtn = document.getElementById('logout-btn');
    if (logoutBtn) {
        logoutBtn.addEventListener('click', function(e) {
            e.preventDefault();
            if (confirm('Are you sure you want to logout?')) {
                window.location.href = "login.html";
            }
        });
    }
    
    // Helper functions
    function showToast(message, type = 'success') {
        let toastContainer = document.querySelector('.toast-container');
        if (!toastContainer) {
            toastContainer = document.createElement('div');
            toastContainer.className = 'toast-container';
            document.body.appendChild(toastContainer);
        }

        const toast = document.createElement('div');
        toast.className = `toast ${type}`;
        toast.textContent = message;
        toastContainer.appendChild(toast);

        setTimeout(() => {
            toast.style.opacity = '1';
            toast.style.transform = 'translateY(0)';
        }, 10);

        setTimeout(() => {
            toast.style.opacity = '0';
            toast.style.transform = 'translateY(20px)';
            setTimeout(() => {
                toastContainer.removeChild(toast);
            }, 300);
        }, 3000);
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
            month: '2-digit', 
            day: '2-digit', 
            year: 'numeric',
            hour: '2-digit',
            minute: '2-digit'
        });
    }
    
    function capitalizeFirstLetter(string) {
        return string.charAt(0).toUpperCase() + string.slice(1);
    }
    
    // Initialize the dashboard
    updateDashboard();
    setupUrgentRequests();
    renderInventory();
    renderAppointments();
    renderDonationHistory();
});