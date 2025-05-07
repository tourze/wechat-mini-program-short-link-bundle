<?php

namespace WechatMiniProgramShortLinkBundle\Procedure;

use AntdCpBundle\Builder\Action\ApiCallAction;
use AppBundle\Procedure\Base\ApiCallActionProcedure;
use Carbon\Carbon;
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
#[MethodExpose(GenerateWechatMiniProgramTempShortLink::NAME)]
#[IsGranted('ROLE_OPERATOR')]
#[MethodPermission(permission: PromotionCode::class . '::renderShortLinkTempAction', title: '生成临时短链')]
class GenerateWechatMiniProgramTempShortLink extends ApiCallActionProcedure
{
    public const NAME = 'GenerateWechatMiniProgramTempShortLink';

    public function __construct(
        private readonly PromotionCodeRepository $codeRepository,
        private readonly Client $client,
        private readonly EntityManagerInterface $entityManager,
    ) {
    }

    public function getAction(): ApiCallAction
    {
        return ApiCallAction::gen()
            ->setLabel('生成临时短链')
            ->setConfirmText('重新生成后会覆盖已生成链接，确认要生成？')
            ->setApiName(GenerateWechatMiniProgramTempShortLink::NAME);
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

        try {
            $response = $this->client->request($request);
        } catch (\Throwable $exception) {
            throw match ($exception->getCode()) {
                40066 => new ApiException('url不存在，或去掉路径前的/'),
                45009 => new ApiException('单天生成数量超过上限100万'),
                default => new ApiException($exception->getMessage()),
            };
        }

        $that->setShortLinkTemp($response['link']);
        $that->setShortLinkTempCreateTime(Carbon::now());
        $this->entityManager->persist($that);
        $this->entityManager->flush();

        return [
            '__message' => '生成成功',
        ];
    }
}
