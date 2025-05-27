document.addEventListener('DOMContentLoaded', function() {
    const hamMenu = document.querySelector('.ham-menu');
    const offScreenMenu = document.querySelector('.off-screen-menu');
    const closeBtn = document.querySelector('.off-screen-menu .close-btn');
    const body = document.body;

    function closeMenu() {
        hamMenu.classList.remove('active');
        offScreenMenu.classList.remove('active');
        body.classList.remove('menu-open');
    }

    if (hamMenu && offScreenMenu) {
        hamMenu.addEventListener('click', function() {
            hamMenu.classList.toggle('active');
            offScreenMenu.classList.toggle('active');
            body.classList.toggle('menu-open');
        });

        closeBtn.addEventListener('click', closeMenu);

        document.addEventListener('click', function(e) {
            if (!hamMenu.contains(e.target) && !offScreenMenu.contains(e.target) && offScreenMenu.classList.contains('active')) {
                closeMenu();
            }
        });

        document.addEventListener('keydown', function(e) {
            if (e.key === 'Escape' && offScreenMenu.classList.contains('active')) {
                closeMenu();
            }
        });

        const menuItems = offScreenMenu.querySelectorAll('li');
        menuItems.forEach(item => {
            item.addEventListener('click', function() {
                menuItems.forEach(i => i.classList.remove('active'));
                this.classList.add('active');
                closeMenu();
            });
        });
    } else {
        console.error('Hamburger menu or off-screen menu elements not found');
    }

    const nextButton = document.querySelector('.btn-next');
    const prevButton = document.querySelector('.btn-prev');
    const steps = document.querySelectorAll('.step');
    const formSteps = document.querySelectorAll('.form-step');

    let active = 1;

    if (nextButton && prevButton) {
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
    }

    function updateProgress() {
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

        if (prevButton && nextButton) {
            prevButton.disabled = active === 1;
            nextButton.disabled = active === steps.length;
        }
    }

    updateProgress();
});