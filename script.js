function showLogin(type) {
    // Hide all login forms
    document.getElementById('admin-login').style.display = 'none';
    document.getElementById('student-login').style.display = 'none';
    document.getElementById('faculty-login').style.display = 'none';

    // Show the selected login form
    if (type === 'admin') {
        document.getElementById('admin-login').style.display = 'block';
    } else if (type === 'student') {
        document.getElementById('student-login').style.display = 'block';
    } else if (type === 'faculty') {
        document.getElementById('faculty-login').style.display = 'block';
    }

    // Clear any previous error messages
    clearErrors();
}

function validateForm(userType) {
    // Clear previous error messages
    clearErrors();

    let id, password, errorElement;

    // Select form elements based on user type
    if (userType === 'admin') {
        id = document.getElementById('admin-id').value.trim();
        password = document.getElementById('admin-password').value.trim();
        errorElement = document.getElementById('admin-error');
    } else if (userType === 'student') {
        id = document.getElementById('student-id').value.trim();
        password = document.getElementById('student-password').value.trim();
        errorElement = document.getElementById('student-error');
    } else if (userType === 'faculty') {
        id = document.getElementById('faculty-id').value.trim();
        password = document.getElementById('faculty-password').value.trim();
        errorElement = document.getElementById('faculty-error');
    }

    // Check if fields are empty
    if (id === '' || password === '') {
        errorElement.textContent = 'Both fields are required.';
        errorElement.style.display = 'block';
        return false; // Prevent form submission
    }

    // Add further validation if needed, e.g., password strength

    // If validation passes, proceed (simulate form submission)
    alert('Login successful for ' + userType + '!');
    return false; // Prevent default form submission for demo purposes
}

function clearErrors() {
    // Clear error messages for all forms
    document.getElementById('admin-error').style.display = 'none';
    document.getElementById('student-error').style.display = 'none';
    document.getElementById('faculty-error').style.display = 'none';
}