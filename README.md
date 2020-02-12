# Notify notifications for Symfony 4

[![Latest Version on Packagist](https://img.shields.io/packagist/v/notify-eu/notify-bundle.svg?style=flat-square)](https://packagist.org/packages/notify-eu/notify-bundle)
[![Software License](https://img.shields.io/badge/license-MIT-brightgreen.svg?style=flat-square)](LICENSE.md)
[![Build Status](https://img.shields.io/travis/notify-eu/notify-bundle/master.svg?style=flat-square)](https://travis-ci.org/notify-eu/notify-bundle)
[![StyleCI](https://styleci.io/repos/239555542/shield)](https://styleci.io/repos/239555542)
[![Total Downloads](https://img.shields.io/packagist/dt/notify-eu/notify-bundle.svg?style=flat-square)](https://packagist.org/packages/notify-eu/notify-bundle)

This package makes it easy to send notifications using [Notify](https://notify.eu) with Symfony 4

## Contents

- [Installation](#installation)
	- [Setting up your Notify account](#setting-up-your-notify-account)
- [Usage](#usage)
	- [Available Message methods](#all-available-methods)
- [Changelog](#changelog)
- [Testing](#testing)
- [Security](#security)
- [Contributing](#contributing)
- [Credits](#credits)
- [License](#license)

## Installation

You can install the package via composer:

```bash
$ composer require notify-eu/notify-bundle
```

### Setting up your Notify account

Add your Notify credentials to your `.env`:

```php
// .env
...
NOTIFY_CLIENT_ID=
NOTIFY_SECRET=
NOTIFY_TRANSPORT=
NOTIFY_URL=
],
...
```

`NOTIFY_URL` is not mandatory. Can be used when you want to overwrite the endpoint Notify is calling. (f.e. different url for Staging/production)

## Usage

1) Load the 'notifyService' inside your services/controllers
2) Create a NotifyMessage object with the required parameters
3) Send the message

``` php
<?php

namespace App\Controller;

use NotifyEu\NotifyBundle\Entity\NotifyMessage;
use NotifyEu\NotifyBundle\Service\NotifyService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Config\Definition\Exception\Exception;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class IndexController extends AbstractController
{
    protected $notifyService;

    public function __construct(NotifyService $notifyService)
    {
        $this->notifyService = $notifyService;
    }

    /**
     * @Route("/notify", name="app_notify")
     * @return Response
     */
    public function index()
    {
        $message = (new NotifyMessage())
            ->setNotificationType('resetPassword')
            ->addRecipient('John Doe','John.Doe@notify.eu')
            ->setLanguage('nl')
            ->setParams(['username' => 'John Doe']);

        $response = $this->notifyService->send($message);
        if ($response['success'] == true) {
            return new Response('Notification send!');
        }
    }
}


```

### NotifyMessage

Make sure to add a recipient to the message:

``` php
    $message->addRecipient('John Doe','John.Doe@notify.eu')
```

### All available methods

- `notificationType('')`: Accepts a string value.
- `addRecipient($array)`: Accepts an array of arrays of 'name'/'recipient' keys
- `transport('')`: Accepts a string value. if not set, it will fallback to NOTIFY_TRANSPORT in .env file
- `language('')`: Accepts a string value.
- `params($array)`: Accepts an array of key/value parameters
- `Cc($array)`: Accepts an array of arrays of 'name'/'recipient' keys
- `Bcc($array)`: Accepts an array of arrays of 'name'/'recipient' keys

## Changelog

Please see [CHANGELOG](CHANGELOG.md) for more information what has changed recently.

## Testing

```bash
$ composer test
```

## Security

If you discover any security related issues, please email info@notify.eu instead of using the issue tracker.

## Contributing

Please see [CONTRIBUTING](CONTRIBUTING.md) for details.

## Credits

- [notify](https://github.com/notify-eu)

## License

The MIT License (MIT). Please see [License File](LICENSE.md) for more information.
