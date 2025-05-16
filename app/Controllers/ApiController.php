<?php

namespace App\Controllers;

use CodeIgniter\RESTful\ResourceController;
use App\Models\UsersModel;
use App\Models\TokensModel;
use App\Models\UserconfigModel;
use App\Models\GameModel;

class ApiController extends ResourceController
{
    public function create_user()
    {
        $data = $this->request->getJSON(true);

        if (!$data || !isset($data['username'], $data['password'], $data['email'], $data['age'], $data['country'])) {
            return $this->respond([
                'status' => 'error',
                'message' => 'Dades incorrectes o contrasenya insegura',
                'errorcode'=>'500.1'
            ], 400);
        }

        if (strlen($data['password']) < 8) {
            return $this->respond([
                'status' => 'error',
                'message' => 'Dades incorrectes o contrasenya insegura',
                'errorcode'=>'500.2'
            ], 400);
        }

        $userData = [
            'username' => $data['username'],
            'password' => password_hash($data['password'], PASSWORD_BCRYPT),
            'email' => $data['email'],
            'age' => $data['age'],
            'country' => $data['country'],
            'created_at' => date('Y-m-d H:i:s')
        ];

        $model = new UsersModel();
        if ($model->insert($userData)) {
            return $this->respond([
                'status' => 'ok',
                'message' => 'Usuari creat correctament'
            ]);
        }

        return $this->respond([
            'status' => 'error',
            'message' => 'Error en crear l\'usuari',
            'errorcode'=>'500.3'
        ], 500);
    }

    public function login()
    {
        helper("form");

        $rules = [
            'email' => 'required',
            'password' => 'required|min_length[4]'
        ];
        if (!$this->validate($rules)) return $this->fail($this->validator->getErrors());

        $model = new UsersModel();
        $user = $model->getUserByMailOrUsername($this->request->getVar('email'));

        if (!$user) return $this->failNotFound('Email Not Found');

        if (!password_verify($this->request->getVar('password'), $user['password'])) {
            return $this->fail('Wrong Password');
        }

        /****************** GENERATE TOKEN ********************/
        helper("jwt");
        $cfgAPI = new \Config\APIJwt("default");

        $data = [
            "uid" => $user['id'],
            "username" => $user['username'],
            "email" => $user['email']
        ];

        $token = newTokenJWT($cfgAPI->config(), $data);
        /****************** END TOKEN GENERATION **************/

        return $this->respondCreated([
            'status' => 200,
            'error' => false,
            'messages' => 'User logged In successfully',
            'token' => $token
        ]);
    }

    public function logged()
    {
        helper('jwt');
        try {
            $decoded = validateTokenFromRequest($this->request);

            return $this->respond([
                'status' => 'ok',
                'logged' => true,
                'user_id' => $decoded->uid,
                'username' => $decoded->username
            ]);
        } catch (\Exception $e) {
            return $this->failUnauthorized('Token invàlid o caducat');
        }
    }

    public function update_user()
    {
        helper('jwt');
        try {
            $token_data = validateTokenFromRequest($this->request);
        } catch (\Exception $e) {
            return $this->failUnauthorized($e->getMessage());
        }

        $data = $this->request->getJSON(true);
        if (!$data || (!isset($data['email']) && !isset($data['country']))) {
            return $this->failValidationErrors('No hi ha dades per actualitzar');
        }

        $updateData = [];
        if (!empty($data['email'])) $updateData['email'] = $data['email'];
        if (!empty($data['country'])) $updateData['country'] = $data['country'];

        $model = new UsersModel();
        $model->update($token_data->uid, $updateData);

        return $this->respond([
            'status' => 'ok',
            'message' => 'Dades actualitzades'
        ]);
    }

    public function logout()
    {
        helper('jwt');
        try {
            $token_data = validateTokenFromRequest($this->request);
        } catch (\Exception $e) {
            return $this->failUnauthorized($e->getMessage());
        }

        if (!isset($token_data->jti, $token_data->email, $token_data->exp)) {
            return $this->failUnauthorized('Token invàlid');
        }

        $model = new TokensModel();
        $model->insert([
            'tokenid' => $token_data->jti,
            'subject' => $token_data->email,
            'expiration' => $token_data->exp
        ]);

        return $this->respond([
            'status' => 'ok',
            'message' => 'Sessió tancada'
        ]);
    }

    public function config_game()
    {
        helper('jwt');
        try {
            $token_data = validateTokenFromRequest($this->request);
        } catch (\Exception $e) {
            return $this->failUnauthorized($e->getMessage());
        }

        $data = $this->request->getJSON(true);
        if (!isset($data['theme'], $data['music'], $data['difficulty'])) {
            return $this->respond([
                'status' => 'error',
                'message' => 'Dades incorrectes'
            ], 400);
        }

        $model = new UserconfigModel();
        $model->insert([
            'user_id' => $token_data->uid,
            'theme' => $data['theme'],
            'music' => $data['music'],
            'difficulty' => $data['difficulty']
        ]);

        return $this->respond([
            'status' => 'ok',
            'message' => 'Configuració desada'
        ]);
    }

    public function update_config_game()
    {
        helper('jwt');
        try {
            $token_data = validateTokenFromRequest($this->request);
        } catch (\Exception $e) {
            return $this->failUnauthorized($e->getMessage());
        }

        $data = $this->request->getJSON(true);
        $updateData = [];
        if (isset($data['theme'])) $updateData['theme'] = $data['theme'];
        if (isset($data['music'])) $updateData['music'] = $data['music'];
        if (isset($data['difficulty'])) $updateData['difficulty'] = $data['difficulty'];

        if (empty($updateData)) {
            return $this->failValidationErrors('No hi ha dades per actualitzar');
        }

        $model = new UserconfigModel();
        $model->where('user_id', $token_data->uid)->set($updateData)->update();

        return $this->respond([
            'status' => 'ok',
            'message' => 'Configuració actualitzada'
        ]);
    }

    public function add_game()
    {
        helper('jwt');
        try {
            $token_data = validateTokenFromRequest($this->request);
        } catch (\Exception $e) {
            return $this->failUnauthorized($e->getMessage());
        }

        $data = $this->request->getJSON(true);
        if (!isset($data['played_at'], $data['won'], $data['score'], $data['duration'])) {
            return $this->failValidationErrors('Falten dades obligatòries');
        }

        $model = new GameModel();
        $model->insert([
            'user_id' => $token_data->uid,
            'played_at' => $data['played_at'],
            'won' => filter_var($data['won'], FILTER_VALIDATE_BOOLEAN) ? 1 : 0,
            'score' => $data['score'],
            'duration' => $data['duration']
        ]);

        return $this->respondCreated([
            'status' => 'ok',
            'message' => 'Partida registrada'
        ]);
    }

    public function get_user_last_games()
    {
        helper('jwt');
        try {
            $token_data = validateTokenFromRequest($this->request);
        } catch (\Exception $e) {
            return $this->failUnauthorized($e->getMessage());
        }

        $model = new GameModel();
        $games = $model->where('user_id', $token_data->uid)
            ->orderBy('played_at', 'DESC')
            ->findAll(10);

        $partides = array_map(fn($g) => [
            'played_at' => $g['played_at'],
            'won' => (bool)$g['won'],
            'score' => $g['score'],
            'duration' => $g['duration']
        ], $games);

        return $this->respond([
            'status' => 'ok',
            'partides' => $partides
        ]);
    }

    public function get_user_stats()
    {
        helper('jwt');
        try {
            $token_data = validateTokenFromRequest($this->request);
        } catch (\Exception $e) {
            return $this->failUnauthorized($e->getMessage());
        }

        $model = new GameModel();
        $games = $model->where('user_id', $token_data->uid)->findAll();

        $total = count($games);
        $guanyades = count(array_filter($games, fn($g) => $g['won']));
        $perdudes = $total - $guanyades;
        $percentatge_victories = $total > 0 ? round($guanyades / $total * 100) : 0;
        $mitjana_punts = $total > 0 ? round(array_sum(array_column($games, 'score')) / $total) : 0;
        $mitjana_durada = $total > 0 ? round(array_sum(array_column($games, 'duration')) / $total) : 0;

        return $this->respond([
            'status' => 'ok',
            'total' => $total,
            'guanyades' => $guanyades,
            'perdudes' => $perdudes,
            'percentatge_victories' => $percentatge_victories,
            'mitjana_punts' => $mitjana_punts,
            'mitjana_durada' => $mitjana_durada
        ]);
    }

    public function get_top_users()
    {
        $db = \Config\Database::connect();

        $builder = $db->table('game g');
        $builder->select('u.username as nom_usuari, COUNT(g.id) as partides, 
                          SUM(g.won) as victories, 
                          COUNT(g.id) - SUM(g.won) as derrotes,
                          SUM(g.score) as punts_totals');
        $builder->join('users u', 'g.user_id = u.id');
        $builder->groupBy('g.user_id');
        $builder->orderBy('punts_totals', 'DESC');
        $builder->limit(10);

        $result = $builder->get()->getResultArray();

        $jugadors = [];
        $pos = 1;
        foreach ($result as $r) {
            $jugadors[] = [
                'posicio' => $pos++,
                'nom_usuari' => $r['nom_usuari'],
                'partides' => (int)$r['partides'],
                'victories' => (int)$r['victories'],
                'derrotes' => (int)$r['derrotes'],
                'punts_totals' => (int)$r['punts_totals'],
            ];
        }

        return $this->respond([
            'status' => 'ok',
            'jugadors' => $jugadors
        ]);
    }
}
