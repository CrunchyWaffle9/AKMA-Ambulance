document.getElementById('loginForm').addEventListener('submit', function(event) {
    event.preventDefault();

    const email = document.getElementById('email').value;
    const password = document.getElementById('password').value;

    const customers = JSON.parse(localStorage.getItem('customers')) || [];
    const admins = JSON.parse(localStorage.getItem('admins')) || [];
    const managers = JSON.parse(localStorage.getItem('managers')) || [];

    const user = customers.find(c => c.email === email && c.password === password) || 
                 admins.find(a => a.email === email && a.password === password) || 
                 managers.find(m => m.email === email && m.password === password);

    if (user) {
        localStorage.setItem('loggedInUser', JSON.stringify(user));
        if (admins.some(a => a.email === email)) {
            window.location.href = 'admin.html';
        } else if (managers.some(m => m.email === email)) {
            window.location.href = 'manager.html';
        } else {
            window.location.href = 'halaman.php';
        }
    } else {
        alert('Invalid email or password!');
    }
});
