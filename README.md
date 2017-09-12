# Partialy defined dates 

## Supported date formats

Package supports dates, defined using the following formats:

 - `H:i:s d.m.Y` (01:00:05 21.07.2017)
 - `H:i d.m.Y` (01:00 21.07.2017)
 - `H: d.m.Y` (01: 21.07.2017)
 - `d.m.Y` (21.07.2017)
 - `m.Y` (07.2017)
 - `Y` (2017)
 - `H:i:s` (01:00:05)
 - `H:i` (01:00)
 - `H:` (01:)

## Comparison 

Partially defined dates can be compared one with another. 
Basic usage example is:

```php
<?php

$partialDateA = new \Oprokidnev\PartialDate\PartialDate('2017');
$partialDateB = new \Oprokidnev\PartialDate\PartialDate('2018');
$partialDateA->compareTo($partialDateB); // -1 A is less than B

$partialDateC = new \Oprokidnev\PartialDate\PartialDate('02.2017');
$partialDateD = new \Oprokidnev\PartialDate\PartialDate('2018');
$partialDateD->compareTo($partialDateC); // 1 D is greater than C

try {
    $partialDateE = new \Oprokidnev\PartialDate\PartialDate('01.2017');
    $partialDateF = new \Oprokidnev\PartialDate\PartialDate('2017');
    $partialDateE->compareTo($partialDateF);
} catch (\Oprokidnev\PartialDate\Exception\UnobviousResultException $ex) {
    echo 'Unobvious result';
}

```


## Installation
```
composer require oprokidnev/partial-date
```

## Contribution
```
composer create-project oprokidnev/partial-date --stability dev;
composer run tests
```