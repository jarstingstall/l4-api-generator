<?php

use Api\Commands\ApiGenerateCommand;
use Api\Builders\RoutesBuilder;
use Api\Builders\ModelsBuilder;
use Api\Builders\ControllersBuilder;

/*
|--------------------------------------------------------------------------
| Register The Artisan Commands
|--------------------------------------------------------------------------
|
| Each available Artisan command must be registered with the console so
| that it is available to be called. We'll register every command so
| the console gets access to each of the command object instances.
|
*/
Artisan::add(
    new ApiGenerateCommand(
        new RoutesBuilder,
        new ModelsBuilder,
        new ControllersBuilder
    )
);
