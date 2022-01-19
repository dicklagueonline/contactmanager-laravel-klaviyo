<?php

namespace App\Http\Controllers;

use App\Models\Contact;
use App\Events\ContactCreated;
use App\Events\ContactDeleted;
use App\Events\ContactUpdated;
use App\Services\KlaviyoService;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\ContactRequest;

class ContactController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $contacts = Auth::user()->contacts()->orderBy('firstname')->paginate(25);

        return view('contact.index', compact('contacts'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('contact.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  App\Http\Requests\ContactRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(ContactRequest $request)
    {
        $contact = Auth::user()->contacts()->create($request->validated());

        event(new ContactCreated($contact));

        return redirect()
            ->route('contact.create')
            ->with('success', 'New contact has been added successfully.');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  Contact $contact
     * @return \Illuminate\Http\Response
     */
    public function edit(Contact $contact)
    {
        if( !$contact ) {
            abort(404);
        }

        return view('contact.edit', compact('contact'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  App\Http\Requests\ContactRequest  $request
     * @param  Contact $contact
     * @return \Illuminate\Http\Response
     */
    public function update(ContactRequest $request, Contact $contact)
    {
        if ( !$contact ) {
            abort(404);
        }

        $contact->update($request->validated());

        event(new ContactUpdated($contact));

        return redirect()
            ->route('contact.index')
            ->with('success', 'Contact has been updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  Contact  $contact
     * @return \Illuminate\Http\Response
     */
    public function destroy(Contact $contact)
    {
        if (!$contact) {
            abort(404);
        }

        event(new ContactDeleted($contact));

        $contact->delete();

        return redirect()
            ->route('contact.index')
            ->with('success', 'Contact has been deleted successfully.');
    }
}
