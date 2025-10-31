<?php

declare(strict_types=1);

namespace WechatMiniProgramShortLinkBundle;

use Symfony\Component\HttpKernel\Bundle\Bundle;
use Tourze\BundleDependency\BundleDependencyInterface;
use WechatMiniProgramBundle\WechatMiniProgramBundle;

class WechatMiniProgramShortLinkBundle extends Bundle implements BundleDependencyInterface
{
    public static function getBundleDependencies(): array
    {
        return [
            WechatMiniProgramBundle::class => [],
        ];
    }
}
