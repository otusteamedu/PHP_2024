<?php

namespace Service;

class Author {
    private $id;
    private $name;
    private $last_name;
    private $patronymic;
    private $date_of_birth;
    private $date_of_death;
    private $country;
    private $gender;

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

    public function getLastName() {
        return $this->last_name;
    }

    public function setLastName($last_name) {
        $this->last_name = $last_name;
    }

    public function getPatronymic() {
        return $this->patronymic;
    }

    public function setPatronymic($patronymic) {
        $this->patronymic = $patronymic;
    }

    public function getDateOfBirth() {
        return $this->date_of_birth;
    }

    public function setDateOfBirth($date_of_birth) {
        $this->date_of_birth = $date_of_birth;
    }

    public function getDateOfDeath() {
        return $this->date_of_death;
    }

    public function setDateOfDeath($date_of_death) {
        $this->date_of_death = $date_of_death;
    }

    public function getCountry() {
        return $this->country;
    }

    public function setCountry($country) {
        $this->country = $country;
    }

    public function getGender() {
        return $this->gender;
    }

    public function setGender($gender) {
        $this->gender = $gender;
    }
}
