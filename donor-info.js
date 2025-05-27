if (window.history.replaceState) {
    window.history.replaceState(null, null, window.location.href);
}

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
            
        // Show home if home
        if (menuText === 'home') {
            window.location.href = "home.php";
        } else if (menuText === 'login') { // Check login para deretso sa dashboard if may session
            checkLogin(); // Show login if login
        }
    });
});

const nextButton = document.querySelector('.btn-next');
const prevButton = document.querySelector('.btn-prev');
const steps = document.querySelectorAll('.step');
const formSteps = document.querySelectorAll('.form-step'); 

const nameField = document.getElementById('name');
const bloodTypeField = document.getElementById('bloodtype');
const contactField = document.getElementById('contact')

let active = 1;

nextButton.addEventListener('click', () => {
    if (active == 1) {
        if (!nameField.value) {
            alert('Please enter your name.');
        } else {
            active++;
            if (active > steps.length) {
                active = steps.length;
                console.log(active);
            }
            updateProgress();
            return;
        }
    } else if (active == 2) {
        if (bloodTypeField.value == '') {
            alert('Please select a blood type.');
        } else {
            active++;
            if (active > steps.length) {
                active = steps.length;
            }
            updateProgress();
            return;
        }
    } else if (active == 3) {
        contactNumber = contactField.value;
        firstDigit = contactNumber.charAt(0);
        secondDigit = contactNumber.charAt(1);
        
        if (!contactNumber) {
            alert('Please enter your phone number.');
        } else if (firstDigit != '0' || secondDigit != '9' || contactNumber.length != 11) {
            alert('Please enter a valid 11-digit number.');
        } else {
            active++;
            if (active > steps.length) {
                active = steps.length;
            }
            updateProgress();
            return;
        }
    } else if (active == 2) {
        if (bloodTypeField.value == '') {
            alert('Please select a blood type.');
            return;
        } else {
            active++;
            if (active > steps.length) {
                active = steps.length;
            }
            updateProgress();
            return;
        }
    }
});

prevButton.addEventListener('click', () => {
    active--;
    if (active < 1) {
        active = 1;
    }
    updateProgress();
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

updateProgress();
