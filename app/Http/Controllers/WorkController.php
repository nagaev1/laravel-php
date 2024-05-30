<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use Illuminate\Support\Facades\DB;

use App\Models\Work;
use App\Models\Genre;
use App\Models\WorkGenre;
use App\Models\Status;
use App\Models\Type;
use App\Models\Company;


use Illuminate\Support\Facades\Validator;

use Illuminate\Support\Facades\Storage;

class WorkController extends Controller
{
    
    public function index() {
        $works = Work::all();
        return view('work.all', [
            'data' => $works,
            'genres' => Genre::orderBy('ru_name')->get(),
            'statuses' => Status::orderBy('ru_name')->get(),
            'types' => Type::orderBy('ru_name')->get()
        ]);
    }
    
    public function filter(Request $request) {
        $works = Work::query();
        $companies = [];

        $input_genres = $request->input('genres');
        $input_statuses = $request->input('statuses');
        $input_types = $request->input('types');
        $input_studios = $request->input('studios');
        $input_q = $request->input('q');

        if ($input_genres) {
            $genres = Genre::whereIn('name', $input_genres)->pluck('id');
            $work_genres = WorkGenre::whereIn('genre_id', $genres)->pluck('work_id');
            $works = $works->whereIn('id', $work_genres);
        }
        if ($input_statuses) {
            $statuses = Status::whereIn('name', $input_statuses)->pluck('id');
            $works = $works->whereIn('status_id', $statuses);
        }
        if ($input_types) {
            $types = Type::whereIn('name', $input_types)->pluck('id');
            $works = $works->whereIn('type_id', $types);
        }
        if ($input_studios) {
            $studios = Company::whereIn('name', $input_studios)->pluck('id');
            $works = $works->whereIn('company_id', $studios);
        }
        if ($input_q) {
            $works = $works->where('ru_name', 'like', '%'.$input_q.'%');
            $companies = Company::where('name', 'like', '%'.$input_q.'%')->get();
        }
        $works = $works->orderBy('ru_name')->get();
        return view('work.all', [
            'works' => $works,
            'companies' => $companies,
            'genres' => Genre::orderBy('ru_name')->get(),
            'statuses' => Status::orderBy('ru_name')->get(),
            'types' => Type::orderBy('ru_name')->get()
        ]);
    }

    public function show($name) {
        $work = Work::where('name', $name)->first();
        if (!$work) {
            return abort(404);
        }
        return view('work.show', [
            'work' => $work
        ]);
    }

    public function create() {
        return view('work.form', [
            'statuses' => Status::orderBy('ru_name')->get(),
            'genres' => Genre::orderBy('ru_name')->get(),
            'types' => Type::orderBy('ru_name')->get(),
            'companies' => Company::all(),
            'action' => route('anime.store'),
            'method' => 'POST'
        ]);
    }

    public function store(Request $request) {
        $validator = Validator::make(request()->all(), [
            'name' => 'required',
            'ru_name' => 'required', 
            'description' => 'required',
            'status_id' => 'required',
            'type_id' => 'required',
            'company_id' => 'required',
            'image' => ['image', 'required']
        ]);

        if ($request->hasFile('image')) {
            $image = $request->file('image')->store('public');
        }

        if($validator->fails())
            return response($validator->messages()->toArray(), 400);

        $work = Work::create([
            'name' => $request->name,
            'ru_name' => $request->ru_name,
            'description' => $request->description,
            'status_id' => $request->status_id,
            'image' => $image,
            'type_id' => $request->type_id,
            'company_id' => $request->company_id
        ]);

        $work->refresh();

        if ($request->input('genres')) {
            foreach ($request->input('genres') as $genre_id) {
                $work_genre = WorkGenre::create([
                    'work_id' => $work->id,
                    'genre_id' => $genre_id
                ]);
            }
        }

        return response(json_encode($work, JSON_UNESCAPED_UNICODE), 200)
            ->header('Content-Type', 'application/json;charset=utf-8');
    }

    public function edit($name) {
        $work = Work::where('name', $name)->first();
        if (!$work) {
            abort(404);
        }
        return view('work.form', [
            'work' => $work,
            'genres' => Genre::orderBy('ru_name')->get(),
            'statuses' => Status::orderBy('ru_name')->get(),
            'types' => Type::orderBy('ru_name')->get(),
            'companies' => Company::all(),
            'action' => route('anime.update', $work->name),
            'method' => 'PATCH'
        ]);
    }

    public function update(Request $request, $name) {
        $work = Work::where('name', $name)->first();
        if (!$work) {
            return abort(404);
        }

        $input_genres = $request->input('genres');
        $parent_work = Work::where('name', $request->input('parent_work_name'))->first('id');

        if ($request->hasFile('image')) {
            $image = $request->file('image')->store('public');
        }
        
        WorkGenre::where('work_id', $work->id)->whereNotIn('genre_id', $input_genres ?? [])->delete();

        if ($input_genres) {
            foreach ($input_genres as $genre_id) {
                if (!WorkGenre::where('work_id', $work->id)->where('genre_id', $genre_id)->first()) {
                    WorkGenre::create([
                        'work_id' => $work->id,
                        'genre_id' => $genre_id
                    ]);
                }
            }
        }
        $work->update([
            'name' => $request->name,
            'ru_name' => $request->ru_name,
            'description' => $request->description,
            'status_id' => $request->status_id,
            'image' => $image ??= $work->image,
            'type_id' => $request->type_id,
            'company_id' => $request->company_id,
            'parent_work_id' => $parent_work->id ?? null
        ]);
        return redirect()->route('anime.edit', $work->name);
    }
}
