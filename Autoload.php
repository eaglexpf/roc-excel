<?php
/**
 * Created by PhpStorm.
 * User: roc
 * Date: 2017/3/25
 * Time: 16:02
 */

namespace RocExcel;


class Autoload{
    public static function loadByNamespace($name){
        $class_path = str_replace('\\', DIRECTORY_SEPARATOR, $name);

        if (empty($class_file) || !is_file($class_file)) {
            $class_file = __DIR__ . DIRECTORY_SEPARATOR . '..' . DIRECTORY_SEPARATOR . '..' . DIRECTORY_SEPARATOR . '..' . DIRECTORY_SEPARATOR . "$class_path.php";
        }

        if (is_file($class_file)) {
            require_once($class_file);
            if (class_exists($name, false)) {
                return true;
            }
        }
        return false;
    }
}

spl_autoload_register('\RocExcel\Autoload::loadByNamespace');