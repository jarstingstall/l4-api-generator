<?php namespace Api\Builders;

use Str;

class RoutesBuilder extends Builder
{
    public function build($prefix, $resources)
    {
        if (!is_null($prefix)) {
            $content = "\nRoute::group(['prefix' => '{$prefix}'], function()\n{";
        }

        foreach ($resources as $resource) {

            if (strpos($resource, '.') === false) {
                $controller = Str::studly($resource) . 'Controller';
            } else {
                $controller = Str::studly($this->getNestedResource($resource)) . 'Controller';
            }

            $resource = $this->slashesForUnderscores($resource);

            $content .= "\n\tRoute::resource('{$resource}', '{$controller}', ['except' => ['create', 'edit']]);\n";

        }

        if (!is_null($prefix)) {
            return $content .= "});";
        }

        return $content;
    }

    protected function slashesForUnderscores($resource)
    {
        return str_replace('_', '-', $resource);
    }
}