<p align="center">
  <img alt="logo" src="https://hsto.org/webt/0v/qb/0p/0vqb0pp6ntyyd8mbdkkj0wsllwo.png" width="70" height="70" />
</p>

# Projects templates builder

[![Version][badge_version]][link_packagist]
[![License][badge_license]][link_license]
[![Build Status][badge_build_status]][link_build_status]
![StyleCI][badge_styleci]
[![Code Coverage][badge_coverage]][link_coverage]

Использование данного пакета упрощает и ускоряет развертывание однотипных приложений, базовая структура которых (скелетон) уже устоялась и используется неоднократно.

Выполнив всего лишь одну команду в терминале вы получите готовую "заготовку" для вашего приложения и, разумеется, можете использовать свои собственные шаблоны.

## Установка

Для установки данного пакета выполните в терминале следующую команду:

```shell
$ composer global require tarampampam/templates-builder "^1.0"
```

> Для этого необходим установленный `composer`. Для его установки перейдите по [данной ссылке][getcomposer].

> Обратите внимание на то, что необходимо фиксировать мажорную версию устанавливаемого пакета, и устанавливать данный пакет глобально (для пользователя). Для последующих обновлений данного пакета будет достаточно выполнить:
>
> ```shell
> $ composer global update tarampampam/templates-builder
> ```

### Создание директории для собственных шаблонов

После установки рекомендуется создать директорию для ваших собственных шаблонов:

```shell
$ mkdir "$HOME/.php-builder-templates"
```

### Создание алиаса вызова

Вы можете создать алиас с помощью следующего "однострочника":

```shell
$ BUILDER_BIN="$HOME/.composer/vendor/bin/templates-builder"; if [ -x "$BUILDER_BIN" ]; then echo -e "function templates-builder() {\n  $BUILDER_BIN --templates-dir=\"\$HOME/.php-builder-templates\" \"\$@\"\n}" >> "$HOME/.bash_aliases"; else echo "Error"; exit 1; fi;
```

> Данная команда создаст в файле `~/.bash_aliases` bash-функцию `templates-builder`, которая позволит вам находясь в любой директории вызывать bin-файл данного пакета без необходимости "ручного" указания использования директории для собственных шаблонов.
>
> Так же стоит помнить, что как в различных дистрибутивах linux, так и при использовании различных shell-ов метод регистрации алиасов может разниться.

После этого необходимо перезапустить терминал и проверить работоспособность алиаса выполнением в терминале:

```shell
$ templates-builder
```

## Использование

Исполняемый (bin) файл данного пакета поддерживает следующие команды:

Команда | Описание
------- | --------
`templates` | Выводит список всех доступных шаблонов
`build` | Производит "установку" выбранного шаблона по указанному пути

Более подробно о каждой команде и параметрах её вызова вы можете узнать, выполнив её с опцией `--help`, например:

```shell
$ templates-builder templates --help
# или
$ ~/.composer/vendor/bin/templates-builder build --help
# или
$ templates-builder b --help
```

При выполнении "установки" шаблона в указанной директории - если шаблон поддерживает динамическую замену регулярных вхождений - о каждой замене пользовалелю будет задан интерактивный запрос.

## Создание собственных шаблонов

Шаблон - это директория (имя которой является именем шаблона), содержащая специальный файл `metadata.json` (далее по тексту - мета-файл), который описывает шаблон, и исходный код самого шаблона.

Файловая структура его может быть следующая:

```
$HOME
└── .php-builder-templates
    └── example-template
        ├── metadata.json
        └── src
            ├── script.sh
            └── README.md
```

 * `example-template` - имя шаблона;
 * `metadata.json` - его мета-файл;
 * `src` - директория с файлами шаблона;
 
Структура мета-файла должна иметь следующий вид:
 
```json
{
    "description": "Example template",
    "sources-dir": "src",
    "replaces": [
        {
            "signature": "{%custom_value_1%}",
            "description": "Custom value 1 description"
        },
        {
            "signature": "{%custom_value_2%}",
            "description": "Custom value 2 description",
            "default": "Default value 2"
        }
    ]
}
``` 

Имя поля мета-файла | Описание
------------------- | --------
`description` | Краткое описание шаблона
`sources-dir` | Относительный путь к директории к файлам шаблона (по умолчанию `src`)
`replaces` | Правила замен регулярных вхождений (регулярные выражения **не** поддерживаются) шаблона в формате, описанном в примере выше

Создав подобный шаблон в директории `$HOME/.php-builder-templates` вы сможете его "разворачивать" при помощи данного приложения командой:

```shell
$ ~/.composer/vendor/bin/templates-builder b /path/to/target example-template
# или
$ templates-builder build /path/to/target example-template
```

### Тестирование

Для тестирования данного пакета используется фреймворк `phpunit`. Для запуска тестов выполните в терминале:

```shell
$ git clone git@github.com:tarampampam/templates-builder.git
$ cd ./templates-builder
$ composer update --dev
$ composer test
```

## Поддержка и развитие

Если у вас возникли какие-либо проблемы по работе с данным пакетом, пожалуйста, создайте соответствующий `issue` в данном репозитории.

При необходимости добавления какого-либо шаблона - тоже.

Если вы способны самостоятельно реализовать тот функционал, что вам необходим - создайте PR с соответствующими изменениями. Крайне желательно сопровождать PR соответствующими тестами, фиксирующими работу ваших изменений. После проверки и принятия изменений будет опубликована новая минорная версия.

## Лицензирование

Код данного пакета распространяется под лицензией [MIT][link_license].

[badge_version]:https://img.shields.io/packagist/v/tarampampam/templates-builder.svg?style=flat&maxAge=30
[badge_license]:https://img.shields.io/packagist/l/tarampampam/templates-builder.svg
[badge_build_status]:https://scrutinizer-ci.com/g/tarampampam/templates-builder/badges/build.png?b=master
[badge_styleci]:https://styleci.io/repos/121279820/shield?style=flat&maxAge=30
[badge_coverage]:https://scrutinizer-ci.com/g/tarampampam/templates-builder/badges/coverage.png?b=master
[link_packagist]:https://packagist.org/packages/tarampampam/templates-builder
[link_license]:https://github.com/tarampampam/templates-builder/blob/master/LICENSE
[link_build_status]:https://scrutinizer-ci.com/g/tarampampam/templates-builder/build-status/master
[link_coverage]:https://scrutinizer-ci.com/g/tarampampam/templates-builder/?branch=master
[getcomposer]:https://getcomposer.org/download/
