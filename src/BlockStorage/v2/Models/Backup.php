<?php

declare(strict_types=1);

namespace OpenStack\BlockStorage\v2\Models;

use OpenStack\Common\Resource\Alias;
use OpenStack\Common\Resource\OperatorResource;
use OpenStack\Common\Resource\Creatable;
use OpenStack\Common\Resource\Deletable;
use OpenStack\Common\Resource\HasWaiterTrait;
use OpenStack\Common\Resource\Listable;
use OpenStack\Common\Resource\Retrievable;
use Psr\Http\Message\ResponseInterface;

/**
 * @property \OpenStack\BlockStorage\v2\Api $api
 */
class Backup extends OperatorResource implements Listable, Creatable, Deletable, Retrievable
{
    use HasWaiterTrait;

    /** @var string */
    public $id;

    /** @var string */
    public $name;

    /** @var string */
    public $status;

    /** @var string */
    public $description;

    /** @var \DateTimeImmutable */
    public $createdAt;

    /** @var string */
    public $volumeId;

    /** @var int */
    public $size;

    /** @var string */
    public $projectId;

    protected $resourceKey  = 'backup';
    protected $resourcesKey = 'backups';
    protected $markerKey    = 'id';

    protected $aliases = [
        'volume_id'                                  => 'volumeId',
        'os-extended-snapshot-attributes:project_id' => 'projectId',
    ];

    /**
     * {@inheritdoc}
     */
    protected function getAliases(): array
    {
        return parent::getAliases() + [
            'created_at' => new Alias('createdAt', \DateTimeImmutable::class),
        ];
    }

    public function populateFromResponse(ResponseInterface $response): self
    {
        parent::populateFromResponse($response);

        return $this;
    }

    public function retrieve()
    {
        $response = $this->executeWithState($this->api->getBackup());
        $this->populateFromResponse($response);
    }

    /**
     * @param array $userOptions {@see \OpenStack\BlockStorage\v2\Api::postSnapshots}
     *
     * @return Creatable
     */
    public function create(array $userOptions): Creatable
    {
        $response = $this->execute($this->api->postBackups(), $userOptions);

        return $this->populateFromResponse($response);
    }

    public function delete()
    {
        $this->executeWithState($this->api->deleteBackup());
    }
}
