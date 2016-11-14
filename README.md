Composer Ignore Plugin
----

This plugin help us to remove the unused file or directories in vendor.

## Installation

```
$ composer global require "light/composer-ignore-plugin:~1.0"
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

MIT


