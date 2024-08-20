<?php

namespace Service;

class Book {
    private $id;
    private $name;
    private $author_id;
    private $date_of_issue;
    private $rating;
    private $number_of_copies;

    public function getId() {
        return $this->id;
    }

    public function setId($id) {
        $this->id = $id;
    }

    public function getName() {
        return $this->name;
    }

    public function setName($name) {
        $this->name = $name;
    }

    public function getAuthorId() {
        return $this->author_id;
    }

    public function setAuthorId($author_id) {
        $this->author_id = $author_id;
    }

    public function getDateOfIssue() {
        return $this->date_of_issue;
    }

    public function setDateOfIssue($date_of_issue) {
        $this->date_of_issue = $date_of_issue;
    }

    public function getRating() {
        return $this->rating;
    }

    public function setRating($rating) {
        $this->rating = $rating;
    }

    public function getNumberOfCopies() {
        return $this->number_of_copies;
    }

    public function setNumberOfCopies($number_of_copies) {
        $this->number_of_copies = $number_of_copies;
    }
}
