<?php

  namespace Massfice\Storage;

  class ShelfBuilder {

    private $json_allowed;
    private $session_allowed;
    private $override_allowed;
    private $override_session_allowed;
    private $modify_allowed;

    private function __construct() {
      $this->json_allowed = false;
      $this->session_allowed = false;
      $this->override_allowed = true;
      $this->override_session_allowed = true;
      $this->modify_allowed = false;
    }

    public static function getBuilder() : self {
      return new ShelfBuilder();
    }

    public function build() : Shelf {
      return new Shelf($this);
    }

    public function load(string $key) : Shelf {
      return ShelfSessionLoader::safeLoad($key,$this);
    }

    //Seters and Geters
    public function setJsonAllowed(bool $json_allowed) : self {
      $this->json_allowed = $json_allowed;
      return $this;
    }

    public function getJsonAllowed() : bool {
      return $this->json_allowed;
    }

    public function setSessionAllowed(bool $session_allowed) : self {
      $this->session_allowed = $session_allowed;
      return $this;
    }

    public function getSessionAllowed() : bool {
      return $this->session_allowed;
    }

    public function setOverrideAllowed(bool $override_allowed) : self {
      $this->override_allowed = $override_allowed;
      return $this;
    }

    public function getOverrideAllowed() :bool {
      return $this->override_allowed;
    }

    public function setOverrideSessionAllowed(bool $override_session_allowed) : self {
      $this->override_session_allowed = $override_session_allowed;
      return $this;
    }

    public function getOverrideSessionAllowed() :bool {
      return $this->override_session_allowed;
    }

    public function setModifyAllowed(bool $modify_allowed) : self {
      $this->modify_allowed = $modify_allowed;
      return $this;
    }

    public function getModifyAllowed() : bool {
      return $this->modify_allowed;
    }

  }

?>
