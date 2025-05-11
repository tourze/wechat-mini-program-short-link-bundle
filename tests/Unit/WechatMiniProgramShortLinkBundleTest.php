<?php

namespace WechatMiniProgramShortLinkBundle\Tests\Unit;

use PHPUnit\Framework\TestCase;
use Symfony\Component\HttpKernel\Bundle\Bundle;
use WechatMiniProgramShortLinkBundle\WechatMiniProgramShortLinkBundle;

class WechatMiniProgramShortLinkBundleTest extends TestCase
{
    public function testInstanceOf(): void
    {
        $bundle = new WechatMiniProgramShortLinkBundle();
        $this->assertInstanceOf(Bundle::class, $bundle);
    }

    public function testInstantiation(): void
    {
        $bundle = new WechatMiniProgramShortLinkBundle();
        $this->assertNotNull($bundle);
    }
} 