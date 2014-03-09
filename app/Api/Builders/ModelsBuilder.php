<?php namespace Api\Builders;

use Str;
use File;
use Illuminate\Support\Pluralizer;

class ModelsBuilder
{
    public function build($resources)
    {
        foreach ($resources as $resource) {
            $model = Str::studly(Pluralizer::singular($resource));
            $stub = File::get(__DIR__.'/../stubs/model.stub');

            $stub = str_replace('{{model}}', $model, $stub);
            $path = app_path()."/models/{$model}.php";

            if (!File::exists($path)) {
                File::put($path, $stub);
            }
        }
    }
}