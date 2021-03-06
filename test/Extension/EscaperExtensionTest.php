<?php

/**
 * @see       https://github.com/mezzio/mezzio-platesrenderer for the canonical source repository
 * @copyright https://github.com/mezzio/mezzio-platesrenderer/blob/master/COPYRIGHT.md
 * @license   https://github.com/mezzio/mezzio-platesrenderer/blob/master/LICENSE.md New BSD License
 */

declare(strict_types=1);

namespace MezzioTest\Plates\Extension;

use Laminas\Escaper\Escaper;
use League\Plates\Engine;
use Mezzio\Plates\Extension\EscaperExtension;
use PHPUnit\Framework\TestCase;
use Prophecy\Argument;
use Prophecy\PhpUnit\ProphecyTrait;

use function is_array;

class EscaperExtensionTest extends TestCase
{
    use ProphecyTrait;

    public function testRegistersEscaperFunctionsWithEngine()
    {
        $extension = new EscaperExtension();

        $engine = $this->prophesize(Engine::class);
        $engine
            ->registerFunction('escapeHtml', Argument::that(function ($argument) {
                return is_array($argument) && $argument[0] instanceof Escaper && $argument[1] === 'escapeHtml';
            }))->shouldBeCalled();
        $engine
            ->registerFunction('escapeHtmlAttr', Argument::that(function ($argument) {
                return is_array($argument) && $argument[0] instanceof Escaper && $argument[1] === 'escapeHtmlAttr';
            }))->shouldBeCalled();
        $engine
            ->registerFunction('escapeJs', Argument::that(function ($argument) {
                return is_array($argument) && $argument[0] instanceof Escaper && $argument[1] === 'escapeJs';
            }))->shouldBeCalled();
        $engine
            ->registerFunction('escapeCss', Argument::that(function ($argument) {
                return is_array($argument) && $argument[0] instanceof Escaper && $argument[1] === 'escapeCss';
            }))->shouldBeCalled();
        $engine
            ->registerFunction('escapeUrl', Argument::that(function ($argument) {
                return is_array($argument) && $argument[0] instanceof Escaper && $argument[1] === 'escapeUrl';
            }))->shouldBeCalled();

        $extension->register($engine->reveal());
    }
}
