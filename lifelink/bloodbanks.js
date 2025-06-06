document.addEventListener('DOMContentLoaded', function() {
    const hamMenu = document.querySelector('.ham-menu');
    const offScreenMenu = document.querySelector('.off-screen-menu');
    
    // burger icon
    if (hamMenu && offScreenMenu) {
        hamMenu.addEventListener('click', function() {
            hamMenu.classList.toggle('active');
            offScreenMenu.classList.toggle('active');
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

    const donorGrid = document.getElementById('cardGrid');
    const searchInput = document.getElementById('searchInput');
    const searchBtn = document.getElementById('searchBtn');
    const filterOptions = document.getElementById('filterOptions');
    
    let currentSearchTerm = document.getElementById('searchInput').value;
    let currentFilter = 'all';

    let bloodbanks = [];

    fetch('_bloodbanks.json')
    .then(res => res.json())
    .then(data => {
        bloodbanks = data;
        renderDonorCards(bloodbanks);
    });

    function renderDonorCards(cardsToRender) {
        cardGrid.innerHTML = '';

        if (cardsToRender === null) {
            cardGrid.innerHTML = '<p class="no-results">No blood banks yet</p>';
        }
        
        if (cardsToRender.length === 0) {
            cardGrid.innerHTML = '<p class="no-results">No donors found matching your criteria.</p>';
            return;
        }
        
        cardsToRender.forEach(card => {
            const cardDiv = document.createElement('div');
            cardDiv.className = `card`;
            
            cardDiv.innerHTML = `
                <div class="card-header">
                    <h3 class="donor-name">${card.name}</h3>
                </div>
                <div class="card-details">
                    <div class="detail-row">
                        <span class="detail-label"><i class="fas fa-map-marker-alt"></i> Location:</span>
                        <span class="detail-value">${card.address}</span>
                    </div>
                    <div class="detail-row">
                        <span class="detail-label"><i class="fas fa-phone"></i> Contact:</span>
                        <span class="detail-value">${card.contact}</span>
                    </div>
                    <div class="detail-row">
                        <span class="detail-label"><i class="fas fa-envelope"></i> Email:</span>
                        <span class="detail-value">${card.email}</span>
                    </div>
                </div>
                <div class="card-footer">
                    <form method="GET" action="_email_blood_bank.php">
                        <input type="text" name="email" value="${card.email}" style="display: none;">
                        <button class="contact-btn" name="contactBb" value="true">
                            <i class="fas fa-comment-dots"></i> Contact via Email
                        </button>
                    </form>
                </div>
            `;
            
            cardGrid.appendChild(cardDiv);
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

    setupEventListeners();
});


/*

// card detail
<div class="detail-row">
                        <span class="detail-label"><i class="fa-solid fa-droplet"></i> Available Blood Type:</span>
                        <span class="detail-value">${donor.bloodType}</span>
                    </div>

// card footer
<span class="availability ${donor.available ? 'available' : 'unavailable'}">
                        <i class="fas ${donor.available ? 'fa-check-circle' : 'fa-clock'}"></i> 
                        ${donor.available ? 'Available for donation' : `Next eligible: ${donor.nextAvailable ?? 'N/A'}`}
                    </span>

*/