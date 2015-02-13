<?php if (!defined('BASEPATH')) exit("No direct script access allowed");

Class Assets {

    var $javascript = array();
    var $css = array();


    function Assets( $config=array() ) {

        $this->ci =& get_instance();

        if( !empty( $config ) ) {
            foreach($config as $k => $v) {
                $this->$k = $v;
            }
        }
        else {
            show_error("Assets configuration file is missing or is empty");
        }
    }

    function load( $file, $level="", $params=array() )
    {
        if(!$level) {
            $level = $this->default_level;
        }

        $type = strtolower( substr( strrchr( $file, '.' ), 1 ));

        if($type == 'jpg' || $type == 'jpeg' || $type == "png" || $type == 'gif' ) {
            $image_uri = base_url("$this->assets_folder/$level/images")."/".$file;

            $image_params = $this->generate_params($params);

            $output = '<img src="'.$image_uri.' ">';

            return $output;

        }

        elseif($type == 'js') {

            if(array_key_exists("extra", $params) && $params['extra'] != "") {
                $this->javascript[] = "$type/$level/$file/{$params["extra"]}";
            }

            else {
                $this->javascript[] = "$type/$level/$file";
            }
        }

        elseif( $type == 'css' ) {
            $this->css[] = "$type/$level/$file";
        } else {
            return false;
        }
    }

    function url($file, $level ="")
    {
        if(!$level) {
            $level = $this->default_level;
        }

        $type = strtolower( substr( strrchr( $file, '.' ), 1 ));

        if(array_key_exists( $type, $this->asset_types ))
        {
            foreach($this->asset_types as $asset_type => $folder) {
              if($type == $asset_type) {
                  $output = base_url("$this->assets_folder/$level/$folder")."/".$file;
                  return $output;
                  break;
              }
            }
        } else {
            show_error("$type is not a valid asset type");
        }
    }

    function generate_params($params) {
        $output = '';

        if(!empty($params)) {
            foreach($params as $k => $v) {
                $output .= ' ' . $k . '="' . $v . '"';
            }
        }
        return $output;
    }

    function display_header_assets() {
        $output = '';

        foreach($this->javascript as $file) {
            $output .= "\n";
        }

        foreach($this->css as $file) {
            $output .= "&lt;link type='text/css' rel='stylesheet' href='".site_url("asset").str_replace(".css","",$file)."/' /&gt;\n";
        }

        return $output;
    }
}