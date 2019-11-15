<?php

use enricodias\Template;
use PHPUnit\Framework\TestCase;

final class TemplateTest extends TestCase
{
    public function testLoad()
    {
        $Template = new Template('tests/samples/a.tpl');

        $this->assertSame('Template A. {$var}', $Template->getContent());

        $Template->load('tests/samples/b.tpl');

        $this->assertSame('Template B.', $Template->getContent());
    }

    public function testWithoutTemplateFile()
    {
        $Template = new Template('tests/samples/wrong_path.tpl');

        $this->assertSame('', $Template->getContent());
    }

    public function testReplace()
    {
        $Template = new Template('tests/samples/a.tpl');

        $Template->replace('var', '{$var2}');
        $this->assertSame('Template A. {$var2}', $Template->getContent());

        $Template->replace('var2', 'value');
        $this->assertSame('Template A. value', $Template->getContent());
    }

    public function testReload()
    {
        $Template = new Template('tests/samples/a.tpl');

        $Template->reload('tests/samples/b.tpl');
        $this->assertSame('Template A. {$var}'.'Template B.', $Template->getContent());

        $Template->reload('tests/samples/b.tpl');
        $this->assertSame('Template A. {$var}'.'Template B.'.'Template B.', $Template->getContent());
    }

    public function testBlocks()
    {
        $Template = new Template('tests/samples/blocks_test.tpl');

        $Template->getBlock('header');
        $Template->makeBlock();

        $Template->getBlock('row');

        $Template->reloadBlock();
        $Template->reloadBlock();

        $Template->getBlock('footer');
        $Template->reloadBlock();

        $this->assertSame(file_get_contents('tests/samples/blocks_result.tpl'), $Template->getContent());
    }

    public function testToString()
    {
        $Template = new Template('tests/samples/b.tpl');

        $this->assertSame('Template B.', $Template->__toString());
    }

    public function testPublish()
    {
        $this->expectOutputString('Template B.');

        $Template = new Template('tests/samples/b.tpl');
        $Template->publish();
    }

}