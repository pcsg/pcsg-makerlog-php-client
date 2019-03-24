Makerlog PHP Client Tasks API
======

This documentation describes how to create, modify and delete tasks in Makerlog. 
It describes the most basic properties of a task and how to handle them.

Get tasks
----

Returns a list of all tasks

```php
<?php

use PCSG\Makerlog\Makerlog;

$Makerlog = new Makerlog();
$list     = $Makerlog->getTasks()->getList();
```


Get a task
------

A single task can be received via its id

```php
<?php

use PCSG\Makerlog\Makerlog;

$Makerlog = new Makerlog();
$task     = $Makerlog->getTasks()->get(892); // get task via ID
```

With a normal task which has been received via get(), no operations can be executed. 
If you want to change the task, you should get a task object. This can be done via getTaskAsObject().


```php
<?php

use PCSG\Makerlog\Makerlog;

$Makerlog = new Makerlog();
$Task     = $Makerlog->getTasks()->getTaskAsObject(892); // get task via ID

// delete the task
$Task->delete();

// praise the task
$Task->praise(100);
```

A task object has several getter methods, so it is quite easy to access the data of the task.

```php
<?php

use PCSG\Makerlog\Makerlog;

$Makerlog = new Makerlog();
$Task     = $Makerlog->getTasks()->getTaskAsObject(892); // get task via ID

// main data
$Task->getId();
$Task->getContent();

// dates
$Task->getCreationDate();
$Task->getDoneDate();
$Task->getLastUpdateDate();

$Task->getCommentCount();

// is methods
$Task->isDone();         // returns true if the task is done
$Task->isInProgress();   // returns true if the task is in progress
```

Create a Task
------

To create a new task, you must use the tasks object.


```php
<?php

use PCSG\Makerlog\Makerlog;

$Makerlog = new Makerlog();
$Makerlog->getTasks()->createTask('YOUR CONTENT', $options);
```

The options of a task can have the following values

```php
<?php

$options = [
    "done"        => false, // bool
    "in_progress" => false  // bool
];

```

Change a Task
------

After creating a task it is possible to change or delete the task.

```php
<?php

use PCSG\Makerlog\Makerlog;

$Makerlog = new Makerlog();
$Tasks = $Makerlog->getTasks();

// Create a new task
$Task  = $Tasks->createTask('My awsme Tsk');

// change the content
$Task->setContent('My awesome Task');

// mark the task as done
$Task->done();

// mark the task as undone
$Task->undone();

// delete the task
$Task->delete();

```

Tasks search
------

Via an API not yet documented at the moment, tasks can also be searched globally. The Tasks object already offers an interface here.

```php
<?php

$result = $Makerlog->getTasks()->search('dehenne');
```

These results can also be limited or extended using various parameters.

```php
<?php

$result = $Makerlog->getTasks()->search('dehenne', [
    'limit'  => 30, // how many entries
    'offset' => 60  // the start of the results, needed for pagination
]);

```

In addition the search can be told if the results should be built as Tasks objects. 
No additional request will be sent.

```php
<?php

$result = $Makerlog->getTasks()->search('dehenne', [
    'limit' => 30
], true);

foreach ($result->results as $Task) {
    /* @var $Task \PCSG\Makerlog\Api\Tasks\Task */
    echo $Task->getContent();
    echo PHP_EOL;
    echo PHP_EOL;
}

```