Astina Bernard Bundle
=====================

Symfony bundle integrating https://github.com/bernardphp/bernard

## Install

### Step 1: Add to composer.json

```
"require" :  {
    // ...
    "astina/bernard-bundle":"dev-master",
}
```

### Step 2: Enable the bundle

Enable the bundle in the kernel:

``` php
<?php
// app/AppKernel.php

public function registerBundles()
{
    $bundles = array(
        // ...
        new Astina\Bundle\BernardBundle\AstinaBernardBundle(),
    );
}
```

### Step 3: Configuration

**TODO**: Driver configuration. At the moment only Doctrine driver is supported.

```yaml
# app/config.yml

astina_bernard:
    driver: TODO
```

## Usage

Use the `astina_bernard.producer` service to produce messages:

```php
/** @var Bernard\Producer $producer */
$producer = ... // get from container or have it injected

$message = new DefaultMessage('my_name', array(
    'foo' => 'bar',
));

$producer->produce($message, 'my_queue');
```

Define message receiver services by tagging them as `astina_bernard.receiver`.

```xml
<service id="my_bernard_receiver" class="Astina\Bundle\SandboxBundle\Foo\MyMessageReceiver">
    <tag name="astina_bernard.receiver" receiver="my_name" method="foo" />
</service>
```

Run consumer command to consume messages from a queue:

`app/console astina:bernard:consume my_queue`

**Note**: Don't forget to set `-e=prod` when using in production. Otherwise the command will eventually use up all memory.

