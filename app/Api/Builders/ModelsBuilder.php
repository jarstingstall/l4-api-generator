<?php namespace Api\Builders;

use Str;
use File;
use Config;
use Illuminate\Support\Pluralizer;

class ModelsBuilder extends Builder
{
    public function build($resources)
    {
        foreach ($resources as $resource) {

            if (strpos($resource, '.') !== false) {
                $resource = $this->getNestedResource($resource);
            }

            $stub = File::get(__DIR__.'/../stubs/model.stub');
            $model = $this->getModelName($resource);

            $stub = str_replace('{{model}}', $model, $stub);
            $path = Config::get('api-generator.paths.models') . "/{$model}.php";

            if (!File::exists($path)) {
                File::put($path, $stub);
            }
        }
    }
}