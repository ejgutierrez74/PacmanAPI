<!DOCTYPE html>
<html lang="ca">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Actualitza les teves dades</title>
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

  <h1>Actualitza les teves dades</h1>
  <div class="form-container">
    <form id="update-form" onsubmit="updateUser(event)">
      <label for="email">Nou correu electrònic:</label>
      <input type="email" id="email" placeholder="Nou correu electrònic" required><br><br>

      <label for="country">Nou país:</label>
      <input type="text" id="country" placeholder="Nou país" required><br><br>

      <button type="submit">Actualitzar</button>
    </form>
  </div>

  <script>
    // Funció per actualitzar les dades de l'usuari
    function updateUser(event) {
      event.preventDefault();  // Prevenir l'enviament per defecte del formulari

      const email = document.getElementById('email').value;
      const country = document.getElementById('country').value;
      const token = localStorage.getItem('token');  // Recuperar el token del localStorage

      if (!token) {
        alert('No estàs autenticat. Si us plau, inicia sessió.');
        return;
      }

      // Enviar la sol·licitud d'actualització a l'API
      fetch('/apis/V1/update_user', {
        method: 'POST',
        headers: {
          'Content-Type': 'application/json',
          'Authorization': 'Bearer ' + token  // Afegir el token d'autenticació
        },
        body: JSON.stringify({
          email: email,
          country: country
        })
      })
      .then(response => response.json())
      .then(data => {
        if (data.status === 'ok') {
          alert('Les teves dades s\'han actualitzat correctament!');
        } else {
          alert('Error en actualitzar les teves dades: ' + (data.message || 'Intenta-ho més tard.'));
        }
      })
      .catch(error => {
        console.error('Error:', error);
        alert('Error de connexió amb el servidor.');
      });
    }
  </script>

</body>

</html>
