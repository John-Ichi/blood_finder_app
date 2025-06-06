// restart page
if (window.history.replaceState) {
    window.history.replaceState(null, null, window.location.href);
}

// initialize burger
const hamMenu = document.querySelector('.ham-menu');
const offScreenMenu = document.querySelector('.off-screen-menu');
const body = document.body;

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

const menuItems = document.querySelectorAll('.off-screen-menu ul li');
menuItems.forEach(item => {
    item.addEventListener('click', function() {
        hamMenu.classList.remove('active');
        offScreenMenu.classList.remove('active');
        const menuText = this.textContent.trim().toLowerCase();
            
        if (menuText === 'home') {
            window.location.href = "home.php"; // home
        } else if (menuText === 'login') { // check login para deretso sa dashboard if may session
            checkLogin(); // show login if login
        } else if (menuText === 'logout') {
            window.location.href = "_logout.php"; // logout
        }
    });
});

const nextButton = document.querySelector('.btn-next');
const prevButton = document.querySelector('.btn-prev');
const steps = document.querySelectorAll('.step');
const formSteps = document.querySelectorAll('.form-step'); 

const nameField = document.getElementById('name');
const bloodTypeField = document.getElementById('bloodtype');
const contactField = document.getElementById('contact');
const provinceField = document.getElementById('province');
const municipalityField = document.getElementById('municipality');

let active = 1; // step number

// next button
nextButton.addEventListener('click', () => {
    if (active == 1) { // step number 1
        if (!nameField.value) { // check if empty
            alert('Please enter your name');
        } else {
            active++;
            if (active > steps.length) {
                active = steps.length;
                console.log(active);
            }
            updateProgress(); // go to step 2
        }
    } else if (active == 2) { // step 2
        if (bloodTypeField.value == '') { // check if empty
            alert('Please select a blood type');
        } else {
            active++;
            if (active > steps.length) {
                active = steps.length;
            }
            updateProgress(); // go to step 3
        }
    } else if (active == 3) { // step 3
        contactNumber = contactField.value;
        firstDigit = contactNumber.charAt(0); // get first digit
        secondDigit = contactNumber.charAt(1); // get second digit
        
        if (!contactNumber) { // check if empty
            alert('Please enter your phone number');
        } else if (firstDigit != '0' || secondDigit != '9' || contactNumber.length != 11) { // validate phone number [starts in 09]
            alert('Please enter a valid 11-digit number');
        } else {
            active++;
            if (active > steps.length) {
                active = steps.length;
            }
            updateProgress();
        }
    }
});

prevButton.addEventListener('click', () => { // prev button
    active--;
    if (active < 1) {
        active = 1;
    }
    updateProgress();
});

const submitButton = document.querySelector('.btn-submit');

submitButton.addEventListener('click', (e) => { // submit
    if (active == 4) { // step 4
        if (!provinceField.value) { // check if empty
            alert('Please enter your province');
            e.preventDefault(); // prevent submit
        } else if (!municipalityField.value) { // check if empty
            alert('Please enter your municipality');
            e.preventDefault(); // prevent submit
        }
    }
});

const updateProgress = () => {
    steps.forEach((step, i) => {
        if (i === active - 1) {
            step.classList.add('active');
        } else {
            step.classList.remove('active');
        }
    });

    formSteps.forEach((formStep, i) => {
        if (i === active - 1) {
            formStep.classList.add('active');
        } else {
            formStep.classList.remove('active');
        }
    });

    prevButton.disabled = active === 1;
    nextButton.disabled = active === steps.length;
};

const registrationForm = document.getElementById('registration');
registrationForm.onsubmit = function(e) {
    if (!nameField.value || !bloodTypeField.value || !contactField.value || !provinceField.value || !municipalityField.value) {
        e.preventDefault();
        alert("Please enter your information");
    }
}

updateProgress();
