const API_URL = 'http://localhost:3000/students';
const tbody = document.querySelector('tbody');
const btnAdd = document.querySelector('#btn-add');
const form = document.querySelector('form');
const nameField = document.querySelector('#fullname');
const ageField = document.querySelector('#age');
const stateField = document.querySelector('#state');
const errorDiv = document.querySelector('#error');
let editingId = null;

// Add error handling for DOM elements
if (!tbody || !btnAdd || !form || !nameField || !ageField || !stateField || !errorDiv) {
    console.error('Required DOM elements not found');
}

// Make functions globally accessible
window.changeState = (id, currentState) => changeState(id, currentState);
window.editStudent = (id) => editStudent(id);
window.deleteStudent = (id) => deleteStudent(id);
window.resetForm = () => resetForm();

// Load students when page loads
loadStudents();

const loadStudents = async () => {
    try {
        const response = await fetch(API_URL);
        const students = await response.json();
        students.sort((a, b) => parseInt(a.id) - parseInt(b.id));
        displayStudents(students);
    } catch (error) {
        showError('Error loading students: ' + error.message);
    }
};

const displayStudents = (students) => {
    tbody.innerHTML = students.map(student => `
    <tr>
        <td>${student.id}</td>
        <td>${student.name}</td>
        <td>${student.age}</td>
        <td><span class="badge badge-${student.state === 'pending' ? 'warning' : 'success'}">${student.state || 'pending'}</span></td>
        <td>
            <button onclick="changeState('${student.id}', '${student.state || 'pending'}')" class="btn btn-sm btn-outline-primary">Change</button>
            <button onclick="editStudent('${student.id}')" class="btn btn-sm btn-outline-warning">Edit</button>
            <button onclick="deleteStudent('${student.id}')" class="btn btn-sm btn-outline-danger">Delete</button>
        </td>
    </tr>
`).join('');
};

const changeState = async (id, currentState) => {
    try {
        const newState = currentState === 'pending' ? 'completed' : 'pending';
        const response = await fetch(`${API_URL}/${id}`, {
            method: 'PATCH',
            headers: {
                'Content-Type': 'application/json'
            },
            body: JSON.stringify({ state: newState })
        });
        if (response.ok) {
            loadStudents();
        }
    } catch (error) {
        showError('Error changing state: ' + error.message);
    }
};

const editStudent = async (id) => {
    try {
        const response = await fetch(`${API_URL}/${id}`);
        const student = await response.json();

        nameField.value = student.name;
        ageField.value = student.age;
        stateField.value = student.state ? (student.state.charAt(0).toUpperCase() + student.state.slice(1)) : 'Pending';
        editingId = id;
        btnAdd.textContent = 'Update';
        form.scrollIntoView({ behavior: 'smooth' });
    } catch (error) {
        showError('Error loading student data: ' + error.message);
    }
};

const getNextId = async () => {
    try {
        const response = await fetch(API_URL);
        const students = await response.json();
        const ids = students.map(student => parseInt(student.id)).filter(id => !isNaN(id));
        return ids.length > 0 ? Math.max(...ids) + 1 : 1;
    } catch (error) {
        showError('Error generating ID: ' + error.message);
        return null;
    }
};

if (form) {
    form.addEventListener('submit', async (e) => {
        e.preventDefault();
        const name = nameField.value.trim();
        const age = parseInt(ageField.value);
        const state = stateField.value.toLowerCase();

        if (name === '') {
            nameField.focus();
            return showError('Please enter student name');
        }

        if (isNaN(age) || age < 18 || age > 100) {
            ageField.focus();
            return showError('Please enter valid age between 18 and 100');
        }

        try {
            const url = editingId ? `${API_URL}/${editingId}` : API_URL;
            const method = editingId ? 'PUT' : 'POST';
            const nextId = editingId || await getNextId();

            const response = await fetch(url, {
                method: method,
                headers: {
                    'Content-Type': 'application/json'
                },
                body: JSON.stringify({
                    id: nextId.toString(),
                    name,
                    age,
                    state
                })
            });

            if (response.ok) {
                form.reset();
                btnAdd.textContent = 'Add';
                editingId = null;
                loadStudents();
            }
        } catch (error) {
            showError(`Error ${editingId ? 'updating' : 'adding'} student: ` + error.message);
        }
    });
}

const resetForm = () => {
    form.reset();
    editingId = null;
    btnAdd.textContent = 'Add';
};

const deleteStudent = async (id) => {
    if (!confirm('Are you sure you want to delete this student?')) return;
    try {
        const response = await fetch(`${API_URL}/${id}`, {
            method: 'DELETE'
        });
        if (response.ok) {
            loadStudents();
        }
    } catch (error) {
        showError('Error deleting student: ' + error.message);
    }
};

const showError = (message) => {
    errorDiv.style.display = 'block';
    errorDiv.textContent = message;
    setTimeout(() => {
        errorDiv.style.display = 'none';
    }, 3000);
};