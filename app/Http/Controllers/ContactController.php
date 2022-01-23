<?php

namespace App\Http\Controllers;

use App\Events\ContactCreated;
use App\Events\ContactDeleted;
use App\Events\ContactUpdated;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\ContactRequest;
use App\Http\Resources\ContactCollection;
use Illuminate\Support\Facades\Auth;
use App\Http\Resources\ContactResource;
use App\Models\Contact;

class ContactController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('contact.index');
    }

    /**
     * Return a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function list()
    {
        return new ContactCollection(Auth::user()->contacts()->orderBy('firstname')->paginate(10));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(ContactRequest $request)
    {
        $contact = Auth::user()->contacts()->create($request->validated());

        event(new ContactCreated($contact));

        return new ContactResource($contact);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param ContactRequest $request
     * @param Contact $contact
     *
     * @return \Illuminate\Http\Response
     */
    public function update(ContactRequest $request, Contact $contact)
    {
        if (!$contact) {
            abort(404);
        }

        $contact->update($request->validated());

        event(new ContactUpdated($contact));

        return new ContactResource($contact);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Contact $contact)
    {
        if (!$contact) {
            abort(404);
        }

        $contact->delete();

        event(new ContactDeleted($contact));

        return new ContactResource($contact);
    }
}
