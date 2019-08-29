<?php
  namespace Massfice\Storage\UtilsManager;

  interface SessionUtilInterface {
    public function store(string $key, $data);
    public function load(string $key);
    public function unset(string $key);
    public function isset(string $key) : bool;
  }
?>
