<?php
class GenString{
  private $oldString;
  private $lastChar;
  private $newChar;
  private $newString;

  public function __construct($oldString){
      $this->oldString = $oldString;

      //a-zA-Z0-9'
      /**
      *If the last char is 'a'  through 'y' add 1 to char number etc  A = 41
      *If the last char is 'A'  through 'Y' add 1 to char number etc B = 42
      *If the last char is '0'  through 'y' add 1 to char number
      *If the last char is 'z' change char number to 'A'
      *If the last char is 'Z' change char number to '0'
      *If the last char is '9' add 'a' to the end of the string
      */

      $this->lastChar = substr($this->oldString, -1);

      if(ctype_lower($this->lastChar)){
        if(ord($this->lastChar) == 122){
          $this->newChar = chr(65);
          $this->makeNewString();
          //Change z to A
        }
        else{
          $this->newChar = chr(ord($this->lastChar)+1);
          $this->makeNewString();
          //Change x to x+1
        }
      }
      else if(ctype_upper($this->lastChar)){
        if(ord($this->lastChar) == 90){
          $this->newChar = chr(48);
          $this->makeNewString();
          //change Z to 0
        }
        else{
          $this->newChar = chr(ord($this->lastChar)+1);
          $this->makeNewString();
          //change x to x+1
        }
      }
      else if(ctype_digit($this->lastChar)){
        if(ord($this->lastChar) == 57){
          $this->newChar = $this->lastChar."a";
          $this->makeNewString();
          //Add 'a' to the end of the original string
        }
        else{
          $this->newChar = chr(ord($this->lastChar)+1);
          $this->makeNewString();
          //change x to x+1
        }
      }
  }
  public function makeNewString(){
    $this->newString = substr_replace($this->oldString, "", -1).$this->newChar;
    //$this->printNewString();
  }
  //printNewString not working
  public function printNewString(){
    echo $this->newString;
  }
  public function getNewString(){
    return $this->newString;
  }

}
