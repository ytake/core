<?php
namespace Iono\Micro\Foundation;

use Symfony\Component\Finder\Finder;
use ClassPreloader\Command\PreCompileCommand;

/**
 * Class PreCompiler
 * @package Iono\Micro\Foundation
 * @author yuuki.takezawa<yuuki.takezawa@comnect.jp.net>
 */
class PreCompiler
{
    /** @var PreCompileCommand */
    protected $compiler;

    public function __construct()
    {
        $this->registerCompiler();
    }

    /**
     * @return void
     */
    protected function registerCompiler()
    {
        $this->compiler = new PreCompileCommand;
    }

    /**
     * @param $target
     * @param $output
     */
    public function start($target, $output)
    {
        $finder = new Finder();
        $finder->files()->in($target);
        $files = [];
        foreach ($finder as $file) {
            /** @var \Symfony\Component\Finder\SplFileInfo $file */
            $files[] = $target . $file->getRelativePathname();
        }
        $files = implode(',', $files);
        exec("php vendor/bin/classpreloader.php compile --config={$files} --output={$output}/compiled.php --strip_comments=1");
    }
}
