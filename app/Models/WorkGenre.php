<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

use App\Models\Genre;

class WorkGenre extends Model
{
    use HasFactory;

    protected $fillable = ['work_id', 'genre_id'];


    protected $appends = ['genre'];

    protected function getGenreAttribute() {
        return Genre::find($this->genre_id);
    }

    public $timestamps = false;
}
