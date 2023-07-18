
[![Codacy Badge](https://api.codacy.com/project/badge/Grade/2ddb0754a2154d008813bbdcab4e6203)](https://app.codacy.com/gh/MarionDoubeck/OCphp_P5_first_blog?utm_source=github.com&utm_medium=referral&utm_content=MarionDoubeck/OCphp_P5_first_blog&utm_campaign=Badge_Grade)

Composer :
intall composer
then : 
composer -v
composer init
Would you like to define your dependencies (require) interactively [yes]? -> no
Would you like to define your dev dependencies (require-dev) interactively [yes]? -> no
Add PSR-4 autoload mapping? Maps namespace "your file path" to the entered relative path. [src/, n to skip]: -> n
then in composer.json add: 
    "autoload": {
        "psr-4": {
            "App\\": "app/"
        }
    }
then execute composer dumpautoload
then execute composer require phpmailer/phpmailer
then execute composer require vlucas/phpdotenv


