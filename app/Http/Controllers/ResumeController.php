<?php

namespace App\Http\Controllers;

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
     * @return \Illuminate\Http\Response
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
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(ResumeCreateRequest $request)
    {
        $store = $request->all();
        $store['user_id'] = Auth::id();
        $item = Resume::create($store);
        if($item){
            $job = new StoreResume($item);
            $this->dispatch($job);
        }
        return true;
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $resume = Resume::findOrFail($id);
        if($resume){
            $resume->get();
            return $resume;
        }
        return 404;
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(ResumeUpdateRequest $request, $id)
    {
        $resume = Resume::findOrFail($id);
        if($resume)
            $resume->update($request->all());
        else
            return 404;
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $resume = Resume::findOrFail($id);
        if($resume){
            $resume->destroy($id);
            return '200';
        }
        return '500';
    }
}
