<?php

declare(strict_types=1);

namespace WechatMiniProgramShortLinkBundle\Tests;

use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\RunTestsInSeparateProcesses;
use Tourze\PHPUnitSymfonyKernelTest\AbstractBundleTestCase;
use WechatMiniProgramShortLinkBundle\WechatMiniProgramShortLinkBundle;

/**
 * @internal
 */
#[CoversClass(WechatMiniProgramShortLinkBundle::class)]
#[RunTestsInSeparateProcesses]
final class WechatMiniProgramShortLinkBundleTest extends AbstractBundleTestCase
{
}
