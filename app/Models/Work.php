<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

use App\Models\Status;
use App\Models\WorkGenre;
use App\Models\Type;
use App\Models\Company;

/**
 * @property $name
 */
class Work extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'ru_name',
        'description',
        'image',
        'status_id',
        'type_id',
        'company_id',
        'parent_work_id'
    ];

    protected $hidden = ['status_id', 'type_id', 'company_id', 'parent_work_id'];

    protected $appends = ['status', 'genres', 'type', 'company', 'parent_work', 'child_work', 'image_url'];

    protected function getStatusAttribute() {
        return Status::find($this->status_id);
    }
    protected function getCompanyAttribute() {
        return Company::find($this->company_id);
    }
    protected function getTypeAttribute() {
        return Type::find($this->type_id);
    }
    protected function getParentWorkAttribute() {
        return Work::find($this->parent_work_id);
    }
    protected function getChildWorkAttribute() {
        $work = Work::where('parent_work_id', $this->id)->first(); 
        $data = null;
        if ($work) {
            $data = [
                'id' => $work->id,
                'name' => $work->name,
                'ru_name' => $work->ru_name,
                'image' => $work->image,
                'type' => $work->type
            ]; 
        }
        return $data; 
    }

    protected function getImageUrlAttribute() {
        if ($this->image) {
            return url('storage/'.substr($this->image, 7));
        }
    }

    protected function getGenresAttribute() {
        $works = WorkGenre::where('work_id', '=', $this->id)->get();
        $genres = [];
        foreach ($works as $work) {
            array_push($genres, $work->genre);
        }
        return $genres;
    }

    public $timestamps = false;
}
