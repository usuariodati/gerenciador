<?php

namespace App\Traits;

trait PersonalTrait {
    public $open = false;

    public function clearFields() {
        $this->reset();
    }

    public function create() {
        $this->clearFields();
        $this->open = true;
    }

    public function close() {
        $this->open = false;
        $this->clearFields();
    }
}