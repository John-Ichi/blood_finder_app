document.addEventListener('DOMContentLoaded', function() {
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

    const cardGrid = document.getElementById('cardGrid');
    const searchInput = document.getElementById('searchInput');
    const clearBtn = document.getElementById('clearBtn');
    
    let currentSearchTerm = document.getElementById('searchInput').value;

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
            cardGrid.innerHTML = '<p class="no-results">No blood banks found matching your criteria.</p>';
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

    function filterBloodBanks() {
        let filteredBloodBanks = [...bloodbanks];
        
        if (currentSearchTerm) {
            const searchTerm = currentSearchTerm.toLowerCase();
            filteredBloodBanks = filteredBloodBanks.filter(bloodbank => 
                bloodbank.name.toLowerCase().includes(searchTerm) ||
                bloodbank.address.toLowerCase().includes(searchTerm)
            );
        }
        
        return filteredBloodBanks;
    }

    function setupEventListeners() {
        searchInput.addEventListener('input', (e) => {
            currentSearchTerm = e.target.value;
            const filteredBloodBanks = filterBloodBanks();
            renderDonorCards(filteredBloodBanks);
        });

        clearBtn.addEventListener('click', () => {
            document.getElementById('searchInput').value = '';
            currentSearchTerm = '';
            const filteredBloodBanks = filterBloodBanks();
            renderDonorCards(filteredBloodBanks);
        });
    }

    setupEventListeners();
});