<?php

function manifest($name = null) {
	$manifest_path = public_path('assets/manifest.json');

	if (!file_exists($manifest_path)) {
		return null;
	}

	$manifest_content = file_get_contents($manifest_path);
	$assets = json_decode($manifest_content, true);

	if (!isset($assets[$name])) {
		return null;
	}

	$asset_path = $assets[$name];

	if (substr($asset_path, 0, 1) !== '/') {
		$asset_path = '/' . $asset_path;
	}

	return $asset_path;
}
