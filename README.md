# Install
## Step 1. Clone project
```bash
git clone https://github.com/poshyvailo/slotegrator-twitter-api.git
cd slotegrator-twitter-api
cp .env.example .env
docker-compose up -d --build
```
## Step 2. Install composer dependency
```bash
docker exec -it slotegrator_php-fpm_1 composer install
```
## Step 3. Run migration
```bash
docker exec -it slotegrator_php-fpm_1 ./yii migrate
```

# API methods

* Endpoint - `http://127.0.0.1:3099/v1/api`
* Add `GET: {endpoint}/add?id=...&user=..&secret=..`
* Feed `GET: {endpoint}/feed?id=...&secret=..`
* Remove `GET: {endpoint}/remove?id=...&user=..&secret=..`

Additional
* Twitter Login - `GET: {endpoint}/login`

# Test

Login [http://127.0.0.1:3099/v1/api/login](http://127.0.0.1:3099/v1/api/login)

Add [http://127.0.0.1:3099/v1/api/add?id=...&user=elonmusk&secret=...](http://127.0.0.1:3099/v1/api/add?id=WBYX1TLPRWJ7NSV36LCPP2OZFH6AE6LM&user=elonmusk&secret=3dfb3e37b62f0f13ceca0dfa87a860b007a29e73)

Feed [http://127.0.0.1:3099/v1/api/feed?id=...&user=elonmusk&secret=...](http://127.0.0.1:3099/v1/api/feed?id=WBYX1TLPRWJ7NSV36LCPP2OZFH6AE6LM&user=elonmusk&secret=3dfb3e37b62f0f13ceca0dfa87a860b007a29e73)

Remove [http://127.0.0.1:3099/v1/api/remove?id=...&user=elonmusk&secret=...](http://127.0.0.1:3099/v1/api/remove?id=WBYX1TLPRWJ7NSV36LCPP2OZFH6AE6LM&user=elonmusk&secret=3dfb3e37b62f0f13ceca0dfa87a860b007a29e73)