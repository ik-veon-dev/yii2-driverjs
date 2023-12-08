yii2-driverjs -under development!!!
=============

Driverjs.com component for Yii2

Installation
------------

The preferred way to install this extension is through [composer](http://getcomposer.org/download/).

Either run

```
php composer.phar require --prefer-dist adlurfm/yii2-driverjs "*"
```

or add

```
"adlurfm/yii2-driverjs": "*"
```

to the require section of your `composer.json` file.


Usage
-----

Once the extension is installed, simply use it in your code by  :

```php
$dri = new DriverJsWidget();

$dri->addStep('.info-box',"step 1", "this is the step 1")
    ->addStep('.info-box',"step 2", "this is the step 2")
    ->addStep('.info-box',"step 3", "this is the step 3")
    ->addStep('.info-box',"step 4", "this is the step 4")
    ->addStep('.info-box',"step 5", "this is the step 5")
    ->useButton()
    ->build(false);
```