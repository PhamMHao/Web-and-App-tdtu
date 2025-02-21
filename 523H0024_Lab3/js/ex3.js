const textInput = document.getElementById('message');
const colorSelect = document.getElementById('color');
const boldCheckbox = document.getElementById('bold');
const italicCheckbox = document.getElementById('italic');
const underlineCheckbox = document.getElementById('underline');
const alertBox = document.querySelector('.alert');
const restoreButton = document.querySelector('.btn-success');

const updateText = () => {
    // Update text content
    alertBox.textContent = textInput.value || 'This text will be changed immediately when typing new text.';

    // Update text color
    alertBox.style.color = colorSelect.value.toLowerCase();

    // Update text styles
    alertBox.style.fontWeight = boldCheckbox.checked ? 'bold' : 'normal';
    alertBox.style.fontStyle = italicCheckbox.checked ? 'italic' : 'normal';
    alertBox.style.textDecoration = underlineCheckbox.checked ? 'underline' : 'none';
};

const restoreDefaults = () => {
    textInput.value = '';
    colorSelect.value = 'Black';
    boldCheckbox.checked = false;
    italicCheckbox.checked = false;
    underlineCheckbox.checked = false;
    updateText();
};

// Add event listeners
textInput.addEventListener('input', updateText);
colorSelect.addEventListener('change', updateText);
boldCheckbox.addEventListener('change', updateText);
italicCheckbox.addEventListener('change', updateText);
underlineCheckbox.addEventListener('change', updateText);
restoreButton.addEventListener('click', restoreDefaults);
