from nanayu/munoh-api:latest
# php customize
COPY php.ini /usr/local/etc/php
# application setting
COPY ./ChatterBot /var/www/html/ChatterBot
# cron setting
COPY artisan-job-cron /var/spool/cron/crontabs/root
CMD bash -c "busybox crond && apachectl -D FOREGROUND"
