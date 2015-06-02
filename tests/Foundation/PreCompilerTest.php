<?php

class PreCompilerTest extends \PHPUnit_Framework_TestCase
{

    /** @var \Iono\Micro\Foundation\PreCompiler */
    protected $compiler;

    protected function setUp()
    {
        $this->compiler = new \Iono\Micro\Foundation\PreCompiler();
    }

    public function tearDown()
    {
        if(file_exists(__DIR__ . '/stub/compiled.php')) {
            unlink(__DIR__ . '/stub/compiled.php');
        }
    }

    public function testInstance()
    {
        $this->assertInstanceOf("Iono\Micro\Foundation\PreCompiler", $this->compiler);
    }

    public function testCompilerStart()
    {
        $this->compiler->start(__DIR__ . '/stub/', __DIR__ . '/stub');
        $this->assertFileExists(__DIR__ . '/stub/compiled.php');
    }

}
