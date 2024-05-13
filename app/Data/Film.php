<?php

namespace App\Data;

class Film
{
    var string $title;
    public function __construct(string $title)
    {
        $this->title = $title;
    }
}
