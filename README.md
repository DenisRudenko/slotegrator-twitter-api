# Install
## Step 1. Clone project
```bash
git clone ...
cd twitter-api
cp .env.example .env
docker-compose up -d --build
```
## Step 2. Install composer dependency
```bash
docker exec -it sloterator_php-fpm_1 composer install
```
## Step 3. Run migration
```bash
docker exec -it sloterator_php-fpm_1 ./yii migrate
```

# API methods

* Endpoint - `http://127.0.0.1:3099/v1/api`
* Add `GET: {endpoint}/add?id=...&user=..&secret=..`
* Feed `GET: {endpoint}/feed?id=...&secret=..`
* Remove `GET: {endpoint}/remove?id=...&user=..&secret=..`

Additional
* Twitter Login - `GET: {endpoint}/login`