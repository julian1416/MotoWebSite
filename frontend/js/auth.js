// Enviar formulario de registro
document.addEventListener("DOMContentLoaded", function () {
  const registerForm = document.getElementById("registerForm");
  const loginForm = document.getElementById("loginForm");

  if (registerForm) {
    registerForm.addEventListener("submit", async function (e) {
      e.preventDefault();
      const formData = new FormData(registerForm);

      const res = await fetch("../backend/auth/register.php", {
        method: "POST",
        body: formData
      });

      const text = await res.text();
      document.getElementById("registerResult").innerText = text;
    });
  }

  // Enviar formulario de login
  if (loginForm) {
    loginForm.addEventListener("submit", async function (e) {
      e.preventDefault();
      const formData = new FormData(loginForm);

      const res = await fetch("../backend/auth/login.php", {
        method: "POST",
        body: formData
      });

      const text = await res.text();
      document.getElementById("loginResult").innerText = text;
    });
  }
});
