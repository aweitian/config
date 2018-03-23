<?php
/**
 * 2017/5/15 17:36:25
 * config component
 */

namespace Aw;


class Config
{
    //配置集合
    protected $items = array();

    //批量设置配置项
    public function batch(array $config)
    {
        foreach ($config as $k => $v) {
            $this->set($k, $v);
        }
        return true;
    }

    /**
     * 加载目录下的所有文件
     *
     * @param string $dir 目录
     */
    public function loadFiles($dir)
    {
        foreach (glob($dir . '/*') as $f) {
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
        $tmp = &$this->items;
        $config = explode('.', $key);
        foreach ((array)$config as $d) {
            if (!isset($tmp[$d])) {
                $tmp[$d] = array();
            }
            $tmp = &$tmp[$d];
        }
        $tmp = $name;
        return true;
    }

    /**
     * @param string $key 配置标识
     * @param mixed $default 配置不存在时返回的默认值
     *
     * @return array|mixed|null
     */
    public function get($key, $default = null)
    {
        $tmp = $this->items;
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
        $data = array();
        foreach ((array)$config as $k => $v) {
            if (!in_array($k, $extame)) {
                $data[$k] = $v;
            }
        }
        return $data;
    }

    /**
     * Flatten a multi-dimensional array into a single level.
     *
     * @param  array $array
     * @param string $path
     * @param int $depth
     * @return array
     */
    public function flatten($array = null, $path = '', $depth = INF)
    {
        if (is_null($array)) {
            $array = $this->items;
        }
        $result = array();
        foreach ($array as $key => $item) {
            if (!is_array($item)) {
                $result[$path ? $path . "." . $key : $key] = $item;
            } elseif ($depth === 1) {
                $result = array_merge($result, $item);
            } else {
                $result = array_merge($result, $this->flatten($item, $path ? $path . "." . $key : $key, $depth - 1));
            }
        }
        return $result;
    }

    /**
     * @param $keys
     * @return array
     */
    public function filterIn($keys)
    {
        if (is_string($keys)) {
            $keys = explode(',', $keys);
        }
        $ret = array();
        foreach ($keys as $key) {
            if (array_key_exists($key, $this->items)) {
                $ret[$key] = $this->items[$key];
            }
        }
        return $ret;
    }

    /**
     * @param $keys
     * @return array
     */
    public function filterNotIn($keys)
    {
        if (is_string($keys)) {
            $keys = explode(',', $keys);
        }
        $ret = array();
        $data = $this->flatten();
        foreach ($data as $k => $item) {
            if (!in_array($k, $keys)) {
                $ret[$k] = $data[$k];
            }
        }
        return $ret;
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
        $tmp = $this->items;
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
     * 删除最后一节
     * @param $key
     * @return bool
     */
    public function remove($key)
    {
        $tmp = &$this->items;
        $config = explode('.', $key);
        for ($i = 0; $i < count($config) - 1; $i++) {
            if (!isset($tmp[$config[$i]])) {
                return false;
            }
            $tmp = &$tmp[$config[$i]];
        }
        if (isset($config[$i])) {
            unset($tmp[$config[$i]]);
        }
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
