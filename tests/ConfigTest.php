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

    public function testFlatten()
    {
        $config = new Config();
        $config->set('a.b.c','foo');
        //var_dump($config->all());
        $config->set('g','g');

        $config->set('r.b.c','foo');
        $config->set('b.b.d','ad');
        $flatten = $config->flatten();
        $this->assertEquals('foo',$flatten['a.b.c']);
    }

    public function testIn()
    {
        $data = array(
            'a' => 'a',
            'b' => 'bb',
            'c' => 'ccc',
        );
        $config = new Config();
        $config->setItems($data);
        $ret = $config->filterIn('b,c');
        $this->assertEquals($ret['b'],'bb');
        $this->assertTrue(!array_key_exists('a',$ret));
    }

    public function testNotIn()
    {
        $data = array(
            'a' => 'a',
            'b' => 'bb',
            'c' => 'ccc',
            'ce' => 'eeeeeeeee',
        );
        $config = new Config();
        $config->setItems($data);
        $ret = $config->filterNotIn('b,c');
//        var_dump($ret);
        $this->assertEquals($ret['a'],'a');
        $this->assertEquals($ret['ce'],'eeeeeeeee');
        $this->assertTrue(!array_key_exists('b',$ret));
    }
}

