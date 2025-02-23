document.addEventListener('DOMContentLoaded', function () {
    const passwordInput = document.getElementById('password');
    const criteria = {
        length: document.getElementById('length'),
        uppercase: document.getElementById('uppercase'),
        lowercase: document.getElementById('lowercase'),
        number: document.getElementById('number'),
        special: document.getElementById('special')
    };

    const validatePassword = (password) => {
        // Check length
        criteria.length.classList.toggle('valid', password.length >= 8);

        // Check uppercase
        criteria.uppercase.classList.toggle('valid', /[A-Z]/.test(password));

        // Check lowercase
        criteria.lowercase.classList.toggle('valid', /[a-z]/.test(password));

        // Check numbers
        criteria.number.classList.toggle('valid', /[0-9]/.test(password));

        // Check special characters
        criteria.special.classList.toggle('valid', /[^A-Za-z0-9]/.test(password));
    };

    passwordInput.addEventListener('input', (e) => {
        validatePassword(e.target.value);
    });
});
