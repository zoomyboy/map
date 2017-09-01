<?php

namespace Zoomyboy\Map;

use Illuminate\Support\ServiceProvider as BaseServiceProvider;

class ServiceProvider extends BaseServiceProvider {
	public function register() {
		app()->singleton(MapServiceInterface::class, function() {
			return new MapService(config('map.key'));
		});
	}

	public function boot() {
		$this->mergeConfigFrom(__DIR__.'/config/map.php', 'map');
	}
}
