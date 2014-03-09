<?php namespace Api\Builders;

use Str;

class RoutesBuilder
{
    public function build($prefix, $resources)
    {
        $content = "\nRoute::group(array('prefix' => '{$prefix}'), function()\n{";

        foreach ($resources as $resource) {
            $controller = Str::studly($resource) . 'Controller';
            $resource = str_replace('_', '-', $resource);
            $content .= "\n\tRoute::resource('{$resource}', '{$controller}', ['except' => ['create', 'edit']]);\n";
        }

        return $content .= "});";
    }
}