Makerlog PHP Client - User Object
======

in order to keep the abstraction a bit clearer, 
there is a user object which makes working with users a bit easier.

To use simple fast operations you can go directly through the API.
[As described here](users.md)

**The benefit of working with the user object is:**  
**No unnecessary API requests will be made**


The User Object
------

To get a user, you only need to do the following

```php
<?php

use PCSG\Makerlog\Makerlog;

$Makerlog = new Makerlog($options);

$User = $Makerlog->getUsers()->getUserObject('dehenne'); // via name
$User = $Makerlog->getUsers()->getUserObject(892);       // via user id

```

Now you can do some things with the user.  
*Attention: Some things need write permissions.*

```php
<?php

// profile stuff
$User->getId();
$User->getUsername();

$User->getFirstName();
$User->getLastName();
$User->getDescription();

$User->getAccent();
$User->getAvatar();
$User->getHeader();
$User->getTimeZone();

// maker stuff
$User->getActivityGraph();
$User->getMakerScore();
$User->getStreak();
$User->getStreakEnd();

// handles
$User->getGithubHandle();
$User->getInstagramHandle();
$User->getProductHuntHandle();
$User->getShipstreamsHandle();
$User->getTwitterHandle();

// all handles as array
$handles = $User->getHandles();

```

### Embed

The embed is a small exception. 
getEmbed() returns a complete html page which shows all data of the user.

```php
<?php
 
    echo $User->getEmbed();

?>
```

### Follow API

*At the moment the User API is not yet very extensively developed by makerlog.*

#### Follow

Follow the user.

```php
<?php

use PCSG\Makerlog\Makerlog;

$Makerlog = new Makerlog($options);

$User = $Makerlog->getUsers()->getUserObject('dehenne');
$User->follow();

```

#### Unfollow

Unfollow the user.

```php
<?php

use PCSG\Makerlog\Makerlog;

$Makerlog = new Makerlog($options);

$User = $Makerlog->getUsers()->getUserObject('dehenne');
$User->unfollow();

```

#### Does the user follow me?

```php
<?php

use PCSG\Makerlog\Makerlog;

$Makerlog = new Makerlog($options);
$User     = $Makerlog->getUsers()->getUserObject('dehenne');

if ($User->isFollowing()) {
    echo 'yes';    
} else {
    echo 'no';
}

```
