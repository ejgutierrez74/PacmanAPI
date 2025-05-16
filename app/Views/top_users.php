<!DOCTYPE html>
<html lang="ca">
<head>
    <meta charset="UTF-8" />
    <title>Top Jugadors</title>
    <style>
        body {
            background-color: #000;
            color: yellow;
            font-family: 'Press Start 2P', cursive;
            padding: 20px;
            text-align: center;
        }
        h1 {
            color: red;
        }
        table {
            margin: 20px auto;
            border-collapse: collapse;
            width: 80%;
            max-width: 800px;
        }
        th, td {
            border: 2px solid yellow;
            padding: 10px 15px;
            font-size: 14px;
        }
        th {
            background-color: red;
            color: yellow;
        }
        tr:nth-child(even) {
            background-color: #222;
        }
        tr:hover {
            background-color: yellow;
            color: red;
            cursor: pointer;
        }
    </style>
</head>
<body>
    <h1>Top 10 Jugadors</h1>
    <table id="top-users-table">
        <thead>
            <tr>
                <th>Posició</th>
                <th>Nom d'Usuari</th>
                <th>Partides</th>
                <th>Victòries</th>
                <th>Derrotes</th>
                <th>Punts Totals</th>
            </tr>
        </thead>
        <tbody>
            <tr><td colspan="6">Carregant dades...</td></tr>
        </tbody>
    </table>

    <script>
        async function carregarTopUsers() {
            try {
                const resposta = await fetch('/apis/V1/get_top_users');
                if (!resposta.ok) throw new Error('Error al carregar dades');
                const dades = await resposta.json();

                const tbody = document.querySelector('#top-users-table tbody');
                tbody.innerHTML = '';

                if (dades.status === 'ok' && dades.jugadors.length > 0) {
                    dades.jugadors.forEach(j => {
                        const fila = document.createElement('tr');
                        fila.innerHTML = `
                            <td>${j.posicio}</td>
                            <td>${j.nom_usuari}</td>
                            <td>${j.partides}</td>
                            <td>${j.victories}</td>
                            <td>${j.derrotes}</td>
                            <td>${j.punts_totals}</td>
                        `;
                        tbody.appendChild(fila);
                    });
                } else {
                    tbody.innerHTML = '<tr><td colspan="6">No hi ha jugadors per mostrar.</td></tr>';
                }
            } catch (error) {
                const tbody = document.querySelector('#top-users-table tbody');
                tbody.innerHTML = `<tr><td colspan="6">${error.message}</td></tr>`;
            }
        }

        carregarTopUsers();
    </script>
</body>
</html>
