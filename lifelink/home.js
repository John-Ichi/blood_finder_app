document.addEventListener('DOMContentLoaded', function() {
    const hamMenu = document.querySelector('.ham-menu');
    const offScreenMenu = document.querySelector('.off-screen-menu');
    const body = document.body;
    

    if (hamMenu && offScreenMenu) {
        hamMenu.addEventListener('click', function() {
            hamMenu.classList.toggle('active');
            offScreenMenu.classList.toggle('active');
            body.classList.toggle('menu-open');
        });

        document.addEventListener('click', function(e) {
            if (!hamMenu.contains(e.target) && !offScreenMenu.contains(e.target) && offScreenMenu.classList.contains('active')) {
                hamMenu.classList.remove('active');
                offScreenMenu.classList.remove('active');
                body.classList.remove('menu-open');
            }
        });
 
        document.addEventListener('keydown', function(e) {
            if (e.key === 'Escape' && offScreenMenu.classList.contains('active')) {
                hamMenu.classList.remove('active');
                offScreenMenu.classList.remove('active');
                body.classList.remove('menu-open');
            }
        });
    } else {
        console.error('Hamburger menu or off-screen menu elements not found');
    }

    const menuItems = document.querySelectorAll('.off-screen-menu ul li');
    menuItems.forEach(item => {
        item.addEventListener('click', function() {
            hamMenu.classList.remove('active');
            offScreenMenu.classList.remove('active');
            body.classList.remove('menu-open');
            const menuText = this.textContent.trim().toLowerCase();
            
            if (menuText === 'home') {
                showPage('home');
            } else if (menuText === 'donor login') {
                showLoginForm();
                showPopup();
            }
        });
    });

    const donorLoginBtn = document.querySelector('.donor-login-btn');
    const formPopup = document.querySelector('.form-popup');
    const blurOverlay = document.querySelector('.blur-bg-overlay');
    const closeBtn = document.querySelector('.close-btn');
    
    function showPopup() {
        if (formPopup && blurOverlay) {
            formPopup.style.display = 'block';
            blurOverlay.style.display = 'block';
             
            formPopup.offsetHeight;  
            blurOverlay.offsetHeight;  
            
            setTimeout(() => {
                formPopup.classList.add('popup-active');
                blurOverlay.classList.add('overlay-active');
            }, 10);
        }
    }

    function hidePopup() {
        if (formPopup && blurOverlay) {
            formPopup.classList.remove('popup-active');
            blurOverlay.classList.remove('overlay-active');

            setTimeout(() => {
                formPopup.style.display = 'none';
                blurOverlay.style.display = 'none';
            }, 300);
        }
    }

    const signupLink = document.querySelector('.form-box.login .bottom-link a');
    const loginLink = document.querySelector('.form-box.signup .bottom-link a');
    const loginForm = document.querySelector('.form-box.login');
    const signupForm = document.querySelector('.form-box.signup');
    
    function showSignupForm() {
        if (loginForm && signupForm) {
            loginForm.classList.add('hiding');
            loginForm.classList.remove('showing');
            
            setTimeout(() => {
                loginForm.style.display = 'none';
                signupForm.style.display = 'flex';

                // Force reflow
                signupForm.offsetHeight;

                setTimeout(() => {
                    signupForm.classList.remove('hiding');
                    signupForm.classList.add('showing');
                }, 10);
            }, 300);
        }
    }

    function showLoginForm() {
        if (loginForm && signupForm) {
            if (signupForm.style.display === 'flex') {
                signupForm.classList.add('hiding');
                signupForm.classList.remove('showing');
                
                setTimeout(() => {
                    signupForm.style.display = 'none';
                    loginForm.style.display = 'flex';
                    
                    // Force reflow
                    loginForm.offsetHeight;
                    
                    setTimeout(() => {
                        loginForm.classList.remove('hiding');
                        loginForm.classList.add('showing');
                    }, 10);
                }, 300);
            } else {
                loginForm.style.display = 'flex';
                
                // Force reflow
                loginForm.offsetHeight;
                
                setTimeout(() => {
                    loginForm.classList.remove('hiding');
                    loginForm.classList.add('showing');
                }, 10);
            }
        }
    }

    if (blurOverlay) blurOverlay.style.display = 'none';
    if (formPopup) formPopup.style.display = 'none';
    if (loginForm) {
        loginForm.style.display = 'flex';
        loginForm.classList.add('showing');
    }
    if (signupForm) {
        signupForm.style.display = 'none';
        signupForm.classList.add('hiding');
    }

    if (donorLoginBtn) {
        donorLoginBtn.addEventListener('click', function(e) {
            e.preventDefault();
            showLoginForm();
            showPopup();
        });
    }

    if (closeBtn) {
        closeBtn.addEventListener('click', hidePopup);
    }

    if (signupLink) {
        signupLink.addEventListener('click', function(e) {
            e.preventDefault();
            showSignupForm();
        });
    }

    if (loginLink) {
        loginLink.addEventListener('click', function(e) {
            e.preventDefault();
            showLoginForm();
        });
    }
    
    const navLinks = document.querySelectorAll('.nav-links a');
    navLinks.forEach(link => {
        link.addEventListener('click', function(e) {
            e.preventDefault();
            const target = this.getAttribute('href').replace('#', '');
            showPage(target);
        });
    });

    document.addEventListener('keydown', function(e) {
        if (e.key === 'Escape') {
            hidePopup();
        }
    });
    
    const searchBtn = document.getElementById('searchBtn');
    if (searchBtn) {
        searchBtn.addEventListener('click', function() {
            const bloodType = document.getElementById('bloodType');
            const bloodTypeValue = bloodType ? bloodType.value : '';
            
            if (!bloodTypeValue) {
                alert('Please select a blood type');
                return;
            }
            alert('Search for blood type: ' + bloodTypeValue);
        });
    }

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
        const phoneInput = signupFormElement.querySelector('input[type="tel"]');
        const passwordInput = signupFormElement.querySelector('input[type="password"]');
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

        phoneInput.addEventListener('input', function() {
            const phoneRegex = /^\d{10}$/;
            const digitsOnly = this.value.replace(/\D/g, '');
            
            if (this.value.trim() === '') {
                removeErrorMessage(this);
                this.style.borderColor = '#ddd';
            } else if (!phoneRegex.test(digitsOnly)) {
                showErrorMessage(this, 'Please enter a valid 10-digit phone number');
            } else {
                removeErrorMessage(this);
            }
            
            validateForm();
        });
    
        passwordInput.addEventListener('input', function() {
            if (this.value.trim() === '') {
                removeErrorMessage(this);
                this.style.borderColor = '#ddd';
            } else if (this.value.length < 8) {
                showErrorMessage(this, 'Password must be at least 8 characters long');
            } else {
                removeErrorMessage(this);
            }
            
            validateForm();
        });

        function validateForm() {
            const emailValid = !emailInput.parentNode.querySelector('.error-message') && emailInput.value.trim() !== '';
            const phoneValid = !phoneInput.parentNode.querySelector('.error-message') && phoneInput.value.trim() !== '';
            const passwordValid = !passwordInput.parentNode.querySelector('.error-message') && passwordInput.value.trim() !== '';
            const policyChecked = policyCheckbox.checked;

            submitButton.disabled = !(emailValid && phoneValid && passwordValid && policyChecked);
            submitButton.style.opacity = submitButton.disabled ? '0.5' : '1';
            submitButton.style.cursor = submitButton.disabled ? 'not-allowed' : 'pointer';
        }

        policyCheckbox.addEventListener('change', validateForm);

        signupFormElement.addEventListener('submit', function(e) {
            e.preventDefault();
        
            const emailValid = !emailInput.parentNode.querySelector('.error-message') && emailInput.value.trim() !== '';
            const phoneValid = !phoneInput.parentNode.querySelector('.error-message') && phoneInput.value.trim() !== '';
            const passwordValid = !passwordInput.parentNode.querySelector('.error-message') && passwordInput.value.trim() !== '';
            const policyChecked = policyCheckbox.checked;
            
            if (emailValid && phoneValid && passwordValid && policyChecked) {
                alert('Signup successful! You can now add API code here to submit the form.');
            } else {
                alert('Please fill all fields correctly');
            }
        });
    }

    if (loginFormElement) {
        const emailInput = loginFormElement.querySelector('input[type="email"]');
        const passwordInput = loginFormElement.querySelector('input[type="password"]');
        const submitButton = loginFormElement.querySelector('button[type="submit"]');
        
        loginFormElement.addEventListener('submit', function(e) {
            e.preventDefault();
            
            if (emailInput.value.trim() !== '' && passwordInput.value.trim() !== '') {
                alert('Login successful! Redirecting...');
            } else {
                alert('Please enter your email and password');
            }
        });
    }
});

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

