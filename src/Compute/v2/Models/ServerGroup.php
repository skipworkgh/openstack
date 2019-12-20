<?php

declare(strict_types=1);

namespace OpenStack\Compute\v2\Models;

use OpenStack\Common\Resource\HasWaiterTrait;
use OpenStack\Common\Resource\Creatable;
use OpenStack\Common\Resource\Deletable;
use OpenStack\Common\Resource\Listable;
use OpenStack\Common\Resource\Retrievable;
use OpenStack\Common\Resource\OperatorResource;
use OpenStack\Common\Transport\Utils;
use Psr\Http\Message\ResponseInterface;

/**
 * @property \OpenStack\Compute\v2\Api $api
 */
class ServerGroup extends OperatorResource implements Creatable, Deletable, Retrievable, Listable
{
    use HasWaiterTrait;

    /** @var string */
    public $id;

    /** @var array */
    public $members;

    /** @var array */
    public $metadata;

    /** @var string */
    public $name;

    /** @var array Until version 2.63 */
    public $policies;

    /** @var string Version 2.64 onwards */
    public $policy;

    protected $resourceKey  = 'server_group';
    protected $resourcesKey = 'server_groups';

    protected $aliases = [];

    /**
     * {@inheritdoc}
     *
     * @param array $userOptions {@see \OpenStack\Compute\v2\Api::postServer}
     */
    public function create(array $userOptions): Creatable
    {
        if (!isset($userOptions["policy"]) && !isset($userOptions["policies"])) {
            throw new \RuntimeException('A policy must be set');
        }

        $response = $this->execute($this->api->postServerGroup(), $userOptions);

        return $this->populateFromResponse($response);
    }

    /**
     * {@inheritdoc}
     */
    public function delete()
    {
        $this->execute($this->api->deleteServerGroup(), $this->getAttrs(['id']));
    }

    /**
     * {@inheritdoc}
     */
    public function retrieve()
    {
        $response = $this->execute($this->api->getServerGroup(), $this->getAttrs(['id']));
        $this->populateFromResponse($response);
    }

    /**
     * Retrieves metadata from the API.
     *
     * @return array
     */
    public function getMetadata(): array
    {
        $response = $this->execute($this->api->getServerMetadata(), ['id' => $this->id]);

        return $this->parseMetadata($response);
    }

    /**
     * Resets all the metadata for this server with the values provided. All existing metadata keys
     * will either be replaced or removed.
     *
     * @param array $metadata {@see \OpenStack\Compute\v2\Api::putServerMetadata}
     */
    public function resetMetadata(array $metadata)
    {
        $response       = $this->execute($this->api->putServerMetadata(), ['id' => $this->id, 'metadata' => $metadata]);
        $this->metadata = $this->parseMetadata($response);
    }

    /**
     * Merges the existing metadata for the server with the values provided. Any existing keys
     * referenced in the user options will be replaced with the user's new values. All other
     * existing keys will remain unaffected.
     *
     * @param array $metadata {@see \OpenStack\Compute\v2\Api::postServerMetadata}
     *
     * @return array
     */
    public function mergeMetadata(array $metadata)
    {
        $response       = $this->execute($this->api->postServerMetadata(), ['id' => $this->id, 'metadata' => $metadata]);
        $this->metadata = $this->parseMetadata($response);
    }

    /**
     * Retrieve the value for a specific metadata key.
     *
     * @param string $key {@see \OpenStack\Compute\v2\Api::getServerMetadataKey}
     *
     * @return mixed
     */
    public function getMetadataItem(string $key)
    {
        $response             = $this->execute($this->api->getServerMetadataKey(), ['id' => $this->id, 'key' => $key]);
        $value                = $this->parseMetadata($response)[$key];
        $this->metadata[$key] = $value;

        return $value;
    }

    /**
     * Remove a specific metadata key.
     *
     * @param string $key {@see \OpenStack\Compute\v2\Api::deleteServerMetadataKey}
     */
    public function deleteMetadataItem(string $key)
    {
        if (isset($this->metadata[$key])) {
            unset($this->metadata[$key]);
        }

        $this->execute($this->api->deleteServerMetadataKey(), ['id' => $this->id, 'key' => $key]);
    }

    public function parseMetadata(ResponseInterface $response): array
    {
        return Utils::jsonDecode($response)['metadata'];
    }
}
