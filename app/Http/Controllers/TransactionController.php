<?php

namespace App\Http\Controllers;

use App\Models\Transaction;
use Illuminate\Http\Request;

class TransactionController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $transaction = Transaction::latest()->get();
        if ($request->ajax()) {
            return datatables()->of($transaction)
                ->addIndexColumn()
                ->addColumn('transaction_total', function ($row) {
                    return 'Rp.' . number_format($row->transaction_total, 2, ',', '.');
                })
                ->addColumn('transaction_status', function ($row) {
                    if ($row->transaction_status == 'success') {
                        return '<span class="badge badge-success badge-pill">' . $row->transaction_status . '</span>';
                    } elseif ($row->transaction_status == 'pending') {
                        return '<span class="badge badge-warning badge-pill">' . $row->transaction_status . '</span>';
                    } else {
                        return '<span class="badge badge-danger badge-pill">' . $row->transaction_status . '</span>';
                    }
                })
                ->addColumn('action', function ($row) {
                    return '<a href="javascript:void(0)" data-id="' . $row->id . '" class="detail btn btn-info mr-1 btn-sm " > <i class="fas fa-eye"></i></a><a href="javascript:void(0)" data-id="' . $row->id . '" class="edit btn btn-warning mr-1 btn-sm " > <i class="fas fa-pen"></i></a><a href="javascript:void(0)" data-id="' . $row->id . '" class="delete btn btn-danger btn-sm "> <i class="fas fa-trash"></i></a>';
                })
                ->rawColumns(['transaction_status', 'action'])
                ->make(true);
        }
        return view('pages.transaction');
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
        //
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
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $transaction = Transaction::findOrFail($id)->delete();
        return response()->json($transaction);
    }
}
