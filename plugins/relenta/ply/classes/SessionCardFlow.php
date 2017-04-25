<?php namespace Relenta\Ply\Classes;

use Relenta\Ply\Classes\CardFlow;

class SessionCardFlow implements CardFlow {
    public function save($data) {

    }

    public function get($parent) {
        return Card::where(['unit' => 1])->with('sides')->inRandomOrder()->first();
    }
}