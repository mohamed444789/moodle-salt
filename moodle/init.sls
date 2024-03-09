# Update
update_package_repos:
  cmd.run:
    - name: apt update
   
# Upgrade
upgrade_packages:
  cmd.run:
    - name: apt upgrade -y
    - require:
      - cmd: update_package_repos

# Autoremove
clean_up:
  cmd.run:
    - name: apt autoremove -y && apt autoclean
    - require:
      - cmd: upgrade_packages
# Install nginx and PostgreSQL
install_nginx_postgres:
  pkg.installed:
    - names:
      - nginx
      - postgresql
      - postgresql-contrib
      - fail2ban
# Install dependencies
install_dependencies:
  pkg.installed:
    - names:
      - software-properties-common
      - ca-certificates
      - lsb-release
      - apt-transport-https
# PHP repository
add_php_repository:
  cmd.run:
    - name: add-apt-repository ppa:ondrej/php -y && apt update
# Install Certbot  Nginx
install_certbot_nginx:
  pkg.installed:
    - name: python3-certbot-nginx
# Install PHP  package
install_php_packages:
  pkg.installed:
    - names:
      - php7.4
      - php7.4-fpm
      - php7.4-common
      - php7.4-pgsql
      - php7.4-gmp
      - php7.4-curl
      - php7.4-intl
      - php7.4-mbstring
      - php7.4-soap
      - php7.4-xmlrpc
      - php7.4-gd
      - php7.4-xml
      - php7.4-cli
      - php7.4-zip
      - unzip
      - git
      - curl

# replace php.ini
copy_php_ini:
  file.managed:
    - name: /etc/php/7.4/fpm/php.ini
    - source: salt://moodle/Files/php.ini
    - replace: True
#postgress
postgres_setup:
  cmd.run:
    - name: |
        sudo -u postgres psql -c "CREATE USER moodleuser WITH PASSWORD 'Admin123';"
        sudo -u postgres psql -c "CREATE DATABASE moodle;"
        sudo -u postgres psql -c "GRANT ALL PRIVILEGES ON DATABASE moodle to moodleuser;"
#copy moodle.conf
copy_moodle_conf:
  file.managed:
    - name: /etc/nginx/conf.d/moodle.conf
    - source: salt://moodle/Files/moodle.conf
    - user: root
    - group: root
    - replace: True

# Copy nginx.conf
copy_nginx_conf:
  file.managed:
    - name: /etc/nginx/nginx.conf
    - source: salt://moodle/Files/nginx.conf
    - user: root
    - group: root
    - replace: True

# Copy fail2ban.local
copy_fail2ban_local:
  file.managed:
    - name: /etc/fail2ban/jail.local
    - source: salt://moodle/Files/jail.local
    - user: root
    - group: root
    - replace: True


# /var/www/html/moodledata
create_moodledata_directory:
  cmd.run:
    - name: sudo mkdir -p /var/www/html/moodledata
    - unless: test -d /var/www/html/moodledata

# Clone Moodle repository
clone_moodle_repository:
  cmd.run:
    - name: git clone -b MOODLE_400_STABLE git://git.moodle.org/moodle.git moodle
    - cwd: /var/www/html
    - unless: test -d /var/www/html/moodle


#copy Plugin 
copy_files:
  file.recurse:
    - name: /var/www/html/moodle/blocks
    - source: salt://moodle/Files/plugin
    - replace: True

#/var/www/html/moodle directory
set_moodle_ownership:
  cmd.run:
    - name: sudo chown -R www-data:www-data /var/www/html/moodle

# /var/www/html/moodledata 
set_moodledata_ownership:
  cmd.run:
    - name: sudo chown www-data:www-data /var/www/html/moodledata

#  /var/www/html 
set_html_permissions:
  cmd.run:
    - name: sudo chmod -R 755 /var/www/html/*

#  nginx service  enable
nginx_enabled:
  service.enabled:
    - name: nginx
    - enable: True
# Restart nginx service
nginx_restarted:
  service.running:
    - name: nginx
    - restarted: True
# Enable  php7.4-fpm service
enable_php_fpm:
  service.enabled:
    - name: php7.4-fpm
    - enable: True
# Restart php7.4-fpm service
restart_php_fpm:
  service.running:
    - name: php7.4-fpm
    - restarted: True
# Enable postgresql service
enable_postgresql:
  service.enabled:
    - name: postgresql
    - enable: True
# Restart postgresql service
restart_postgresql:
  service.running:
    - name: postgresql
    - restarted: True
#Zertifikat installieren
letsencrypt_cert:
  cmd.run:
    - name: certbot --nginx --agree-tos -d at30.de -d www.at30.de --email deineEamil@email.com
    - unless: test -f /etc/letsencrypt/live/at30.de/fullchain.pem
