<?php namespace Api\Commands;

use Illuminate\Console\Command;
use Illuminate\Filesystem\Filesystem;
use Illuminate\Support\Pluralizer;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Input\InputArgument;

class ApiGenerateCommand extends Command {

	protected $files;

	/**
	 * The console command name.
	 *
	 * @var string
	 */
	protected $name = 'api:generate';

	/**
	 * The console command description.
	 *
	 * @var string
	 */
	protected $description = 'Generate boilerplate code for your API.';

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
		// read the Config
		$config = $this->readConfig();

		// build Routes
		$this->files->append(app_path().'/routes.php', $this->buildRoutes($config['prefix'], $config['resources']));

		// build Controllers
		$this->buildControllers($config['prefix'], $config['resources']);

		// build Models
		$this->buildModels($config['resources']);
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
			$stub = $this->files->get(__DIR__.'../stubs/controller.eloquent.stub');

        	$stub = str_replace('{{name}}', $name, $stub);
        	$stub = str_replace('{{resource}}', $resource, $stub);
        	$path = app_path()."/controllers/{$name}Controller.php";

        	if (!$this->files->exists($path)) {
            	$this->files->put($path, $stub);
        	}
		}
	}

	protected function buildModels($resources)
	{
		foreach ($resources as $resource) {
			$model = Str::studly(Pluralizer::singular($resource));
			$stub = $this->files->get(__DIR__.'../stubs/model.stub');

			$stub = str_replace('{{model}}', $model, $stub);
			$path = app_path()."/models/{$model}.php";

        	if (!$this->files->exists($path)) {
            	$this->files->put($path, $stub);
        	}
		}
	}

}
