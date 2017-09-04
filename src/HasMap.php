<?php

namespace Zoomyboy\Map;

use Zoomyboy\Map\Facades\Map;
use Cache;

trait HasMap {
	public function updateCoords() {
		$location = Map::coords($this->addressForCoords);
		if ($location !== false) {
			$this->update(array_only($location, ['latitude', 'longitude']));
		} else {
			$this->update(['latitude' => null, 'longitude' => null]);
		}
	}

	public function setCoords() {
		$location = Cache::rememberForever(strtolower('geocode.'.str_slug($this->addressForCoords)), function() {
			return Map::coords($this->addressForCoords);
		});

		if ($location !== false) {
			$this->latitude = $location['latitude'];
			$this->longitude = $location['longitude'];
		} else {
			$this->latitude = null;
			$this->longitude = null;
		}
	}

	public function getAddressForCoordsAttribute() {
		$a = '';

		if (isset($this->address) && is_string($this->address)) {
			$a .= $this->address.', ';
		}

		if (isset($this->zip) && is_string($this->zip)) {
			$a .= $this->zip.' ';
		}

		if (isset($this->city) && is_string($this->city)) {
			$a .= $this->city;
		}

		return $a;
	}

	public function distanceIsGreaterThan($location, $value) {
		$d = Map::distance($location, $this->latitude.','.$this->longitude);
		return $d !== false && $d >= $value;
	}

	public function distanceIsLowerThan($location, $value) {
		$d = Map::distance($location, $this->latitude.','.$this->longitude);
		return $d !== false && $d <= $value;
	}

	public static function bootHasMap() {
		static::saving(function($model) {
			$model->setCoords();
		});
	}

	public function newCollection(array $models = []) {
		return new MapCollection($models);
	}
}
