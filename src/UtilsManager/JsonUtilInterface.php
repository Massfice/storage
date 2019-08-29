<?php
  namespace Massfice\Storage\UtilsManager;

  interface JsonUtilInterface {
    public function encode(array $array) : string;
    public function decode(string $json);
  }
?>
