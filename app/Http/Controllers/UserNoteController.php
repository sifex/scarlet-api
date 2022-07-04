<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreUserNoteRequest;
use App\Http\Requests\UpdateUserNoteRequest;
use App\User;
use App\UserNote;
use Illuminate\Http\Response;

class UserNoteController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param StoreUserNoteRequest $request
     * @return Response
     */
    public function store(StoreUserNoteRequest $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param User $user, UserNote $userNote
     * @return Response
     */
    public function show(User $user, UserNote $userNote)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param User $user, UserNote $userNote
     * @return Response
     */
    public function edit(User $user, UserNote $userNote)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param UpdateUserNoteRequest $request
     * @param User $user, UserNote $userNote
     * @return Response
     */
    public function update(UpdateUserNoteRequest $request, User $user, UserNote $userNote)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param User $user, UserNote $userNote
     * @return Response
     */
    public function destroy(User $user, UserNote $userNote)
    {
        //
    }
}
