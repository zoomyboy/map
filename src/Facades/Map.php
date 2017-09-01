<?php

namespace Zoomyboy\Map\Facades;

use \Illuminate\Support\Facades\Facade;

class Map extends Facade {
	public static function getFacadeAccessor() {
		return 'Zoomyboy\Map\MapServiceInterface';
	}
}
