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

const nextButton = document.querySelector('.btn-next');
const prevButton = document.querySelector('.btn-prev');
const steps = document.querySelectorAll('.step');
const formSteps = document.querySelectorAll('.form-step'); 

let active = 1;

nextButton.addEventListener('click', () => {
    active++;
    if (active > steps.length) {
        active = steps.length;
    }
    updateProgress();
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
