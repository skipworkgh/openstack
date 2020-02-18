<?php

declare(strict_types=1);

namespace OpenStack\Shared\v2\Models;

use OpenStack\Common\Resource\HasWaiterTrait;
use OpenStack\Common\Resource\OperatorResource;

/**
 * Class AccessRule
 *
 * @package OpenStack\Shared\v2\Models
 */
class AccessRule extends OperatorResource
{
    use HasWaiterTrait;

    /** @var string $id */
    public $id;

    /** @var string|null $share_id */
    public $share_id;

    /** @var string $access_level */
    public $access_level;

    /** @var string $access_to */
    public $access_to;

    /** @var string $access_type */
    public $access_type;

    /** @var string $status */
    public $status;

    /** @var string $access_key */
    public $access_key;


    /** @var string */
    protected $resourceKey  = 'access';
    protected $resourcesKey = 'access_list';

    protected $aliases = [
        'state' => 'status',
    ];

    /**
     * {@inheritdoc}
     */
    public function retrieve()
    {
        $response = $this->executeWithState($this->api->getShareAccessRule());
        $this->populateFromResponse($response);
    }
}