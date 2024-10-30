document.getElementById('registerForm').addEventListener('submit', function(event) {
    event.preventDefault();

    const email = document.getElementById('email').value;
    const password = document.getElementById('password').value;
    const name = document.getElementById('name').value;
    const ambulanceType = document.getElementById('ambulanceType').value; // New field
    const phone = document.getElementById('phone').value;

    const user = {
        email,
        password,
        name,
        ambulanceType, // Save vehicle type
        phone
    };

    let users = JSON.parse(localStorage.getItem('customers')) || [];
    users.push(user);
    localStorage.setItem('customers', JSON.stringify(users));

    alert('Registration successful!');
    window.location.href = 'login.php';
});
