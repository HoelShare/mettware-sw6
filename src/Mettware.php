<?php

declare(strict_types=1);

namespace Mettware;

use Shopware\Core\Framework\Context;
use Shopware\Core\Framework\DataAbstractionLayer\EntityRepositoryInterface;
use Shopware\Core\Framework\Plugin;
use Shopware\Core\Framework\Plugin\Context\InstallContext;
use Shopware\Core\Framework\Plugin\Context\UpdateContext;
use Shopware\Core\System\CustomField\CustomFieldTypes;

class Mettware extends Plugin
{
    private const ID_FIELD_SET = '3b9d41230614453faddadbc65806a216';
    private const ID_FIELD_MEAT_CONTENT = '90a6aa8807d7462395666c3ec04f89e3';
    private const ID_SET_RELATION = 'db0511f7852a4d44812a2c6568accb62';

    public function postUpdate(UpdateContext $updateContext): void
    {
        parent::postUpdate($updateContext);
        $fieldSetRepository = $updateContext->getPlugin()->container->get('custom_field_set.repository');
        $this->upsertCustomFields($fieldSetRepository, $updateContext->getContext());
    }

    public function postInstall(InstallContext $installContext): void
    {
        parent::postInstall($installContext);
        $fieldSetRepository = $installContext->getPlugin()->container->get('custom_field_set.repository');
        $this->upsertCustomFields($fieldSetRepository, $installContext->getContext());
    }

    private function upsertCustomFields(
        EntityRepositoryInterface $fieldSetRepository,
        Context $context
    ): void {
        $fieldSetRepository->upsert(
            [
                [
                    'id' => self::ID_FIELD_SET,
                    'name' => 'metttware',
                    'config' => [
                        'label' => [
                            'en-GB' => 'Mettware',
                            'de-DE' => 'Mettware'
                        ]
                    ],
                    'relations' => [
                        ['id' => self::ID_SET_RELATION, 'setId' => self::ID_FIELD_SET, 'entityName' => 'product'],
                    ],
                    'customFields' => [
                        [
                            'id' => self::ID_FIELD_MEAT_CONTENT,
                            'name' => 'custom_mettware_meat_content',
                            'type' => CustomFieldTypes::FLOAT,
                            'config' => [
                                'label' => [
                                    'en-GB' => 'Meat Content',
                                    'de-DE' => 'Fleischgehalt'
                                ],
                                'customFieldPosition' => 1
                            ],
                        ],
                    ],
                ],
            ],
            $context
        );
    }
}
