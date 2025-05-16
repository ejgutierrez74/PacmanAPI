<!DOCTYPE html>
<html lang="ca">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Registra't</title>
  <script>
    function registerUser(event) {
      event.preventDefault();

      const username = document.getElementById('username').value;
      const email = document.getElementById('email').value;
      const password = document.getElementById('password').value;
      const confirmPassword = document.getElementById('confirm-password').value;
      const age = document.getElementById('age').value;
      const country = document.getElementById('country').value;

      if (password !== confirmPassword) {
        alert("Les contrasenyes no coincideixen!");
        return;
      }

      fetch('/apis/V1/create_user', {
        method: 'POST',
        headers: {
          'Content-Type': 'application/json'
        },
        body: JSON.stringify({
          username: username,  
          email: email,      
          password: password, 
          age: age,           
          country: country     
        })
      })
      .then(response => response.json())
      .then(data => {
        console.log(data);

        if (data.status === 'ok') {
          alert("Usuari registrat correctament!");
          window.location.href = "/app/login"; 
        } else {
          alert("Error al registrar l'usuari: " + (data.message || "Intenta-ho de nou."));
        }
      })
      .catch(error => {
        console.error('Error:', error);
        alert('Error de connexió amb el servidor.');
      });
    }
  </script>
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
  </style>
</head>
<body>

  <h1>Registra't</h1>
  <div class="form-container">
    <form id="register-form" onsubmit="registerUser(event)">
      <label for="username">Nom d'usuari:</label>
      <input type="text" id="username" required><br><br>

      <label for="email">Correu electrònic:</label>
      <input type="email" id="email" required><br><br>

      <label for="age">Edat:</label>
      <input type="number" id="age" required><br><br>

      <label for="country">País:</label>
      <input type="text" id="country" required><br><br>

      <label for="password">Contrasenya:</label>
      <input type="password" id="password" required><br><br>

      <label for="confirm-password">Confirma la contrasenya:</label>
      <input type="password" id="confirm-password" required><br><br>

      <button type="submit">Registrar</button>
    </form>
  </div>

</body>
</html>
