// Registrasi
document.getElementById('registerForm')?.addEventListener('submit', function (e) {
  e.preventDefault();
  const formData = new FormData(this);
  fetch('http://localhost:3000/ghsweb/register.php', {
    method: 'POST',
    body: formData
  })
  .then(res => res.text())
  .then(data => document.getElementById('registerResult').innerText = data);
});

// Login
document.getElementById('loginForm')?.addEventListener('submit', function (e) {
  e.preventDefault();
  const formData = new FormData(this);
  fetch('http://localhost:3000/ghsweb/login.php', {
    method: 'POST',
    body: formData
  })
  .then(res => res.text())
  .then(data => document.getElementById('loginResult').innerText = data);
});

// Checkout
document.getElementById('checkoutForm')?.addEventListener('submit', function (e) {
  e.preventDefault();
  const formData = new FormData(this);
  fetch('http://localhost:3000/ghsweb/checkout.php', {
    method: 'POST',
    body: formData
  })
  .then(res => res.text())
  .then(data => document.getElementById('checkoutResult').innerText = data);
});
