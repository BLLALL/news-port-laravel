<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'color',
        'parent_id',
    ];

    protected $appends = ['articles_count'];

    public function parent()
    {
        return $this->belongsTo(Category::class, 'parent_id');
    }

    public function children()
    {
        return $this->hasMany(Category::class, 'parent_id');
    }

    public function articles()
    {
        return $this->belongsToMany(Article::class);
    }

    public function getArticlesCountAttribute()
    {
        return $this->articles()->count();
    }

    public function getFullPathAttribute()
    {
        $path = collect([$this]);
        $current = $this;

        while ($current->parent) {
            $current = $current->parent;
            $path->prepend($current);
        }

        return $path->pluck('name')->implode(' > ');
    }

    public function isRoot()
    {
        return is_null($this->parent_id);
    }

    public function isLeaf()
    {
        return $this->children()->count() === 0;
    }

    public function getRoot()
    {
        $current = $this;
        while ($current->parent) {
            $current = $current->parent;
        }

        return $current;
    }

    public function getSiblings()
    {
        return Category::where('parent_id', $this->parent_id)
            ->where('id', '!=', $this->id)
            ->get();
    }

    public static function buildTree($categories = null, $parentId = null)
    {
        if (! $categories) {
            $categories = static::all();
        }

        $branch = collect();

        foreach ($categories as $category) {
            if ($category->parent_id == $parentId) {
                $children = self::buildTree($categories, $category->id);
                if ($children->isNotEmpty()) {
                    $category->children = $children;
                }
                $branch->push($category);
            }
        }

        return $branch;
    }

    public function getAllDescendants()
    {
        $descendants = collect();

        foreach ($this->children as $child) {
            $descendants->push($child);
            $descendants = $descendants->merge($child->getAllDescendants());
        }

        return $descendants;
    }

    public function getDepth()
    {
        $depth = 0;
        $current = $this;

        while ($current->parent) {
            $depth++;
            $current = $current->parent;
        }

        return $depth;
    }

    public function scopeRoots($query)
    {
        return $query->whereNull('parent_id');
    }

    public function scopeLeaves($query)
    {
        return $query->whereDoesntHave('children');
    }
}
