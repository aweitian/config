<?php

use Aw\Config;

class ConfigTest extends PHPUnit_Framework_TestCase
{
    public function testloadFiles()
    {
        $config = new Config();
        $config->loadFiles(__DIR__.'/config');
        $this->assertEquals('Laravel',$config->get('app.name'));
        $this->assertEquals('bar',$config->get('app.arr.foo'));
        $this->assertEquals('AES-256-CBC',$config->get('app.cipher'));
        $this->assertEquals('AES-256-CBC',$config->get('app.cipher'));
    }
}

