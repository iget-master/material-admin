<?php

use Carbon\Carbon;

function getFormatedDate($date, $raw = false) {
	if ($date instanceof Carbon) {
        if ($raw) {
            return $date->toDateString();
        } else {
            return $date->format('d/m/Y');
        }
	} else {
		return '';
	}
}

function getFormatedDateTime($date) {
	if ($date instanceof Carbon) {
		return $date->format('d/m/Y G:i:s');
	} else {
		return '';
	}
}

function formatMonetary($value, $precision = 2) {
	return number_format($value, $precision, ',', '.');
}