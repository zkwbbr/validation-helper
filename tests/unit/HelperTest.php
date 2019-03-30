<?php

declare(strict_types=1);

use PHPUnit\Framework\TestCase;
use Zkwbbr\ValidationHelper;
use Respect\Validation\Validator as v;

class HelperTest extends TestCase
{
    private $helper;
    private $rules;
    private $data;

    public function setUp(): void
    {
        $this->helper = new ValidationHelper\Helper;
        $this->helper->setErrorsHtmlWrap('<div class="myerror">|</div>');

        $this->rules = [
            'foo' => v::email()->contains('.')->setName('fooField'),
            'bar' => v::numeric()
        ];

        $this->data = [
            'foo' => 'fooValue',
            'bar' => 'abc'
        ];
    }

    public function tearDown(): void
    {

    }

    public function testAllErrors()
    {
        $errors = $this->helper->allErrors($this->rules, $this->data);

        $this->assertArrayHasKey(1, $errors['foo']);
        $this->assertArrayHasKey('bar', $errors);
        $this->assertEquals('fooField must be valid email', $errors['foo'][0]);
    }

    public function testOneError()
    {
        $errors = $this->helper->oneError($this->rules, $this->data);

        $this->assertIsNotArray($errors['foo']);
        $this->assertEquals('fooField must be valid email', $errors['foo']);
    }

    public function testOneErrorDiv()
    {
        $errors = $this->helper->oneErrorHtmlWrap($this->rules, $this->data);

        $this->assertStringContainsString('<div class="myerror">', $errors['foo']);
        $this->assertStringContainsString('<div class="myerror">', $errors['bar']);
    }
}
