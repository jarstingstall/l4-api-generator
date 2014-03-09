<?php

use Illuminate\Console\Command;
use Illuminate\Filesystem\Filesystem;
use Illuminate\Support\Pluralizer;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Input\InputArgument;

class GenerateApiCommand extends Command {

	protected $files;

	/**
	 * The console command name.
	 *
	 * @var string
	 */
	protected $name = 'generate:api';

	/**
	 * The console command description.
	 *
	 * @var string
	 */
	protected $description = 'Generate routes and controller end points for specified resources.';

	/**
	 * Create a new command instance.
	 *
	 * @return void
	 */
	public function __construct(Filesystem $files)
	{
		parent::__construct();
		$this->files = $files;
	}

	/**
	 * Execute the console command.
	 *
	 * @return mixed
	 */
	public function fire()
	{
		$config = $this->readConfig();

		$this->files->append(app_path().'/routes.php', $this->buildRoutes($config['prefix'], $config['resources']));

		$this->buildControllers($config['prefix'], $config['resources']);
	}

	protected function readConfig()
	{
		$driver = Config::get('api-generator.driver');
		$resources = Config::get('api-generator.resources');
		$prefix = Config::get('api-generator.prefix');

		return compact('driver', 'resources', 'prefix');
	}
	protected function buildRoutes($prefix, $resources)
	{
		$content = "\nRoute::group(array('prefix' => '{$prefix}'), function()\n{";

		foreach ($resources as $resource) {
			$controller = Str::studly($resource) . 'Controller';
			$resource = str_replace('_', '-', $resource);
			$content .= "\n\tRoute::resource('{$resource}', '{$controller}', ['except' => ['create', 'edit']]);\n";
		}


		return $content .= "});";
	}

	protected function buildControllers($prefix, $resources)
	{
		foreach ($resources as $resource) {
			$name = Str::studly($resource);
			$resource = Str::studly(Pluralizer::singular($resource));
			$stub = $this->files->get(__DIR__.'/stubs/controller.eloquent.stub');

        	$stub = str_replace('{{name}}', $name, $stub);
        	$stub = str_replace('{{resource}}', $resource, $stub);
        	$path = app_path()."/controllers/{$name}Controller.php";

        	if (!$this->files->exists($path)) {
            	$this->files->put($path, $stub);
        	}
		}
	}

}
