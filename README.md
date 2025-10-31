# WeChat Mini Program Short Link Bundle

[English](README.md) | [中文](README.zh-CN.md)

[![PHP Version](https://img.shields.io/badge/php-8.1%2B-blue.svg?style=flat-square)](https://www.php.net/)
[![Symfony Version](https://img.shields.io/badge/symfony-6.4%2B-green.svg?style=flat-square)](https://symfony.com/)
[![License](https://img.shields.io/badge/license-MIT-brightgreen.svg?style=flat-square)](LICENSE)
[![Tests](https://img.shields.io/badge/tests-passing-brightgreen.svg?style=flat-square)](#)
[![Coverage](https://img.shields.io/badge/coverage-100%25-brightgreen.svg?style=flat-square)](#)

A Symfony bundle for generating WeChat Mini Program short links.

## Features

- Generate temporary or permanent short links for WeChat Mini Programs
- Symfony integration with dependency injection
- Comprehensive test coverage
- PSR-4 autoloading support
- Simple and intuitive API

## Installation

```bash
composer require tourze/wechat-mini-program-short-link-bundle
```

## Quick Start

### Basic Usage

```php
<?php
use WechatMiniProgramBundle\Entity\Account;
use WechatMiniProgramShortLinkBundle\Request\ShortLinkRequest;

// Create a WeChat Mini Program account
$account = new Account();
$account->setAppId('your_app_id');
$account->setAppSecret('your_app_secret');

// Create short link request
$request = new ShortLinkRequest();
$request->setAccount($account);
$request->setPageUrl('pages/index/index');
$request->setPageTitle('Home Page');
$request->setPermanent(false); // false for temporary, true for permanent

// Get request options for API call
$options = $request->getRequestOptions();
$path = $request->getRequestPath(); // '/wxa/genwxashortlink'
```

### Configuration

This bundle requires the `tourze/wechat-mini-program-bundle` package and uses its account configuration.

### Request Parameters

- `pageUrl` (string): The page URL within the mini program
- `pageTitle` (string): The title for the short link  
- `permanent` (bool): Whether the short link is permanent (default: false)

### API Endpoint

The bundle generates requests for the WeChat API endpoint `/wxa/genwxashortlink`.

## Advanced Usage

### Custom Configuration

This bundle integrates with `tourze/wechat-mini-program-bundle` for account management. 
Ensure you have properly configured your WeChat Mini Program accounts.

### Error Handling

```php
<?php
use WechatMiniProgramShortLinkBundle\Request\ShortLinkRequest;

try {
    $request = new ShortLinkRequest();
    $request->setAccount($account);
    $request->setPageUrl('pages/products/detail?id=123');
    $request->setPageTitle('Product Detail');
    
    $options = $request->getRequestOptions();
    // Handle API call with proper error handling
} catch (\Exception $e) {
    // Handle errors appropriately
}
```

### Best Practices

- Use meaningful page titles that describe the destination
- Consider using permanent links sparingly as they cannot be deleted
- Validate page URLs before creating short links
- Implement proper error handling for API failures

## Security

When using this bundle, please consider the following security aspects:

- **Input Validation**: Always validate and sanitize page URLs and titles before creating short links
- **Access Control**: Implement proper authorization checks before allowing short link creation
- **Rate Limiting**: Consider implementing rate limiting to prevent abuse of the short link generation API
- **Audit Logging**: Log short link creation activities for security monitoring

## Requirements

- PHP 8.1+
- Symfony 6.4+
- tourze/wechat-mini-program-bundle

## License

This bundle is released under the MIT License. See the bundled LICENSE file for details.