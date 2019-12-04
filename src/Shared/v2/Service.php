<?php

declare(strict_types=1);

namespace OpenStack\Shared\v2;

use OpenStack\BlockStorage\v3\Models\Backup;
use OpenStack\BlockStorage\v3\Models\QuotaSet;
use OpenStack\BlockStorage\v3\Models\Snapshot;
use OpenStack\BlockStorage\v3\Models\Volume;
use OpenStack\BlockStorage\v3\Models\VolumeType;
use OpenStack\Common\Service\AbstractService;
use OpenStack\Shared\v2\Models\Share;

/**
 * @property \OpenStack\Shared\v2\Api $api
 */
class Service extends AbstractService
{
    /**
     * @param bool $detail
     * @param array $userOptions
     * @return \Generator
     */
    public function listShares(bool $detail = false, array $userOptions = []): \Generator
    {
        $def = $detail === true ? $this->api->getSharesDetail() : $this->api->getShares();

        return $this->model(Share::class)->enumerate($def, $userOptions);
    }
    /**
     * @param string $shareId
     * @return \OpenStack\Shared\v2\Models\Share
     */
    public function getShare(string $shareId): Share
    {
        $share = $this->model(Share::class);
        $share->populateFromArray(["id" => $shareId]);
        return $share;
    }
}
