<?php

namespace vendor\libs;

class Cache{

    public function set($key, $data, $seconds = 3600){
        $content['data'] = $data;
        $content['endTime'] = time() + $seconds;
        if (file_put_contents(ROOT . "/" . md5($key) . '.txt', serialize($content))){
            return true;
        }
        return false;
    }

    public function get($key){
        $fileName = ROOT . "/" . md5($key) . '.txt';
        if (file_exists($fileName)) {
            $content = unserialize(file_get_contents($fileName));
            if (time() <= $content['endTime']) {
                return $content['data'];
            }
            unlink($fileName);
        }
        return false;
    }

    public function delete($key){
        $fileName = ROOT . "/" . md5($key) . '.txt';
        if (file_exists($fileName)) {
            unlink($fileName);
        }
    }
}
?>