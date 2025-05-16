<!DOCTYPE html>
<html lang="ca">
<head>
  <meta charset="UTF-8">
  <title>Afegir partida</title>
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
      display: block;
      margin-bottom: 5px;
    }
    input, select {
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
  <h1>Afegir Partida</h1>
  <div class="form-container">
    <form onsubmit="addGame(event)">
      <label for="played_at">Data i hora:</label>
      <input type="datetime-local" id="played_at" required>

      <label for="won">Has guanyat?</label>
      <select id="won" required>
        <option value="true">Sí</option>
        <option value="false">No</option>
      </select>

      <label for="score">Puntuació:</label>
      <input type="number" id="score" required>

      <label for="duration">Duració (en segons):</label>
      <input type="number" id="duration" required>

      <button type="submit">Envia Partida</button>
    </form>
  </div>

  <script>
    async function addGame(event) {
      event.preventDefault();

      const played_at = document.getElementById('played_at').value;
      const won = document.getElementById('won').value;
      const score = parseInt(document.getElementById('score').value);
      const duration = parseInt(document.getElementById('duration').value);

      const token = localStorage.getItem('token');

      const response = await fetch('/apis/V1/add_game', {
        method: 'POST',
        headers: {
          'Content-Type': 'application/json',
          'Authorization': 'Bearer ' + token
        },
        body: JSON.stringify({ played_at, won, score, duration })
      });

      const result = await response.json();
      if (response.ok) {
        alert(result.message);
      } else {
        alert(result.message);
      }
    }
  </script>
</body>
</html>
