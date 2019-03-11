<?php

namespace App\Models;

// use Illuminate\Database\Eloquent\Model;

class Page extends DataModel
{
    //
    protected $fillable = [
        "user_id", 'sort_order'
    ];

    protected $casts = [
        "page_id" => 'integer'
    ];
    /**
     **************************************************
     *              Permissions
     **************************************************
    */
    public function scopeOfType($query, $type)
    {
        return $query->where('type', $type);
    }

    public function scopeVisible($query)
    {
        return $query->where('published_at', '<>', null)->get();
    }

    public function scopeTopMost($query, $id = -1)
    {
        return $query->where('page_id', $id ?? -1)->get();
    }

    public function scopeAllowed($query)
    {
        return $query->where('user_id', auth()->id());
    }
    /**
     **************************************************
     *              Properties
     **************************************************
    */

    public function getUrlAttribute()
    {
        $getFullURL = function($page) use(&$getFullURL){
           $parentlink = "";
           if($page->parent){
               $parentlink = $getFullURL($page->parent);
           }
           return implode("/", [$parentlink, $page->link]);
        };
        return trim($getFullURL($this), '\/');
    }

    public function getPublishedAttribute()
    {
        return $this->published_at !== null;
    }

    /**
     **************************************************
     *              Relationships
     **************************************************
    */

    public function Parent()
    {
        $Parent = $this->belongsTo(Page::class, 'page_id');
        // dump($Parent->getBindings(), $Parent->toSql());
        return $Parent;
    }


    public function Children()
    {
        $Children = $this->hasMany(Page::class);
        // dump($Children->getBindings(), $Children->toSql());
        return $Children;
    }
}
