# boilerplate-yii2
Boilerplate for create Yii 2 application


## Install

### 1. Global replace - first important step

Replace in every file of the project:

- For human-readable labels: Boilerplate Yii 2 k4nuj8
- For urls/db/other ids: boilerplate-yii2-k4nuj8 (including this file)
- Rename the project in IDE
- Replace cookieValidationKey "q2%s2~5twSe2OkBJ8H6k6wUI@fe~Ah9|" to another random string


### 2. Web server

- Replace /boilerplate-yii2-project-path with your local project path
- Add 127.0.0.1 boilerplate-yii2-k4nuj8.local into your hosts file
- Copy apache.conf (or dev/nginx.conf) into sites-enabled/


### 3. Install dependencies

```sh
composer global require "fxp/composer-asset-plugin:^1.2.0"
composer install
npm install
```

And remove folders node_modules, vendor from .gitignore

### 4. Attach local services

- Create database "boilerplate-yii2-k4nuj8"
- Copy config.sample.php to config.php and configure it


### 5. Database migrations

- Run applicaion migrations
```sh
php yii migrate
```


### Test

- Open http://boilerplate-yii2-k4nuj8.local/ the app must be already working


### Clean

- Delete this file (README.md) or replace 100% of its contents with your project's Readme


# Modules dependencies
## comet

```sh
npm install --save neatcomet jii jii-comet
```

## React

```sh
npm install --save react react-dom
```
