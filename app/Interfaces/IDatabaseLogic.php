<?php

namespace App\Interfaces;

interface IDatabaseLogic{
    public static function search($table, $filters = []);
}
