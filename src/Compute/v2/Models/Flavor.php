<?php

declare(strict_types=1);

namespace OpenStack\Compute\v2\Models;

use OpenStack\Common\Resource\Creatable;
use OpenStack\Common\Resource\Deletable;
use OpenStack\Common\Resource\Listable;
use OpenStack\Common\Resource\OperatorResource;
use OpenStack\Common\Resource\Retrievable;

/**
 * Represents a Compute v2 Flavor.
 *
 * @property \OpenStack\Compute\v2\Api $api
 */
class Flavor extends OperatorResource implements Listable, Retrievable, Creatable, Deletable
{
    /** @var int */
    public $disk;

    /** @var string */
    public $id;

    /** @var string */
    public $name;

    /** @var int */
    public $ram;

    /** @var int */
    public $swap;

    /** @var int */
    public $vcpus;

    /** @var array */
    public $links;
    /**
     * @var bool
     */
    public $is_public;

    protected $resourceKey  = 'flavor';
    protected $resourcesKey = 'flavors';

    protected $aliases = [
        'os-flavor-access:is_public' => 'is_public',
    ];

    /**
     * {@inheritdoc}
     */
    public function retrieve()
    {
        $response = $this->execute($this->api->getFlavor(), ['id' => (string) $this->id]);
        $this->populateFromResponse($response);
    }

    /**
     * {@inheritdoc}
     */
    public function create(array $userOptions): Creatable
    {
        $response = $this->execute($this->api->postFlavors(), $userOptions);

        return $this->populateFromResponse($response);
    }

    /**
     * {@inheritdoc}
     */
    public function delete()
    {
        $this->execute($this->api->deleteFlavor(), ['id' => (string) $this->id]);
    }

    /**
     * Creates an access rule to allow the usage of the current flavor in the given project uuid.
     *
     * @see https://docs.openstack.org/api-ref/compute/?expanded=add-flavor-access-to-tenant-addtenantaccess-action-detail#add-flavor-access-to-tenant-addtenantaccess-action
     * @param string $project_uuid
     */
    public function addAccessToProject(string $project_uuid)
    {
        $userValues = array_merge($this->getAttrs(['id']), ['tenant' => $project_uuid]);
        $this->execute($this->api->addFlavorAccessToTenant(), $userValues);
    }

    /**
     * Removes access to the current flavor from the given project uuid.
     *
     * @see https://docs.openstack.org/api-ref/compute/?expanded=remove-flavor-access-from-tenant-removetenantaccess-action-detail#remove-flavor-access-from-tenant-removetenantaccess-action
     * @param string $project_uuid
     */
    public function removeAccessFromProject(string $project_uuid)
    {
        $userValues = array_merge($this->getAttrs(['id']), ['tenant' => $project_uuid]);
        $this->execute($this->api->removeFlavorAccessFromTenant(), $userValues);
    }
}
