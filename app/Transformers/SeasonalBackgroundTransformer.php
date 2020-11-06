<?php

// Copyright (c) ppy Pty Ltd <contact@ppy.sh>. Licensed under the GNU Affero General Public License v3.0.
// See the LICENCE file in the repository root for full licence text.

namespace App\Transformers;

use App\Models\UserContestEntry;

class SeasonalBackgroundTransformer extends TransformerAbstract
{
    protected $availableIncludes = [
        'user',
    ];

    protected $defaultIncludes = [
        'user',
    ];

    /**
     * At least the url generation "logic" probably should be part of a decorator.
     * Please look into doing that before extending this further.
     */
    public function transform(UserContestEntry $entry)
    {
        return [
            // files generated by process separate from osu-web
            'url' => $entry->storage()->url("{$entry->fileDir()}/{$entry->hash}_opt.jpg"),
        ];
    }

    public function includeUser(UserContestEntry $entry)
    {
        return $this->item($entry->user, new UserCompactTransformer());
    }
}
