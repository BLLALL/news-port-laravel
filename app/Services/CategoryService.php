<?php

namespace App\Services;

use Illuminate\Support\Collection;

class CategoryService
{
    public function getDescendantsIds(Collection $categories, $parentId): array
    {
        $descendants = [];
        $children = $categories->where('parent_id', $parentId);
        foreach ($children as $child) {
            $descendants[] = $child->id;
            $descendants = array_merge($descendants, $this->getDescendantsIds($categories, $child->id));
        }

        return $descendants;
    }
}
