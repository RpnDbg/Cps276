<?php
class StickyForm {

  public function set($data, $field) {
    return isset($data[$field]) ? htmlspecialchars($data[$field]) : '';
  }

}
