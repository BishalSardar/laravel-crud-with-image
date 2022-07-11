<?php

namespace App\Http\Controllers;

use App\Models\Person;
use Exception;
use Illuminate\Http\Request;
use PhpParser\Node\Expr\New_;

class PersonController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        $person = Person::all();
        return view('home', compact('person'));
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
    public function store(Request $request)
    {
        try {
            $request->validate([
                'name' => 'required',
            ]);

            $person = new Person();

            if ($request->file('image')) {
                $file = $request->file('image');
                $filename = $file->getClientOriginalName();
                $file->move(public_path('Image'), $filename);
                $person['image'] = $filename;
                $person->name = $request->name;
            }
            $person->save();
        } catch (Exception $exception) {
            dd($exception);
            return redirect()->back()->with('error', 'This is the error' . $exception);
        }

        return redirect()->back();
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Person  $person
     * @return \Illuminate\Http\Response
     */
    public function show(Person $person)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Person  $person
     * @return \Illuminate\Http\Response
     */
    public function edit(Person $person, $id)
    {
        //
        $item = Person::find($id);
        return view('update', compact('item'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Person  $person
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Person $person, $id)
    {
        try {
            $request->validate([
                'name' => 'required',
            ]);

            $person = Person::find($id);

            if ($request->file('image')) {
                $file = $request->file('image');
                $filename = $file->getClientOriginalName();
                $file->move(public_path('Image'), $filename);
                $person['image'] = $filename;
                $person->name = $request->name;
                $person->update();
            }
        } catch (Exception $exception) {
            dd($exception);
            return redirect()->back()->with('error', 'This is the error' . $exception);
        }

        return redirect()->route('home');
    }

    public function delete($id)
    {
        $data = Person::find($id);
        $data->delete();
        return redirect()->back();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Person  $person
     * @return \Illuminate\Http\Response
     */
    public function destroy(Person $person)
    {
        //
    }
}
