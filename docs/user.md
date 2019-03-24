Makerlog PHP Client - User Object
======

in order to keep the abstraction a bit clearer, 
there is a user object which makes working with users a bit easier.

To use simple fast operations you can go directly through the API.
[As described here](users.md)

**The benefit of working with the user object is:**  
- **No unnecessary API requests will be made**
- **and the readability of the code is easier**

The User Object
------

To get a user, you only need to do the following

```php
<?php

use PCSG\Makerlog\Makerlog;

$Makerlog = new Makerlog($options);

$User = $Makerlog->getUsers()->getUserObject('dehenne'); // via name
$User = $Makerlog->getUsers()->getUserObject(892);       // via user id

$Me = $User = $Makerlog->getUsers()->getMe(); // the user of the client

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

In addition to the normal getter methods, the user object also has additional getters that have certain lists as their return value. 
Like for example the user's tasks or the user's projects 

```php
<?php

// return the users recent tasks
$tasks = $User->getRecentTasks();

foreach ($tasks as $Task) {
    echo $Task->getContent();
}


// return the users products
$products = $User->getProducts();

foreach ($products as $Product) {
    echo $Product->getName();
}

?>
```

- More about [tasks](tasks.md)
- More about [products](products.md)

### Embed

The embed is a small exception. 
getEmbed() returns a complete html page which shows all data of the user.

```php
<?php

echo $User->getEmbed();

?>
```

It has two more of these exceptions, one of which is 

```php
<?php

// return stats
echo $User->getEmbedStats();

?>
```

and the other is


```php
<?php
    
// return the wrapped image (binary)
echo $User->getWrappedImage();
    
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


#### Weekend on / off

The weekend mode is well explained [here](https://sergiomattei.com/posts/a-new-healthier-chapter-for-makerlog/).
To switch the weekend mode on or off you just have to do the following:

```php
<?php

$User->setWeekendOff();
$User->setWeekendOn();

```

### Change the user

Of course, users can also be changed. 
Here you have methods that do some work for you or you can use the general update() method for it.


```php
<?php

// update several user data
$User->update([
    'first_name'  => 'First',
    'last_name'   => 'Last',
    'description' => 'This is all about me'
]);

```

The update() function can handle the following options:

**General stuff**
- first_name
- last_name
- description
- status
- digest
- accent

**General stuff - but bool values true or false**
- private
- dark_mode
- weekends_off

**Handles**
- twitter_handle
- instagram_handle
- product_hunt_handle
- github_handle
- shipstreams_handle
- telegram_handle

**Avatar stuff**
- avatar
- header

