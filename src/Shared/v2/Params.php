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
    public function shareIdPath(): array
    {
        return [
            'type' => self::STRING_TYPE,
            'location' => self::URL,
            'description' => 'The UUID of the share resource',
        ];
    }
    /**
     * @return array
     */
    public function shareId(): array
    {
        return [
            'type' => self::STRING_TYPE,
            'location' => self::JSON,
            'description' => 'The UUID of the share resource',
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
    /**
     * @return array
     */
    public function accessLevel(): array
    {
        return [
            'type' => self::STRING_TYPE,
            'location' => self::JSON,
            'sentAs' => 'access_level',
            'description' => 'The access level to the share. To grant or deny access to a share, you specify one of the following share access levels: - rw. Read and write (RW) access. - ro. Read- only (RO) access.',
        ];
    }
    /**
     * @return array
     */
    public function accessType(): array
    {
        return [
            'type' => self::STRING_TYPE,
            'location' => self::JSON,
            'sentAs' => 'access_type',
            'description' => 'The access rule type. A valid value for the share access rule type is one of the following values: - ip. Authenticates an instance through its IP address. A valid format is XX.XX.XX.XX or XX.XX.XX.XX/XX. For example 0.0.0.0/0. - cert. Authenticates an instance through a TLS certificate. Specify the TLS identity as the IDENTKEY. A valid value is any string up to 64 characters long in the common name (CN) of the certificate. The meaning of a string depends on its interpretation. - user. Authenticates by a user or group name. A valid value is an alphanumeric string that can contain some special characters and is from 4 to 32 characters long.',
        ];
    }
    /**
     * @return array
     */
    public function accessTo(): array
    {
        return [
            'type' => self::STRING_TYPE,
            'location' => self::JSON,
            'sentAs' => 'access_to',
            'description' => 'The value that defines the access. The back end grants or denies the access to it. A valid value is one of these values: - ip. Authenticates an instance through its IP address. A valid format is XX.XX.XX.XX or XX.XX.XX.XX/XX. For example 0.0.0.0/0. - cert. Authenticates an instance through a TLS certificate. Specify the TLS identity as the IDENTKEY. A valid value is any string up to 64 characters long in the common name (CN) of the certificate. The meaning of a string depends on its interpretation. - user. Authenticates by a user or group name. A valid value is an alphanumeric string that can contain some special characters and is from 4 to 32 characters long.',
        ];
    }
}
