<?php
namespace App\Http\Transformers;
use App\Community;

class CommunityTransformer {

    public function transform(Community $community) {
        return [
            'name' => $community->name,
            'about' => $community->about,
            'created_at' => $community->created_at,
            'updated_at' => $community->created_at,
            'location' =>
                [
                  'name' => $community->location,
                  'latitude' => $community->latitude,
                  'longitude' => $community->longitude,
                ],
            'members' => $community->members->count(),
        ];
    }

}
