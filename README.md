1. Clone repo:
   
```
git clone git@github.com:Gabriel-Villa/image-to-text.git
```

2: Change directory && install dependencies composer.json

```
cd image-to-text &&
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

4. Start sail without cache , if you dont have any images of sail php version 8.2 just run **sail up**
```
sail build --no-cache &&
sail up -d
```

5. Generate key
```
sail php artisan key:generate
```

6. Run migrations
```
sail php artisan migrate:fresh
```

7. Install dependencies package.json && run
```
sail npm i &&
sail npm run dev
```
