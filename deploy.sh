DB_USERNAME=$1
DB_PASSWORD=$2

cp .env.test .env
sed -i "s|DB_USERNAME=.*|DB_USERNAME=${DB_USERNAME}|g" .env
sed -i "s|DB_PASSWORD=.*|DB_PASSWORD=${DB_PASSWORD}|g" .env
