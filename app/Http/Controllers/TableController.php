<?php

namespace App\Http\Controllers;

use App\Models\Table;
use App\Http\Requests\StoreTableRequest;
use App\Http\Requests\UpdateTableRequest;
use Illuminate\Http\Request;

class TableController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $tables = Table::all();
        return view('pages/staff/table/table-data', [
            'title' => 'Data Meja',
            'tables' => $tables
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('pages/staff/table/add-table', [
            'title' => 'Tambah Meja Baru',
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'visibility' => ['required'],
            'table_number' => ['required']
        ]);
        $token = random_int(100000000000, 999999999999);

        $table = new Table([
            'token' => $token,
            'table_number' => $request->table_number,
            'visibility' => $request->visibility
        ]);
        $table->save();

        return back()->with('success', 'Berhasil menambahkan meja baru');
    }

    /**
     * Display the specified resource.
     */
    public function show(Table $table)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $table = Table::find($id);
        if (!$table)
            return back()->with('error', 'failed operation');

        return view('pages/staff/table/edit-table', [
            'title' => 'Edit Meja',
            'table' => $table
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $request->validate([
            'table_number' => ['required']
        ]);

        $table = Table::find($id);

        if (!$table)
            return back()->with('error', 'Operation Failed!');

        $table['table_number'] = $request->table_number;
        $table->save();

        return redirect()->to(route('table.data'));
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $table = Table::find($id);
        if (!$table)
            return back()->with('error', 'Operation Failed!');
        $table->forceDelete();

        return back()->with('success', 'succesfully delete the table');
    }
}
