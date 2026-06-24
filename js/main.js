// Mobile Navigation Toggle
const hamburger = document.getElementById('hamburger');
const nav = document.getElementById('nav');

if (hamburger && nav) {
    hamburger.addEventListener('click', () => {
        nav.classList.toggle('open');
        hamburger.classList.toggle('open');
    });

    // Close nav when a link is clicked
    const navLinks = nav.querySelectorAll('.nav__link');
    navLinks.forEach(link => {
        link.addEventListener('click', () => {
            nav.classList.remove('open');
            hamburger.classList.remove('open');
        });
    });
}

// Sidebar Toggle for System Pages
const sidebarToggle = document.getElementById('sidebarToggle');
const sidebar = document.getElementById('sidebar');

if (sidebarToggle && sidebar) {
    sidebarToggle.addEventListener('click', () => {
        sidebar.classList.toggle('open');
    });
}

// Toggle Password Visibility
const togglePasswordButtons = document.querySelectorAll('.toggle-password');

togglePasswordButtons.forEach(button => {
    button.addEventListener('click', () => {
        const input = button.parentElement.querySelector('input');
        const icon = button.querySelector('i');
        
        if (input.type === 'password') {
            input.type = 'text';
            icon.classList.remove('fa-eye');
            icon.classList.add('fa-eye-slash');
        } else {
            input.type = 'password';
            icon.classList.remove('fa-eye-slash');
            icon.classList.add('fa-eye');
        }
    });
});

// Contact Form Submission (Demo)
const contactForm = document.getElementById('contactForm');
const formSuccess = document.getElementById('formSuccess');

if (contactForm) {
    contactForm.addEventListener('submit', function(e) {
        e.preventDefault();
        // Simulate sending
        contactForm.style.display = 'none';
        if (formSuccess) {
            formSuccess.style.display = 'block';
        }
        // Reset after 5 seconds for demo
        setTimeout(() => {
            contactForm.style.display = 'block';
            if (formSuccess) formSuccess.style.display = 'none';
            contactForm.reset();
        }, 5000);
    });
}

// Login Form (Demo)
const loginForm = document.getElementById('loginForm');
if (loginForm) {
    loginForm.addEventListener('submit', function(e) {
        e.preventDefault();
        alert('Login simulation: Redirecting to Dashboard...');
        window.location.href = 'dashboard.html';
    });
}

// Register Form (Demo)
const registerForm = document.getElementById('registerForm');
if (registerForm) {
    registerForm.addEventListener('submit', function(e) {
        e.preventDefault();
        const password = document.getElementById('regPassword');
        const confirm = document.getElementById('regConfirm');
        if (password && confirm && password.value !== confirm.value) {
            alert('Passwords do not match!');
            return;
        }
        alert('Registration successful! Redirecting to Login...');
        window.location.href = 'login.html';
    });
}

// Records Tabs (Demo)
const recordsTabs = document.querySelectorAll('.records-tab');
recordsTabs.forEach(tab => {
    tab.addEventListener('click', function() {
        recordsTabs.forEach(t => t.classList.remove('active'));
        this.classList.add('active');
    });
});

// Smooth scroll for anchor links
document.querySelectorAll('a[href^="#"]').forEach(anchor => {
    anchor.addEventListener('click', function(e) {
        const href = this.getAttribute('href');
        if (href.length > 1) {
            e.preventDefault();
            const target = document.querySelector(href);
            if (target) {
                target.scrollIntoView({ behavior: 'smooth', block: 'start' });
            }
        }
    });
});

// Set active navigation based on current page
const currentPage = window.location.pathname.split('/').pop() || 'index.html';
const navLinks = document.querySelectorAll('.nav__link');
navLinks.forEach(link => {
    const linkPage = link.getAttribute('href');
    if (linkPage === currentPage) {
        link.classList.add('active');
    } else {
        link.classList.remove('active');
    }
});

console.log('Petals & Style Flowershop - Frontend Prototype Loaded');