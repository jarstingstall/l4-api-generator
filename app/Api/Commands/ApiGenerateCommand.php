<?php namespace Api\Commands;

use File;
use Config;
use Api\Builders\RoutesBuilder;
use Api\Builders\ModelsBuilder;
use Illuminate\Console\Command;
use Api\Builders\ControllersBuilder;

class ApiGenerateCommand extends Command {

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
		RoutesBuilder $routes,
		ModelsBuilder $models,
		ControllersBuilder $controllers
	) {
		parent::__construct();
		$this->routes = $routes;
		$this->models = $models;
		$this->controllers = $controllers;
		$this->config = Config::get('api-generator');
	}

	/**
	 * Execute the console command.
	 *
	 * @return mixed
	 */
	public function fire()
	{
		// build Routes
		File::append(
			app_path().'/routes.php',
			$this->routes->build(
				$this->config['prefix'],
				$this->config['resources']
			)
		);

		// build Controllers
		$this->controllers->build(
			$this->config['prefix'],
			$this->config['resources']
		);

		// build Models
		$this->models->build($this->config['resources']);
	}

}
