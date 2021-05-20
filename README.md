Composer Ignore Plugin [![version](https://img.shields.io/packagist/v/light/composer-ignore-plugin.svg?style=flat-square)](https://packagist.org/packages/light/composer-ignore-plugin) [![Download](https://img.shields.io/packagist/dt/light/composer-ignore-plugin.svg?style=flat-square)](https://packagist.org/packages/light/composer-ignore-plugin)
----

This plugin help us to remove the unused file or directories in vendor.

## Installation

Both global or local install can work well.

1.Install globally, so every project can use the plugin.

```
$ composer global require "light/composer-ignore-plugin:~2.0"
```

2.Install locally

```
$ composer require "light/composer-ignore-plugin:~2.0" --dev
```

## Usage

Define the ignore file or directory in composer.json, for example:

Before:

```
fzaninotto/faker/
├── CHANGELOG.md
├── composer.json
├── CONTRIBUTING.md
├── LICENSE
├── Makefile
├── phpunit.xml.dist
├── readme.md
├── src
└── test
```

Configuration in `composer.json`:

```json
{
	"extra": {
		"light-ignore-plugin": {
    	  "fzaninotto/faker": [
    	  	"test", 
    	  	"*.md", 
    	  	"LICENSE",
    	  	"Makefile",
    	  	"phpunit.xml.dist"
    	  ]
    	}
	}
}

```

After executed `composer install`, `composer update`, `composer dump-autoload`, The files will be removed.

> When execute the `composer install` or `composer update` will finally trigger the autoload dump event

After:

```
fzaninotto/faker/
├── composer.json
└── src
```

## Why this?

Thanks to open source, there are many useful packages helped us. 

Generally, some files or folder in the installed package is useless, and when deploy to production system, reduce the files can make deploy clean.

Of cause, a lot of package had done this by add `.gitattributes` file, But also not all, [`fzaninotto/faker`](https://github.com/fzaninotto/Faker/pull/1085) for example.

## LICENSE

[MIT](LICENSE)


