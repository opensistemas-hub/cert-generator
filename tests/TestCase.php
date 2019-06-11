<?php

namespace Tests;


abstract class TestCase extends \PHPUnit\Framework\TestCase
{


    public function getFilePath(String $file)
    {

        return __DIR__ . '/files/' . $file;

    }

    public function getSettingsFromJsonFile(String $file)
    {

        return json_decode(file_get_contents($this->getFilePath($file)), true);

    }
}