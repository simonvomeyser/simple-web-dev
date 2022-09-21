@setup
    $dotenv = Dotenv\Dotenv::createImmutable(__DIR__);
    $dotenv->load();
@endsetup

@servers(['web' => [env('DEPLOY_USER') . '@' . env('DEPLOY_HOST')]])

@task('deploy', ['on' => 'web'])
    source {{ env('DEPLOY_LOCATION') }}/../.bashrc
    cd {{ env('DEPLOY_LOCATION') }}
    git checkout .
    git pull
    npm install
    npm run prod
    php81 /usr/bin/composer install --no-dev
    php81 artisan cache:clear
    php81 artisan config:clear
    php81 artisan view:clear
    php81 artisan cache-posts
    php81 artisan responsecache:clear
@endtask
