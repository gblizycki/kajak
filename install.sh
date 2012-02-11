//Wszystkie polecenia jako root
echo "deb http://downloads-distro.mongodb.org/repo/debian-sysvinit dist 10gen">>/etc/apt/source.list
apt-key adv --keyserver keyserver.ubuntu.com --recv 7F0CEB10
apt-get update
apt-get -y install apache2 apache2-doc apache2-utils php5-dev libapache2-mod-php5 make sudo php-pear mongodb-10gen mysql-server php5-mysql git
pecl install mongo
echo "extension=mongo.so">>/etc/php5/apache2/php.ini
a2enmod rewrite
cd /var/www
//jeżeli potrzeba proxy np (10.64.254.254:8080)
git config --global http.proxy http://10.64.254.254:8080/
git clone https://Gary131@github.com/Gary131/kajak.git
cd /var/www/kajak
find . –type d –exec chmod 777 {} \;
find . –name "*.php5" –exec rm {} \;
sed -i 's/AllowOverride None/AllowOverride All/g' /etc/apache2/sites-available/default
cd /var/www/kajak/protected/modules/rights/data
mysql –u root –p < schema.sql
mongorestore -d kajak ./kajak