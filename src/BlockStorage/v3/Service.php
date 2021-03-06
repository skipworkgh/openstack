<?php

declare(strict_types=1);

namespace OpenStack\BlockStorage\v3;

use OpenStack\BlockStorage\v3\Models\Backup;
use OpenStack\BlockStorage\v3\Models\QuotaSet;
use OpenStack\BlockStorage\v3\Models\Snapshot;
use OpenStack\BlockStorage\v3\Models\Volume;
use OpenStack\BlockStorage\v3\Models\VolumeType;
use OpenStack\Common\Service\AbstractService;

/**
 * @property \OpenStack\BlockStorage\v3\Api $api
 */
class Service extends AbstractService
{
    /**
     * Provisions a new bootable volume, based either on an existing volume, image or snapshot.
     * You must have enough volume storage quota remaining to create a volume of size requested.
     *
     * @param array $userOptions {@see Api::postVolumes}
     *
     * @return Volume
     */
    public function createVolume(array $userOptions): Volume
    {
        return $this->model(Volume::class)->create($userOptions);
    }

    /**
     * Lists all available volumes.
     *
     * @param bool  $detail      if set to TRUE, more information will be returned
     * @param array $userOptions {@see Api::getVolumes}
     *
     * @return \Generator
     */
    public function listVolumes(bool $detail = false, array $userOptions = []): \Generator
    {
        $def = (true === $detail) ? $this->api->getVolumesDetail() : $this->api->getVolumes();

        return $this->model(Volume::class)->enumerate($def, $userOptions);
    }

    /**
     * @param string $volumeId the UUID of the volume being retrieved
     *
     * @return Volume
     */
    public function getVolume(string $volumeId): Volume
    {
        $volume = $this->model(Volume::class);
        $volume->populateFromArray(['id' => $volumeId]);

        return $volume;
    }

    /**
     * @param array $userOptions {@see Api::postTypes}
     *
     * @return VolumeType
     */
    public function createVolumeType(array $userOptions): VolumeType
    {
        return $this->model(VolumeType::class)->create($userOptions);
    }

    /**
     * @return \Generator
     */
    public function listVolumeTypes(): \Generator
    {
        return $this->model(VolumeType::class)->enumerate($this->api->getTypes(), []);
    }

    /**
     * @param string $typeId
     *
     * @return VolumeType
     */
    public function getVolumeType(string $typeId): VolumeType
    {
        $type = $this->model(VolumeType::class);
        $type->populateFromArray(['id' => $typeId]);

        return $type;
    }

    /**
     * @param array $userOptions {@see Api::postSnapshots}
     *
     * @return Snapshot
     */
    public function createSnapshot(array $userOptions): Snapshot
    {
        return $this->model(Snapshot::class)->create($userOptions);
    }

    /**
     * @return \Generator
     */
    public function listSnapshots(bool $detail = false, array $userOptions = []): \Generator
    {
        $def = (true === $detail) ? $this->api->getSnapshotsDetail() : $this->api->getSnapshots();

        return $this->model(Snapshot::class)->enumerate($def, $userOptions);
    }

    /**
     * @param string $snapshotId
     *
     * @return Snapshot
     */
    public function getSnapshot(string $snapshotId): Snapshot
    {
        $snapshot = $this->model(Snapshot::class);
        $snapshot->populateFromArray(['id' => $snapshotId]);

        return $snapshot;
    }

    /**
     * Shows A Quota for a tenant.
     *
     * @param string $tenantId
     *
     * @return QuotaSet
     */
    public function getQuotaSet(string $tenantId): QuotaSet
    {
        $quotaSet = $this->model(QuotaSet::class);
        $quotaSet->populateFromResponse($this->execute($this->api->getQuotaSet(), ['tenantId' => $tenantId]));

        return $quotaSet;
    }

    /**
     * @return \Generator
     */
    public function listBackups(bool $detail = false, array $userOptions = []): \Generator
    {
        $def = (true === $detail) ? $this->api->getBackupsDetail() : $this->api->getBackups();

        return $this->model(Backup::class)->enumerate($def, $userOptions);
    }

    /**
     * @param string $backupId
     *
     * @return Backup
     */
    public function getBackup(string $backupId): Backup
    {
        $backup = $this->model(Backup::class);
        $backup->populateFromArray(['id' => $backupId]);

        return $backup;
    }

    /**
     * @param array $userOptions {@see Api::postBackups}
     *
     * @return Backup
     */
    public function createBackup(array $userOptions): Backup
    {
        return $this->model(Backup::class)->create($userOptions);
    }
    /**
     * @param array $userOptions {@see Api::restoreBackup}
     * @return mixed
     */
    public function restoreBackup(array $userOptions)
    {
        return $this->model(Backup::class)->restore($userOptions);
    }
}
