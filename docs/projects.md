Makerlog PHP Client Project API
======

This documentation describes how to create, modify and delete projects in Makerlog. 
It describes the most basic properties of a project and how to handle them.

A project is something like a hash tag.


Get projects
----

Returns a list of all projects

```php
<?php

use PCSG\Makerlog\Makerlog;

$Makerlog = new Makerlog();
$list     = $Makerlog->getProjects()->getList();
```


Get a project
------

A single project can be received via its id

```php
<?php

use PCSG\Makerlog\Makerlog;

$Makerlog = new Makerlog();
$project     = $Makerlog->getProjects()->get(10); // get project via ID
```

With a normal project which has been received via get(), no operations can be executed. 
If you want to change the project, you should get a project object. This can be done via getProjectAsObject().


```php
<?php

use PCSG\Makerlog\Makerlog;

$Makerlog = new Makerlog();
$Project     = $Makerlog->getProjects()->getProjectAsObject(10); // get project via ID

// delete the project
$Project->delete();

```

A project object has several getter methods, so it is quite easy to access the data of the project.

```php
<?php

use PCSG\Makerlog\Makerlog;

$Makerlog = new Makerlog();
$Project     = $Makerlog->getProjects()->getProjectAsObject(10); // get project via ID

// main data
$Project->getId();
$Project->getName();

// Gets user and products associated to this project/hashtag. 
$Project->getRelated();

// is methods
 
$Project->isPrivate();  // returns true if the project is private
$Project->isPublic();   // returns true if the project is public
```

Create a project
------

To create a new project, you must use the projects object.


```php
<?php

use PCSG\Makerlog\Makerlog;

$Makerlog = new Makerlog();

$PublicProject  = $Makerlog->getProjects()->createProject('My new Project');
$PrivateProject = $Makerlog->getProjects()->createProject('My new private Project', true);
```

Change a project
------

After creating a project it is possible to change or delete the project.

```php
<?php

use PCSG\Makerlog\Makerlog;

$Makerlog = new Makerlog();
$Projects = $Makerlog->getProjects();

// Create a new project
$Project  = $Projects->createProject('My awsme project');

$Project->setToPublic();
$Project->setToPrivate();

$Project->update([
    'name' => 'MyNewName'
]);

// delete the project
$Project->delete();

```