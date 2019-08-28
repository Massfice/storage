<?php

  namespace Massfice\Storage;

  class Shelf implements \Iterator {

    private $position;

    private $data;

    private $json_allowed;
    private $session_allowed;
    private $override_allowed;
    private $override_session_allowed;
    private $modify_allowed;

    private $builder;

    public function __construct(ShelfBuilder $sb) {
      $this->clearData();
      $this
        ->setJsonAllowed($sb->getJsonAllowed())
        ->setSessionAllowed($sb->getSessionAllowed())
        ->setOverrideAllowed($sb->getOverrideAllowed())
        ->setOverrideSessionAllowed($sb->getOverrideSessionAllowed())
        ->setModifyAllowed($sb->getModifyAllowed());
      $this->rewind();

      $this->builder = $sb;
    }

    public function getData($key) {
      if(isset($this->data[$key])) return $this->data[$key];
      else return null;
    }

    public function addData(string $key, $data, bool $override_allowed = false) : self {
      if(!isset($this->data[$key]) || ($override_allowed && $this->override_allowed))
        $this->data[$key] = $data;
        return $this;
    }

    public function clearData(string ...$clear_this) : self {
      if(count($clear_this) == 0) $this->data = [];
      else {
        foreach ($clear_this as $k) {
          if(isset($this->data[$k])) unset($this->data[$k]);
        }
      }
      return $this;
    }

    public function addToStorage($key, bool $override_allowed = false) : self {
      Storage::getInstance()->addShelf($key,$this,$override_allowed);
      return $this;
    }

    public function makeJson() : string {
      if($this->json_allowed) return json_encode($this->data);
      else return '';
    }

    public function storeSession(string $key, bool $override_session_allowed) {
      @session_start();
      if($this->session_allowed) {
        if(!isset($_SESSION[$key]) || ($override_session_allowed && $this->override_session_allowed))
          $_SESSION[$key] = serialize($this);
      }
    }

    public function getBuilder() : ShelfBuilder {
      return $this->builder;
    }

    public function getAllData() : array {
      return $this->data;
    }

    //Setters
    public function setJsonAllowed(bool $json_allowed) : self {
      if(!isset($this->modify_allowed) || $this->modify_allowed)
        $this->json_allowed = $json_allowed;
      return $this;
    }

    public function setSessionAllowed(bool $session_allowed) : self {
      if(!isset($this->modify_allowed) || $this->modify_allowed)
        $this->session_allowed = $session_allowed;
      return $this;
    }

    public function setOverrideAllowed(bool $override_allowed) : self {
      if(!isset($this->modify_allowed) || $this->modify_allowed)
        $this->override_allowed = $override_allowed;
      return $this;
    }

    public function setOverrideSessionAllowed(bool $override_session_allowed) : self {
      if(!isset($this->modify_allowed) || $this->modify_allowed)
        $this->override_session_allowed = $override_session_allowed;
      return $this;
    }

    public function setModifyAllowed(bool $modify_allowed) : self {
      if(!isset($this->modify_allowed) || $this->modify_allowed)
        $this->modify_allowed = $modify_allowed;
      return $this;
    }

    //Iterator
    public function rewind() {
      $this->position = 0;
    }

    public function current() {
      return $this->data[array_keys($this->data)[$this->position]];
    }

    public function key() {
      return array_keys($this->data)[$this->position];
    }

    public function next() {
      $this->position++;
    }

    public function valid() {
      return isset(array_keys($this->data)[$this->position]);
    }
  }

?>
