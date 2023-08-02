<?php

namespace App\Traits\Livewire;

use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Auth;

trait CheckGuard
{
    public function initializeCheckGuard()
    {
        if (App::runningInConsole() && !App::runningUnitTests()) {
            return;
        }

        if (isset($this->guard)) {
            abort_unless(Auth::guard($this->guard)->check(), 401);
        }
    }
}
