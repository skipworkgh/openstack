<?php

declare(strict_types=1);

namespace OpenStack\Shared\v2\Models;

use RuntimeException;
use OpenStack\Common\Resource\Deletable;
use OpenStack\Common\Resource\HasWaiterTrait;
use OpenStack\Common\Resource\OperatorResource;

/**
 * Class AccessRule
 *
 * @package OpenStack\Shared\v2\Models
 */
class AccessRule extends OperatorResource implements Deletable
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
    public function delete()
    {
        // For some odd reason, the share_id is not passed along when fetching all access rules for a single share.
        // We need to make sure the local share_id has been set, or the call will fail.
        if (is_null($this->share_id)) {
            throw new RuntimeException('No share_id has been set for this access rule. Call the retrieve() method prior to the delete method!');
        }
        $this->execute($this->api->deleteShareAccessRule(), ['id' => $this->share_id, 'access_id' => $this->id]);
    }

    /**
     * {@inheritdoc}
     */
    public function retrieve()
    {
        $response = $this->executeWithState($this->api->getShareAccessRule());
        $this->populateFromResponse($response);
    }
}