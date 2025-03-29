const validateForm = (event) => {
    event.preventDefault();
    const email = document.getElementById('email');
    const password = document.getElementById('pwd');
    const errorMessage = document.getElementById('errorMessage');

    errorMessage.style.display = 'none';

    if (!email.value.trim()) {
        showError('Please enter your email', email);
        return false;
    }

    const emailPattern = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
    if (!emailPattern.test(email.value)) {
        showError('Your email is not correct', email);
        return false;
    }

    if (!password.value) {
        showError('Please enter your password', password);
        return false;
    }


    if (password.value.length < 6) {
        showError('Your password must contain at least 6 characters', password);
        return false;
    }

    document.getElementById('loginForm').submit();
    return true;
}

const showError = (message, inputElement) => {
    const errorMessage = document.getElementById('errorMessage');
    errorMessage.textContent = message;
    errorMessage.style.display = 'block';
    inputElement.focus();
}


document.getElementById('email').addEventListener('focus', () => {
    document.getElementById('errorMessage').style.display = 'none';
});

document.getElementById('pwd').addEventListener('focus', () => {
    document.getElementById('errorMessage').style.display = 'none';
});
