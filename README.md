# boilerplate-yii2
Boilerplate for create Yii 2 application


### Global replace - first important step

Replace in every file of the project:

- For human-readable labels: Boilerplate Yii 2 k4nuj8
- For urls/db/other ids: boilerplate-yii2-k4nuj8 (including this file)
- Rename the project in IDE


### Nginx config

- Copy dev/nginx.conf into sites-enabled/
- Replace /boilerplate-yii2-project-path with your local project path
- Add 127.0.0.1 boilerplate-yii2-k4nuj8.local into your hosts file


### Apache 2.4+ config

- Copy dev/apache.conf into sites-enabled/
- Replace /boilerplate-yii2-project-path with your local project path
- Add 127.0.0.1 boilerplate-yii2-k4nuj8.local into your hosts file


### Install dependencies

- composer install


### Attach local services

- Copy config.sample.php to config.php
- Create database "boilerplate-yii2-k4nuj8"


### Test

- Open http://boilerplate-yii2-k4nuj8.local/ the app must be already working


### Clean

- Delete this file (README.md) or replace 100% of its contents with your project's Readme
