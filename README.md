mod-compare NO TEST, NO FINISH!
===========
Module for CORNER CMS

[![Latest Stable Version](https://poser.pugx.org/panix/mod-compare/v/stable)](https://packagist.org/packages/panix/mod-compare) [![Total Downloads](https://poser.pugx.org/panix/mod-compare/downloads)](https://packagist.org/packages/panix/mod-compare) [![Monthly Downloads](https://poser.pugx.org/panix/mod-compare/d/monthly)](https://packagist.org/packages/panix/mod-compare) [![Daily Downloads](https://poser.pugx.org/panix/mod-compare/d/daily)](https://packagist.org/packages/panix/mod-compare) [![Latest Unstable Version](https://poser.pugx.org/panix/mod-compare/v/unstable)](https://packagist.org/packages/panix/mod-compare) [![License](https://poser.pugx.org/panix/mod-compare/license)](https://packagist.org/packages/panix/mod-compare)


Installation
------------

The preferred way to install this extension is through [composer](http://getcomposer.org/download/).

Either run

```
php composer.phar require --prefer-dist panix/mod-compare "*"
```

or add

```
"panix/mod-compare": "*"
```

to the require section of your `composer.json` file.

Add to web config.
```
'modules' => [
    'compare' => ['class' => 'panix\compare\Module'],
],

