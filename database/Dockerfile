FROM mysql:8.0.30
ENV MYSQL_ROOT_PASSWORD=test
COPY resources/database.sql /docker-entrypoint-initdb.d/
RUN echo "[mysqld]\n\
character-set-server=utf8mb4\n\
collation-server=utf8mb4_unicode_ci" > /etc/mysql/conf.d/charset.cnf
EXPOSE 3306