<?php

namespace Stillat\BladeParser\Tests;

class BladeSectionTest extends ParserTestCase
{
    public function testSectionStartsAreCompiled()
    {
        $this->assertSame('<?php $__env->startSection(\'foo\'); ?>', $this->compiler->compileString('@section(\'foo\')'));
        $this->assertSame('<?php $__env->startSection(name(foo)); ?>', $this->compiler->compileString('@section(name(foo))'));
    }
}
