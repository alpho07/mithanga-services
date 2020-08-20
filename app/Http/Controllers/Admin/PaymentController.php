<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Payment;
use App\Models\Transaction;
use App\Models\Mop;
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
        $transactions = DB::select(DB::raw("SELECT * From vw_payments order by id desc"));
        $i = 1;
        return view('payment.index', compact('transactions', 'i'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create() {
        $transaction = new Payment();
        $mop = Mop::all();
        $banks = \App\Models\Bank::all();
        $clients = DB::select("SELECT * FROM vw_clients order by id asc");
        return view('payment.create', compact('clients', 'transaction', 'mop', 'banks'));
    }

    public function adjust() {
        $transaction = new Payment();
        $mop = Mop::all();
        $banks = \App\Models\Bank::all();
        $clients = DB::select("SELECT * FROM vw_clients order by id asc");
        return view('payment.create_adj', compact('clients', 'transaction', 'mop', 'banks'));
    }

    function saveAdjustments(Request $r) {
        $reason = $r->adjustment_type == 'debit' ? 'Account Debited' : 'Account Cedited';
        $ref = date('YmdHis').'-'.$r->adjustment_type;
        $tadate = date('Y-m-d H:i:s');
        DB::insert("INSERT INTO transactions (client_id,description,date,type,amount,reference,comments) VALUES ('$r->client_id','$reason','$tadate','$r->adjustment_type','$r->amount','$ref','$r->comment')");
        return redirect()->route('payment.index')->with('success', 'Payment Successfully Adjustent On Account Successful');
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

        return redirect()->route('payment.index')
                        ->with('success', 'Payment Successfully Saved');
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

    function loadClientInformation($pid, $clent_id) {
        $transaction = DB::table('vw_payments')->where('client_id', $clent_id)->where('id', $pid)->get();
        $due = DB::table('vw_balances')->where('client_id', $clent_id)->get();
        return ['transactions' => $transaction, 'due' => $due];
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

    function loadBranches($bank) {
        return \App\Models\Branch::where('bank_id', $bank)->get();
    }

    function receipt() {
        return view('transaction.receipt');
    }

}
