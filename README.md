Composer :
intall composer
then : composer -v
    composer init
    Would you like to define your dependencies (require) interactively [yes]? no
    Would you like to define your dev dependencies (require-dev) interactively [yes]? no
    Add PSR-4 autoload mapping? Maps namespace "Mariondoubeck\OCphpP5FirstBlog" to the entered relative path. [src/, n to skip]: n
then in composer.json add: 
    "autoload": {
        "psr-4": {
            "App\\": "app/",
            "Config\\": "config/"
        }
    }
then execute composer dumpautoload
then execute composer require phpmailer/phpmailer

