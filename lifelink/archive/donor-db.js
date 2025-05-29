document.addEventListener('DOMContentLoaded', function() {
    const navLinks = document.querySelectorAll('.sidebar-links a, [data-page]');
    const pages = document.querySelectorAll('.page');
    const requestsLink = document.querySelector('[data-page="requests"]');
    
    let unreadRequests = 3;
    
    if (unreadRequests > 0) {
        addNotificationBadge(requestsLink, unreadRequests);
    }
    
    initializeNavigation();
    initializeNotifications();
    initializeRequestDetails();
    initializeModals();
    initializeRequestActions();
    initializeForms();
    initializeFilters();
    initializePagination();
    initializeDonationDetails();
    initializeDonationHistory();
    startRequestSimulation();
    
    function addNotificationBadge(element, count) {
        let badge = element.querySelector('.sidebar-notification-badge');
        
        if (count > 0) {
            if (!badge) {
                badge = document.createElement('span');
                badge.className = 'sidebar-notification-badge';
                element.appendChild(badge);
            }
            badge.textContent = count;
        } else if (badge) {
            badge.remove();
        }
    }
    
    function showPage(pageId) {
        pages.forEach(page => {
            page.classList.remove('active');
            if (page.id === `${pageId}-page`) {
                page.classList.add('active');
            }
        });
        
        navLinks.forEach(link => {
            link.classList.remove('active');
            if (link.getAttribute('data-page') === pageId) {
                link.classList.add('active');
            }
        });
        
        if (pageId === 'requests') {
            unreadRequests = 0;
            addNotificationBadge(requestsLink, unreadRequests);
        }
    }
    
    function initializeNavigation() {
        navLinks.forEach(link => {
            link.addEventListener('click', function(e) {
                e.preventDefault();
                const pageId = this.getAttribute('data-page');
                if (pageId) {
                    showPage(pageId);
                }
            });
        });
        
        showPage('home');
    }
    
    function initializeNotifications() {
        const notificationBtn = document.querySelector('.notification-btn');
        const notificationDropdown = document.querySelector('.notification-dropdown');
        
        if (notificationBtn && notificationDropdown) {
            const markAllReadBtn = document.getElementById('markAllRead');
            
            notificationBtn.addEventListener('click', function() {
                notificationDropdown.classList.toggle('show');
            });
            
            if (markAllReadBtn) {
                markAllReadBtn.addEventListener('click', function() {
                    document.querySelectorAll('.notification-item.unread').forEach(item => {
                        item.classList.remove('unread');
                    });
                    document.querySelector('.notification-badge').textContent = '0';
                });
            }
            
            window.addEventListener('click', function(e) {
                if (!e.target.closest('.user-actions')) {
                    notificationDropdown.classList.remove('show');
                }
            });
        }
    }
    
    function initializeRequestDetails() {
        const requestDetailButtons = document.querySelectorAll('#requests-page .view-details, #home-page .view-details');
        const requestModal = document.getElementById('requestModal');

        requestDetailButtons.forEach(button => {
            button.addEventListener('click', function() {
                const requestItem = this.closest('.request-item');
                const requestType = requestItem.getAttribute('data-type');
                const requestTitle = requestItem.querySelector('h3').textContent;
                const requestLocation = requestItem.querySelector('p').textContent;

                if (requestModal) {
                    const modalTitle = requestModal.querySelector('h2');
                    if (modalTitle) {
                        modalTitle.textContent = requestTitle;
                    }

                    const bloodTypeElement = requestModal.querySelector('.request-details p:nth-child(2)');
                    if (bloodTypeElement) {
                        bloodTypeElement.innerHTML = `<strong>Blood Type Needed:</strong> ${requestType}`;
                    }

                    closeAllModals();
                    requestModal.style.display = 'flex';
                }
            });
        });
    }
    
    function closeAllModals() {
        document.querySelectorAll('.modal').forEach(modal => {
            modal.style.display = 'none';
        });
    }
    
    function initializeModals() {
        // Appointment Details Modal
    const viewAppointmentDetails = document.querySelector('.view-appointment-details');
    const appointmentModal = document.getElementById('appointmentDetailsModal');

    if (viewAppointmentDetails && appointmentModal) {
    viewAppointmentDetails.addEventListener('click', function() {

        const date = document.getElementById('donationDate').value;
        const time = document.getElementById('donationTime').value;
        const center = document.getElementById('donationCenter').value;
        const bloodType = document.getElementById('bloodType').value;
        
        // Format the date
        let formattedDate = 'Not scheduled yet';
        if (date) {
            formattedDate = new Date(date).toLocaleDateString('en-US', {
                year: 'numeric',
                month: 'long',
                day: 'numeric'
            });
        }
        
        // Format time
        let formattedTime = 'Not selected yet';
        if (time) {
            const timeMap = {
                'morning': 'Morning (8am-12pm)',
                'afternoon': 'Afternoon (12pm-4pm)',
                'evening': 'Evening (4pm-8pm)'
            };
            formattedTime = timeMap[time] || time;
        }
        
        // Format location
        let formattedLocation = 'Not selected yet';
        if (center) {
            formattedLocation = document.querySelector(`#donationCenter option[value="${center}"]`).textContent;
        }
        
        // Update modal content
        document.getElementById('appointmentDate').textContent = formattedDate;
        document.getElementById('appointmentTime').textContent = formattedTime;
        document.getElementById('appointmentLocation').textContent = formattedLocation;
        document.getElementById('appointmentBloodType').textContent = bloodType || 'Not specified';
        
        closeAllModals();
        appointmentModal.style.display = 'flex';
    });
    
    // Edit Appointment button
    const editAppointment = document.getElementById('editAppointment');
    if (editAppointment) {
        editAppointment.addEventListener('click', function() {
            appointmentModal.style.display = 'none';

        });
    }
    
    // Cancel Appointment button
        const cancelAppointment = document.getElementById('cancelAppointment');
        if (cancelAppointment) {
            cancelAppointment.addEventListener('click', function() {
                if (confirm('Are you sure you want to cancel this appointment?')) {

                    document.getElementById('donationForm').reset();
                

                    const statusBadge = document.querySelector('.status-badge');
                    if (statusBadge) {
                        statusBadge.innerHTML = '<i class="fas fa-calendar-plus"></i> No Appointment Scheduled';
                        statusBadge.className = 'status-badge';
                    }
                
                    appointmentModal.style.display = 'none';
                    showToast('Appointment cancelled successfully');
                    }
                });
            }
        }


        const closeModalButtons = document.querySelectorAll('.close-modal, .modal-actions button[id^="close"]');
        closeModalButtons.forEach(button => {
            button.addEventListener('click', function(e) {
                e.preventDefault();
                const modal = this.closest('.modal');
                if (modal) {
                    modal.style.display = 'none';
                }
            });
        });
        
        window.addEventListener('click', function(event) {
            if (event.target.classList.contains('modal')) {
                event.target.style.display = 'none';
            }
        });
        
        const logoutBtn = document.getElementById('logoutBtn');
        const logoutModal = document.getElementById('logoutModal');
        
        if (logoutBtn && logoutModal) {
            const confirmLogout = document.getElementById('confirmLogout');
            const cancelLogout = document.getElementById('cancelLogout');
            
            logoutBtn.addEventListener('click', function() {
                closeAllModals();
                logoutModal.style.display = 'flex';
            });
            
            if (confirmLogout) {
                confirmLogout.addEventListener('click', function() {
                    logoutModal.style.display = 'none';
                    window.location.href = 'index.html';
                });
            }
            
            if (cancelLogout) {
                cancelLogout.addEventListener('click', function() {
                    logoutModal.style.display = 'none';
                });
            }
        }
    }
    
    function initializeRequestActions() {
    const acceptButtons = document.querySelectorAll('.accept-request');
    acceptButtons.forEach(button => {
        button.addEventListener('click', function() {
            const requestItem = this.closest('.request-item');
            const requestTitle = requestItem.querySelector('h3').textContent;
            
            this.textContent = 'Accepted';
            this.classList.remove('btn-primary');
            this.classList.add('btn-outline');
            this.disabled = true;
            
            showToast(`You've accepted the request: ${requestTitle}`, 'success');
        });
    });
    
    const confirmAccept = document.getElementById('confirmAccept');
    if (confirmAccept) {
        confirmAccept.addEventListener('click', function() {
            const requestModal = document.getElementById('requestModal');
            requestModal.style.display = 'none';
            
            const currentRequestTitle = requestModal.querySelector('h2').textContent;
            document.querySelectorAll('.request-item h3').forEach(item => {
                if (item.textContent === currentRequestTitle) {
                    const acceptBtn = item.closest('.request-item').querySelector('.accept-request');
                    if (acceptBtn) {
                        acceptBtn.textContent = 'Accepted';
                        acceptBtn.classList.remove('btn-primary');
                        acceptBtn.classList.add('btn-outline');
                        acceptBtn.disabled = true;
                    }
                }
            });
            
            showToast(`You've accepted the request: ${currentRequestTitle}`, 'success');
        });
    }
    
    const saveForLater = document.getElementById('saveForLater');
    if (saveForLater) {
        saveForLater.addEventListener('click', function() {
            document.getElementById('requestModal').style.display = 'none';
        });
    }
}
    
    function initializeForms() {
        const donationForm = document.getElementById('donationForm');
        if (donationForm) {
            donationForm.addEventListener('submit', function(e) {
                e.preventDefault();
                
                const date = this.querySelector('#donationDate').value;
                const center = this.querySelector('#donationCenter').value;
                const bloodType = this.querySelector('#bloodType').value;
                
                const formattedDate = new Date(date).toLocaleDateString('en-US', {
                    year: 'numeric',
                    month: 'long',
                    day: 'numeric'
                });
                
                const centerName = document.querySelector(`#donationCenter option[value="${center}"]`).textContent;
                            
                const historyList = document.querySelector('#profile-page .card .request-list');
                if (historyList) {
                    const newDonation = document.createElement('li');
                    newDonation.className = 'request-item';
                    newDonation.innerHTML = `
                        <div class="request-info">
                            <h3>${formattedDate}</h3>
                            <p><i class="fas fa-map-marker-alt"></i> ${centerName}</p>
                            <p><i class="fas fa-tint"></i> ${bloodType} Blood Type</p>
                            <p><i class="fas fa-calendar-check"></i> Surgery: Scheduled Donation</p>
                            <p><i class="fas fa-check-circle"></i> Scheduled</p>
                        </div>
                        <div class="request-actions">
                            <button class="btn btn-outline btn-sm view-details">Details</button>
                        </div>
                    `;
                    
                    if (historyList.firstChild) {
                        historyList.insertBefore(newDonation, historyList.firstChild);
                    } else {
                        historyList.appendChild(newDonation);
                    }
                    
                    showToast('Donation scheduled successfully!');
                }
                
                this.reset();
                const statusBadge = document.querySelector('.status-badge');
                if (statusBadge) {
                statusBadge.innerHTML = '<i class="fas fa-clock"></i> Pending Approval';
                statusBadge.className = 'status-badge status-pending';
            }
                showPage('home');
            });
        }
        
        const profileForm = document.getElementById('profileForm');
        if (profileForm) {
            profileForm.addEventListener('submit', function(e) {
                e.preventDefault();
                
                const name = this.querySelector('#fullName').value;
                
                const profileName = document.querySelector('.user-profile h3');
                
                if (profileName) profileName.textContent = name;
                
                showToast('Profile updated successfully!');
            });
        }
    }
    
    function initializeFilters() {
        const filterBloodType = document.getElementById('filterBloodType');
        const filterDistance = document.getElementById('filterDistance');
        const filterUrgency = document.getElementById('filterUrgency');
        const requestItems = document.querySelectorAll('#requests-page .request-list .request-item');
        
        // Create no-results message element for the requests page
        let noResultsMsg = document.getElementById('noResultsMsg');
        if (!noResultsMsg) {
            noResultsMsg = document.createElement('div');
            noResultsMsg.id = 'noResultsMsg';
            noResultsMsg.className = 'no-results-message';
            noResultsMsg.textContent = 'No Results Found.';
            noResultsMsg.style.display = 'none';
            const requestList = document.querySelector('#requests-page .request-list');
            if (requestList) {
                requestList.appendChild(noResultsMsg);
            }
        }
        
        function filterRequests() {
            const bloodTypeValue = filterBloodType?.value || '';
            const distanceValue = filterDistance?.value || '';
            const urgencyValue = filterUrgency?.value || '';
            
            let visibleCount = 0;
            
            requestItems.forEach(item => {
                const itemType = item.getAttribute('data-type');
                const itemDistance = parseFloat(item.getAttribute('data-distance') || '0');
                const itemUrgency = item.getAttribute('data-urgency');
                
                const typeMatch = !bloodTypeValue || itemType === bloodTypeValue;
                const distanceMatch = !distanceValue || itemDistance <= parseInt(distanceValue || '0');
                const urgencyMatch = !urgencyValue || itemUrgency === urgencyValue;
                
                if (typeMatch && distanceMatch && urgencyMatch) {
                    item.style.display = 'flex';
                    visibleCount++;
                } else {
                    item.style.display = 'none';
                }
            });
            
            const resultsCounter = document.getElementById('resultsCounter');
            if (resultsCounter) {
                resultsCounter.textContent = `Showing ${visibleCount} results`;
            }
            
            // Show/Hide no results message
            if (noResultsMsg) {
                if (visibleCount === 0) {
                    noResultsMsg.style.display = 'block';
                } else {
                    noResultsMsg.style.display = 'none';
                }
            }
        }
        
        [filterBloodType, filterDistance, filterUrgency].forEach(filter => {
            if (filter) {
                filter.addEventListener('change', filterRequests);
            }
        });
        
        const filterHistoryYear = document.getElementById('filterHistoryYear');
        const filterHistoryType = document.getElementById('filterHistoryType');
        
        // Create no-results message element for the history modal
        let noHistoryResultsMsg = document.getElementById('noHistoryResultsMsg');
        if (!noHistoryResultsMsg) {
            noHistoryResultsMsg = document.createElement('div');
            noHistoryResultsMsg.id = 'noHistoryResultsMsg';
            noHistoryResultsMsg.className = 'no-results-message';
            noHistoryResultsMsg.textContent = 'No Results Found.';
            noHistoryResultsMsg.style.display = 'none';
            const historyList = document.querySelector('#fullHistoryModal .request-list');
            if (historyList) {
                historyList.appendChild(noHistoryResultsMsg);
            }
        }
        
        function filterHistory() {
            const fullHistoryModal = document.getElementById('fullHistoryModal');
            if (!fullHistoryModal) return;
            
            const yearValue = filterHistoryYear?.value || '';
            const typeValue = filterHistoryType?.value || '';
            
            const historyItems = fullHistoryModal.querySelectorAll('.request-list .request-item');
            
            let visibleCount = 0;
            donationForm
            historyItems.forEach(item => {
                const date = item.querySelector('h3').textContent;
                const type = item.querySelectorAll('p')[1]?.textContent || '';
                
                const year = date.split(',')[1]?.trim() || '';
                
                const yearMatch = !yearValue || year === yearValue;
                let typeMatch = !typeValue;
                        
                if (typeValue) {
                    const bloodTypeText = type.toLowerCase();
                    typeMatch = bloodTypeText.includes(typeValue.toLowerCase());
                }
                
                if (yearMatch && typeMatch) {
                    item.style.display = 'flex';
                    visibleCount++;
                } else {
                    item.style.display = 'none';
                }
            });
            
            // Show/Hide no results message in history modal
            if (noHistoryResultsMsg) {
                if (visibleCount === 0) {
                    noHistoryResultsMsg.style.display = 'block';
                } else {
                    noHistoryResultsMsg.style.display = 'none';
                }
            }
        }
        
        if (filterHistoryYear) filterHistoryYear.addEventListener('change', filterHistory);
        if (filterHistoryType) filterHistoryType.addEventListener('change', filterHistory);
    }

    function initializePagination() {
        // Placeholder for pagination initialization
    }

    function initializeDonationDetails() {
        document.querySelectorAll('#profile-page .request-item .view-details').forEach(btn => {
            btn.classList.add('donation-details-btn');  
        });
        
        const donationDetailsModal = document.getElementById('donationDetailsModal');
        
        document.addEventListener('click', function(e) {
            if (e.target && (
                (e.target.classList.contains('donation-details-btn')) || 
                (e.target.closest && e.target.closest('.donation-details-btn'))
            )) {
                
                const donationItem = e.target.closest('.request-item');
                if (!donationItem) return;
                
                const requestsPage = donationItem.closest('#requests-page');
                const homePage = donationItem.closest('#home-page .urgent-requests');
                
                if (requestsPage || homePage) {
                    return;
                }
                
                const donationDate = donationItem.querySelector('h3').textContent;
                const donationLocation = donationItem.querySelector('p').textContent;
                
                const bloodTypeElement = donationItem.querySelectorAll('p')[1];
                const bloodType = bloodTypeElement ? bloodTypeElement.textContent : 'Not specified';
                
                const surgeryElement = donationItem.querySelectorAll('p')[2];
                const surgeryType = surgeryElement ? surgeryElement.textContent : 'Regular donation';
        
                if (donationDetailsModal) {
                    document.getElementById('detailDate').textContent = donationDate;
                    document.getElementById('detailLocation').textContent = donationLocation;
                    document.getElementById('detailType').textContent = bloodType;
                    document.getElementById('detailSurgery').textContent = surgeryType;
                    document.getElementById('detailNotes').textContent = "No adverse reactions reported. Donation completed successfully.";
        
                    closeAllModals();
                    donationDetailsModal.style.display = 'flex';
                }
            }
        });
        
        const closeDetailsBtn = document.getElementById('closeDetailsBtn');
        if (closeDetailsBtn) {
            closeDetailsBtn.addEventListener('click', function() {
                if (donationDetailsModal) {
                    donationDetailsModal.style.display = 'none';
                }
            });
        }
    }
    
    function initializeDonationHistory() {
        const viewFullHistoryBtn = document.getElementById('viewFullHistory');
        const fullHistoryModal = document.getElementById('fullHistoryModal');
    
        if (viewFullHistoryBtn && fullHistoryModal) {
            viewFullHistoryBtn.addEventListener('click', function() {
                closeAllModals();
                fullHistoryModal.style.display = 'flex';
                
                const historyItems = document.querySelectorAll('#profile-page .card .request-list .request-item'); 
                const historyList = fullHistoryModal.querySelector('.request-list');
                
                historyList.innerHTML = ''; 
        
                historyItems.forEach(item => {
                    const clonedItem = item.cloneNode(true);
                    
                    const detailBtn = clonedItem.querySelector('.view-details, .donation-details-btn');
                    if (detailBtn) {
                        detailBtn.className = 'btn btn-outline btn-sm view-details donation-details-btn';
                    }
                    
                    historyList.appendChild(clonedItem);
                });
                
                // Create no-results message for history if it doesn't exist after cloning
                let noHistoryResultsMsg = fullHistoryModal.querySelector('#noHistoryResultsMsg');
                if (!noHistoryResultsMsg) {
                    noHistoryResultsMsg = document.createElement('div');
                    noHistoryResultsMsg.id = 'noHistoryResultsMsg';
                    noHistoryResultsMsg.className = 'no-results-message';
                    noHistoryResultsMsg.textContent = 'No Results Found.';
                    noHistoryResultsMsg.style.display = 'none';
                    historyList.appendChild(noHistoryResultsMsg);
                }
            });
        }
        
        const closeFullHistory = document.getElementById('closeFullHistory');
        if (closeFullHistory) {
            closeFullHistory.addEventListener('click', function() {
                if (fullHistoryModal) {
                    fullHistoryModal.style.display = 'none';
                }
            });
        }
    }
    
    function startRequestSimulation() {
        let simulateNewRequestInterval;
        
        if (simulateNewRequestInterval) {
            clearInterval(simulateNewRequestInterval);
        }
        
        simulateNewRequestInterval = setInterval(() => {
            const requestsPage = document.querySelector('#requests-page');
            if (!requestsPage.classList.contains('active')) {
                unreadRequests++;
                addNotificationBadge(requestsLink, unreadRequests);
                
                showToast('New blood request received!');
            }
        }, 60000);
    }
    
    function showToast(message, type = 'success') {
    const toast = document.createElement('div');
    toast.className = `toast ${type}`;
    toast.textContent = message;
    document.body.appendChild(toast);
    
    setTimeout(() => {
        toast.classList.add('show');
        setTimeout(() => {
            toast.classList.remove('show');
            setTimeout(() => {
                toast.remove();
            }, 300);
        }, 3000);
    }, 100);
}
});