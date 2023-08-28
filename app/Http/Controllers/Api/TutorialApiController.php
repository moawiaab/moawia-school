<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreTestModelRequest;
use App\Http\Requests\StoreTutorialRequest;
use App\Http\Requests\UpdateTestModelRequest;
use App\Http\Requests\UpdateTutorialRequest;
use App\Http\Resources\Admin\CreateMaterialResource;
use App\Http\Resources\Admin\TutorialListResource;
use App\Http\Resources\Admin\TutorialResource;
use App\Http\Resources\Admin\TutorialShowResource;
use App\Models\Answer;
use App\Models\TeacherMaterialLevel;
use App\Models\TestItem;
use App\Models\TestModel;
use App\Models\Tutorial;
use Illuminate\Http\Request as HttpRequest;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Request;

class TutorialApiController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        abort_if(Gate::denies('tutorial_access'), Response::HTTP_FORBIDDEN, 'ليس لديك الصلاحية الكافية لتنفيذ هذه العملية');
        return TutorialListResource::collection(
            Tutorial::advancedFilter()
                ->filter(Request::only(['trashed', 'type']))
                ->paginate(request('limit', 20))
        );
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //TeacherMaterialLevel
        return response([
            'meta' => [
                'materials' => CreateMaterialResource::collection(TeacherMaterialLevel::all())
            ],
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreTutorialRequest $request)
    {
        $tutorial = Tutorial::create($request->validated() + ['user_id' => auth()->id()]);
        if ($request->hasFile('audio')) {
            $tutorial->addMediaFromRequest('audio')->toMediaCollection('tutorial_audio');
        }
        return  response(['data' => $tutorial])
            ->setStatusCode(Response::HTTP_CREATED);
    }

    /**
     * Display the specified resource.
     */
    public function show(Tutorial $tutorial)
    {
        return response([
            'data' => new TutorialResource($tutorial),
        ]);
    }


    public function showOne(Tutorial $tutorial)
    {


        return response([
            'data' => new TutorialResource($tutorial),
            // 'tutorialData' => Tutorial::where("material_id", $tutorial->id)->get(),
            // 'data' => new TutorialResource($tutorial),
        ]);
    }

    public function answer(UpdateTestModelRequest $request)
    {
        $data = [];
        foreach ($request->data as $i) {
            $ask = TestModel::find($i[0]['id']);
            $asw = TestItem::find($i[0]['status']);
            $answer = new Answer();

            $answer->ask_id      = $ask->id;
            $answer->tutorial_id = $ask->tutorial_id;
            $answer->material_id = $ask->material_id;
            $answer->status      = $asw->status;
            $answer->answer_id   = $asw->id;
            $answer->user_id     = auth()->id();
            $answer->save();
            // $data[] = $i[0]['id'];
        }
        return response(null)->setStatusCode(Response::HTTP_CREATED);
    }


    public function asks(StoreTestModelRequest $request)
    {

        $tut = Tutorial::find($request->tutorial_id);
        $ask = new TestModel();
        $ask->ask           = $request->ask;
        $ask->details       = $request->details;
        $ask->user_id       = auth()->id();
        $ask->tutorial_id   = $request->tutorial_id;
        $ask->material_id   = $tut->material_id;

        if ($ask->save()) {
            foreach ($request->answers as $k) {
                $at = new TestItem();
                $at->ask_id = $ask->id;
                $at->answer = $k['answer'];
                $at->status = $k['id'] == $request->type ? 1 : 0;
                $at->save();
            }
        }

        return  response(['data' => $ask])
            ->setStatusCode(Response::HTTP_CREATED);
    }
    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Tutorial $tutorial)
    {

        return response([
            'data' => new TutorialResource($tutorial),
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateTutorialRequest $request, Tutorial $tutorial)
    {
        $tutorial->update($request->validated());
        return response(['data' => 'ok'])
            ->setStatusCode(Response::HTTP_ACCEPTED);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Tutorial $tutorial)
    {
        abort_if(Gate::denies('tutorial_delete'), Response::HTTP_FORBIDDEN, 'ليس لديك الصلاحية الكافية لتنفيذ هذه العملية');

        if ($tutorial->deleted_at) {
            $tutorial->forceDelete();
        } else {
            $tutorial->delete();
        }

        return response(null, Response::HTTP_NO_CONTENT);
    }

    public function deleteItem(TestModel $item)
    {
        $item->delete();
        return response(null, Response::HTTP_NO_CONTENT);
    }

    public function restore(Tutorial $item)
    {
        abort_if(Gate::denies('teacher_delete'), Response::HTTP_FORBIDDEN, 'ليس لديك الصلاحية الكافية لتنفيذ هذه العملية');
        $item->restore();
        return response(null, Response::HTTP_NO_CONTENT);
    }

    public function storeMedia(HttpRequest $request)
    {
        $model         = new Tutorial();
        $model->id     = $request->input('model_id', 0);
        $model->exists = true;
        $media         = $model->addMediaFromRequest('file')->toMediaCollection($request->input('collection_name'));

        if (!$media) {
            $this->validate($request, [
                'file' => 'required',
            ]);
        }
        return response()->json($media, Response::HTTP_CREATED);
    }
}
