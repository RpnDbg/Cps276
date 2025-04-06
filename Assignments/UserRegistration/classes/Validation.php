<?php
class Validation {

  public function name($name) {
    return preg_match("/^[a-zA-Z\s']+$/", $name);
  }

  public function email($email) {
    return filter_var($email, FILTER_VALIDATE_EMAIL);
  }

  public function password($password) {
    return preg_match("/^(?=.*[A-Z])(?=.*\d)(?=.*\W).{8,}$/", $password);
  }
}
