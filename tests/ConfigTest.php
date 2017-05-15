<?php
class ConfigTest extends PHPUnit_Framework_TestCase
{
  	public function setup()
  	{
  		
  	}
    public function testLoadEnv()
    {
    	\Tian\Config::loadEnv(__DIR__.'/env');
    	$this->assertEquals(\Tian\Config::env("DB_HOST"),"127.0.0.1");
    	$this->assertEquals(\Tian\Config::env("empty","default"), "default");
    }
    public function testSetget()
    {
    	\Tian\Config::set("db.name", "qq");
    	$this->assertEquals(\Tian\Config::get("db.name"),"qq");
    	$arr = \Tian\Config::all();
    	$this->assertEquals($arr["db"]["name"], "qq");
    	$this->assertEquals(\Tian\Config::get("db.name"), "qq");
    	$this->assertEquals(\Tian\Config::get("db.nonexist","missing"), "missing");
    }
    public function testBatchHasEx()
    {
    	\Tian\Config::batch(['app.debug'=>true,'database.host'=>'localhost']);
    	$this->assertEquals(\Tian\Config::get("app.debug"),true);
    	$this->assertTrue(\Tian\Config::has("app.debug"));
    	\Tian\Config::set("app.name", "app");
    	\Tian\Config::set("app.ver", 1.1);
    	\Tian\Config::set("app.cookie", 'cookie');
    	\Tian\Config::set("app.author", 'awei.tian');
    	$data = \Tian\Config::getExName("app", ['name','cookie']);
    	$this->assertArrayHasKey("ver", $data);
    }
   
}


