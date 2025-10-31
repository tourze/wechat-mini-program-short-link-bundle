<?php

declare(strict_types=1);

namespace WechatMiniProgramShortLinkBundle\Tests\DependencyInjection;

use PHPUnit\Framework\Attributes\CoversClass;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Tourze\PHPUnitSymfonyUnitTest\AbstractDependencyInjectionExtensionTestCase;
use WechatMiniProgramShortLinkBundle\DependencyInjection\WechatMiniProgramShortLinkExtension;

/**
 * @internal
 */
#[CoversClass(WechatMiniProgramShortLinkExtension::class)]
final class WechatMiniProgramShortLinkExtensionTest extends AbstractDependencyInjectionExtensionTestCase
{
    protected function provideServiceDirectories(): iterable
    {
        // 这个包没有需要注册为服务的目录
        // Request 是数据传输对象(DTO)，不应该注册为服务
        return [];
    }

    public function testLoadWithEmptyConfiguration(): void
    {
        $extension = new WechatMiniProgramShortLinkExtension();
        $container = new ContainerBuilder();
        $container->setParameter('kernel.environment', 'test');

        // 加载空配置不应抛出异常
        $extension->load([], $container);

        // 验证容器已经被正确配置
        $this->assertInstanceOf(ContainerBuilder::class, $container);
    }
}
