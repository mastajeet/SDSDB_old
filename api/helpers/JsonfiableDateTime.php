<?php


namespace SDSApi;

use DateTime;
use JsonSerializable;

class JsonfiableDateTime extends DateTime implements JsonSerializable
{
    public function jsonSerialize()
    {
        return $this->format("c");
    }
}