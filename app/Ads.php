<?php

namespace App;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

class Ads extends Model
{
    protected $fillable = [
        'title',
        'body',
        'published_at',
        'user_id',
        'category_id',
        'type_id',
        'pictures'
    ];

    protected $dates = ['published_at'];

    public function setPicturesAttribute($pics)
    {
        //dd($pics);
        return $this->attributes['pictures'] = $pics;
    }

    /**
     *
     * Set every time global published_ad to be carbon instance and format
     *
     * @param $date
     *
     */
    public function setPublishedAtAttribute($date)
    {
        //Carbon::parse($date);
        $this->attributes['published_at'] = Carbon::createFromFormat('Y-m-d', $date);
    }

    /**
     *
     * Get  every time global published_ad to be carbon instance and format
     *
     * @param $date
     *
     * @return Carbon date
     */
    public function getPublishedAtAttribute($date)
    {
        //Carbon::parse($date);
        return new Carbon($date);
    }

    public function scopePublished($query) // Ads::published($value); === scopePublished($query, value)
    {
        $query->where('published_at', '<=', Carbon::now());
    }

    public function scopeUnpublished($query)
    {
        $query->where('published_at', '>', Carbon::now());
    }

    public function setPublishedAttribute($date)
    {
        $this->attributes['published_at'] = Carbon::parse($date);
    }

    /**
     * An article is owned by a user
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function user()
    {
        return $this->belongsTo('App\User');
    }
}
