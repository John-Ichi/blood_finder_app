const donors = [
    {
        id: 1,
        name: "Philippine General Hospital",
        bloodType: "A+, O+, B+",
        location: "Manila, Metro Manila",
        contact: "0917 123 4567",
        email: "PGH@gmail.com",
        available: true
    },
    {
        id: 2,
        name: "Phillipine-Korean Hospital",
        bloodType: "B-, B+, A+, A-",
        location: "Quezon City, Metro Manila (near SM North EDSA)",
        contact: "0918 987 6543 / 02-8123 4567",
        email: "Ph-love-korea@gmail.com",
        notes: "Available weekends only. Preferred contact method: text message first.",
        available: true
    },
    {
        id: 3,
        name: "Medicare",
        bloodType: "O+",
        location: "Cebu City, Cebu",
        contact: "0919 555 1234",
        email: "Medicare@gmail.com",
        available: true,
    },
    {
        id: 4,
        name: "San Lorenzo Ruiz Hospital",
        bloodType: "AB+",
        email: "San-Darating@gmail.com",
        contact: "0916 789 0123",
        available: true
    },
    {
        id: 5,
        name: "MedEx Hospital",
        bloodType: "A-",
        location: "Baguio City, Benguet",
        contact: "0915 456 7890",
        notes: "Available on weekdays only",
        available: true,
    },
    {
        id: 6,
        name : "Gentri Hospital",
        bloodType: "O-",
        location: "General Trias, Cavite",
        email: "gentrinamo@gmail.com",
        contact: "0917 777 8888",
        availability: "Weekdays after 6pm, Weekends all day",
        available: true
    }
];

const donorGrid = document.getElementById('donorGrid');
const searchInput = document.getElementById('searchInput');
const searchBtn = document.getElementById('searchBtn');
const filterOptions = document.getElementById('filterOptions');
let currentFilter = 'all';
let currentSearchTerm = '';

function init() {
    renderDonorCards(donors);
    setupEventListeners();
}

function renderDonorCards(donorsToRender) {
    donorGrid.innerHTML = '';
    
    if (donorsToRender.length === 0) {
        donorGrid.innerHTML = '<p class="no-results">No donors found matching your criteria.</p>';
        return;
    }
    
    donorsToRender.forEach(donor => {
        const donorCard = document.createElement('div');
        donorCard.className = `donor-card ${donor.available ? '' : 'unavailable'}`;
        
        donorCard.innerHTML = `
            <div class="donor-header">
                <h3 class="donor-name">${donor.name}</h3>
            </div>
            <div class="donor-details">
                <div class="detail-row">
                    <span class="detail-label"><i class="fas fa-map-marker-alt"></i> Location:</span>
                    <span class="detail-value">${donor.location}</span>
                </div>
                <div class="detail-row">
                    <span class="detail-label"><i class="fa-solid fa-droplet"></i> Available Blood Type:</span>
                    <span class="detail-value">${donor.bloodType}</span>
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
                ${donor.notes ? `
                <div class="detail-row">
                    <span class="detail-label"><i class="fas fa-info-circle"></i> Notes:</span>
                    <span class="detail-value">${donor.notes}</span>
                </div>` : ''}
                ${donor.availability ? `
                <div class="detail-row">
                    <span class="detail-label"><i class="fas fa-clock"></i> Availability:</span>
                    <span class="detail-value">${donor.availability}</span>
                </div>` : ''}
            </div>
            <div class="donor-footer">
                <span class="availability ${donor.available ? 'available' : 'unavailable'}">
                    <i class="fas ${donor.available ? 'fa-check-circle' : 'fa-clock'}"></i> 
                    ${donor.available ? 'Available for donation' : `Next eligible: ${donor.nextAvailable}`}
                </span>
                <button class="contact-btn" ${donor.available ? '' : 'disabled'}>
                    <i class="fas ${donor.available ? 'fa-comment-dots' : 'fa-ban'}"></i> 
                    ${donor.available ? 'Contact Blood Bank' : 'Currently Unavailable'}
                </button>
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
            donor.location.toLowerCase().includes(searchTerm) ||
            donor.bloodType.toLowerCase().includes(searchTerm)
        );
    }
    
    if (currentFilter !== 'all') {
        if (currentFilter === 'available') {
            filteredDonors = filteredDonors.filter(donor => donor.available);
        } else {
            filteredDonors = filteredDonors.filter(donor => {
                const bloodTypes = donor.bloodType.split(',').map(type => type.trim());
                return bloodTypes.includes(currentFilter);
            });
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
    
    searchBtn.addEventListener('click', () => {
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

init();