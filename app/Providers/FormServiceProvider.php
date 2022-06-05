<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Form;

class FormServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap the application services.
     *
     * @return void
     */
    public function boot()
    {
        Form::component('bsText',       'components.form.text',     ['name', 'labelName', 'value'=>null, 'attributes'=>[]]);
        Form::component('bsPassword',   'components.form.password', ['name', 'labelName', 'value'=>null, 'attributes'=>[]]);
    }

    /**
     * Register the application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }
}
