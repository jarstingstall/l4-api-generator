<?php

use Illuminate\Database\Eloquent\ModelNotFoundException;

class MessageEventsController extends BaseController {

    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index()
    {
        $data = MessageEvent::all();

        return Response::json($data);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @return Response
     */
    public function store()
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return Response
     */
    public function show($id)
    {
        try {
            $data = MessageEvent::findOrFail($id);
        } catch (ModelNotFoundException $e) {
            return Response::json(
                [
                    'status' => 404,
                    'message' => 'The requested resource was not found'
                ],
                404
            );
        }

        return Response::json($data);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  int  $id
     * @return Response
     */
    public function update($id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return Response
     */
    public function destroy($id)
    {
        //
    }

}