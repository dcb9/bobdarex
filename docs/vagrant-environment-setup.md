# 本地使用 Vagrant 进行测试

## 安装 Vagrant 

1. 安装 VirtualBox

虚拟机还是得依靠 VirtualBox 来搭建，免费小巧。
下载地址：https://www.virtualbox.org/wiki/Downloads

* 虽然 Vagrant 也支持 VMware，不过 VMware 是收费的，对应的 Vagrant 版本也是收费的

2. 安装 Vagrant

下载地址：http://downloads.vagrantup.com/ 根据提示一步步安装。

参照：http://segmentfault.com/blog/fenbox/1190000000264347

## 添加镜像到 Vagrant

```
$ mkdir vagrant
把镜像文件放到刚才创建的目录：idarex_development_v0.1.box 
$ vagrant box add base idarex_development_v0.1.box
$ vagrant init
修改配置文件
$ vim Vagrantfile
# line: 31 config.vm.network 前面的井号删除
# line: 46 config.vm.synced_folder "你idarex项目的目录", "/var/www/html/idarex"

$ vagrant up
```
Vagrant 测试机的IP为： 192.168.33.10  root 密码为 vagrant 可直接通过用户名密码连接

如果在本地开发测试时，需要修改本地的hosts：

```
192.168.33.10 idarex.com www.idarex.com
192.168.33.10 weixin.idarex.com api.idarex.com
```
这时切换hosts  推荐使用 Gas Mask 来进行线上环境和本地环境的 hosts 切换。

## 代码初始化
```
$ ssh root@192.168.33.10  # 连接到 Vagrant 虚拟机
$ cd /var/www/html/idarex  # 切换到项目目录
$ cp /var/www/html/idarex/environments/nginx.conf /etc/nginx/nginx.conf # 使用最新的nginx配置文件
$ ./init    # 这时候输入  0 Development在本地就选这个
```

然后尽管在浏览器里面访问吧！
