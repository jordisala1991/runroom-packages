<?php

declare(strict_types=1);

/*
 * This file is part of the Runroom package.
 *
 * (c) Runroom <runroom@runroom.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Runroom\RenderEventBundle\DependencyInjection;

use Runroom\RenderEventBundle\ViewModel\PageViewModel;
use Runroom\RenderEventBundle\ViewModel\PageViewModelInterface;
use Symfony\Component\Config\Definition\Builder\TreeBuilder;
use Symfony\Component\Config\Definition\ConfigurationInterface;

final class Configuration implements ConfigurationInterface
{
    public function getConfigTreeBuilder(): TreeBuilder
    {
        $treeBuilder = new TreeBuilder('render_event');

        $treeBuilder
            ->getRootNode()
                ->children()
                    ->scalarNode('page_view_model')
                        ->cannotBeEmpty()
                        ->defaultValue(PageViewModel::class)
                        ->validate()
                            ->ifTrue(function ($config) {
                                return !is_a($config, PageViewModelInterface::class, true);
                            })
                            ->thenInvalid('%s must extend ' . PageViewModelInterface::class)
                        ->end()
                    ->end()
                ->end();

        return $treeBuilder;
    }
}
