<?php

  namespace Massfice\Storage;

  class Storage {

      private static $instance;

      private $shelfs;

      private $override_allowed;
      private $modify_allowed;

      private function __construct() {
        $this->removeShelfs();
        $this->override_allowed = true;
      }

      public static function getInstance() : self {
        if(!isset(self::$instance)) self::$instance = new Storage();
        return self::$instance;
      }

      public function setOverrideAllowed(bool $override_allowed) : self {
        if(!isset($this->modify_allowed) || $this->modify_allowed)
          $this->override_allowed = $override_allowed;
        return $this;
      }

      public function setModifyAllowed(bool $modify_allowed) : self {
        if(!isset($this->modify_allowed) || $this->modify_allowed)
          $this->modify_allowed = $modify_allowed;
        return $this;
      }

      public function addShelf(string $key, Shelf $shelf, bool $override_allowed = false) {
        if(!isset($this->shelfs[$key]) || ($override_allowed && $this->override_allowed))
          $this->shelfs[$key] = $shelf;
      }

      public function isShelf($key) : bool {
        return isset($this->shelfs[$key]);
      }

      public function getShelf($key) : Shelf {
        return $this->shelfs[$key];
      }

      public function getAllShelfs() : array {
        return $this->shelfs;
      }

      public function removeShelfs(string ...$remove_this) : self {
        if(count($remove_this) == 0) $this->shelfs = [];
        else {
          foreach ($remove_this as $r) {
            if(isset($this->shelfs[$r])) unset($this->shelfs[$r]);
          }
        }
        return $this;
      }

      public function makeJson() : string {

        $r = [];

        foreach($this->shelfs as $k => $s) {
          $buff = $s->makeJson();
          if($buff != '') {
            $buff = json_decode($buff,true);
            $r[$k] = $buff;
          }
        }

        return json_encode($r);
      }

      public function storeSession(string ...$override_allows) : self {
        foreach($this->shelfs as $k => $s) {
          $buff = in_array($k,$override_allows);
          $s->storeSession($k,$buff);
        }

        return self::$instance;
      }

  }

?>
