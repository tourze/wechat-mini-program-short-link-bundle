# 微信小程序短链接包

[English](README.md) | [中文](README.zh-CN.md)

[![PHP Version](https://img.shields.io/badge/php-8.1%2B-blue.svg?style=flat-square)](https://www.php.net/)
[![Symfony Version](https://img.shields.io/badge/symfony-6.4%2B-green.svg?style=flat-square)](https://symfony.com/)
[![License](https://img.shields.io/badge/license-MIT-brightgreen.svg?style=flat-square)](LICENSE)
[![Tests](https://img.shields.io/badge/tests-passing-brightgreen.svg?style=flat-square)](#)
[![Coverage](https://img.shields.io/badge/coverage-100%25-brightgreen.svg?style=flat-square)](#)

用于生成微信小程序短链接的 Symfony 包。

## 功能特性

- 生成微信小程序临时或永久短链接
- Symfony 集成与依赖注入
- 全面的测试覆盖
- PSR-4 自动加载支持
- 简单直观的 API

## 安装

```bash
composer require tourze/wechat-mini-program-short-link-bundle
```

## 快速开始

### 基本用法

```php
<?php
use WechatMiniProgramBundle\Entity\Account;
use WechatMiniProgramShortLinkBundle\Request\ShortLinkRequest;

// 创建微信小程序账号
$account = new Account();
$account->setAppId('your_app_id');
$account->setAppSecret('your_app_secret');

// 创建短链接请求
$request = new ShortLinkRequest();
$request->setAccount($account);
$request->setPageUrl('pages/index/index');
$request->setPageTitle('首页');
$request->setPermanent(false); // false 为临时链接，true 为永久链接

// 获取 API 调用的请求选项
$options = $request->getRequestOptions();
$path = $request->getRequestPath(); // '/wxa/genwxashortlink'
```

### 配置

此包需要 `tourze/wechat-mini-program-bundle` 包，并使用其账号配置。

### 请求参数

- `pageUrl` (string): 小程序内的页面路径
- `pageTitle` (string): 短链接的标题
- `permanent` (bool): 短链接是否永久有效（默认：false）

### API 端点

该包为微信 API 端点 `/wxa/genwxashortlink` 生成请求。

## 高级用法

### 自定义配置

此包与 `tourze/wechat-mini-program-bundle` 集成进行账号管理。请确保正确配置了您的微信小程序账号。

### 错误处理

```php
<?php
use WechatMiniProgramShortLinkBundle\Request\ShortLinkRequest;

try {
    $request = new ShortLinkRequest();
    $request->setAccount($account);
    $request->setPageUrl('pages/products/detail?id=123');
    $request->setPageTitle('产品详情');
    
    $options = $request->getRequestOptions();
    // 进行 API 调用并正确处理错误
} catch (\Exception $e) {
    // 适当处理错误
}
```

### 最佳实践

- 使用有意义的页面标题来描述目标页面
- 谨慎使用永久链接，因为它们无法删除
- 在创建短链接之前验证页面 URL
- 为 API 失败实现适当的错误处理

## 安全性

使用此包时，请考虑以下安全方面：

- **输入验证**：在创建短链接之前，始终验证和净化页面 URL 和标题
- **访问控制**：在允许创建短链接之前实现适当的授权检查
- **速率限制**：考虑实现速率限制以防止滥用短链接生成 API
- **审计日志**：记录短链接创建活动以进行安全监控

## 系统要求

- PHP 8.1+
- Symfony 6.4+
- tourze/wechat-mini-program-bundle

## 许可证

此包在 MIT 许可证下发布。详情请参阅捆绑的 LICENSE 文件。
