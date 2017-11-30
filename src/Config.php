<?php
/**
 * 2017/5/15 17:36:25
 * config component
 */
namespace Tian;

use Dotenv\Dotenv;

class Config
{
	//配置集合
    protected $items = [];
    //批量设置配置项
    public function batch(array $config)
    {
        foreach ($config as $k => $v) {
            $this->set($k, $v);
        }
        return true;
    }

    /**
     * 设置.env目录
     * 设置变量到$_EVN环境变量上去
     * @param  string $path
     * @param string $file
     * @return void
     */
    public function loadEnv($path = '.', $file = '.env')
    {
        (new Dotenv($path, $file))->load();
    }

    /**
     * 设置.env目录
     *
     * @param $name
     * @param null $value
     * @return null
     */
    public function env($name, $value = null)
    {
        return getenv($name) ?: $value;
    }
      
    /**
     * 加载目录下的所有文件
     *
     * @param string $dir 目录
     */
    public function loadFiles($dir)
    {
        foreach (glob($dir.'/*') as $f) {
            $info = pathinfo($f);
            $this->set($info['filename'], include $f);
        }
    }
    /**
     * 添加配置
     *
     * @param $key
     * @param $name
     *
     * @return bool
     */
    public function set($key, $name)
    {
        $tmp    = &$this->items;
        $config = explode('.', $key);
        foreach ((array)$config as $d) {
            if ( ! isset($tmp[$d])) {
                $tmp[$d] = [];
            }
            $tmp = &$tmp[$d];
        }
        $tmp = $name;
        return true;
    }
    /**
     * @param string $key     配置标识
     * @param mixed  $default 配置不存在时返回的默认值
     *
     * @return array|mixed|null
     */
    public function get($key, $default = null)
    {
        $tmp    = $this->items;
        $config = explode('.', $key);
        foreach ((array)$config as $d) {
            if (isset($tmp[$d])) {
                $tmp = $tmp[$d];
            } else {
                return $default;
            }
        }
        return $tmp;
    }

    /**
     * 排队字段获取数据
     *
     * @param string $key 获取键名
     * @param array $extame
     * @return array
     */
    public function getExName($key, array $extame)
    {
        $config = $this->get($key);
        $data   = [];
        foreach ((array)$config as $k => $v) {
            if ( ! in_array($k, $extame)) {
                $data[$k] = $v;
            }
        }
        return $data;
    }
    /**
     * 检测配置是否存在
     *
     * @param $key
     *
     * @return bool
     */
    public function has($key)
    {
        $tmp    = $this->items;
        $config = explode('.', $key);
        foreach ((array)$config as $d) {
            if (isset($tmp[$d])) {
                $tmp = $tmp[$d];
            } else {
                return false;
            }
        }
        return true;
    }
    /**
     * 获取所有配置项
     *
     * @return array
     */
    public function all()
    {
        return $this->items;
    }
    /**
     * 设置items也就是一次更改全部配置
     *
     * @param $items
     *
     * @return mixed
     */
    public function setItems($items)
    {
        return $this->items = $items;
    }	
}
