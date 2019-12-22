FROM kanboard/kanboard:latest

RUN mkdir -p /var/www/app/plugins/Kanext

VOLUME /var/www/app/plugins/Kanext

# plugins
COPY config.php /var/www/app/
COPY .plugins/. /var/www/app/plugins/

# php configuration (disable opcache)
COPY php.ini /etc/php7/

# entrypoint
COPY entrypoint.sh /entrypoint.sh
RUN chmod +x /entrypoint.sh
ENTRYPOINT ["/entrypoint.sh"]
CMD []
