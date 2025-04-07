const homePage = document.getElementById('home');
const loginPage = document.getElementById('login');
const searchPage = document.getElementById('search');
const resultsContainer = document.getElementById('resultsContainer');

document.querySelector('.home-link').addEventListener('click', (e) => {
    e.preventDefault();
    showPage('home');
});

document.querySelector('.donorlist-link').addEventListener('click', (e) => {
    e.preventDefault();
    showPage('donorlist');
});

document.querySelector('.login-link').addEventListener('click', (e) => {
    e.preventDefault();
    showPage('login');
});

document.querySelector('.donor-login-btn').addEventListener('click', () => {
    showPage('login');
});

document.getElementById('loginBtn').addEventListener('click', () => {
    const email = document.getElementById('email').value;
    const password = document.getElementById('password').value;
    
    if (email && password) {
        alert('Login successful! Redirecting to donor dashboard...');
    } else {
        alert('Please enter both email and password');
    }
});

document.getElementById('searchBtn').addEventListener('click', () => {
    const bloodType = document.getElementById('bloodType').value;
    const location = document.getElementById('location').value.toLowerCase();
    
    if (!bloodType) {
        alert('Please select a blood type');
        return;
    }
    
    let filteredDonors = donors.filter(donor => donor.bloodType === bloodType);
    
    if (location) {
        filteredDonors = filteredDonors.filter(donor => 
            donor.location.toLowerCase().includes(location)
        );
    }
    
    displayResults(filteredDonors);
});

function showPage(pageId) {
    document.querySelectorAll('.page').forEach(page => {
        page.classList.remove('active');
    });
    
    document.getElementById(pageId).classList.add('active');
}