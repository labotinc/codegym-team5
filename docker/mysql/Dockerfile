# Dockerfile_MySQL
FROM mysql:8.0

# Set debian default locale to ja_JP.UTF-8
RUN apt-get update \
  && apt-get install -y locales \
  && rm -rf /var/lib/apt/lists/* \
  && echo "ja_JP.UTF-8 UTF-8" > /etc/locale.gen \
  && locale-gen ja_JP.UTF-8
ENV LC_ALL ja_JP.UTF-8

# Set MySQL character
RUN { \
  echo '[mysqld]'; \
  echo 'character-set-server=utf8'; \
  echo 'default_authentication_plugin=mysql_native_password'; \
  echo 'collation-server=utf8_general_ci'; \
  echo '[client]'; \
  echo 'default-character-set=utf8'; \
  } > /etc/mysql/conf.d/my.cnf
