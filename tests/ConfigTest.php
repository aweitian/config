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

    public function testRm()
    {
        $config = new Config();
        $config->set('a.b.c','foo');
//        var_dump($config->all());
        $config->remove('a.b.c');//array('a'=>array('b'=>array()))
        //var_dump($config->all());
        $config->set('g','g');

        $config->remove('g');//array('a'=>array('b'=>array()))
        $config->remove('a');//array()
        $config->set('a.b.c','foo');
        $config->remove('a.b');//array('a'=>array())
        //var_dump($config->all());
    }
}

