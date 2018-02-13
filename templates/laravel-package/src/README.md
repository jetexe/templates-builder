<p align="center">
  <img alt="logo" src="https://i.imgur.com/jnfieJ6.png" width="140" />
</p>

# {% Короткое описание пакета %}

[![Version][badge_version]][link_packagist]
![Downloads count][badge_downloads_count]
[![License][badge_license]][link_license]
[![Build Status][badge_build_status]][link_build_status]
![StyleCI][badge_styleci]
[![Code Coverage][badge_coverage]][link_coverage]
[![Scrutinizer Code Quality][badge_quality]][link_coverage]
[![GitHub issues][badge_issues]][link_issues]

{% Более полное описание пакета, которое позволяет принять решение о его предназначении и применимости в том проекте, работа над которым привела пользователя в данный репозиторий. %}

## Установка

Для установки данного пакета выполните в терминале следующую команду:

```shell
$ composer require {%org_name%}/{%repo_name%} "1.*"
```

> Для этого необходим установленный `composer`. Для его установки перейдите по [данной ссылке][getcomposer].

> Обратите внимание на то, что необходимо фиксировать мажорную версию устанавливаемого пакета.

## Использование

{% В данной блоке следует максимально подробно рассказать о том, какие задачи решает данный пакет, какое API предоставляет разработчику, из каких компонентов состоит и привести примеры использования с примерами кода. Привести максимально подробне разъяснения и комментарии. %}

### Тестирование

Для тестирования данного пакета используется фреймворк `phpunit`. Для запуска тестов выполните в терминале:

```shell
$ composer test
```

## Поддержка и развитие

Если у вас возникли какие-либо проблемы по работе с данным пакетом, пожалуйста, создайте соответствующий `issue` в данном репозитории.

Если вы способны самостоятельно реализовать тот функционал, что вам необходим - создайте PR с соответствующими изменениями. Крайне желательно сопровождать PR соответствующими тестами, фиксирующими работу ваших изменений. После проверки и принятия изменений будет опубликована новая минорная версия.

## Лицензирование

Код данного пакета распространяется под лицензией [MIT][link_license].

[badge_version]:https://img.shields.io/packagist/v/{%org_name%}/{%repo_name%}.svg?style=flat&maxAge=30
[badge_downloads_count]:https://img.shields.io/packagist/dt/{%org_name%}/{%repo_name%}.svg?style=flat&maxAge=30
[badge_license]:https://img.shields.io/packagist/l/{%org_name%}/{%repo_name%}.svg
[badge_build_status]:https://scrutinizer-ci.com/g/{%org_name%}/{%repo_name%}/badges/build.png?b=master
[badge_styleci]:https://styleci.io/repos/{%styleci_id%}/shield?style=flat&maxAge=30
[badge_coverage]:https://scrutinizer-ci.com/g/{%org_name%}/{%repo_name%}/badges/coverage.png?b=master
[badge_quality]:https://scrutinizer-ci.com/g/{%org_name%}/{%repo_name%}/badges/quality-score.png?b=master
[badge_issues]:https://img.shields.io/github/issues/{%org_name%}/{%repo_name%}.svg?style=flat&maxAge=30
[link_packagist]:https://packagist.org/packages/{%org_name%}/{%repo_name%}
[link_license]:https://github.com/{%org_name%}/{%repo_name%}/blob/master/LICENSE
[link_build_status]:https://scrutinizer-ci.com/g/{%org_name%}/{%repo_name%}/build-status/master
[link_coverage]:https://scrutinizer-ci.com/g/{%org_name%}/{%repo_name%}/?branch=master
[link_issues]:https://github.com/{%org_name%}/{%repo_name%}/issues
[getcomposer]:https://getcomposer.org/download/
