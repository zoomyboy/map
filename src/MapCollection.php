<?php

namespace Zoomyboy\Map;

use Zoomyboy\Map\Facades\Map;
use Illuminate\Database\Eloquent\Collection;

class MapCollection extends Collection {
	public function whereDistanceGreaterThan($address, $distance) {
		return $this->filter(function($model) use ($address, $distance) {
			return Map::distance($address, $model->addressForCoords) > $distance; 
		});
	}

	public function whereDistanceLowerThan($address, $distance) {
		return $this->filter(function($model) use ($address, $distance) {
			$dist = Map::distance($address, $model->addressForCoords);
			return $dist !== false && $dist < $distance; 
		});
	}
}
