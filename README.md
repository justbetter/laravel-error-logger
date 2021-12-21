# Laravel Error Logger

This packages contains a nice and easy way to log errors that happen in your application. A job can be added to your
scheduler in order to receive daily notifications about reported errors via e.g. Slack.

Support for Laravel Nova is also available to view a list of reported errors with the `justbetter/nova-error-logger`
package.

Please note that this package won't automatically save exceptions thrown by Laravel or PHP - you have to manually save
them like the example shown later in this documentation.

## Setup

In order to make use of the package the following actions are required.

### Publishing

Publish the configuration of the package.

```shell
php artisan vendor:publish --provider="JustBetter\ErrorLogger\ServiceProvider"
```

### Migrations

Run your migrations.

```shell
php artisan migrate
```

## Scheduler

> **NOTE!** This is optional and not required in order to use the package.

In your `App\Console\Kernel.php` you can add the daily error notification job like so:

```php
use JustBetter\ErrorLogger\Jobs\ErrorNotificationJob;

$schedule->job(ErrorNotificationJob::class)->dailyAt('09:00');
```

## Configuration

Add the following variable to your `.env` to define the logging channel for daily notifications if the job is enabled.

```
LARAVEL_ERROR_NOTIFICATION_CHANNEL=slack
```

## Commands

The logging table can build up pretty fast. In order to prune older records, you can use the following command:

```shell
php artisan laravel-error-logger:prune --all
php artisan laravel-error-logger:prune --hours=720
```

To automatically prune the logs, you may want to add the command to your scheduler.

## Example usage

> **IMPORTANT!** When using the method `withChannel` it will directly send a notification when saved.

The error class can be easily used. No value is required to be set in order to save the log.

```php
use JustBetter\ErrorLogger\Models\Error;

Error::log()
    ->withGroup('Magento')
    ->withMessage('Something went wrong!')
    ->withDetails('Extra information of this log!')
    ->withThrowable($exception)
    ->withChannel('slack')
    ->save();
```

## License

The MIT License (MIT). Please see [License File](LICENSE.md) for more information.
