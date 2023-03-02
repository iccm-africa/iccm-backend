<?php

namespace App\Http\Controllers;

use App\Models\Accommodation;
use App\Models\Currency;
use App\Models\Invoice;
use App\Models\Product;
use App\Services\UserRegistration;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class GroupController extends Controller
{
    /**
     * UserController constructor.
     *
     * @param \App\Services\UserRegistration $registration
     */
    public function __construct(protected UserRegistration $registration)
    {
        $this->middleware('auth');
    }

    public function index(Request $request, $uid = null)
    {
        $thanks = $request->headers->get('referer') == route('register');
        $userAdded = $request->headers->get('referer') == route('addUser');
        $group = Auth::user()->group;
        $msg = '';
        if ($uid) {
            $invoice = Invoice::where('mollie_uid', $uid)->first();
            if (! $invoice) {
                abort(404);
            } elseif ($invoice->group != $group) {
                abort(403);
            }
            if ($invoice->paid) {
                $msg = 'paid';
            } elseif ($invoice->mollieFailed()) {
                $msg = 'failed';
            } else {
                $msg = 'toBePaid';
            }
        }
        $group = Auth::user()->group;
        $users = $group->users()->where("checked_out", true)->get();
        $users_checkout = $group->users()->where("checked_out", false)->get();

        return view('group', compact('group', 'users', 'users_checkout', 'thanks', 'userAdded', 'msg'));
    }

    public function addUser()
    {
        $organisation = Auth::user()->group->name;
        $accommodations = Accommodation::all();
        $def = Currency::def();
        $products = Product::all();

        return view('auth.register', compact('accommodations', 'organisation', 'products', 'def'))->with('login', false);
    }

    /**
     * Handle a registration request for the application.
     *
     * @param \Illuminate\Http\Request $request
     *
     * @throws \Exception
     */
    public function saveUser(Request $request)
    {
        $this->registration->form_validate($request);
        $data = $request->all();
        $group = Auth::user()->group;
        $this->registration->registerUser($data, 'participant', $group);

        return redirect()->route('group');
    }

    public function downloadInvoice($uid)
    {
        $invoice = Invoice::where('mollie_uid', $uid)->first();
        if ($invoice->group != Auth::user()->group) {
            abort(403);
        }

        return Storage::download($invoice->invoiceFile());
    }

    public function downloadReceipt($uid)
    {
        $invoice = Invoice::where('mollie_uid', $uid)->first();
        if ($invoice->group != Auth::user()->group) {
            abort(403);
        }

        return Storage::download($invoice->receiptFile());
    }



    /**
     * Validate the form
     *
     * @param \Illuminate\Http\Request $request
     *
     * @return \Illuminate\Http\JsonResponse
     * @throws \Exception
     */
    public function form_validate($request)
    {
        $this->registration->form_validate($request);
    }
}
