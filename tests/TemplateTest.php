<?php

use enricodias\Template;
use PHPUnit\Framework\TestCase;

final class TemplateTest extends TestCase
{
    public function testLoad()
    {
        $template = new Template('tests/samples/a.tpl');

        $this->assertSame('Template A. {$var}', $template->getContent());

        $template->load('tests/samples/b.tpl');

        $this->assertSame('Template B.', $template->getContent());
    }

    public function testWithoutTemplateFile()
    {
        $template = new Template('tests/samples/wrong_path.tpl');

        $this->assertSame('', $template->getContent());
    }

    public function testReplace()
    {
        $template = new Template('tests/samples/a.tpl');

        $template->replace('var', '{$var2}');
        $this->assertSame('Template A. {$var2}', $template->getContent());

        $template->replace('var2', 'value');
        $this->assertSame('Template A. value', $template->getContent());
    }

    public function testReload()
    {
        $template = new Template('tests/samples/a.tpl');

        $template->reload('tests/samples/b.tpl');
        $this->assertSame('Template A. {$var}'.'Template B.', $template->getContent());

        $template->reload('tests/samples/b.tpl');
        $this->assertSame('Template A. {$var}'.'Template B.'.'Template B.', $template->getContent());
    }

    public function testBlocks()
    {
        $template = new Template('tests/samples/blocks_test.tpl');

        $template->getBlock('header');
        $template->makeBlock();

        $template->getBlock('row');

        $template->reloadBlock();
        $template->reloadBlock();

        $template->getBlock('footer');
        $template->reloadBlock();

        $this->assertSame(file_get_contents('tests/samples/blocks_result.tpl'), $template->getContent());
    }

    public function testToString()
    {
        $template = new Template('tests/samples/b.tpl');

        $this->assertSame('Template B.', $template->__toString());
    }

    public function testPublish()
    {
        $this->expectOutputString('Template B.');

        $template = new Template('tests/samples/b.tpl');
        $template->publish();
    }

}