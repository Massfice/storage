<?php
  namespace Massfice\Storage\UtilsManager;

  class JsonUtil implements JsonUtilInterface {
    public function encode(array $array) : string {
      return json_encode($array);
    }

    public function decode(string $json) {
      return json_decode($json,true);
    }
  }
?>
