<?php

namespace Zoomyboy\Map;

use Illuminate\Support\ServiceProvider as BaseServiceProvider;
use Illuminate\Support\Facades\Validator;
use Zoomyboy\Map\Facades\Map;

class ServiceProvider extends BaseServiceProvider {
	public function register() {
		app()->singleton(MapServiceInterface::class, function() {
			return new MapService(config('map.key'));
		});


	}

	public function boot() {
		$this->mergeConfigFrom(__DIR__.'/config/map.php', 'map');

        Validator::extend('location_exists', function ($attribute, $value, $parameters, $validator) {
			return is_array(Map::coords($value));
        });
	}
}
