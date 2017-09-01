<?php

namespace Zoomyboy\Map;

interface MapServiceInterface {
	public function coords($address, $zip, $city);
	public function distance($from, $to);
}
