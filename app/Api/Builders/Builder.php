<?php namespace Api\Builders;

use Str;
use Illuminate\Support\Pluralizer;

abstract class Builder
{
    protected function getModelName($resource)
    {
        return Str::studly(Pluralizer::singular($resource));
    }

    protected function getNestedResource($resource)
    {
        return last(explode('.', $resource));
    }
}