<?php
class SitemapLog 
{
  const TYPE_MSG = 0;
  const TYPE_WARN = 1;
  const TYPE_ERR  = 2;

  function message($message)
  {
    $this->log($message);
  }

  function warning($message)
  {
    $this->log($message,self::TYPE_WARN);
  }

  function error($message)
  {
    $this->log($message,self::TYPE_ERR);
  }

  function log($message, $type = self::TYPE_MSG)
  {
     switch($type)
     {
       case self::TYPE_MSG:
         $log_message = $message.PHP_EOL;
       break;

       case self::TYPE_WARN:
         $log_message = "WARNING: $message".PHP_EOL;
       break;

       case self::TYPE_ERR:
         $log_message = "ERROR: $message".PHP_EOL;
         throw new Exception($message);
       break;
     }
  }
}
