![Makerlog PHP Client](makerlog-php-client.png)


PHP Client for Makerlog
======

This repository contains a PHP client for https://getmakerlog.com. 
It simplifies the access to https://api.getmakerlog.com/

**It's still in its early stages.**

[![Build Status](https://travis-ci.com/pcsg/pcsg-makerlog-php-client.svg?branch=master)](https://travis-ci.com/pcsg/pcsg-makerlog-php-client)
[![codecov](https://codecov.io/gh/pcsg/pcsg-makerlog-php-client/branch/master/graph/badge.svg)](https://codecov.io/gh/pcsg/pcsg-makerlog-php-client)


Installation
------

This repository can be installed via [composer](https://getcomposer.org/).  

You can add the following line to the require part in your composer.json:

- `"pcsg/makerlog-php-client": "*"`

Or you can execute the follwing command

- `php composer.phar require "pcsg/makerlog-php-client"`


What you need
------

To use this client you need:

- Makerlog Account (https://getmakerlog.com)
- At some endpoints you will need a Makerlog API Application 
(https://api.getmakerlog.com/oauth/applications/)
You will find more information about that in the [redirect example](https://github.com/pcsg/pcsg-makerlog-php-client/blob/master/examples/oauth/redirect.php)


Usage
------

```php
<?php

use PCSG\Makerlog\Makerlog;

$Makerlog = new Makerlog();

echo $Makerlog->getUsers()->count();
```


```php
<?php

use PCSG\Makerlog\Makerlog;

$Makerlog = new Makerlog([
    'client_id'     => 'YOUR_CLIENT_ID',
    'client_secret' => 'YOUR_CLIENT_SECRET',
    'access_token'  => 'ACCESS_TOKEN_FROM_THE_USER'
]);

echo $Makerlog->getTasks()->getList();
```


You can find more examples at the [examples folder](examples).

Authors
------

- Henning Leutz | [Makerlog](https://getmakerlog.com/@dehenne) 
                | [GitHub](https://github.com/dehenne/) 
                | [Twitter](https://twitter.com/de_henne)


Contribute
------

If you find mistakes, issues or have somes ideas we would be happy 
if you put them down here under [issues](https://github.com/pcsg/pcsg-makerlog-php-client/issues).
  
If you would like to help us, please do so at https://dev.quiqqer.com, because this repository is a 
clone and only serves as a distribution point. 
We do not like to be dependent on others and therefore have our own gitlab instance.

- Project: https://dev.quiqqer.com/pcsg/makerlog-php-client
- Issue Tracker: https://dev.quiqqer.com/pcsg/makerlog-php-client/issues || https://github.com/pcsg/pcsg-makerlog-php-client/issues
- Source Code: https://dev.quiqqer.com/pcsg/makerlog-php-client/tree/master


Licence
------

GPL-3.0+



Makerlog
------

### What is Makerlog?

Makerlog is the dead-simple task log that helps you stay productive and ship faster.
There you can meet other makers and share your progress.

https://getmakerlog.com/
