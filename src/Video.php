<?php

namespace Turanzamanli\LaraVideo;

use Illuminate\Database\Eloquent\Model;


class Video extends Model
{
    
    use \Dimsav\Translatable\Translatable;
    use \Spatie\Activitylog\Traits\LogsActivity;

    protected static $logAttributes = ["*"];

    public $translationModel = 'App\Models\VideoTranslation';

    public $translatedAttributes = ['title'];

    protected $fillable = ['image','ordering', 'video', 'link', 'date', 'status'];

    protected $dates = ['date'];


    public function __construct(array $attributes = []) {

    	 parent::__construct($attributes);
    	 $this->defaultLocale = 'az';
    }


    public function scopeOrdering($query) {

        return $query->orderBy('date', 'desc');
    }


     public function scopeActive($query) {
        
    }

}
