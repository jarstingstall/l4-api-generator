<?php namespace Api\Commands;

use File;
use Api\Builders\RoutesBuilder;
use Api\Builders\ModelsBuilder;
use Illuminate\Console\Command;
use Api\Compilers\ConfigCompiler;
use Api\Builders\ControllersBuilder;

class ApiGenerateCommand extends Command {

	/**
	 * ConfigCompiler instance
	 *
	 * @var Api\Compilers\ConfigCompiler
	 */
	protected $config;

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
	public function __construct(
		ConfigCompiler $config,
		RoutesBuilder $routes,
		ModelsBuilder $models,
		ControllersBuilder $controllers
	) {
		parent::__construct();
		$this->config = $config;
		$this->routes = $routes;
		$this->models = $models;
		$this->controllers = $controllers;
	}

	/**
	 * Execute the console command.
	 *
	 * @return mixed
	 */
	public function fire()
	{
		// read the Config
		$this->config->compile();

		// build Routes
		File::append(
			app_path().'/routes.php',
			$this->routes->build(
				$this->config->getPrefix(),
				$this->config->getResources()
			)
		);

		// build Controllers
		$this->controllers->build(
			$this->config->getPrefix(),
			$this->config->getResources()
		);

		// build Models
		$this->models->build($this->config->getResources());
	}

}
