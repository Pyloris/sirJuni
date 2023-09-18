![badge4](https://img.shields.io/badge/MIT-License-red)
![badge1](https://img.shields.io/badge/Built%20With%20Love-8A2BE2)
![badge2](https://img.shields.io/static/v1?label=easy&message=install&color=green)
![badge1](https://img.shields.io/static/v1?label=PHP%20>%208.2&message=Framework&color=blue)
# SirJuni
![logo](./__dont_touch/logo.png)

#### A Simple Mini-Framework for PHP Backend Development

## Quick Install
To install this framework, add a composer.json to your projects root directory.
copy and paste the below contents in the file
```json
{
    "autoload": {
        "psr-4": {
            "sirJuni\\Framework\\" : "vendor/shoaib/sir-juni/src/"
        }
    },

    "require": {
        "shoaib/sir-juni" : "dev-master"
    }

}

```

After adding these contents to this file, run the following command
```shell
$ composer install
```
It should install the Framework in your root directory.

# How to use
If you want to use Components from the Framework, make sure you include the `autoload.php` file from the `vendor/` directory that gets created after running the above command.

After this, you can simply use the components of the framework by using the `use sirJuni\Framework\..` below the require statement of the 'autoload.php'.

For a complete setup tutorial visit the [Documentation](https://shoaib-1.gitbook.io/sirjuni/).