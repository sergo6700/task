<?php

namespace App\Http\Controllers;

use Illuminate\Http\JsonResponse;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Resume;
use App\Jobs\StoreResume;
use App\Http\Requests\ResumeCreateRequest;
use App\Http\Requests\ResumeUpdateRequest;

class ResumeController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return JsonResponse
     */
    public function index()
    {
        $data = Resume::where(['user_id' => Auth()->id()])->get([
            'id',
            'first_name',
            'last_name',
            'email',
            'job',
        ]);
        return response()->json($data);

    }

    /**
     * Show the form for creating a new resource.
     *
     * @return void
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param ResumeCreateRequest $request
     * @return JsonResponse
     */
    public function store(ResumeCreateRequest $request)
    {
        $store = $request->all();
        $store['user_id'] = Auth::id();
        $item = Resume::create($store);
        if ($item) {
            $job = new StoreResume($item);
            $this->dispatch($job);
        }
        return response()->json('success', 200);
    }

    /**
     * Display the specified resource.
     *
     * @param int $id
     * @return void
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param int $id
     * @return JsonResponse
     */
    public function edit($id)
    {
        $resume = Resume::findOrFail($id);
        if ($resume) {
            $resume->get();
            return $resume;
        }
        return response()->json("Not Found", 404);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param ResumeUpdateRequest $request
     * @param int $id
     * @return JsonResponse
     */
    public function update(ResumeUpdateRequest $request, $id)
    {
        $resume = Resume::findOrFail($id);
        if ($resume)
            $resume->update($request->all());
        else
            return response()->json("Not Found", 404);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     * @return JsonResponse
     */
    public function destroy($id)
    {
        $resume = Resume::findOrFail($id);
        if ($resume) {
            $resume->destroy($id);
            return response()->json("Success", 200);
        }
        return response()->json("Not Found", 404);

    }
}
