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

    public function invoice() {
        $invoices = DB::select(DB::raw("SELECT * From vw_invoices order by id desc"));
        $payments = DB::select(DB::raw("SELECT * From vw_payment order by id desc"));
        $i = 1;
        $mop = Mop::all();
        $banks = \App\Models\Bank::all();
        return view('payment.invoice', compact('invoices', 'i', 'mop', 'banks', 'payments'));
    }

    function loadPaymentDetails($ref) {
        return DB::select(DB::raw("SELECT * From vw_payment WHERE reference='$ref' order by id desc"));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create_invoice() {
        $supplier = \App\Models\Supplier::all();
        $cost_center = \App\Models\CostCenter::all();
        return view('payment.create_invoice', compact('supplier', 'cost_center'));
    }

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
        $ref = date('YmdHis') . '-' . $r->adjustment_type;
        $tadate = date('Y-m-d H:i:s');
        DB::insert("INSERT INTO transactions (client_id,description,date,type,amount,reference,comments) VALUES ('$r->client_id','$reason','$tadate','$r->adjustment_type','$r->amount','$ref','$r->comment')");
        return redirect()->route('payment.index')->with('success', 'Payment Successfully Adjustent On Account Successful');
    }

    function saveInvoice(Request $r) {
        $date = date('Y-m-d H:i:s');
        $total = 0;
        for ($i = 0; $i < count($r->cost_center); $i++) {
            $cs = $r->cost_center[$i];
            $amount = $r->amount_invoiced[$i];
            DB::insert("INSERT INTO invoice_details (item,reference,amount) VALUES ('$cs','$r->reference','$amount')");
            $total = $total + $r->amount_invoiced[$i];
        }
        DB::insert("INSERT INTO invoices (supplier,cost_center,reference,amount_invoiced,remarks,date) VALUES ('$r->supplier','-','$r->reference','$total','$r->remarks','$date')");

        return redirect()->route('invoicing.index')->with('success', 'Invoice Successfully Created');
    }

    function saveInvoicePayment(Request $r) {
        $date = date('Y-m-d H:i:s');
        DB::update("UPDATE invoices SET paid=paid+$r->amount WHERE reference='$r->reference'");
        DB::insert("INSERT INTO payment (reference,bank,mode,amount,date_paid) VALUES ('$r->reference','$r->bank','$r->mode','$r->amount','$date')");
        return redirect()->route('invoicing.index')->with('success', 'Invoice Payment Successfull');
    }

    function deleteInvoiceMicro($id, $reference) {
        $amount = DB::select("SELECT amount FROM payment WHERE id='$id'")[0]->amount;
        //DB::update("UPDATE invoices SET amount_invoiced=amount_invoiced + $amount WHERE reference='$reference'");
        DB::update("UPDATE invoices SET paid=paid - $amount WHERE reference='$reference'");
        DB::delete("DELETE FROM payment WHERE id='$id'");
        return ['message' => 'Deleted'];
    }

    public function showInvoice($cid, $ref) {
        $i = 0;
        $supplier = DB::select(DB::raw("SELECT * FROM suppliers WHERE id='$cid'"));
        $invoice = DB::select(DB::raw("SELECT * FROM invoices WHERE reference='$ref'"));
        $details = DB::select(DB::raw("SELECT * FROM vw_invdetails WHERE reference='$ref'"));
        return view('payment.index_show', compact('details', 'invoice', 'supplier', 'ref', 'i'));
    }

    public function editInvoice($cid, $ref) {

        $suppliers = \App\Models\Supplier::all();
        $cost_center = \App\Models\CostCenter::all();
        $supplier = DB::select(DB::raw("SELECT * FROM suppliers WHERE id='$cid'"));
        $invoice = DB::select(DB::raw("SELECT * FROM vw_invoices WHERE reference='$ref'"));
        $details = DB::select(DB::raw("SELECT * FROM vw_invdetails WHERE reference='$ref'"));
        return view('payment.edit_invoice', compact('details', 'invoice', 'supplier', 'cid', 'ref', 'cost_center', 'suppliers'));
    }

    function saveInvoiceEdit(Request $r, $cid, $ref) {
        DB::delete("DELETE FROM invoices WHERE reference='$ref'");
        DB::delete("DELETE FROM invoice_details WHERE reference='$ref'");
        $date = date('Y-m-d H:i:s');
        $total = 0;
        for ($i = 0; $i < count($r->cost_center); $i++) {
            $cs = $r->cost_center[$i];
            $amount = $r->amount_invoiced[$i];
            DB::insert("INSERT INTO invoice_details (item,reference,amount) VALUES ('$cs','$r->reference','$amount')");
            $total = $total + $r->amount_invoiced[$i];
        }
        DB::insert("INSERT INTO invoices (supplier,cost_center,reference,amount_invoiced,remarks,date) VALUES ('$r->supplier','-','$r->reference','$total','$r->remarks','$date')");

        return redirect()->route('invoicing.edit', ['cid' => $cid, 'ref' => $ref])->with('success', 'Invoice Successfully Edited');
    }

    function deleteInvoice($ref) {
        DB::delete("DELETE FROM invoices WHERE reference='$ref'");
        DB::delete("DELETE FROM invoice_details WHERE reference='$ref'");
        return redirect()->route('invoicing.index')->with('success', 'Invoice Successfully Deleted');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request) {
        //dd($request->all());
        $check = $clientid = $request->client_id;
        $amount = $request->amount;
        $date = date('YmdHis');

        $last_credit = DB::select("SELECT * FROM transactions WHERE client_id='$clientid' ORDER BY id DESC LIMIT 1");
        if (count($last_credit) > 0) {
            $update_id = @$last_credit[0]->id;

            $client = @$request->client_id;
            $mop = @$request->mop;
            if ($last_credit[0]->description == 'Reconnection Fee') {

                DB::update("UPDATE transactions SET amount='$amount',reference='$date',mop='$mop' WHERE id='$update_id'");
                return redirect()->route('client.receipt', ['pid' => $last_credit[0]->id, 'client_id' => $client])
                                ->with('success', 'Reconnection fee updated');
            } else {
                request()->validate(Transaction::$rules);
                $transaction = Transaction::create($request->all());
                $pid = DB::select("SELECT MAX(id) id FROM transactions ")[0]->id;
                return redirect()->route('client.receipt', ['pid' => $pid, 'client_id' => $client])
                                ->with('success', 'Payment Successfully Saved');
            }
        } else {

            request()->validate(Transaction::$rules);
            $transaction = Transaction::create($request->all());
            $pid = DB::select("SELECT MAX(id) id FROM transactions ")[0]->id;
            return redirect()->route('client.receipt', ['pid' => $pid, 'client_id' => $client])
                            ->with('success', 'Payment Successfully Saved');
        }
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
