<?php

// Ex: app/helpers.php

function vite_asset($path)
{
    $manifestPath = public_path('build/manifest.json');

    if (!file_exists($manifestPath)) {
        throw new Exception('Vite manifest not found.');
    }

    $manifest = json_decode(file_get_contents($manifestPath), true);

    if (!array_key_exists($path, $manifest)) {
        throw new Exception("Unable to locate file in Vite manifest: {$path}");
    }

    return asset('build/' . $manifest[$path]['file']);
}
