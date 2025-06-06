// Restart page
if (window.history.replaceState) {
    window.history.replaceState(null, null, window.location.href);
}

console.log(window.location.href);

document.addEventListener('DOMContentLoaded', function() {
    // AJAX: Check if naka login si user
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

    // Burger list
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

    /* const signupConfirm = document.getElementById('signup');
    signupConfirm.onsubmit = function(e) {
        password = document.getElementById('password').value;
        confirmPassword = document.getElementById('confirm_password').value;
        if(password != confirmPassword) {
            e.preventDefault();
            alert('passwords do not match');
        }
    }

    const signupBtn = document.getElementById('signup');
    signupBtn.onclick = function(e) {
        password = document.getElementById('password');
        confirmPassword = document.getElementById('confirm_password');
    } */

    const donorLoginBtn = document.querySelector('.donor-login-btn');
    const formPopup = document.querySelector('.form-popup');
    const blurOverlay = document.querySelector('.blur-bg-overlay');
    const closeBtn = document.querySelector('.close-btn');
    
    // Show popups: login and signup [ refactored ]
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

    donorLoginBtn.addEventListener('click', function() {
        checkLogin()
    });

    closeBtn.addEventListener('click', hidePopup);

    const signupLink = document.querySelector('.form-box.login .bottom-link a');
    const loginLink = document.querySelector('.form-box.signup .bottom-link a');
    const loginForm = document.querySelector('.form-box.login');
    const signupForm = document.querySelector('.form-box.signup');
    
    // Show signup [ refactored ]
    function showSignupForm() {
        loginForm.style.display = 'none';
        signupForm.style.display = 'flex';
    }

    function showLoginForm() {
        signupForm.style.display = 'none';
        loginForm.style.display = 'flex';
    }

    signupLink.addEventListener('click', function(e) {
        e.preventDefault();
        showSignupForm();
    });

    loginLink.addEventListener('click', function(e) {
        e.preventDefault();
        showLoginForm();
    });
    
    /* const navLinks = document.querySelectorAll('.nav-links a');
    navLinks.forEach(link => {
        link.addEventListener('click', function(e) {
            e.preventDefault();
            const target = this.getAttribute('href').replace('#', '');
            showPage(target);
        });
    }); */

    // Close popup on escape
    document.addEventListener('keydown', function(e) {
        if (e.key === 'Escape') {
            hidePopup();
        }
    });
    
    // Search
    const searchBtn = document.getElementById('searchBtn');
    searchBtn.addEventListener('click', function(e) {
        const bloodType = document.getElementById('bloodType');
        const bloodTypeValue = bloodType ? bloodType.value : '';
            
        if (!bloodTypeValue) {
            alert('Please select a blood type');
            e.preventDefault();
            return;
        }
    });

    // IDK
    const signupFormElement = document.querySelector('.form-box.signup form');
    const loginFormElement = document.querySelector('.form-box.login form');
    const forgotFormElement = document.querySelector('.form-box.forgot form');

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
    setupInputFields(forgotFormElement);

    forgotFormElement.onsubmit = function(e) {
        alert('Feature not yet implemented');
    }

    // Signup form [ refactored ]
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
});