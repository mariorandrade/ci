<?php

/*
 * Assets Manager
 *
 * @see https://github.com/bcit-ci/CodeIgniter/wiki/Asset-Manager
 * @param assets_folder - root assets folder name
 * @param assets_path - path for assets folder
 * @param default_level - default assets folder (assets/public)
 * */

$config['assets_folder']    = "assets";
$config['assets_path']      = $_SERVER['DOCUMENT_ROOT']."/".$config['assets_folder'];
$config["default_level"]    = "public";

/*
 * Assets types
 * Each asset type can be associated with a specific folder
 * Asset
 * */

$config["asset_types"] = array(
    'jpg'   => 'images',
    'gif'   => 'images',
    'png'   => 'images',
    'js'    => 'js',
    'css'   => 'css',
);
