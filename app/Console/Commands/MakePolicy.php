<?php

namespace App\Console\Commands;

use Illuminate\Console\GeneratorCommand;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Artisan;

class MakePolicy extends GeneratorCommand
{
    protected $signature = 'make:craft-policy {name} {--owned}';
    protected $description = 'Create a policy.';

    /**
     *
     */
    protected function buildClass($name)
    {
        $name = trim($this->argument('name'));
        $replace = [];

        $replace['DummyPolicy'] = $this->getPolicyName();
        $replace['DummyModel'] = $name;
        $replace['DummyBinding'] = Str::snake($name);
        $replace['DummyPluralBinding'] = Str::snake(Str::plural($name));
        $replace['DummyBindingId'] = Str::snake($name) . '_id';

        return str_replace(
            array_keys($replace), array_values($replace), parent::buildClass($name)
        );
    }

    /**
     *
     */
    protected function getDefaultNamespace($rootNamespace)
    {
        return $rootNamespace . '\Policies\Api';
    }

    /**
     *
     */
    protected function getPath($name)
    {
        $name = Str::replaceFirst($this->rootNamespace(), '', $name) . '.php';
        $name = str_replace(
            "{$this->argument('name')}.php", "{$this->getPolicyName()}.php", $name
        );

        return $this->laravel['path'].'/'.str_replace('\\', '/', $name);
    }

    /**
     *
     */
    protected function getPolicyName()
    {
        return str_replace('Policy', '', trim($this->argument('name'))) . 'Policy';
    }

    /**
     *
     */
    protected function getStub()
    {
        return __DIR__ . '/stubs/policies/' . ($this->option('owned') ? 'policy-owned.stub' : 'policy.stub');
    }
}
