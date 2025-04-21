document.addEventListener('DOMContentLoaded', function() {
    const navLinks = document.querySelectorAll('.nav-links a, [data-page]');
    const pages = document.querySelectorAll('.page');
    
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
    }
    
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
    
    const notificationBtn = document.getElementById('notificationBtn');
    const notificationDropdown = document.getElementById('notificationDropdown');
    const markAllReadBtn = document.getElementById('markAllRead');
    
    notificationBtn.addEventListener('click', function() {
        notificationDropdown.classList.toggle('show');
    });
    
    markAllReadBtn.addEventListener('click', function() {
        document.querySelectorAll('.notification-item.unread').forEach(item => {
            item.classList.remove('unread');
        });
        document.querySelector('.notification-badge').textContent = '0';
    });
    
    window.addEventListener('click', function(e) {
        if (!e.target.closest('.user-actions')) {
            notificationDropdown.classList.remove('show');
        }
    });
    
    const detailButtons = document.querySelectorAll('.view-details');
    const requestModal = document.getElementById('requestModal');
    const closeModal = document.querySelectorAll('.close-modal');
    const confirmAccept = document.getElementById('confirmAccept');
    const saveForLater = document.getElementById('saveForLater');
    
    detailButtons.forEach(button => {
        button.addEventListener('click', function() {
            requestModal.style.display = 'flex';
        });
    });
    
    confirmAccept.addEventListener('click', function() {
        alert('You have accepted the blood request. Thank you!');
        requestModal.style.display = 'none';
    });
    
    saveForLater.addEventListener('click', function() {
        alert('Request saved to your profile for later consideration.');
        requestModal.style.display = 'none';
    });
    
    const logoutBtn = document.getElementById('logoutBtn');
    const logoutModal = document.getElementById('logoutModal');
    const confirmLogout = document.getElementById('confirmLogout');
    const cancelLogout = document.getElementById('cancelLogout');
    
    logoutBtn.addEventListener('click', function() {
        logoutModal.style.display = 'flex';
    });
    
    confirmLogout.addEventListener('click', function() {
        alert('You have been logged out. Redirecting to home page...');
        logoutModal.style.display = 'none';
        showPage('home');
    });
    
    cancelLogout.addEventListener('click', function() {
        logoutModal.style.display = 'none';
    });
    
    closeModal.forEach(button => {
        button.addEventListener('click', function() {
            requestModal.style.display = 'none';
            logoutModal.style.display = 'none';
        });
    });
    
    window.addEventListener('click', function(event) {
        if (event.target === requestModal) {
            requestModal.style.display = 'none';
        }
        if (event.target === logoutModal) {
            logoutModal.style.display = 'none';
        }
    });
    
    document.getElementById('donationForm').addEventListener('submit', function(e) {
        e.preventDefault();
        alert('Thank you! Your donation has been scheduled.');
        this.reset();
        showPage('home');
    });
    
    document.getElementById('profileForm').addEventListener('submit', function(e) {
        e.preventDefault();
        alert('Your profile has been updated!');
    });

    const acceptButtons = document.querySelectorAll('.accept-request');
    acceptButtons.forEach(button => {
        button.addEventListener('click', function() {
            const requestTitle = this.closest('.request-item').querySelector('h3').textContent;
            alert(`You've accepted the request: ${requestTitle}\nWe'll contact you with details.`);
        });
    });
    
    const filterBloodType = document.getElementById('filterBloodType');
    const filterDistance = document.getElementById('filterDistance');
    const filterUrgency = document.getElementById('filterUrgency');
    const requestsList = document.getElementById('requestsList');
    const requestItems = document.querySelectorAll('.request-item');
    
    function filterRequests() {
        const bloodTypeValue = filterBloodType.value;
        const distanceValue = filterDistance.value;
        const urgencyValue = filterUrgency.value;
        
        requestItems.forEach(item => {
            const itemType = item.getAttribute('data-type');
            const itemDistance = parseFloat(item.getAttribute('data-distance'));
            const itemUrgency = item.getAttribute('data-urgency');
            
            const typeMatch = !bloodTypeValue || itemType === bloodTypeValue;
            const distanceMatch = !distanceValue || itemDistance <= parseInt(distanceValue);
            const urgencyMatch = !urgencyValue || itemUrgency === urgencyValue;
            
            if (typeMatch && distanceMatch && urgencyMatch) {
                item.style.display = 'flex';
            } else {
                item.style.display = 'none';
            }
        });
    }
    
    [filterBloodType, filterDistance, filterUrgency].forEach(filter => {
        filter.addEventListener('change', filterRequests);
    });
    
    const prevPageBtn = document.getElementById('prevPage');
    const nextPageBtn = document.getElementById('nextPage');
    const pageIndicator = document.getElementById('pageIndicator');
    
    let currentPage = 1;
    const totalPages = 3;
    
    function updatePagination() {
        pageIndicator.textContent = `Page ${currentPage} of ${totalPages}`;
        prevPageBtn.disabled = currentPage === 1;
        nextPageBtn.disabled = currentPage === totalPages;
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
});