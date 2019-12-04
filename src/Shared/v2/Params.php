<?php
declare(strict_types = 1);

namespace OpenStack\Shared\v2;

use OpenStack\Common\Api\AbstractParams;

/**
 * Class Params
 *
 * @package OpenStack\Shared\v2
 */
class Params extends AbstractParams
{
    /**
     * @return array
     */
    public function availabilityZone(): array
    {
        return [
            'type' => self::STRING_TYPE,
            'location' => self::JSON,
            'sentAs' => 'availability_zone',
            'description' => 'The availability zone where the entity will reside.',
        ];
    }
    /**
     * @return array
     */
    public function desc(): array
    {
        return [
            'type' => self::STRING_TYPE,
            'location' => self::JSON,
            'description' => 'A human-friendly description that describes the resource',
        ];
    }
    /**
     * @return array
     */
    public function snapshotId(): array
    {
        return [
            'type' => self::STRING_TYPE,
            'location' => self::JSON,
            'sentAs' => 'snapshot_id',
            'description' => 'To create a share from an existing snapshot, specify the ID of the existing share ' . 'snapshot. The share is created in same availability zone and with same size as the snapshot.',
        ];
    }
    /**
     * @return array
     */
    public function size(): array
    {
        return [
            'type' => self::INT_TYPE,
            'location' => self::JSON,
            'required' => true,
            'description' => 'The size of the share, in gibibytes (GiB).',
        ];
    }
    /**
     * @return array
     */
    public function shareType(): array
    {
        return [
            'type' => self::STRING_TYPE,
            'location' => self::JSON,
            'sentAs' => 'share_type',
            'description' => 'The associated share type.',
        ];
    }
    /**
     * @return array
     */
    public function shareNetworkId(): array
    {
        return [
            'type' => self::STRING_TYPE,
            'location' => self::JSON,
            'sentAs' => 'share_network_id',
            'description' => 'The associated share network id.',
        ];
    }
    /**
     * @return array
     */
    public function shareProto(): array
    {
        return [
            'type' => self::STRING_TYPE,
            'location' => self::JSON,
            'sentAs' => 'share_proto',
            'description' => 'The Shared File Systems protocol. A valid value is NFS, CIFS, GlusterFS, HDFS, CephFS, MAPRFS, CephFS supported is starting with API v2.13.',
        ];
    }

    /**
     * @return array
     */
    public function metadata(): array
    {
        return [
            'type' => self::OBJECT_TYPE,
            'location' => self::JSON,
            'description' => 'One or more metadata key and value pairs to associate with the share.',
            'properties' => [
                'type' => self::STRING_TYPE,
                'description' => <<<TYPEOTHER
The value being set for your key. Bear in mind that "key" is just an example, you can name it anything.
TYPEOTHER
    ,
            ],
        ];
    }
    /**
     * @return array
     */
    public function sort(): array
    {
        return [
            'type' => self::STRING_TYPE,
            'location' => self::QUERY,
            'description' => 'Comma-separated list of sort keys and optional sort directions in the form of ' . '<key>[:<direction>]. A valid direction is asc (ascending) or desc (descending).',
        ];
    }
    /**
     * @param string $resource
     * @return array
     */
    public function name(string $resource): array
    {
        return parent::name($resource) + [
                'type' => self::STRING_TYPE,
                'location' => self::JSON,
            ];
    }
    /**
     * @return array
     */
    public function idPath(): array
    {
        return [
            'type' => self::STRING_TYPE,
            'location' => self::URL,
            'description' => 'The UUID of the resource',
            'documented' => false,
        ];
    }
    /**
     * @return array
     */
    public function projectId(): array
    {
        return [
            'type' => self::STRING_TYPE,
            'location' => self::URL,
            'sentAs' => 'project_id',
            'description' => 'The UUID of the project in a multi-tenancy cloud.',
        ];
    }
    /**
     * @return array
     */
    public function public(): array
    {
        return [
            'type'        => self::BOOL_TYPE,
            'location'    => self::JSON,
            'sentAs'      => 'is_public',
            'description' => 'Enables or disables the public attribute. You can make a share publicly available.',
        ];
    }
}
