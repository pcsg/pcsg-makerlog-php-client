Makerlog PHP Client User API
======

Get one user
------

```php
<?php

use PCSG\Makerlog\Makerlog;

$Makerlog = new Makerlog();
$User     = $Makerlog->getUsers()->get(892);

// general
echo $User->username;
echo $User->id;
echo $User->username;
echo $User->first_name;
echo $User->last_name;
echo $User->status;
echo $User->description;
echo $User->verified;
echo $User->private;
echo $User->avatar;
echo $User->streak;
echo $User->streak_end_date;
echo $User->timezone;
echo $User->week_tda;

// handles
echo $User->twitter_handle;
echo $User->instagram_handle;
echo $User->product_hunt_handle;
echo $User->github_handle;

// stuff
echo $User->header;
echo $User->is_staff;
echo $User->donor;
echo $User->tester;
echo $User->telegram_handle;
echo $User->digest;
echo $User->gold;
echo $User->accent;
echo $User->maker_score;

```

Get user count
------

```php
<?php

use PCSG\Makerlog\Makerlog;

// "long version"
$Makerlog = new Makerlog();

echo $Makerlog->getUsers()->count();

// short version
echo (new Makerlog())->getUsers()->count();
```

Get a complete user list
------

```php
<?php

use PCSG\Makerlog\Makerlog;

$Makerlog = new Makerlog();
$list     = $Makerlog->getUsers()->getList();

// output
echo PHP_EOL;

foreach ($list as $user) {
    echo $user->username . PHP_EOL;
}

```