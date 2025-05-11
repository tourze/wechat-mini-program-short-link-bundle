<?php

namespace WechatMiniProgramShortLinkBundle\Tests\Unit\Request;

use PHPUnit\Framework\TestCase;
use WechatMiniProgramBundle\Request\WithAccountRequest;
use WechatMiniProgramShortLinkBundle\Request\ShortLinkRequest;

class ShortLinkRequestTest extends TestCase
{
    private ShortLinkRequest $request;

    protected function setUp(): void
    {
        $this->request = new ShortLinkRequest();
    }

    public function testInstanceOf(): void
    {
        $this->assertInstanceOf(WithAccountRequest::class, $this->request);
    }

    public function testGetRequestPath(): void
    {
        $this->assertEquals('/wxa/genwxashortlink', $this->request->getRequestPath());
    }

    public function testGetRequestOptions_WithDefaultValues(): void
    {
        $expectedOptions = [
            'json' => [
                'page_url' => '',
                'page_title' => '',
                'is_permanent' => false,
            ],
        ];

        $this->assertEquals($expectedOptions, $this->request->getRequestOptions());
    }

    public function testGetRequestOptions_WithCustomValues(): void
    {
        $this->request->setPageUrl('pages/index/index');
        $this->request->setPageTitle('首页');
        $this->request->setPermanent(true);

        $expectedOptions = [
            'json' => [
                'page_url' => 'pages/index/index',
                'page_title' => '首页',
                'is_permanent' => true,
            ],
        ];

        $this->assertEquals($expectedOptions, $this->request->getRequestOptions());
    }

    public function testGetSetPageUrl(): void
    {
        $this->assertEquals('', $this->request->getPageUrl());

        $this->request->setPageUrl('pages/index/index');
        $this->assertEquals('pages/index/index', $this->request->getPageUrl());

        $this->request->setPageUrl('');
        $this->assertEquals('', $this->request->getPageUrl());
    }

    public function testGetSetPageTitle(): void
    {
        $this->assertEquals('', $this->request->getPageTitle());

        $this->request->setPageTitle('首页');
        $this->assertEquals('首页', $this->request->getPageTitle());

        $this->request->setPageTitle('');
        $this->assertEquals('', $this->request->getPageTitle());
    }

    public function testIsPermanent(): void
    {
        $this->assertFalse($this->request->isPermanent());

        $this->request->setPermanent(true);
        $this->assertTrue($this->request->isPermanent());

        $this->request->setPermanent(false);
        $this->assertFalse($this->request->isPermanent());
    }

    public function testGetSetPageUrl_WithSpecialCharacters(): void
    {
        $specialUrl = 'pages/index/index?id=123&name=测试';
        $this->request->setPageUrl($specialUrl);
        $this->assertEquals($specialUrl, $this->request->getPageUrl());
    }

    public function testGetSetPageTitle_WithSpecialCharacters(): void
    {
        $specialTitle = '测试标题 123 !@#$%^&*()_+';
        $this->request->setPageTitle($specialTitle);
        $this->assertEquals($specialTitle, $this->request->getPageTitle());
    }
} 