<?php

class Post {
    public $id;
    public $title;
    public $content;
    public $images = [];
    public $ratings = [];
    public $comments = [];
    public $averageRating;

    public function __construct($title, $content, $images, $id = null) {
        $this->id = $id;
        $this->title = $title;
        $this->content = $content;
        $this->images = $images;
        $this->averageRating = 0;
    }

    public function addRating($rating) {
        $this->ratings[] = $rating;
    }

    public function addComment(Comment $comment) {
        $this->comments[] = $comment;
    }

    public function getAverageRating() {
        if (count($this->ratings) > 0) {
            return array_sum($this->ratings) / count($this->ratings);
        }
        return 0;
    }
}
?>
