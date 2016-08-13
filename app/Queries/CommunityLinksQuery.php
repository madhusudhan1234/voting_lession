<?php

namespace App\Queries;

use App\CommunityLink;

class CommunityLinksQuery
{
	public function get($channel,$sortByPopular)
	{
		$orderBy = $sortByPopular ? 'votes_count' : 'updated_at';

		return CommunityLink::with('creator','channel')
			->withCount('votes')
            ->forChannel($channel)
            ->orderBy($orderBy,'desc')
            ->where('approved', '1')
            ->paginate(3);
	}
}