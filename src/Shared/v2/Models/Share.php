<?php

declare(strict_types=1);

namespace OpenStack\Shared\v2\Models;

use DateTimeImmutable;
use OpenStack\Common\Resource\Alias;
use OpenStack\Common\Resource\OperatorResource;
use OpenStack\Common\Resource\Creatable;
use OpenStack\Common\Resource\Deletable;
use OpenStack\Common\Resource\HasMetadata;
use OpenStack\Common\Resource\HasWaiterTrait;
use OpenStack\Common\Resource\Listable;
use OpenStack\Common\Resource\Retrievable;
use OpenStack\Common\Resource\Updateable;
use OpenStack\Common\Transport\Utils;
use Psr\Http\Message\ResponseInterface;

/**
 * @url https://docs.openstack.org/api-ref/shared-file-system/?expanded=list-all-major-versions-detail#shares
 *
 * @property \OpenStack\Shared\v2\Api $api
 */
class Share extends OperatorResource implements Creatable, Listable, Updateable, Deletable, Retrievable, HasMetadata
{
    use HasWaiterTrait;

    /** @var string */
    public $availabilityZone;

    /** @var \DateTimeImmutable */
    public $createdAt;

    /** @var string */
    public $description;

    /** @var string */
    public $exportLocation;

    /** @var array */
    public $exportLocations;

    /** @var string */
    public $host;

    /** @var string */
    public $id;

    /** @var array */
    public $metadata = [];

    /** @var string */
    public $name;

    /** @var bool */
    public $public;

    /** @var null|string */
    public $shareNetworkId;

    /** @var string */
    public $shareProto;

    /** @var string */
    public $shareServerId;

    /** @var string */
    public $shareType;

    /** @var int */
    public $size;

    /** @var string */
    public $snapshotId;

    /** @var string */
    public $status;

    /** @var string */
    public $volumeType;

    /** @var string */
    protected $resourceKey  = 'share';

    /** @var string */
    protected $resourcesKey = 'shares';

    /** @var string */
    protected $markerKey    = 'id';

    /**
     * @var array
     */
    protected $aliases = [
        'availability_zone' => 'availabilityZone',
        'export_location' => 'exportLocation',
        'export_locations' => 'exportLocations',
        'is_public' => 'public',
        'share_network_id' => 'shareNetworkId',
        'share_proto' => 'shareProto',
        'share_server_id' => 'shareServerId',
        'share_type' => 'shareType',
        'snapshot_id' => 'snapshotId',
        'volume_type' => 'volumeType',
    ];

    /**
     * {@inheritdoc}
     */
    protected function getAliases(): array
    {
        return parent::getAliases() + [
                'created_at' => new Alias('createdAt', DateTimeImmutable::class),
            ];
    }
    /**
     * @param \Psr\Http\Message\ResponseInterface $response
     * @return $this
     */
    public function populateFromResponse(ResponseInterface $response): self
    {
        parent::populateFromResponse($response);
        $this->metadata = $this->parseMetadata($response);

        return $this;
    }
    /**
     * @return void
     */
    public function retrieve(): void
    {
        $response = $this->executeWithState($this->api->getShare());
        $this->populateFromResponse($response);
    }

    /**
     * @param array $userOptions {@see \OpenStack\BlockStorage\v3\Api::postVolumes}
     * @return Creatable
     */
    public function create(array $userOptions): Creatable
    {
        $response = $this->execute($this->api->postShares(), $userOptions);

        return $this->populateFromResponse($response);
    }

    public function update()
    {
        $response = $this->executeWithState($this->api->putShare());
        $this->populateFromResponse($response);
    }

    public function delete()
    {
        $this->executeWithState($this->api->deleteShare());
    }
    /**
     * @return array
     */
    public function getMetadata(): array
    {
        $response       = $this->executeWithState($this->api->getShareMetadata());
        $this->metadata = $this->parseMetadata($response);

        return $this->metadata;
    }
    /**
     * @param array $metadata
     */
    public function mergeMetadata(array $metadata)
    {
        $this->getMetadata();
        $this->metadata = array_merge($this->metadata, $metadata);
        $this->executeWithState($this->api->putShareMetadata());
    }
    /**
     * @param array $metadata
     */
    public function resetMetadata(array $metadata)
    {
        $this->metadata = $metadata;
        $this->executeWithState($this->api->putShareMetadata());
    }
    /**
     * @param \Psr\Http\Message\ResponseInterface $response
     * @return array
     */
    public function parseMetadata(ResponseInterface $response): array
    {
        $json = Utils::jsonDecode($response);

        return isset($json['metadata']) ? $json['metadata'] : [];
    }
    /**
     * @param array $userOptions
     * @return \OpenStack\Common\Resource\ResourceInterface
     */
    public function grantAccess(array $userOptions): AccessRule
    {
        $userOptions = array_merge($userOptions, ['id' => $this->id]);
        $response = $this->execute($this->api->postShareGrantaccess(), $userOptions);

        return $this->model(AccessRule::class)->populateFromResponse($response);
    }
    /**
     * @return mixed
     */
    public function getAccessRules()
    {
        return $this->model(AccessRule::class)->enumerate($this->api->getShareAccessRules(), ['id' => $this->id]);
    }
}
