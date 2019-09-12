<?php

  namespace Massfice\Storage;

  use Massfice\UtilsManager\UtilsManager;

  class ShelfSessionLoader {

    public static function load(string $key) : Shelf {
      $util = UtilsManager::getInstance()->getSessionUtil();
      return unserialize($util->load($key));
    }

    public static function isStored(string $key) : bool {
      $util = UtilsManager::getInstance()->getSessionUtil();
      if($util->isset($key) && is_string($util->load($key)))
        $shelf = @unserialize($util->load($key)); //@ - wyłącza notice'a
      else
        return false;

      return $shelf && $shelf instanceof Shelf;
    }

    public static function safeLoad(string $key, ShelfBuilder $sb) : Shelf {
      if(self::isStored($key)) return self::load($key);
      else return $sb->build();
    }

    public static function remove(string $key) : Shelf {
      $util = UtilsManager::getInstance()->getSessionUtil();
      if(self::isStored($key)) {
        $shelf = self::load($key);
        $util->unset($key);
        return $shelf;
      }
    }

  }

?>
