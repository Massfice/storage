<?php
  namespace Massfice\Storage\UtilsManager;

  class UtilsManager {

    private static $instance;

    private $session_util;
    private $json_util;

    private function __construct() {
      $this
        ->setJsonUtil(new JsonUtil())
        ->setSessionUtil(new SessionUtil());
    }

    public static function getInstance() : self {
      if(!isset(self::$instance)) self::$instance = new UtilsManager();
      return self::$instance;
    }

    //Setters and Getters
    public function setSessionUtil(SessionUtilInterface $util) : self {
      $this->session_util = $util;
      return $this;
    }

    public function getSessionUtil() : SessionUtilInterface {
      return $this->session_util;
    }

    public function setJsonUtil(JsonUtilInterface $util) : self {
      $this->json_util = $util;
      return $this;
    }

    public function getJsonUtil() : JsonUtilInterface {
      return $this->json_util;
    }

  }
?>
