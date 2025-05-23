<?php

namespace Stillat\BladeParser\Tests;

class BladeIfIssetStatementsTest extends ParserTestCase
{
    public function testIfStatementsAreCompiled()
    {
        $string = '@isset ($test)
breeze
@endisset';
        $expected = '<?php if(isset($test)): ?>
breeze
<?php endif; ?>';
        $this->assertEquals($expected, $this->compiler->compileString($string));
    }
}
