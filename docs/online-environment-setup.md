# 环境安装
* 环境采用PHP5.5-fpm + Nginx + MySQL
```
$ vi /etc/sysconfig/iptables
-A INPUT -m state --state NEW -m tcp -p tcp --dport 80 -j ACCEPT
-A INPUT -m state --state NEW -m tcp -p tcp --dport 3306 -j ACCEPT
```

* 关闭SELINUX
```
$ vim /etc/selinux/config
SELINUX=disabled
```

* 安装Nginx & MySQL
```
$ yum -y install nginx mysql mysql-server
$ chkconfig nginx on
$ chkconfig mysql on
设置root 密码
$ mysql_secure_installation
```

* 安装PHP5.5

参照：https://webtatic.com/packages/php55/
```
$ rpm -Uvh https://mirror.webtatic.com/yum/el6/latest.rpm
$ yum install php55w php55w-opcache php55w-mysql php55w-gd libjpeg* php55w-imap php55w-ldap php55w-odbc php55w-pear php55w-xml php55w-xmlrpc php55w-mbstring php55w-mcrypt php55w-bcmath php55w-mhash libmcrypt
$ vim /etc/php.ini
  date.timezone = PRC
  ```

* 代码克隆并实现自动更新
bob's qcloud /var/www/html/coding.net/idarex 使用计划任务来自动更新代码

* 权限

* 项目初始化
```
$ ./init
select Prod
```
