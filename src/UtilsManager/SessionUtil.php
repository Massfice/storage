<?php
  namespace Massfice\Storage\UtilsManager;

  class SessionUtil implements SessionUtilInterface {

    public function __construct() {
      @session_start();
    }

    public function store(string $key, $data) {
      $_SESSION[$key] = $data;
    }

    public function load(string $key) {
      return $_SESSION[$key];
    }

    public function unset(string $key) {
      unset($_SESSION[$key]);
    }

    public function isset(string $key) : bool {
      return isset($_SESSION[$key]);
    }
  }
?>
