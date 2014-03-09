<?php namespace Api\Builders;

use Str;
use File;
use Illuminate\Support\Pluralizer;

class ControllersBuilder
{
    public function build($prefix, $resources)
    {
        foreach ($resources as $resource) {
            $name = Str::studly($resource);
            $resource = Str::studly(Pluralizer::singular($resource));
            $stub = File::get(__DIR__.'/../stubs/controller.eloquent.stub');

            $stub = str_replace('{{name}}', $name, $stub);
            $stub = str_replace('{{resource}}', $resource, $stub);
            $path = app_path()."/controllers/{$name}Controller.php";

            if (!File::exists($path)) {
                File::put($path, $stub);
            }
        }
    }
}