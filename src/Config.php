<?php
/**
 * 2017/5/15 17:36:25
 * config component
 */
namespace Tian;

class Config
{
	//配置集合
    protected static $items = [];
    //批量设置配置项
    public static function batch(array $config)
    {
        foreach ($config as $k => $v) {
            self::set($k, $v);
        }
        return true;
    }
    /**
     * 设置.env目录
     *
     * @param        $path
     * @param string $file
     */
    public static function loadEnv($path, $file = '.env')
    {
        (new \Dotenv\Dotenv($path, $file))->load();
    }

     /**
     * 设置.env目录
     *
     * @param        $path
     * @param string $file
     */
    public static function env($name, $value = null)
    {
        return getenv($name) ?: $value;
    }
      
    /**
     * 加载目录下的所有文件
     *
     * @param $dir 目录
     */
    public static function loadFiles($dir)
    {
        foreach (glob($dir.'/*') as $f) {
            $info = pathinfo($f);
            self::set($info['filename'], include $f);
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
    public static function set($key, $name)
    {
        $tmp    = &self::$items;
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
    public static function get($key, $default = null)
    {
        $tmp    = self::$items;
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
     * @param string $key     获取键名
     * @param array  $exName  排除的字段
     *
     * @return array
     */
    public static function getExName($key, array $extame)
    {
        $config = self::get($key);
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
    public static function has($key)
    {
        $tmp    = self::$items;
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
    public static function all()
    {
        return self::$items;
    }
    /**
     * 设置items也就是一次更改全部配置
     *
     * @param $items
     *
     * @return mixed
     */
    public static function setItems($items)
    {
        return self::$items = $items;
    }	
}
