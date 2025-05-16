<?php

namespace App\Controllers;

class Home extends BaseController
{
    public function loginapi(): string
    {
        return view('loginapi');
    }

    public function registerapi(): string
    {
        return view('registerapi');
    }

        public function update_user(): string
    {
        return view('update_user'); 
    }

    public function config_game(): string
    {
        return view('config_game'); 
    }

    public function update_config_game(): string
    {
        return view('update_config_game');
    }

    public function add_game(): string
    {
        return view('add_game');
    }

    public function last_games(): string
    {
        return view('last_games');
    }

    public function user_stats(): string
    {
        return view('user_stats');
    }

    public function top_users(): string
    {
        return view('top_users');
    }


    public function index(): string
    {

        return view('index');
    }


}
