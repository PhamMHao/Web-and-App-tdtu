const addStudent = () => {
    const firstname = document.getElementById('firstname').value.trim();
    const lastname = document.getElementById('lastname').value.trim();
    const email = document.getElementById('email').value.trim();

    // Validate inputs
    if (!firstname || !lastname || !email) {
        alert('Please fill in all fields');
        return;
    }

    // Validate email format
    const emailPattern = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
    if (!emailPattern.test(email)) {
        alert('Please enter a valid email address');
        return;
    }

    // Create new row
    const tbody = document.querySelector('tbody');
    const newRow = document.createElement('tr');
    newRow.innerHTML = `
        <td>${firstname}</td>
        <td>${lastname}</td>
        <td>${email}</td>
        <td><button class="btn btn-danger btn-sm">Delete</button></td>
    `;

    // Add delete event listener to new button
    newRow.querySelector('button').addEventListener('click', () => {
        newRow.remove();
    });

    // Add row to table
    tbody.appendChild(newRow);

    // Reset form
    resetForm();
};

const resetForm = () => {
    document.getElementById('firstname').value = '';
    document.getElementById('lastname').value = '';
    document.getElementById('email').value = '';
};


document.querySelector('.btn-success').addEventListener('click', addStudent);
document.querySelector('.btn-outline-primary').addEventListener('click', resetForm);

// Add delete functionality to existing buttons
// Want to delete the user, can check the user and after then can call the db and use the db.NameDB.destroy();
// 
document.querySelectorAll('.btn-danger').forEach(button => {
    button.addEventListener('click', () => {
        button.closest('tr').remove();
    });
});
