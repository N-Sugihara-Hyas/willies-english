!/bin/bash

sudo yum install php-mysql php php-cli php-devel php-pdo php-mbstring php-mcrypt php-gd php-imap php-intl php-common
sudo yum install mysql-devel mysql-libs mysql-server mysql

sudo service mysqld restart
sudo chkconfig mysqld on

sudo yum install httpd

sudo service httpd restart
sudo chkconfig httpd on

sudo rm -rf /var/www/html

sudo ln -fs /vagrant/