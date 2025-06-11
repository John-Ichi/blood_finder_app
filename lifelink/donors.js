if (window.history.replaceState) {
    window.history.replaceState(null, null, window.location.href);
}

// Login form JS
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

// Select elements
const loginForm = document.querySelector('.form-box.login');
const loginLink = document.querySelector('.form-box.signup .bottom-link a');
const signupForm = document.querySelector('.form-box.signup');
const signupLink = document.querySelector('.form-box.login .bottom-link a');
const formPopup = document.querySelector('.form-popup');
const blurOverlay = document.querySelector('.blur-bg-overlay');
const closeBtn = document.querySelector('.close-btn');

closeBtn.addEventListener('click', hidePopup); // Close popup

// Login form and popup
function showLoginForm() {
    signupForm.style.display = 'none';
    loginForm.style.display = 'flex';
}

loginLink.addEventListener('click', function(e) {
    e.preventDefault();
    showLoginForm();
});

function showSignupForm() {
    loginForm.style.display = 'none';
    signupForm.style.display = 'flex';
}

signupLink.addEventListener('click', function(e) {
    e.preventDefault();
    showSignupForm();
});

function showPopup() {
    if (formPopup && blurOverlay) {
        formPopup.style.display = 'block';
        blurOverlay.style.display = 'block';

        document.body.classList.add('no-scroll'); 
             
        formPopup.offsetHeight;  
        blurOverlay.offsetHeight;  
            
        setTimeout(() => {
            formPopup.classList.add('popup-active');
            blurOverlay.classList.add('overlay-active');
        }, 10);
    }
}

function hidePopup() {
    formPopup.classList.remove('popup-active');
    blurOverlay.classList.remove('overlay-active');

    document.body.classList.remove('no-scroll');

    setTimeout(() => {
        formPopup.style.display = 'none';
        blurOverlay.style.display = 'none';
        forgotForm.style.display = 'none';
    }, 300);
}

document.addEventListener('keydown', function(e) {
    if (e.key === 'Escape') {
        hidePopup();
    }
});

const signupFormElement = document.querySelector('.form-box.signup form');
const loginFormElement = document.querySelector('.form-box.login form');

function setupInputFields(form) {
    if (!form) return;
        
    const inputFields = form.querySelectorAll('.input-field input');
        
    inputFields.forEach(input => {
        if (input.value.trim() !== '') {
            input.classList.add('has-content');
        }
            
        input.addEventListener('focus', function() {
            const label = this.nextElementSibling;
            if (label && label.tagName === 'LABEL') {
                label.classList.add('field-active');
            }
        });
            
        input.addEventListener('blur', function() {
            const label = this.nextElementSibling;
            if (this.value.trim() === '') {
                this.classList.remove('has-content');
                if (label && label.tagName === 'LABEL') {
                    label.classList.remove('field-active');
                }
            } else {
                this.classList.add('has-content');
            }
        });
            
        input.addEventListener('input', function() {
            if (this.value.trim() !== '') {
                this.classList.add('has-content');
            } else {
                this.classList.remove('has-content');
            }
        });
    });
}

setupInputFields(loginFormElement);
setupInputFields(signupFormElement);

if (signupFormElement) {
    const emailInput = signupFormElement.querySelector('input[type="email"]');
    const passwordInput = signupFormElement.querySelector('input[name="password"]');
    const confirmPassword = signupFormElement.querySelector('input[name="confirm_password"]');
    const policyCheckbox = document.getElementById('policy');
    const submitButton = signupFormElement.querySelector('button[type="submit"]');
        
    function showErrorMessage(input, message) {
        removeErrorMessage(input);
            
        const errorMsg = document.createElement('span');
        errorMsg.classList.add('error-message');
        errorMsg.style.color = 'var(--primary)';
        errorMsg.style.fontSize = '0.8rem';
        errorMsg.style.marginTop = '5px';
        errorMsg.style.display = 'block';
        errorMsg.textContent = message;
   
        input.parentNode.appendChild(errorMsg);
        input.style.borderColor = 'var(--primary-light)';
    }
        
    function removeErrorMessage(input) {
        const existingError = input.parentNode.querySelector('.error-message');
        if (existingError) {
            existingError.remove();
        }
        input.style.borderColor = 'green';
    }
        
    emailInput.addEventListener('input', function() {
        const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
            
        if (this.value.trim() === '') {
            removeErrorMessage(this);
            this.style.borderColor = '#ddd';
        } else if (!emailRegex.test(this.value)) {
            showErrorMessage(this, 'Please enter a valid email address');
        } else {
            removeErrorMessage(this);
        }

        validateForm();
    });

    let password;
    let password_confirm;
    
    passwordInput.addEventListener('input', function() {
        password = this.value.trim();
        if (this.value.trim() === '') {
            removeErrorMessage(this);
            this.style.borderColor = '#ddd';
        } else if (this.value.length < 8) {
            showErrorMessage(this, 'Password must be at least 8 characters long');
        } else {
            removeErrorMessage(this);
        }

        if (password_confirm != password) {
            showErrorMessage(confirmPassword, "Passwords don't match");
        } else {
            removeErrorMessage(confirmPassword);
        }

        validateForm();
    });

    confirmPassword.addEventListener('input', function() {
        password_confirm = this.value.trim();
        if (this.value.trim() === '') {
            removeErrorMessage(this);
            this.style.borderColor = '#ddd';
        } else if (password_confirm != password) {
            showErrorMessage(this, "Passwords don't match");
        } else {
            removeErrorMessage(this);
        }

        validateForm();
    });

    function validateForm() {
        const emailValid = !emailInput.parentNode.querySelector('.error-message') && emailInput.value.trim() !== '';
        const passwordValid = !passwordInput.parentNode.querySelector('.error-message') && passwordInput.value.trim() !== '';
        const passwordMatch = !confirmPassword.parentNode.querySelector('.error-message') && confirmPassword.value.trim() != '';
        const policyChecked = policyCheckbox.checked;

        submitButton.disabled = !(emailValid && passwordValid && passwordMatch && policyChecked);
        submitButton.style.opacity = submitButton.disabled ? '0.5' : '1';
        submitButton.style.cursor = submitButton.disabled ? 'not-allowed' : 'pointer';
    }

    policyCheckbox.addEventListener('change', validateForm);
}

// Forgot password form
const forgotForm = document.querySelector('.form-box.forgot');
const forgotPasswordLink = document.getElementById('forgot-password-link');
const backToLoginLink = document.getElementById('back-to-login');

function showForgotForm() {
    loginForm.style.display = 'none';
    signupForm.style.display = 'none';
    forgotForm.style.display = 'flex';

    forgotForm.offsetHeight;
    forgotForm.classList.remove('hiding');
    forgotForm.classList.add('showing');
}

function hideForgotForm() {
    forgotForm.style.display = 'none';
    loginForm.style.display = 'flex';

    loginForm.offsetHeight;
    loginForm.classList.remove('hiding');
    loginForm.classList.add('showing');
}

if (forgotForm) forgotForm.style.display = 'none';

forgotPasswordLink.addEventListener('click', function(e) {
    e.preventDefault();
    showForgotForm();
});

backToLoginLink.addEventListener('click', function(e) {
    e.preventDefault();
    hideForgotForm();
});

// End of Login form JS

// Grid display of donors/blood banks JS

const donorGrid = document.getElementById('donorGrid');
const searchInput = document.getElementById('searchInput');
const clearBtn = document.getElementById('clearBtn');
const filterOptions = document.getElementById('filterOptions');

const bloodTypeFilter = document.getElementById('bloodTypeFilterValue').innerHTML.toUpperCase();

let currentSearchTerm = searchInput.value;
let currentFilter = bloodTypeFilter
if (currentFilter == '') {
    currentFilter = 'All';
}

let donors = [];

fetch('_donor_list.json')
.then(res => res.json())
.then(data => {
    if(currentFilter != 'all') {
        donors = data;
        filterOptions.querySelectorAll('.filter-btn').forEach(btn => {
            if (currentFilter == btn.innerHTML) {
                filterOptions.querySelectorAll('.filter-btn').forEach(b => b.classList.remove('active'));
                btn.classList.add('active');
                currentFilter = btn.dataset.filter;
                const filteredDonors = filterDonors();
                renderDonorCards(filteredDonors);
            }
        });
    } else {
        donors = data;
        filterOptions.querySelectorAll('.filter-btn').forEach(btn => {
            if (currentFilter == btn.innerHTML) {
                filterOptions.querySelectorAll('.filter-btn').forEach(b => b.classList.remove('active'));
                btn.classList.add('active');
                renderDonorCards(donors);
            }
        });
    }
});

function renderDonorCards(donorsToRender) {
    donorGrid.innerHTML = '';

    if (donorsToRender === null) {
        donorGrid.innerHTML = '<p class="no-results" style="text-align: center;">No donors yet.</p>';
        return;
    }
    
    if (donorsToRender.length === 0) {
        donorGrid.innerHTML = '<p class="no-results" style="text-align: center;">No donors found matching your criteria.</p>';
        return;
    }
    
    donorsToRender.forEach(donor => {
        if (donor.extraction_datetime == null) {
            donor.extraction_datetime = "No Record";
        } else {
            let timestamp = donor.extraction_datetime.slice(-8);
            if (timestamp == '00:00:00') {
                donor.extraction_datetime = donor.extraction_datetime.substring(0, 10);
            }
        }

        const donorCard = document.createElement('div');
        donorCard.className = `donor-card ${donor.available != '0' ? '' : 'unavailable'}`;
        
        donorCard.innerHTML = `
            <div class="donor-header">
                <h3 class="donor-name">${donor.donor_name}</h3>
                <span class="blood-type">${donor.blood_type}</span>
            </div>
            <div class="donor-details">
                <div class="detail-row">
                    <span class="detail-label"><i class="fas fa-map-marker-alt"></i> Location:</span>
                    <span class="detail-value">${donor.address}</span>
                </div>
                <div class="detail-row">
                    <span class="detail-label"><i class="fas fa-calendar-alt"></i> Last Donation:</span>
                    <span class="detail-value">${donor.extraction_datetime}</span>
                </div>
                <div class="detail-row">
                    <span class="detail-label"><i class="fas fa-phone"></i> Contact:</span>
                    <span class="detail-value">${donor.contact}</span>
                </div>
                ${donor.email ? `
                <div class="detail-row">
                    <span class="detail-label"><i class="fas fa-envelope"></i> Email:</span>
                    <span class="detail-value" style="max-width: 220.53px; overflow-wrap: break-word;">${donor.email}</span>
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
            donor.donor_name.toLowerCase().includes(searchTerm) ||
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

/* function bloodTypeSearch() {
    window.addEventListener('load', () => {
        filterOptions.querySelectorAll('.filter-btn').forEach(btn => {
        const bloodTypeSearchInput = document.getElementById('bloodTypeSearch').innerHTML.toUpperCase();
        if (bloodTypeSearchInput == btn.innerHTML) {
            filterOptions.querySelectorAll('.filter-btn').forEach(b => b.classList.remove('active'));
            btn.classList.add('active');
            currentFilter = btn.dataset.filter;
            const filteredDonors = filterDonors();
            renderDonorCards(filteredDonors);
        }
    });
    });
}

bloodTypeSearch(); */

// Grid display JS end