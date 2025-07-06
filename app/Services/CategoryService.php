<?php

namespace App\Services;

use Illuminate\Support\Collection;

class CategoryService
{
    /**
     * Get all descendant category IDs for a given parent category
     */
    public function getDescendantsIds(Collection $categories, $parentId): array
    {
        $descendants = [];
        $children = $categories->where('parent_id', $parentId);

        foreach ($children as $child) {
            $descendants[] = $child->id;
            // Recursively get descendants of this child
            $descendants = array_merge($descendants, $this->getDescendantsIds($categories, $child->id));
        }

        return $descendants;
    }

    /**
     * Get a flattened list of all categories in a tree structure
     */
    public function flattenCategories(Collection $categories): Collection
    {
        $flattened = collect();

        foreach ($categories as $category) {
            $flattened->push($category);
            if ($category->children && $category->children->count() > 0) {
                $flattened = $flattened->merge($this->flattenCategories($category->children));
            }
        }

        return $flattened;
    }

    /**
     * Get all parent category IDs for a given category
     */
    public function getParentIds(Collection $categories, $categoryId): array
    {
        $parents = [];
        $category = $categories->firstWhere('id', $categoryId);

        if ($category && $category->parent_id) {
            $parents[] = $category->parent_id;
            $parents = array_merge($parents, $this->getParentIds($categories, $category->parent_id));
        }

        return $parents;
    }
}
