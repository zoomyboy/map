<?php

namespace Zoomyboy\Map;

class MapService implements MapServiceInterface {

	private $key = false;

	public function __construct($key) {
		if ($key) {
			$this->key = $key;
		}
	}

	public function fromAddressParts($address = null, $zip = null, $city = null) {
		$a = '';

		if (is_string($this->address)) {
			$a .= $this->address.', ';
		}

		if (is_string($this->zip)) {
			$a .= $this->zip.' ';
		}

		if (is_string($this->city)) {
			$a .= $this->city;
		}

		return $a;
	}

	public function coords($address, $zip='', $city='') {
		$location = '';

		$location .= $address.(($zip) ? ', ' : '').(($city) ? ' '.$city : '');

		$data = json_decode(file_get_contents('https://maps.googleapis.com/maps/api/geocode/json?address='.rawurlencode($location).(($this->key) ? '&key='.$this->key : '')));

		if ($data->status != 'OK') {
			return false;
		}

		return [
			'latitude' => $data->results[0]->geometry->location->lat,
			'longitude' => $data->results[0]->geometry->location->lng
		];
	}

	public function distance($from, $to) {
		$data = json_decode(file_get_contents('https://maps.googleapis.com/maps/api/distancematrix/json?units=metric&origins='.rawurlencode($from).'&destinations='.rawurlencode($to)));

		if($data->rows[0]->elements[0]->status == 'NOT_FOUND' || $data->rows[0]->elements[0]->status == 'ZERO_RESULTS') {
			return false;
		}

		return $data->rows[0]->elements[0]->distance->value;
	}
}
