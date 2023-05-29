<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class TemplateController extends Controller
{
    public function index()
    {
        return view('template.index');
    }

    public function docs()
    {
        return view('template.docs');
    }

    public function orders()
    {
        return view('template.orders');
    }

    public function notifications()
    {
        return view('template.page.notifications');
    }

    public function account()
    {
        return view('template.page.account');
    }

    public function settings()
    {
        return view('template.page.settings');
    }

    public function login()
    {
        return view('template.external.login');
    }

    public function register()
    {
        return view('template.external.register');
    }

    public function reset_password()
    {
        return view('template.external.reset_password');
    }

    public function page404()
    {
        return view('template.external.page404');
    }

    public function charts()
    {
        return view('template.charts');
    }

    public function help()
    {
        return view('template.help');
    }
}
