<?php

namespace App\Http\Controllers;

use App\Models\Person;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PersonController extends Controller
{
    public function index()
    {
        $id = Auth::id();
        $people = Person::where('user_id', $id)->paginate(3);

        return view('person.index', ['people' => $people]);
    }

    public function create()
    {
        $people = Person::all();
        return view('person.create', ['people' => $people]);
    }

    public function store(Request $request )
    {
        $user_id = Auth::id();
        $validated = $request->validate([
            'name' => 'required',
            'company' => 'required',
            'email' => 'nullable|email',
            'phone' => 'nullable',
        ]);

        $validated['user_id'] = $user_id;
        $person = Person::create($validated);

        return redirect()->route('person.index')->with('success', 'Contact added successfully!');
    }

    public function show(Person $person)
    {
        // TODO
    }

    public function edit($person)
    {
        $people = Person::findOrFail($person);

        return view('person.edit', ['person' => $people]);
    }

    public function update($id, Request $request)
    {
        $person = Person::findOrFail($id);

        $validated = $request->validate([
            'name' => 'required',
            'company' => 'required',
            'email' => 'nullable|email',
            'phone' => 'nullable',
        ]);

        $validated['name'] = strip_tags($validated['name']);
        $validated['company'] = strip_tags($validated['company']);
        $validated['email'] = strip_tags($validated['email']);
        $validated['phone'] = strip_tags($validated['phone']);

        $person->update($validated);
        return redirect(route('person.index'));
    }

    public function destroy($id)
    {
        $person = Person::findOrFail($id);
        $person->delete();

        return redirect()->route('person.index')->with('success', 'Contact deleted successfully!');
    }

    public function search(Request $request)
    {
        $user_id = Auth::id();

        $searchTerm = $request->get('query');
        $results = Person::where('user_id', $user_id)
            ->where(function($query) use ($searchTerm) {
                $query->where('name', 'LIKE', "%{$searchTerm}%")
                    ->orWhere('company', 'LIKE', "%{$searchTerm}%")
                    ->orWhere('email', 'LIKE', "%{$searchTerm}%")
                    ->orWhere('phone', 'LIKE', "%{$searchTerm}%");
            })
            ->paginate(3);

        if ($request->ajax()) {
            $output = '';
            if ($results->count() > 0) {
                foreach ($results as $result) {
                    $output .= "
                        <tr>
                            <td class='border px-6 py-4'>{$result->name}</td>
                            <td class='border px-6 py-4'>{$result->company}</td>
                            <td class='border px-6 py-4'>{$result->email}</td>
                            <td class='border px-6 py-4'>{$result->phone}</td>
                            <td class='border px-6 py-4'>
                                <a href='" . route('person.edit', $result->id) . "' class='text-blue-600 hover:underline'>Edit</a>
                                <form action='" . route('person.destroy', $result->id) . "' method='POST' class='inline'>
                                    " . csrf_field() . "
                                    " . method_field('DELETE') . "
                                    <button type='submit' onclick=\"return confirm('Are you sure you want to delete?')\" class='text-red-600 hover:underline ml-2'>Delete</button>
                                </form>
                            </td>
                        </tr>";
                }
            } else {
                $output .= "
                    <tr>
                        <td colspan='5' class='border px-6 py-4 text-center'>No results found</td>
                    </tr>";
            }
            return $output;
        }
    }
}
