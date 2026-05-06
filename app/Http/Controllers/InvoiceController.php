<?php

namespace App\Http\Controllers;

use App\Models\Invoice;
use App\Http\Requests\StoreInvoiceRequest;
use App\Http\Requests\UpdateInvoiceRequest;
use App\Models\Menu;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

use function Laravel\Prompts\error;

class InvoiceController extends Controller
{

    /**
     * Display a listing of the resource.
     */
    public function index($token)
    {
        $invoice = Invoice::where('token', $token)->first();
        if ($invoice) {
            $invoice->menus = json_decode($invoice->menus);
            return view('pages/invoice/invoice-form', [
                'title' => 'Invoice',
                'invoice' => $invoice
            ]);
        }
        return error(404);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $invoiceUser = Invoice::where('user_id', Auth::user()->uuid)->where('already_paid', false)->get();
        if (!(count($invoiceUser) < 3)) {
            return response()->json(['status' => 'failed', 'message' => 'User invoices failed more than 3']);
        }
        $token = random_int(100000000000, 999999999999);
        $invoice = Invoice::where('token', $token)->first();
        while ($invoice) {
            $token = random_int(100000000000, 999999999999);
            $invoice = Invoice::where('token', $token)->first();
        }


        $invoice = new Invoice([
            'user_id' => Auth::user()->uuid,
            'token' => $token,
            'menus' => $request->menus,
            'table_number' => $request->table_number,
            'total_price' => $request->total_price,
            'payment_method' => $request->payment_method,
            'status' => 'menunggu pembayaran',
            'already_paid' => false,
        ]);
        $invoice->save();
        session()->forget('carts');

        return response()->json(['status' => 'success', 'token' => $token]);
    }

    /**
     * Display the specified resource.
     */
    public function show()
    {
        $invoices = Invoice::where('user_id', Auth::user()->uuid)->orderBy('status', 'asc')->get();


        return view('pages/invoice/myinvoice', [
            'title' => 'Invoice Saya',
            'invoices' => $invoices
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Invoice $invoice)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateInvoiceRequest $request, Invoice $invoice)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($token)
    {
        $invoice = Invoice::where('token', $token)->first();

        $invoice->forceDelete();

        return redirect()->to(route('invoice.show'));
    }

    public function searchCashConfirmation()
    {
        return view('pages/staff/cash-confirmation-form', [
            'title' => 'Cash confirmation finder'
        ]);
    }

    public function searchCashConfirmationPost(Request $request)
    {
        $request->validate([
            'token' => ['required']
        ], [
            'token.required' => 'token wajib diisi'
        ]);

        $invoice = Invoice::where('token', $request->token)->first();

        if (!$invoice) {
            return back()->with('error', 'ID tidak valid!');
        }

        return redirect()->to(route('invoice.cash.confirm', $invoice->token));
    }

    public function cashConfirmation($token)
    {
        $invoice = Invoice::where('token', $token)->first();

        if (!$invoice) {
            return back()->with('error', 'ID Invoice Tidak valid!');
        }

        if ($invoice->payment_method != 'cash' || $invoice->already_paid != false) {
            return back()->with('error', 'ID Invoice Tidak valid!');
        }

        $user = User::find($invoice->user_id);

        return view('pages/staff/cash-confirmation', [
            'title' => 'Cash Confirmation',
            'invoice' => $invoice,
            'user' => $user
        ]);
    }

    public function cashConfirmationPost($token)
    {
        $invoice = Invoice::where('token', $token)->first();

        if (!$invoice) {
            return error(404);
        }

        $invoice['already_paid'] = true;
        $invoice['status'] = 'sedang disiapkan';

        $invoice->menus = json_decode($invoice->menus);
        foreach ($invoice->menus as $menu) {
            $menu_model = Menu::find($menu->id);
            $menu_model->sold += $menu->count;
            $menu_model->save();
        }

        $user = User::find($invoice->user_id);

        if (!$user) {
            return back()->with('error', 'Operation failed!');
        }

        $user->total_purchased += $invoice->total_price;

        $user->save();
        $invoice->save();

        return redirect()->to(route('invoice.cash.search'))->with('success', 'Berhasil mengkonfirmasi pembayaran dengan ID Invoice: ' . $invoice->token);
    }

    public function showCustomerOrder()
    {
        $invoices = Invoice::where('status', 'sedang disiapkan')->get();

        if (count($invoices) != 0) {
            foreach ($invoices as $invoice) {
                $invoice->menus = json_decode($invoice->menus);
            }
        }

        return view('pages/staff/customer-order', [
            'title' => 'Customer Order',
            'invoices' => $invoices
        ]);
    }

    public function completeCustomerOrder($token)
    {
        $invoice = Invoice::where('token', $token)->first();
        if (!$invoice)
            return back()->with('error', 'Failed operation!');

        $invoice['status'] = 'selesai';
        $invoice->save();
        return back()->with('success', 'Berhasil menyelesaikan pesanan');
    }
}
