const donorGrid = document.getElementById('donorGrid');
const searchInput = document.getElementById('searchInput');
const clearBtn = document.getElementById('clearBtn');
const filterOptions = document.getElementById('filterOptions');

let currentSearchTerm = document.getElementById('searchInput').value;
let currentFilter = 'all';

let donors = [];

fetch('_donor_list.json')
.then(res => res.json())
.then(data => {
    if(currentSearchTerm != "") {
        donors = data;
        const filteredDonors = filterDonors();
        renderDonorCards(filteredDonors);
    }
    else {
        donors = data;
        renderDonorCards(donors);
    }
});

function renderDonorCards(donorsToRender) {
    donorGrid.innerHTML = '';

    if (donorsToRender === null) {
        donorGrid.innerHTML = '<p class="no-results" style="text-align: center;">No donors found.</p>';
        return;
    }
    
    if (donorsToRender.length === 0) {
        donorGrid.innerHTML = '<p class="no-results" style="text-align: center;">No donors found matching your criteria.</p>';
        return;
    }
    
    donorsToRender.forEach(donor => {
        const donorCard = document.createElement('div');
        donorCard.className = `donor-card ${donor.available != '0' ? '' : 'unavailable'}`;
        
        donorCard.innerHTML = `
            <div class="donor-header">
                <h3 class="donor-name">${donor.name}</h3>
                <span class="blood-type">${donor.blood_type}</span>
            </div>
            <div class="donor-details">
                <div class="detail-row">
                    <span class="detail-label"><i class="fas fa-map-marker-alt"></i> Location:</span>
                    <span class="detail-value">${donor.address}</span>
                </div>
                <div class="detail-row">
                    <span class="detail-label"><i class="fas fa-calendar-alt"></i> Last Donation:</span>
                    <span class="detail-value">${donor.last_donation}</span>
                </div>
                <div class="detail-row">
                    <span class="detail-label"><i class="fas fa-phone"></i> Contact:</span>
                    <span class="detail-value">${donor.contact}</span>
                </div>
                ${donor.email ? `
                <div class="detail-row">
                    <span class="detail-label"><i class="fas fa-envelope"></i> Email:</span>
                    <span class="detail-value">${donor.email}</span>
                </div>` : ''}
                ${donor.donor_notes ? `
                <div class="detail-row">
                    <span class="detail-label"><i class="fas fa-info-circle"></i> Notes:</span>
                    <span class="detail-value">${donor.donor_notes}</span>
                </div>` : ''}
                
                
            </div>
            <div class="donor-footer">
                <span class="availability ${donor.available != '0' ? 'available' : 'unavailable'}">
                    <i class="fas ${donor.available != '0' ? 'fa-check-circle' : 'fa-clock'}"></i> 
                    ${donor.available != '0' ? 'Available for donation' : `Next eligible: ${donor.next_available}`}
                </span>
                <a href="request-donor.php?request=${donor.email}">
                    <button class="contact-btn" type="submit" name="request" ${donor.available != '0' ? '' : 'disabled'}>
                        <i class="fas ${donor.available != '0' ? 'fa-comment-dots' : 'fa-ban'}"></i> 
                        ${donor.available != '0' ? 'Request Donor' : 'Currently Unavailable'}
                    </button>
                </a>
            </div>
        `;

        donorGrid.appendChild(donorCard);
    });
}

function filterDonors() {
    let filteredDonors = [...donors];
    
    if (currentSearchTerm) {
        const searchTerm = currentSearchTerm.toLowerCase();
        filteredDonors = filteredDonors.filter(donor => 
            donor.name.toLowerCase().includes(searchTerm) ||
            donor.address.toLowerCase().includes(searchTerm) ||
            donor.blood_type.toLowerCase().includes(searchTerm)
        );
    }
    
    if (currentFilter !== 'all') {
        if (currentFilter === 'available') {
            filteredDonors = filteredDonors.filter(donor => donor.available != '0');
        } else {
            filteredDonors = filteredDonors.filter(donor => donor.blood_type === currentFilter);
        }
    }
    
    return filteredDonors;
}

function setupEventListeners() {
    searchInput.addEventListener('input', (e) => {
        currentSearchTerm = e.target.value;
        const filteredDonors = filterDonors();
        renderDonorCards(filteredDonors);
    });
    
    clearBtn.addEventListener('click', () => {
        document.getElementById('searchInput').value = '';
        currentSearchTerm = '';
        const filteredDonors = filterDonors();
        renderDonorCards(filteredDonors);
    });
    
    filterOptions.querySelectorAll('.filter-btn').forEach(btn => {
        btn.addEventListener('click', () => {
            filterOptions.querySelectorAll('.filter-btn').forEach(b => b.classList.remove('active'));
            btn.classList.add('active');
            currentFilter = btn.dataset.filter;
            const filteredDonors = filterDonors();
            renderDonorCards(filteredDonors);
        });
    });
}

setupEventListeners();

if (window.history.replaceState) {
    window.history.replaceState(null, null, window.location.href);
}