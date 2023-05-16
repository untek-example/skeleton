
### Одна точка входа для всех приложений

    ├── public/
    │   └── index.php

В соответствии с философией Symfony, переменные окружения могут использоваться для определения режима приложения (dev/test/prod) и определения, включен ли режим отладки.
Кроме того, необходимо создать новую переменную окружения с именем `APP_CONTEXT`, чтобы указать контекст ядра, который должен быть запущен.
Это можно легко проверить с помощью встроенного веб-сервера PHP, установив среду переменная перед запуском сервера:

    $ APP_CONTEXT=admin php -S 127.0.0.1:8000 -t public
    $ APP_CONTEXT=api php -S 127.0.0.1:8001 -t public   

### Использовать локальный веб-сервер Symfony

Чтобы запустить несколько контекстов ядра, вам нужно будет использовать [локальный сервер Symfony](https://symfony.com/doc/current/setup/symfony_server.html) и
его [прокси](https://symfony.com/doc/current/setup/symfony_server.html#setting-up-the-local-proxy).

Сначала запустите прокси Symfony, выполнив команду `symfony proxy:start` в папке проекта.

Затем создайте символическую ссылку ([symlink](https://en.wikipedia.org/wiki/Symbolic_link)) для каждого из ваших приложений, которые
указывает на папку вашего проекта.
Эти символические ссылки могут храниться в папке вашего проекта или вне его, в зависимости
от ваших предпочтений.

    ├── links/
    │   ├── admin
    |   ├── api
    |   └── site
    ├── config/
    ├── src/
    └── var/

После создания символических ссылок вам нужно будет настроить каждый локальный сервер и запустить его. Это делается с помощью
символические ссылки, созданные ранее. Например, вы можете запустить такую команду, как:

```
# start admin local server
APP_CONTEXT=admin symfony proxy:domain:attach admin --dir=[project folder path]/links/admin
APP_CONTEXT=admin symfony server:start --dir=[project folder path]/links/admin

# start api local server
APP_CONTEXT=api symfony proxy:domain:attach api --dir=[project folder path]/links/api
APP_CONTEXT=api symfony server:start --dir=[project folder path]/links/api

# start site local server
APP_CONTEXT=site symfony proxy:domain:attach site --dir=[project folder path]/links/site
APP_CONTEXT=site symfony server:start --dir=[project folder path]/links/site
```

Чтобы убедиться, что каждый сервер работает, вы можете перейти по соответствующему URL-адресу в своем веб-браузере [localhost:7080](http://localhost:7080).

### Продакшн и виртуальные хосты

Чтобы запустить несколько контекстов ядра в продакшн окружении или окружении для разработки, вам необходимо установить
переменную окружения `APP_CONTEXT` для каждой конфигурации виртуального хоста.
Это можно сделать, изменив соответствующие файлы конфигурации:

    <VirtualHost admin.company.com:80>
        # ...
        
        SetEnv APP_CONTEXT admin
        
        # ...
    </VirtualHost>

    <VirtualHost api.company.com:80>
        # ...
        
        SetEnv APP_CONTEXT api
        
        # ...
    </VirtualHost>

### Executing commands per application

    ├── bin/
    │   └── console.php

Use `--kernel`, `-k` option to run any command for one specific app:

    $ bin/console about -k api

Or if you prefer, use environment variables on CLI:

    $ export APP_CONTEXT=api
    $ bin/console about                         # api application
    $ bin/console debug:router                  # api application
    $
    $ APP_CONTEXT=admin bin/console debug:router   # admin application

Additionally, you can set the default `APP_CONTEXT` environment variable in your `.env` file or by modifying the `bin/console` file.
This allows you to specify the default kernel context that will be used if the environment variable is not set or overridden elsewhere.

### Running tests per application

    ├── tests/
    │   └── context/
    │       ├── admin
    │       │   └── AdminWebTestCase.php
    │       └── api/

The `tests/` directory will include a `context/` directory that mirrors the structure of the `context/` directory in the main codebase.
To use this structure in your tests, you will need to update your `composer.json` file to map each directory within `tests/context/<CONTEXT>/`
to its corresponding PSR-4 namespace. This allows you to test each kernel context separately.

    "autoload-dev": {
        "psr-4": {
            "Admin\\Tests\\": "tests/context/admin/",
            "Api\\Tests\\": "tests/context/api/"
        }
    },

Run `composer dump-autoload` to re-generate the autoload config.

To run all the tests for a specific kernel context, create a separate `<CONTEXT>WebTestCase` class for each app.
This allows you to execute all the tests together and test each kernel context independently.

### Adding more applications to the project

To create a new kernel context skeleton, run the command `bin/console make:ddd:context <CONTEXT>` in the terminal. This will
generate the necessary files and directories for the new kernel context, allowing you to easily add new functionality to
your application.

When installing new packages that generate new configuration files, it is important to move them to the correct sub-application
directory if they are not intended to work for all applications. Additionally, you should update the `auto-scripts` section
in `composer.json` to execute each command with the correct kernel option. To ensure that the cache is cleared for each individual
application, it is recommended to include the script `"cache:clear -k <CONTEXT>": "symfony-cmd"` for each app in your `composer.json` file.

License
-------

This software is published under the [MIT License](LICENSE)
