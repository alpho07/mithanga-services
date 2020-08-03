<?php

namespace App\Http\Controllers\Admin;


use App\Http\Controllers\Controller;
use App\Models\Transaction;
use Illuminate\Http\Request;
use DB;

/**
 * Class TransactionController
 * @package App\Http\Controllers
 */
class PaymentController extends Controller {

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index() {
        $payments = DB::select(DB::raw("SELECT * From vw_payments"));
        $i = 1;
        return view('payment.index', compact('payments', 'i'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create() {
        $transaction = new Transaction();
        $clients = DB::select("SELECT * FROM vw_clients");
        return view('payment.create', compact('clients','transaction'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request) {
        request()->validate(Transaction::$rules);

        $transaction = Transaction::create($request->all());

        return redirect()->route('billing.index')
                        ->with('success', 'Transaction created successfully.');
    }

    /**
     * Display the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function show($id) {
        $transaction = Transaction::find($id);

        return view('transaction.show', compact('transaction'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id) {
        $transaction = Transaction::find($id);

        return view('transaction.edit', compact('transaction'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  Transaction $transaction
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Transaction $transaction) {
        request()->validate(Transaction::$rules);

        $transaction->update($request->all());

        return redirect()->route('bill.index')
                        ->with('success', 'Transaction updated successfully');
    }

    /**
     * @param int $id
     * @return \Illuminate\Http\RedirectResponse
     * @throws \Exception
     */
    public function destroy($id) {
        $transaction = Transaction::find($id)->delete();

        return redirect()->route('bill.index')
                        ->with('success', 'Transaction deleted successfully');
    }

    function receipt() {
        return view('transaction.receipt');
    }

}
