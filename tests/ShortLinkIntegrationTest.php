<?php

declare(strict_types=1);

namespace WechatMiniProgramShortLinkBundle\Tests;

use HttpClientBundle\Test\RequestTestCase;
use PHPUnit\Framework\Attributes\CoversClass;
use WechatMiniProgramBundle\Entity\Account;
use WechatMiniProgramShortLinkBundle\Request\ShortLinkRequest;

/**
 * @internal
 */
#[CoversClass(ShortLinkRequest::class)]
final class ShortLinkIntegrationTest extends RequestTestCase
{
    public function testShortLinkRequestCanBeInstantiated(): void
    {
        // 直接实例化 ShortLinkRequest，因为它是数据传输对象(DTO)
        $request = new ShortLinkRequest();

        // 测试设置属性并获取请求选项
        $request->setPageUrl('pages/index/index');
        $request->setPageTitle('测试标题');
        $request->setPermanent(true);

        // 创建 Account 对象并设置到请求中
        $account = new Account();
        $account->setName('测试账号');
        $account->setAppId('wx123456');
        $account->setAppSecret('test_secret');
        $request->setAccount($account);

        // 验证请求选项是否正确
        $expectedOptions = [
            'json' => [
                'page_url' => 'pages/index/index',
                'page_title' => '测试标题',
                'is_permanent' => true,
            ],
        ];
        $this->assertEquals($expectedOptions, $request->getRequestOptions());
        $this->assertEquals('/wxa/genwxashortlink', $request->getRequestPath());
    }

    public function testShortLinkRequestWithNonAsciiCharacters(): void
    {
        $request = new ShortLinkRequest();
        $request->setPageUrl('pages/product/detail?id=123');
        $request->setPageTitle('中文标题测试');

        $expectedOptions = [
            'json' => [
                'page_url' => 'pages/product/detail?id=123',
                'page_title' => '中文标题测试',
                'is_permanent' => false,
            ],
        ];

        $this->assertEquals($expectedOptions, $request->getRequestOptions());
    }

    public function testShortLinkRequestWithEmptyValues(): void
    {
        $request = new ShortLinkRequest();

        $expectedOptions = [
            'json' => [
                'page_url' => '',
                'page_title' => '',
                'is_permanent' => false,
            ],
        ];

        $this->assertEquals($expectedOptions, $request->getRequestOptions());
    }
}
