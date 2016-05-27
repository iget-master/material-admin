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

/**
 * Append version number do script to avoid caching issues on scripts.
 * @param string $url
 * @return string
 */
function versionedScriptUrl($url) {
    $version = str_replace('.', '', config('admin.app_version'));
    return $url . "?${version}";
}

if (! function_exists('versionedFileUrl')) {
    /**
     * Get the path to a versioned Elixir file.
     *
     * @param  string  $file
     * @return string
     *
     * @throws \InvalidArgumentException
     */
    function versionedFileUrl($file)
    {
        static $manifest = null;

        if (is_null($manifest)) {
            $manifest = json_decode(file_get_contents(public_path('iget-master/material-admin/build/rev-manifest.json')), true);
        }

        if (isset($manifest[$file])) {
            return '/iget-master/material-admin/build/'.$manifest[$file];
        }

        throw new InvalidArgumentException("File {$file} not defined in asset manifest.");
    }
}