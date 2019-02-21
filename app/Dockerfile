from nanayu/munoh-api:latest
# php customize
ADD php.ini /usr/local/etc/php
# application setting
COPY ./ChatterBot /var/www/html/ChatterBot
# cron setting
ADD artisan-job-cron /etc/cron.d/artisan-job-cron
RUN chmod 0644 /etc/cron.d/artisan-job-cron

