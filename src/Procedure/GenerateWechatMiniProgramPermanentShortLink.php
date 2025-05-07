<?php

namespace WechatMiniProgramShortLinkBundle\Procedure;

use AntdCpBundle\Builder\Action\ApiCallAction;
use AppBundle\Procedure\Base\ApiCallActionProcedure;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Security\Http\Attribute\IsGranted;
use Tourze\JsonRPC\Core\Attribute\MethodExpose;
use Tourze\JsonRPC\Core\Exception\ApiException;
use Tourze\JsonRPCLogBundle\Attribute\Log;
use Tourze\JsonRPCSecurityBundle\Attribute\MethodPermission;
use WechatMiniProgramBundle\Service\Client;
use WechatMiniProgramShortLinkBundle\Request\ShortLinkRequest;
use WechatMiniProgramUrlLinkBundle\Entity\PromotionCode;
use WechatMiniProgramUrlLinkBundle\Repository\PromotionCodeRepository;

#[Log]
#[MethodExpose(GenerateWechatMiniProgramPermanentShortLink::NAME)]
#[IsGranted('ROLE_OPERATOR')]
#[MethodPermission(permission: PromotionCode::class . '::renderShortLinkTempAction', title: '生成永久短链')]
class GenerateWechatMiniProgramPermanentShortLink extends ApiCallActionProcedure
{
    public const NAME = 'GenerateWechatMiniProgramPermanentShortLink';

    public function __construct(
        private readonly PromotionCodeRepository $codeRepository,
        private readonly Client $client,
        private readonly EntityManagerInterface $entityManager,
    ) {
    }

    public function getAction(): ApiCallAction
    {
        return ApiCallAction::gen()
            ->setLabel('生成永久短链')
            ->setConfirmText('每个小程序只能生成10万次，确认要生成？')
            ->setApiName(GenerateWechatMiniProgramPermanentShortLink::NAME);
    }

    public function execute(): array
    {
        $that = $this->codeRepository->findOneBy(['id' => $this->id]);
        if (!$that) {
            throw new ApiException('找不到记录');
        }

        $request = new ShortLinkRequest();
        $request->setAccount($that->getAccount());
        $request->setPageUrl($that->getLinkUrl());
        $request->setPermanent(true);

        try {
            $response = $this->client->request($request);
        } catch (\Throwable $exception) {
            throw match ($exception->getCode()) {
                40066 => new ApiException('url不存在，或去掉路径前的/'),
                85400 => new ApiException('达到生成上限10万，不可再生成'),
                default => new ApiException($exception->getMessage()),
            };
        }

        $that->setShortLinkPermanent($response['link']);
        $this->entityManager->persist($that);
        $this->entityManager->flush();

        return [
            '__message' => '生成成功',
        ];
    }
}
