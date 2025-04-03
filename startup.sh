apt-get update && apt-get install -y librdkafka-dev
yes '' | pecl install rdkafka
cp /home/site/wwwroot/default /etc/nginx/sites-available/default && service nginx reload