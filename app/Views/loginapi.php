<!DOCTYPE html>
<html lang="ca">
<head>
  <meta charset="UTF-8">
  <title>Login API</title>
  <style>
    body {
      margin: 0;
      font-family: 'Press Start 2P', cursive;
      background-color: #000;
      color: yellow;
      padding: 20px;
    }

    h1 {
      color: red;
      text-align: center;
    }

    .form-container {
      background-color: #111;
      padding: 20px;
      border-radius: 10px;
      border: 2px solid yellow;
      max-width: 400px;
      margin: 0 auto;
    }

    label {
      font-size: 18px;
      display: block;
      margin-bottom: 5px;
    }

    input {
      padding: 10px;
      font-size: 16px;
      width: 100%;
      margin-bottom: 15px;
      border: 1px solid yellow;
      border-radius: 5px;
      background-color: #222;
      color: yellow;
    }

    button {
      padding: 10px 20px;
      background-color: red;
      border: none;
      border-radius: 5px;
      color: yellow;
      font-size: 18px;
      cursor: pointer;
      width: 100%;
    }

    button:hover {
      background-color: yellow;
      color: red;
    }

    .error {
      color: red;
      margin-top: 10px;
      text-align: center;
    }

    .success {
      color: lime;
      margin-top: 10px;
      text-align: center;
    }
  </style>
</head>
<body>
  <h1>Inicia Sessió</h1>
  <div class="form-container">
    <form id="login-form">
      <label for="email">Correu electrònic:</label>
      <input type="email" id="email" required>

      <label for="password">Contrasenya:</label>
      <input type="password" id="password" required>

      <button type="submit">Entrar</button>
      <div id="message"></div>
    </form>
  </div>

  <script>
    document.getElementById('login-form').addEventListener('submit', function (e) {
      e.preventDefault();

      const email = document.getElementById('email').value.trim();
      const password = document.getElementById('password').value.trim();
      const messageDiv = document.getElementById('message');
      messageDiv.innerHTML = '';

      fetch('/apis/V1/login', {
        method: 'POST',
        headers: { 'Content-Type': 'application/json' },
        body: JSON.stringify({ email, password })
      })
      .then(response => {
        if (!response.ok) {
          return response.json().then(err => {
            throw new Error(err.message || 'Error desconegut');
          });
        }
        return response.json();
      })
      .then(data => {
        if (data.token) {
          localStorage.setItem('token', data.token);
          messageDiv.innerHTML = '<p class="success">Sessió iniciada correctament!</p>';
          setTimeout(() => {
            window.location.href = '/app'; // Canvia a la teva pàgina principal
          }, 1500);
        } else {
          throw new Error('No s\'ha rebut cap token.');
        }
      })
      .catch(error => {
        messageDiv.innerHTML = `<p class="error">Error: ${error.message}</p>`;
      });
    });
  </script>
</body>
</html>
