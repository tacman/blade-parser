<?php

namespace Stillat\BladeParser\Tests;

class BladeForeachStatementsTest extends ParserTestCase
{
    public function testForeachStatementsAreCompiled()
    {
        $string = '@foreach ($this->getUsers() as $user)
test
@endforeach';
        $expected = '<?php $__currentLoopData = $this->getUsers(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $user): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
test
<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>';
        $this->assertEquals($expected, $this->compiler->compileString($string));
    }

    public function testForeachStatementsAreCompileWithUppercaseSyntax()
    {
        $string = '@foreach ($this->getUsers() AS $user)
test
@endforeach';
        $expected = '<?php $__currentLoopData = $this->getUsers(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $user): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
test
<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>';
        $this->assertEquals($expected, $this->compiler->compileString($string));
    }

    public function testForeachStatementsAreCompileWithMultipleLine()
    {
        $string = '@foreach ([
foo,
bar,
] as $label)
test
@endforeach';
        $expected = '<?php $__currentLoopData = [
foo,
bar,
]; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $label): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
test
<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>';
        $this->assertEquals($expected, $this->compiler->compileString($string));
    }

    public function testNestedForeachStatementsAreCompiled()
    {
        $string = '@foreach ($this->getUsers() as $user)
user info
@foreach ($user->tags as $tag)
tag info
@endforeach
@endforeach';
        $expected = '<?php $__currentLoopData = $this->getUsers(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $user): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
user info
<?php $__currentLoopData = $user->tags; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $tag): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
tag info
<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>';
        $this->assertEquals($expected, $this->compiler->compileString($string));
    }

    public function testLoopContentHolderIsExtractedFromForeachStatements()
    {
        $string = '@foreach ($some_uSers1 as $user)';
        $expected = '<?php $__currentLoopData = $some_uSers1; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $user): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>';
        $this->assertEquals($expected, $this->compiler->compileString($string));

        $string = '@foreach ($users->get() as $user)';
        $expected = '<?php $__currentLoopData = $users->get(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $user): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>';
        $this->assertEquals($expected, $this->compiler->compileString($string));

        $string = '@foreach (range(1, 4) as $user)';
        $expected = '<?php $__currentLoopData = range(1, 4); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $user): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>';
        $this->assertEquals($expected, $this->compiler->compileString($string));

        $string = '@foreach (   $users as $user)';
        $expected = '<?php $__currentLoopData = $users; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $user): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>';
        $this->assertEquals($expected, $this->compiler->compileString($string));

        $string = '@foreach ($tasks as $task)';
        $expected = '<?php $__currentLoopData = $tasks; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $task): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>';
        $this->assertEquals($expected, $this->compiler->compileString($string));
    }
}
