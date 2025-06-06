document.addEventListener('DOMContentLoaded', function() {

    // Check if logged in AJAX request
function checkLogin() {
    const xhttp = new XMLHttpRequest();
    xhttp.onreadystatechange = function() {
        if(this.readyState == 4 && this.status == 200) {
            if(this.responseText.trim() === 'loggedIn') {
                window.location.href = "donor-db.php";
            }
            else {
                showLoginForm();
                showPopup();
            }
        }    
    };
    xhttp.open("GET", "_check-login.php", true);
    xhttp.send();
}

// Burger JS
const hamMenu = document.querySelector('.ham-menu');
const offScreenMenu = document.querySelector('.off-screen-menu');
const body = document.body;

// Close burger
if (hamMenu && offScreenMenu) {
    hamMenu.addEventListener('click', function() {
        hamMenu.classList.toggle('active');
        offScreenMenu.classList.toggle('active');
        // body.classList.toggle('menu-open');
    });

    document.addEventListener('click', function(e) {
        if (!hamMenu.contains(e.target) && !offScreenMenu.contains(e.target) && offScreenMenu.classList.contains('active')) {
            hamMenu.classList.remove('active');
            offScreenMenu.classList.remove('active');
        }
    });
 
    document.addEventListener('keydown', function(e) {
        if (e.key === 'Escape' && offScreenMenu.classList.contains('active')) {
            hamMenu.classList.remove('active');
            offScreenMenu.classList.remove('active');
        }
    });
} else {
    console.error('Hamburger menu or off-screen menu elements not found');
}

// Add event listener sa burger
const menuItems = document.querySelectorAll('.off-screen-menu ul li');
menuItems.forEach(item => {
    item.addEventListener('click', function() {
        hamMenu.classList.remove('active');
        offScreenMenu.classList.remove('active');
        body.classList.remove('menu-open');
        const menuText = this.textContent.trim().toLowerCase();
            
        // Show home if home
        if (menuText === 'home') {
            if (window.location.href === "http://localhost/lifelink/home.php") {
                return;
            } else {
                window.location.href = "home.php";
            }
        } else if (menuText === 'login') { // Check login para deretso sa dashboard if may session
            checkLogin(); // Show login if login
        } else if (menuText === 'about us') {
            alert("Ceejay Cervantes, Allen Dinglas, John Ichiro Mananquil");
        } else if (menuText === 'contact') {
            alert("Insert LifeLink Team Contact");
        }
    });
});

// End of Burger JS

    // DOM element selectors
    const navLinks = document.querySelectorAll('.sidebar-links a, [data-page]');
    const pages = document.querySelectorAll('.page');
    const requestsLink = document.querySelector('[data-page="requests"]');
    
    // Notification system
    let unreadRequests = 3;
    
    // Initialize badge if needed
    if (unreadRequests > 0) {
        addNotificationBadge(requestsLink, unreadRequests);
    }
    
    // Navigation functionality
    initializeNavigation();
    
    // Initialize notifications dropdown
    initializeNotifications();
    
    // Initialize request details modal
    initializeRequestDetails();
    
    // Initialize modals
    initializeModals();
    
    // Initialize request actions
    initializeRequestActions();
    
    

    // Initialize forms
    initializeForms();
    
    // Initialize filters
    initializeFilters();
    
    // Initialize pagination
    initializePagination();
    
    // Initialize donation details
    initializeDonationDetails();
    
    // Initialize donation history
    initializeDonationHistory();
    
    // Start request simulation
    startRequestSimulation();

    showAppointmentDetails();
    
    // HELPER FUNCTIONS

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
        // Hide all pages and deactivate nav links
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
        
        // Reset requests notifications when visiting requests page
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
        
        // Show home page by default
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
            
            // Close dropdown when clicking outside
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

    function showAppointmentDetails() {
        const showBtn = document.querySelector('.view-appointment-details');
        showBtn.addEventListener('click', function() {
            let appointmentDetailsModal = document.getElementById('appointmentDetailsModal');
            appointmentDetailsModal.style.display = 'flex';
        });
    }
    
    function initializeModals() {
        // Close modal buttons
        const closeModalButtons = document.querySelectorAll('.close-modal, .modal-actions button[id^="close"]');
        closeModalButtons.forEach(button => {
            button.addEventListener('click', function(e) {
                e.preventDefault();
                const modal = this.closest('.modal') || 
                            document.querySelector('.modal.show') || 
                            document.querySelector('.modal[style*="display: flex"]');
                if (modal) {
                    modal.style.display = 'none';
                }
            });
        });
        
        // Close modal when clicking outside
        window.addEventListener('click', function(event) {
            if (event.target.classList.contains('modal')) {
                event.target.style.display = 'none';
            }
        });
        
        // Initialize logout modal
        const logoutBtn = document.getElementById('logoutBtn');
        const logoutModal = document.getElementById('logoutModal');
        
        if (logoutBtn && logoutModal) {
            const confirmLogout = document.getElementById('confirmLogout');
            const cancelLogout = document.getElementById('cancelLogout');
            
            logoutBtn.addEventListener('click', function() {
                logoutModal.style.display = 'flex';
            });
            
            if (confirmLogout) {
                confirmLogout.addEventListener('click', function() {
                    logoutModal.style.display = 'none';
                    window.location.href = '_logout.php';
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
            button.onclick = function(e) {
                let acceptForm = this.parentElement;
                if (confirm("Accept blood request?") == true) {
                    acceptForm.submit();
                } else e.preventDefault();
            }
        });

        const completeButtons = document.querySelectorAll('.complete-request');
        completeButtons.forEach(button => {
            button.onclick = function(e) {
                let completeForm = this.parentElement;
                if (confirm("Mark request as done?") == true) {
                    completeForm.submit();
                } else e.preventDefault();
            }
        });

        const declineButtons = document.querySelectorAll('.decline-request');
        declineButtons.forEach(button => {
            button.onclick = function(e) {
                let declineForm = this.parentElement;
                if (confirm("Decline request?") == true) {
                    declineForm.submit();
                } else e.preventDefault();
            }
        });

        const cancelButtons = document.querySelectorAll('.cancel-request');
        cancelButtons.forEach(button => {
            button.onclick = function(e) {
                let cancelForm = this.parentElement;
                if (confirm("Cancel request? [Please inform requester beforehand via their contact number]") == true) {
                    cancelForm.submit();
                } else e.preventDefault();
            }
        })

        const deleteButtons = document.querySelectorAll('.delete-request');
        deleteButtons.forEach(button => {
            button.onclick = function(e) {
                let deleteForm = this.parentElement;
                if (confirm("Delete request? [Note: deleting request will remove it from your history]") == true) {
                    deleteForm.submit();
                } else e.preventDefault();
            }
        });

        /* const archiveButtons = document.querySelectorAll('.archive-request');
        archiveButtons.forEach(button => {
            button.onclick = function(e) {
                let archiveForm = this.parentElement;
                if (confirm("Hide request?") == true) {
                    archiveForm.submit();
                } else e.preventDefault();
            }
        }) */
       
        /* const acceptButtons = document.querySelectorAll('.accept-request');
        acceptButtons.forEach(button => {
            button.addEventListener('click', function() {
                const requestItem = this.closest('.request-item');
                
                this.textContent = 'Accepted';
                this.classList.remove('btn-primary');
                this.classList.add('btn-outline');
                this.disabled = true;
            });
        }); */
        
        /* const confirmAccept = document.getElementById('confirmAccept');
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
            });
        } */
        
        /* const saveForLater = document.getElementById('saveForLater');
        if (saveForLater) {
            saveForLater.addEventListener('click', function() {
                document.getElementById('requestModal').style.display = 'none';
            });
        } */
    }
    
    function initializeForms() {
        /* const donationForm = document.getElementById('donationForm');
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
                    
                    // Insert at the top of the list
                    if (historyList.firstChild) {
                        historyList.insertBefore(newDonation, historyList.firstChild);
                    } else {
                        historyList.appendChild(newDonation);
                    }
                    
                    // Show a success message
                    showToast('Donation scheduled successfully!');
                }
                
                this.reset();
                showPage('home');
            });
        }
        
        /* const profileForm = document.getElementById('profileForm');
        if (profileForm) {
            profileForm.addEventListener('submit', function(e) {
                e.preventDefault();
                
                const name = this.querySelector('#fullName').value;
                const bloodType = this.querySelector('#bloodTypeProfile').value;
                
                const profileName = document.querySelector('.user-profile h3');
                const profileBloodType = document.querySelector('.user-profile p');
                
                if (profileName) profileName.textContent = name;
                if (profileBloodType) profileBloodType.textContent = bloodType + ' Blood Type';
                
                showToast('Profile updated successfully!');
            });
        } */
    }
    
    function initializeFilters() {
        // const filterBloodType = document.getElementById('filterBloodType');
        // const filterDistance = document.getElementById('filterDistance');
        const filterUrgency = document.getElementById('filterUrgency');
        const requestItems = document.querySelectorAll('#requests-page .request-list .request-item');
        
        function filterRequests() {
            // const bloodTypeValue = filterBloodType?.value || '';
            // const distanceValue = filterDistance?.value || '';
            const urgencyValue = filterUrgency?.value || '';
            
            let visibleCount = 0;
            
            requestItems.forEach(item => {
                // const itemType = item.getAttribute('data-type');
                // const itemDistance = parseFloat(item.getAttribute('data-distance') || '0');
                const itemUrgency = item.getAttribute('data-urgency');
                
                // const typeMatch = !bloodTypeValue || itemType === bloodTypeValue;
                // const distanceMatch = !distanceValue || itemDistance <= parseInt(distanceValue || '0');
                const urgencyMatch = !urgencyValue || itemUrgency === urgencyValue;
                
                if ( /* typeMatch && distanceMatch && */ urgencyMatch) {
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
        }
        
        [ /* filterBloodType, filterDistance, */ filterUrgency].forEach(filter => {
            if (filter) {
                filter.addEventListener('change', filterRequests);
            }
        });
        
        // Initialize history filters
        const filterHistoryYear = document.getElementById('filterHistoryYear');
        const filterHistoryType = document.getElementById('filterHistoryType');
        
        function filterHistory() {
            const fullHistoryModal = document.getElementById('fullHistoryModal');
            if (!fullHistoryModal) return;
            
            const yearValue = filterHistoryYear?.value || '';
            const typeValue = filterHistoryType?.value || '';
            
            const historyItems = fullHistoryModal.querySelectorAll('.request-list .request-item');
            
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
                } else {
                    item.style.display = 'none';
                }
            });
        }
        
        if (filterHistoryYear) filterHistoryYear.addEventListener('change', filterHistory);
        if (filterHistoryType) filterHistoryType.addEventListener('change', filterHistory);
    }
    
    function initializePagination() {
        const prevPageBtn = document.getElementById('prevPage');
        const nextPageBtn = document.getElementById('nextPage');
        const pageIndicator = document.getElementById('pageIndicator');
        
        if (prevPageBtn && nextPageBtn && pageIndicator) {
            let currentPage = 1;
            const totalPages = 3;
            
            function updatePagination() {
                pageIndicator.textContent = `Page ${currentPage} of ${totalPages}`;
                prevPageBtn.disabled = currentPage === 1;
                prevPageBtn.classList.toggle('btn-disabled', currentPage === 1);
                nextPageBtn.disabled = currentPage === totalPages;
                nextPageBtn.classList.toggle('btn-disabled', currentPage === totalPages);
            }
            
            prevPageBtn.addEventListener('click', function() {
                if (currentPage > 1) {
                    currentPage--;
                    updatePagination();
                }
            });
            
            nextPageBtn.addEventListener('click', function() {
                if (currentPage < totalPages) {
                    currentPage++;
                    updatePagination();
                }
            });
            
            updatePagination();
        }
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
                
                const paragraphs = donationItem.querySelectorAll('p');
                let donationType = "Whole Blood Donation";
                let surgeryType = "Standard Procedure";

                for (let p of paragraphs) {
                    const text = p.textContent;
                    if (text.includes('Blood Type')) {
                        donationType = text;
                    }
                    if (text.includes('Surgery:')) {
                        surgeryType = text.replace('Surgery:', '').trim();
                    }
                }
        
                if (donationDetailsModal) {
                    document.getElementById('detailDate').textContent = donationDate;
                    document.getElementById('detailLocation').textContent = donationLocation;
                    document.getElementById('detailType').textContent = donationType;
                    document.getElementById('detailSurgery').textContent = surgeryType;
                    document.getElementById('detailNotes').textContent = "No adverse reactions reported. Donation completed successfully.";
        
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
        }, 60000); // Every minute
    }
    
    /* function showToast(message, type = 'success') {
        const toast = document.createElement('div');
        toast.className = `toast ${type}`;
        toast.textContent = message;
        document.body.appendChild(toast);
        
        // Set toast style based on type
        if (type === 'success') {
            toast.style.backgroundColor = 'var(--accent)';
        } else if (type === 'error') {
            toast.style.backgroundColor = 'var(--primary)';
        } else if (type === 'info') {
            toast.style.backgroundColor = 'var(--dark)';
        }
        
        // Animation sequence
        setTimeout(() => {
            toast.classList.add('show');
            setTimeout(() => {
                toast.classList.remove('show');
                setTimeout(() => {
                    toast.remove();
                }, 300);
            }, 3000);
        }, 100);
    } */
});