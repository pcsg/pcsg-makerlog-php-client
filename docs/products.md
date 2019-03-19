Makerlog PHP Client Products API
======

This documentation describes how to create, modify and delete products in Makerlog. 
It describes the most basic properties of a product and how to handle them.


Get products
----

Returns a list of all products

```php
<?php

use PCSG\Makerlog\Makerlog;

$Makerlog = new Makerlog();
$list     = $Makerlog->getProducts()->getList();
```


Get a products
------

A single products can be received via its slag

```php
<?php

use PCSG\Makerlog\Makerlog;

$Makerlog = new Makerlog();
$product  = $Makerlog->getProducts()->get('myProductSlug'); // get project via its slug
```

With a normal product which has been received via get(), no operations can be executed. 
If you want to change the product, you should get a product object. This can be done via getProductAsObject().


```php
<?php

use PCSG\Makerlog\Makerlog;

$Makerlog = new Makerlog();
$Product  = $Makerlog->getProducts()->getProductAsObject('myProductSlug');

// delete the product
$Product->delete();

```

A product object has several getter methods, so it is quite easy to access the data of the product.

```php
<?php

use PCSG\Makerlog\Makerlog;

$Makerlog = new Makerlog();
$Product  = $Makerlog->getProducts()->getProductAsObject('myProductSlug'); // get project via ID

// main data
$Product->getSlug();
$Product->getName();
$Product->getDescription();
$Product->getIcon();

$Product->getCreateDate();
$Product->getLaunchDate();
$Product->getProductHunt();
$Product->getTwitter();
$Product->getWebsite();

$Product->getUsers();  // return users associated to this product. 
$Product->getPeople(); // alias for getUsers, so its the same ;-)
$Product->getUser();   // returns the main user of the product

$Product->isLaunched(); // is the Product launched? 
 
```

Create a project
------

To create a new product, you must use the main products object.

A product can be created in different ways, 
the simplest method is if the Makerlog client directly creates the project itself:

```php
<?php

use PCSG\Makerlog\Makerlog;

$Makerlog = new Makerlog();
$Products = $Makerlog->getProducts(); 

$Product = $Products->createProduct(
    'My first product',
    'This is a description'
);

```

To create a product, a project must always be assigned to it.  
In the example above, the project is automatically created and assigned to the new product. 
However, if you want to create a product and already have a project, you can also pass this on.


```php
<?php

use PCSG\Makerlog\Makerlog;

$Makerlog = new Makerlog();
$Products = $Makerlog->getProducts(); 
$Project  = $Projects->getProjectAsObject($list[0]->id);

$Product = $Products->createProduct(
    'My first product',
    'This is a description',
    [$Project->getId()]
);

```






Change a product
------

After creating a product it is possible to change or delete the product.

```php
<?php

use PCSG\Makerlog\Makerlog;

$Makerlog = new Makerlog();
$Products = $Makerlog->getProducts(); 
$Product  = $Products->getProductAsObject('myProductSlug');

$Product->update([
    'name'         => 'My new name',
    'slug'         => 'myNewSlug',
    'icon'         => 'new icon',
    'description'  => 'new description',
    'product_hunt' => 'new product hunt handle',
    'twitter'      => 'new twitter handler',
    'website'      => 'new website',
    'launched'     => false // product is launched (true) or not (false)
]);

// delete the product
$Product->delete();

// launch the project, set the launch status to true
$Product->launch();

```

It is also possible to add users to the product team or remove them.

```php
<?php

use PCSG\Makerlog\Makerlog;

$Makerlog = new Makerlog();
$Products = $Makerlog->getProducts(); 
$Product  = $Products->getProductAsObject('myProductSlug');

$User = $Makerlog->getUsers()->getUserObject(1000);

// add a user to the team
$Product->addUserToTheTeam($User);

// remove a user from the team
$Product->removeUserFromTeam($User);

```
