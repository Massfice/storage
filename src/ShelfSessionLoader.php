<?php

  namespace Massfice\Storage;

  class ShelfSessionLoader {

    public static function load(string $key) : Shelf {
      @session_start();
      return unserialize($_SESSION[$key]);
    }

    public static function isStored(string $key) : bool {
      @session_start();
      if(isset($_SESSION[$key]) && is_string($_SESSION[$key]))
        $shelf = @unserialize($_SESSION[$key]); //@ - wyłącza notice'a
      else
        return false;

      return $shelf && $shelf instanceof Shelf;
    }

    public static function safeLoad(string $key, ShelfBuilder $sb) : Shelf {
      @session_start();
      if(self::isStored($key)) return unserialize($_SESSION[$key]);
      else return $sb->build();
    }

  }

?>
