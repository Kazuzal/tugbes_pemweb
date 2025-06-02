document.addEventListener("DOMContentLoaded", function() {
    const loginForm = document.querySelector(".login");
    const signupForm = document.querySelector(".signup");
    const showSignup = document.getElementById("show-signup");
    const showLogin = document.getElementById("show-login");

    showSignup.addEventListener("click", function(event) {
        event.preventDefault(); // Mencegah reload
        loginForm.style.transform = "translateX(-120%)";
        signupForm.style.transform = "translateY(-100%)";
    });

    showLogin.addEventListener("click", function(event) {
        event.preventDefault(); // Mencegah reload
        loginForm.style.transform = "translateX(0)";
        signupForm.style.transform = "translateX(100%)";
    });
});

const signupForm = document.getElementById('signup-form');
    const password = document.getElementById('password');
    const confirmPassword = document.getElementById('confirm_password');

    signupForm.addEventListener('submit', function(e) {
        if (password.value !== confirmPassword.value) {
            e.preventDefault(); // Mencegah form terkirim
            alert("Password dan Confirm Password tidak cocok!");
        }
});

document.getElementById("signup-form").addEventListener("submit", function(e) {
    const pass = document.getElementById("password").value;
    const confirm = document.getElementById("confirm_password").value;
    const errorMsg = document.getElementById("error-message");

    if (pass !== confirm) {
        e.preventDefault(); // cegah form terkirim
       
    }
});

document.getElementById('register-form').addEventListener('submit', function(e) {
    e.preventDefault(); // Mencegah form terkirim dulu

    const password = document.getElementById('password').value;
    const confirm = document.getElementById('confirm-password').value;
    const errorMsg = document.getElementById('error-message');

    if (password !== confirm) {
      errorMsg.style.display = 'block';
      errorMsg.textContent = 'Password dan Konfirmasi Password tidak sama.';
    } else {
      errorMsg.style.display = 'none';
      // lanjutkan submit atau aksi lain
      alert('Registrasi berhasil!');
    }
  });