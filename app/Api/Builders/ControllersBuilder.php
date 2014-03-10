<?php namespace Api\Builders;

use Str;
use File;
use Illuminate\Support\Pluralizer;

class ControllersBuilder extends Builder
{
    public function build($prefix, $resources)
    {
        foreach ($resources as $resource) {

            if (strpos($resource, '.') !== false) {
                $resource = $this->getNestedResource($resource);
            }

            $resource = Str::studly($resource);
            $model = $this->getModelName($resource);

            $stub = File::get(__DIR__.'/../stubs/controller.eloquent.stub');
            $stub = str_replace('{{resource}}', $resource, $stub);
            $stub = str_replace('{{model}}', $model, $stub);
            $path = app_path()."/controllers/{$resource}Controller.php";

            if (!File::exists($path)) {
                File::put($path, $stub);
            }
        }
    }
}