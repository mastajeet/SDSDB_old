<?php

function getOrDefault(&$var, $default=null) {
    return isset($var) ? $var : $default;
}
