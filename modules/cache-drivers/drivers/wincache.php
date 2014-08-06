<?php
class phpfastcache_wincache extends phpFastCache implements phpfastcache_driver  {

    function checkdriver() {
        if(extension_loaded('wincache') && function_exists("wincache_ucache_set"))
        {
            return true;
        }
        return false;
    }

    function __construct($option = array()) {
        $this->setOption($option);
        if(!$this->checkdriver() && !isset($option['skipError'])) {
            throw new Exception("Can't use this driver for your website!");
        }

    }

    function driver_set($keyword, $value = "", $time = 300, $option = array() ) {
        if(isset($option['skipExisting']) && $option['skipExisting'] == true) {
            return wincache_ucache_add($keyword, $value, $time);
        } else {
            return wincache_ucache_set($keyword, $value, $time);
        }
    }

    function driver_get($keyword, $option = array()) {
        // return null if no caching
        // return value if in caching

        $x = wincache_ucache_get($keyword,$suc);

        if($suc == false) {
            return null;
        } else {
            return $x;
        }
    }

    function driver_delete($keyword, $option = array()) {
        return wincache_ucache_delete($keyword);
    }

    function driver_clean($option = array()) {
        wincache_ucache_clear();
        return true;
    }

    function driver_isExisting($keyword) {
        if(wincache_ucache_exists($keyword)) {
            return true;
        } else {
            return false;
        }
    }



}