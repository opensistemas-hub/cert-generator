<?php

namespace Tests\Unit;


use Opensistemas\CertGenerator\Exception;
use Opensistemas\CertGenerator\Template;
use setasign\Fpdi\Fpdi;
use Tests\TestCase;

class TemplateTest extends TestCase
{

    /**
     * @test
     */
    public function make_from_static()
    {

        $settings = $this->getSettingsFromJsonFile('example_01.json');
        $template = $this->getFilePath('template_two_pages.pdf');
        $object = Template::create($settings, $template);
        $this->assertInstanceOf(Template::class, $object);
        $this->assertEquals($object->getSettings(), $settings);
        $this->assertEquals($object->getTemplate(), $template);
    }


    /**
     * @test
     */
    public function make_with_bad_settings_throws_exception()
    {

        $settings = $this->getSettingsFromJsonFile('bad_01.json');
        $this->expectException(Exception::class);
        $template = $this->getFilePath('template_two_pages.pdf');
        Template::create($settings, $template);

    }

    /**
     * @test
     */
    public function make_with_bad_settings_2_throws_exception()
    {

        $settings = $this->getSettingsFromJsonFile('bad_02.json');
        $this->expectException(Exception::class);
        $template = $this->getFilePath('template_two_pages.pdf');
        Template::create($settings, $template);

    }

    /**
     * @test
     */
    public function make_without_valid_file_throws_exception()
    {

        $settings = $this->getSettingsFromJsonFile('example_01.json');
        $this->expectException(Exception::class);
        $template = $this->getFilePath('none.pdf');
        Template::create($settings, $template);

    }

    /**
     * @test
     */
    public function make_simple_pdf_one_page()
    {

        $settings = $this->getSettingsFromJsonFile('only_one_page_no_changes.json');
        $template = $this->getFilePath('template_two_pages.pdf');
        $template = Template::create($settings, $template);


        $result = $template->generateString([]);


        $stream = fopen('php://memory', 'r+');
        fwrite($stream, $result);
        rewind($stream);


        $this->assertEquals(1, (new Fpdi())->setSourceFile($stream));


    }

    /**
     * @test
     */
    public function make_complex_pdf_two_pages()
    {

        $settings = $this->getSettingsFromJsonFile('example_01.json');
        $template = $this->getFilePath('template_two_pages.pdf');
        $template = Template::create($settings, $template);


        $result = $template->generateString([]);


        $stream = fopen('php://memory', 'r+');
        fwrite($stream, $result);
        rewind($stream);


        $this->assertEquals(2, (new Fpdi())->setSourceFile($stream));


    }


    /**
     * @test
     */
    public function make_simple_pdf_one_page_as_file()
    {

        $settings = $this->getSettingsFromJsonFile('only_one_page_no_changes.json');
        $template = $this->getFilePath('template_two_pages.pdf');
        $template = Template::create($settings, $template);
        $tempFile = tempnam(sys_get_temp_dir(), 'test') . '.pdf';

        $template->generate($tempFile, []);

        $this->fileExists($tempFile);


    }


}