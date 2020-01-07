<?php

declare(strict_types=1);

namespace OpenStack\Shared\v2;

use OpenStack\Common\Api\AbstractApi;

/**
 * Class Api
 *
 * @package OpenStack\Shared\v2
 */
class Api extends AbstractApi
{
    /**
     * Api constructor.
     */
    public function __construct()
    {
        $this->params = new Params();
    }
    /**
     * @return array
     */
    public function deleteShare(): array
    {
        return [
            'method' => 'DELETE',
            'path'   => 'shares/{id}',
            'params' => ['id' => $this->params->idPath()],
        ];
    }
    /**
     * @return array
     */
    public function getShares(): array
    {
        return [
            'method' => 'GET',
            'path'   => 'shares',
            'params' => [
                'limit'      => $this->params->limit(),
                'marker'     => $this->params->marker(),
                'sort'       => $this->params->sort(),
                'allTenants' => $this->params->allTenants(),
            ],
        ];
    }
    /**
     * @return array
     */
    public function getSharesDetail(): array
    {
        return [
            'method' => 'GET',
            'path'   => 'shares/detail',
            'params' => [
                'limit'      => $this->params->limit(),
                'marker'     => $this->params->marker(),
                'sort'       => $this->params->sort(),
                'allTenants' => $this->params->allTenants(),
            ],
        ];
    }
    /**
     * @return array
     */
    public function getShare(): array
    {
        return [
            'method' => 'GET',
            'path'   => 'shares/{id}',
            'params' => [
                'id' => $this->params->idPath(),
            ],
        ];
    }
    /**
     * @return array
     */
    public function getShareMetadata(): array
    {
        return [
            'method' => 'GET',
            'path'   => 'shares/{id}/metadata',
            'params' => ['id' => $this->params->idPath()],
        ];
    }
    /**
     * @return array
     */
    public function getVersion(): array
    {
        return [
            'method' => 'GET',
            'path'   => '',
            'params' => [],
        ];
    }
    /**
     * @return array
     */
    public function postShares(): array
    {
        return [
            'method'  => 'POST',
            'path'    => 'shares',
            'jsonKey' => 'share',
            'params'  => [
                'availabilityZone' => $this->params->availabilityZone(),
                'description'      => $this->params->desc(),
                'snapshotId'       => $this->params->snapshotId(),
                'size'             => $this->params->size(),
                'name'             => $this->params->name('share'),
                'metadata'         => $this->params->metadata(),
                'projectId'        => $this->params->projectId(),
                'shareType'        => $this->params->shareType(),
                'shareNetworkId'   => $this->params->shareNetworkId(),
                'shareProto'       => $this->params->shareProto(),
                'public'           => $this->params->public(),
            ],
        ];
    }
    /**
     * @return array
     */
    public function putShare(): array
    {
        return [
            'method'  => 'PUT',
            'path'    => 'shares/{id}',
            'jsonKey' => 'share',
            'params'  => [
                'id'          => $this->params->idPath(),
                'name'        => $this->params->name('share'),
                'description' => $this->params->desc(),
            ],
        ];
    }
    /**
     * @return array
     */
    public function putShareMetadata(): array
    {
        return [
            'method' => 'PUT',
            'path'   => 'shares/{id}/metadata',
            'params' => [
                'id'       => $this->params->idPath(),
                'metadata' => $this->params->metadata(),
            ],
        ];
    }
    /**
     * @return array
     */
    public function postShareGrantaccess(): array
    {
        return [
            'method'  => 'POST',
            'path'    => 'shares/{id}/action',
            'jsonKey' => 'allow_access',
            'params'  => [
                'id'          => $this->params->idPath(),
                'accessLevel' => $this->params->accessLevel(),
                'accessType'  => $this->params->accessType(),
                'accessTo'    => $this->params->accessTo(),
            ],
        ];
    }
}
