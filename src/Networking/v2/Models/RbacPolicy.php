<?php

declare(strict_types=1);

namespace OpenStack\Networking\v2\Models;

use OpenStack\Common\Resource\Creatable;
use OpenStack\Common\Resource\Deletable;
use OpenStack\Common\Resource\Listable;
use OpenStack\Common\Resource\OperatorResource;
use OpenStack\Common\Resource\Retrievable;
use OpenStack\Common\Resource\Updateable;

/**
 * Represents a RBAC Policy.
 *
 * @property \OpenStack\Networking\v2\Api $api
 */
class RbacPolicy extends OperatorResource implements Listable, Retrievable, Creatable, Deletable, Updateable
{
    /** @var string */
    public $id;

    /** @var string */
    public $action;

    /** @var string */
    public $targetTenant;

    /** @var string */
    public $tenantId;

    /** @var string */
    public $objectType;

    /** @var string */
    public $objectId;

    /** @var string */
    public $projectId;

    protected $aliases = [
        'tenant_id'        => 'tenantId',
        'target_tenant'    => 'targetTenant',
        'object_type'      => 'objectType',
        'object_id'        => 'objectId',
        'project_id'       => 'projectId',
    ];

    protected $resourceKey  = 'rbac_policy';
    protected $resourcesKey = 'rbac_policies';

    /**
     * {@inheritdoc}
     */
    public function retrieve()
    {
        $response = $this->execute($this->api->getRbacPolicy(), ['id' => (string) $this->id]);
        $this->populateFromResponse($response);
    }

    /**
     * {@inheritdoc}
     *
     * @param array $data {@see \OpenStack\Networking\v2\Api::postRbacPolicy}
     */
    public function create(array $data): Creatable
    {
        $response = $this->execute($this->api->postRbacPolicy(), $data);

        return $this->populateFromResponse($response);
    }

    /**
     * {@inheritdoc}
     */
    public function update()
    {
        $response = $this->executeWithState($this->api->putRbacPolicy());
        $this->populateFromResponse($response);
    }

    /**
     * {@inheritdoc}
     */
    public function delete()
    {
        $this->executeWithState($this->api->deleteRbacPolicy());
    }
}
