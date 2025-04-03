apt-get update && apt-get install -y librdkafka-dev
yes '' | pecl install rdkafka
echo "extension=rdkafka.so" >> /home/site/wwwroot/.user.ini
cp /home/site/wwwroot/default /etc/nginx/sites-available/default && service nginx reload