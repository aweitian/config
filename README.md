# 配置

Config组件用于完成网站配置项管理。

##开始使用

####安装组件
使用 composer 命令进行安装或下载源代码使用。
````
composer require aweitian/config
````

####加载.env文件
参数为.env文件所在目录
````
Config::loadEnv(dirname(__DIR__));
````

一个简单的env内容如下:
````
DB_DRIVER=mysq22l
DB_HOST=127.0.0.1
DB_DATABASE=hdphp
DB_USER=root
DB_PASSWORD=
````

####读取env文件内容
````
tian\Config::env('DB_HOST','localhost');
````
读取.env文件中的 DB_HOST配置，如果为空时使用 localhost

####设置配置
````
tian\Config::set('alipay.key.auth','aweitian');
````

####加载所有文件
````
//加载config目录下的所有文件到配置容器中
tian\Config::loadFiles('config');
````

####设置多个配置
````
tian\Config::batch(['app.debug'=>true,'database.host'=>'localhost']);
````

####检测配置
````
tian\Config::has('web.master');
````

####获取配置
如果想要获取配置文件的所有内容，只传递文件名就可以：
````
tian\Config::get('app');
````

####获取子元素
获取配置文件使用 get 方法完成，参数为 ”配置文件名.配置项"的形式。
````
tian\Config::get('view.path');
````

####获取所有
也可以使用 all 方法获取所有配置，例如：
````
tian\Config::all();
````

####排除批定字段
````
tian\Config::getExName('database',['write','read']);
````
