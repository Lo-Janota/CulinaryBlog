<?php
class Post {
    public $title;
    public $content;
    public $image;
    public $ratings = [];
    public $comments = [];

    public function __construct($title, $content, $image) {
        $this->title = $title;
        $this->content = $content;
        $this->image = $image;
    }

    public function addRating($rating) {
        $this->ratings[] = $rating;
    }

    public function addComment($comment) {
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
