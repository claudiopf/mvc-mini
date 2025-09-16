<?php
namespace backOffice;
Class HomeController
{
    public function index(){

        viewRaw('layouts/app_admin', [
            'title' => 'Home'
        ]);
    }
}