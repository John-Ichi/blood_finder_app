const donors = [
    {
        id: 1,
        name: "Juan Dela Cruz",
        bloodType: "A+",
        location: "Manila, Metro Manila",
        lastDonation: "November 15, 2023",
        contact: "0917 123 4567",
        email: "juan.delacruz@gmail.com",
        available: true
    },
    {
        id: 2,
        name: "Pedro Penduko",
        bloodType: "B-",
        location: "Quezon City, Metro Manila (near SM North EDSA)",
        lastDonation: "December 22, 2022",
        contact: "0918 987 6543 / 02-8123 4567",
        email: "pedro.penduko@gmail.com",
        notes: "Available weekends only. Preferred contact method: text message first.",
        available: true
    },
    {
        id: 3,
        name: "Enteng Kabisote",
        bloodType: "O+",
        location: "Cebu City, Cebu",
        lastDonation: "January 10, 2024",
        contact: "0919 555 1234",
        email: "enteng.kabisote@gmail.com",
        available: false,
        nextAvailable: "March 5, 2024"
    },
    {
        id: 4,
        name: "Neneng B.",
        bloodType: "AB+",
        location: "Davao City",
        lastDonation: "September 5, 2023",
        contact: "0916 789 0123",
        available: true
    },
    {
        id: 5,
        name: "Cash G.",
        bloodType: "A-",
        location: "Baguio City, Benguet",
        lastDonation: "December 18, 2023",
        contact: "0915 456 7890",
        notes: "Regular donor at Baguio General Hospital blood bank",
        available: false,
        nextAvailable: "April 30, 2024"
    },
    {
        id: 6,
        name: "Koya Wel",
        bloodType: "O-",
        location: "Makati City, Metro Manila",
        lastDonation: "August 28, 2023",
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
                <span class="blood-type">${donor.bloodType}</span>
            </div>
            <div class="donor-details">
                <div class="detail-row">
                    <span class="detail-label"><i class="fas fa-map-marker-alt"></i> Location:</span>
                    <span class="detail-value">${donor.location}</span>
                </div>
                <div class="detail-row">
                    <span class="detail-label"><i class="fas fa-calendar-alt"></i> Last Donation:</span>
                    <span class="detail-value">${donor.lastDonation}</span>
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
                    ${donor.available ? 'Contact Donor' : 'Currently Unavailable'}
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
            filteredDonors = filteredDonors.filter(donor => donor.bloodType === currentFilter);
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