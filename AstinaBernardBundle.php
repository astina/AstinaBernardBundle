<?php

namespace Astina\Bundle\BernardBundle;

use Astina\Bundle\BernardBundle\DependencyInjection\Compiler\ReceiversPass;
use Symfony\Component\Console\Application;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\Finder\Finder;
use Symfony\Component\HttpKernel\Bundle\Bundle;

class AstinaBernardBundle extends Bundle
{
    public function build(ContainerBuilder $container)
    {
        $container->addCompilerPass(new ReceiversPass());
    }
}
