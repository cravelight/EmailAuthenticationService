# Email Authentication Service

Helper service to support the ability to:

- verify a user has access to an email address
- store and validate a user provided email/password combination

To use, simply install with Composer: `composer require cravelight/phpunit-helpers`

To make changes, after cloning:

- run `composer install`
- copy `.env.example` to `.env` and configure your db credentials
- run `php vendor/bin/phinx migrate`
- run tests


## Automated Tests

To run automated test we are using the following frameworks:

- [PHPUnit](https://phpunit.de/) (testing framework)
- [PHP dotenv](https://github.com/vlucas/phpdotenv) (setting environment variables)


### PHPStorm Configuration

To configure PHPStorm:

- Open **Preferences** and navigate to **Languages and Frameworks** &rarr; **PHP** &rarr; **PHPUnit**
- Under **PHPUnit library**, select **Use custom autoloader**
- Enter **Path to script** as `[path/to/project/vendor/autoload.php]`
- In the **Test Runner** section, select **Default bootstrap file** and enter the `[path/to/project/tests/bootstrap.php]`
- **Apply** your changes and exit **Preferences**


### Command Line

When running from the command line use the following:

` php [path/to/phpunit] --bootstrap [path/to/tests/bootstrap.php] --no-configuration [path/to/tests]`

For additional information see: [PHPUnit command line options](https://phpunit.de/manual/current/en/textui.html)



