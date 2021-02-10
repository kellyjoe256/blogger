# Blogger

### To run the project

- clone the repository
- run `composer install && composer install --optimize-autoloader --no-dev`
-  create your env file `cp ./.env.example ./.env`
-  step up options in `.env` file to match your environment
-  if you do not have `redis` setup in your environment, be sure to make the 
   following change in the file `phpunit.xml`
    ```xml
    <!-- FROM -->
    <server name="CACHE_DRIVER" value="redis"/>
    <!-- TO -->
    <server name="CACHE_DRIVER" value="array"/>
    ```
- run tests `php artisan test` or `./vendor/bin/phpunit`
- you can optionally setup your `EXTERNAL_POSTS_API_ENDPOINT=your_api_endpoint` in the `.env` or otherwise the default will be used
- run `php artisan config:cache`
- run `php artisan route:cache`
- run `php artisan view:cache`
- run `php artisan migrate --seed`
- run `php artisan import:posts` to populate the blog posts table with some records
-  create a cron job to handle importation of blog posts every hour
    - run `crontab -e` which open your crontab file
    - paste this `* * * * * cd /path_to_project && \php artisan schedule:run >> /dev/null 2>&1` to your crontab and save
    - don't forget to change `/path_to_project` to the path where your  cloned the repository
- If web server is not setup, run `php artisan serve`
- Launch a web browser and type `http://localhost:8000`  to try out the project
- You can login using the email `admin@example.com` and password as `password`
