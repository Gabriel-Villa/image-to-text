1. Clone repo:
   
```
git@github.com:Gabriel-Villa/image-to-text.git
```

2: Install dependencies composer.json

```
docker run --rm \
    -u "$(id -u):$(id -g)" \
    -v "$(pwd):/var/www/html" \
    -w /var/www/html \
    laravelsail/php82-composer:latest \
    composer install --ignore-platform-reqs
```

3. Create .env
```
cp .env.example .env  
```

4. Start sail
```
sail up
```

5. Generate key
```
sail php artisan key:generate
```

6. Run migrations && seeders
```
sail php artisan migrate:fresh --seed
```

7. Install dependencies package.json && run
```
sail npm i
sail npm run dev
```

/**
apt-get update &&
apt-get install -y imagemagick &&
apt-get install software-properties-common &&
add-apt-repository ppa:alex-p/tesseract-ocr-devel &&
apt-get install -y tesseract-ocr &&
apt-get install wget

cd /usr/share/tesseract-ocr/5/tessdata && wget https://github.com/tesseract-ocr/tessdata/raw/main/spa.traineddata

export TESSDATA_PREFIX=/usr/share/tesseract-ocr/5/tessdata/

 */

