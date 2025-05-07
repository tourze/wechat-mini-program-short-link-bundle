<?php

namespace WechatMiniProgramShortLinkBundle\Request;

use WechatMiniProgramBundle\Request\WithAccountRequest;

/**
 * @see https://developers.weixin.qq.com/miniprogram/dev/OpenApiDoc/qrcode-link/qr-code/getUnlimitedQRCode.html
 */
class ShortLinkRequest extends WithAccountRequest
{
    private string $pageUrl = '';

    private string $pageTitle = '';

    /**
     * @var bool 默认值false。生成的 Short Link 类型，短期有效：false，永久有效：true
     */
    private bool $permanent = false;

    public function getRequestPath(): string
    {
        return '/wxa/genwxashortlink';
    }

    public function getRequestOptions(): ?array
    {
        return [
            'json' => [
                'page_url' => $this->getPageUrl(),
                'page_title' => $this->getPageTitle(),
                'is_permanent' => $this->isPermanent(),
            ],
        ];
    }

    public function getPageUrl(): string
    {
        return $this->pageUrl;
    }

    public function setPageUrl(string $pageUrl): void
    {
        $this->pageUrl = $pageUrl;
    }

    public function getPageTitle(): string
    {
        return $this->pageTitle;
    }

    public function setPageTitle(string $pageTitle): void
    {
        $this->pageTitle = $pageTitle;
    }

    public function isPermanent(): bool
    {
        return $this->permanent;
    }

    public function setPermanent(bool $permanent): void
    {
        $this->permanent = $permanent;
    }
}
