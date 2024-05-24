<?php

namespace App\Http\Controllers;

use App\Models\Todos;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Yajra\DataTables\Facades\DataTables;

class TodoController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('todo');
    }

    // STORE TODO IN DATABASE
    public function store(Request $request)
    {
        if (auth()->guard('admin')->check()) {
            $adminId = auth()->guard('admin')->id();

            $validator = Validator::make($request->all(), [
                'title' => 'required',
                'description' => 'required',
                'due_date' => 'required',
                'status' => 'required',
            ]);

            if ($validator->fails()) {
                return back()->withErrors($validator)->withInput();
            }

            $todo = Todos::create([
                'userid' => $adminId,
                'title' => $request->title,
                'description' => $request->description,
                'due_date' => $request->due_date,
                'status' => $request->status,
            ]);

            return redirect()->back()->with('success', 'Successfully added todo!');
        } else {
            return redirect()->back()->with('error', 'User not authenticated.');
        }
    }


        // DATATABLE FECTH TODO DATA

    public function getData(Request $request)
    {
        if ($request->ajax()) {
            $data = Todos::select('*')->get();
            return DataTables::of($data)
                ->addColumn('action', function ($row) {
                    $deleteButton = '<button class="btn btn-dark btn-sm delete-btn" data-row-id="' . $row->id . '"><i class="fa fa-trash"></i></button>&nbsp;';
                    $editButton = '<button class="btn btn-dark btn-sm edit-btn" data-row-id="' . $row->id . '"><i class="fa fa-edit"></i></button>&nbsp;';
                    return $editButton . $deleteButton;
                })
                ->make(true);
        }
    }

     // EDIT TODO

    public function edit(string $id)
    {
        $todo = Todos::find($id);
        return view('todo_edit', compact('todo'));
    }

        // UPDATE TODO DATA


    public function update(Request $request, $id)
    {
        $todo = Todos::find($id);

        if (!$todo) {
            return redirect()->back()->with('error', 'Todo not found.');
        }

        $validator = Validator::make($request->all(), [
            'title' => 'required',
            'description' => 'required',
            'due_date' => 'required',
            'status' => 'required',
        ]);

        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }

        $todo->update([
            'title' => $request->title,
            'description' => $request->description,
            'due_date' => $request->due_date,
            'status' => $request->status,
        ]);
        return redirect()->route('dashboard')->with('success', 'Successfully updated todo!');
    }

    public function destroy(string $id)
    {
        $data = Todos::findOrfail($id);
        $data->delete();
        return response()->json(['sucess' => true, 'sucess' => 'deleted successfully!!']);
    }
}
