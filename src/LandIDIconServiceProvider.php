<?php

declare(strict_types=1);

namespace ITCareTCR\LandID\Icons;

use BladeUI\Icons\Factory;
use Illuminate\Contracts\Container\Container;
use Illuminate\Support\ServiceProvider;

final class LandIDIconServiceProvider extends ServiceProvider
{
	public function register(): void
	{
		$this->registerConfig();

		$this->callAfterResolving(Factory::class, function (Factory $factory, Container $container) {
			$config = $container->make('config')->get('lidamenities', []);

			$factory->add('lidamenities', array_merge(['path' => __DIR__ . '/../resources/svg'], $config));
		});
	}

	private function registerConfig(): void
	{
		$this->mergeConfigFrom(__DIR__ . '/../config/lidamenities.php', 'lidamenities');
	}

	public function boot(): void
	{
		if ($this->app->runningInConsole()) {
			$this->publishes([
				__DIR__ . '/../resources/svg' => public_path('vendor/blade-heroicons'),
			], 'blade-heroicons');

			$this->publishes([
				__DIR__ . '/../config/lidamenities.php' => $this->app->configPath('lidamenities.php'),
			], 'blade-heroicons-config');
		}
	}
}
