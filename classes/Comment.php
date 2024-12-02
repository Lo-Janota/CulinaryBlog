<?php

class Comment {
    public $user;
    public $text;

    public function __construct($user, $text) {
        $this->user = $user;
        $this->text = $text;
    }
}
?>
