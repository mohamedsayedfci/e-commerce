<?php

namespace App\Http\Controllers\Offers;

use App\Http\Controllers\Controller;
use App\Models\Offer;
use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class OfferController extends Controller
{
    public $module_view_folder;

    public function __construct()
    {
        $this->module_view_folder = 'front.offers';
    }

    public function index()
    {

        $offers = Offer::paginate(PAGINATION_COUNT);

        return view($this->module_view_folder . '.index', compact('offers')) ;
    }

    public function show($offer_id)
    {
        $offer = Offer::findOrFail($offer_id);

        if (request('id') && request('resourcePath')) {
             $payment_status = $this->getPaymentStatus(request('id'), request('resourcePath'));
              if (isset($payment_status['id'])) { //success payment id -> transaction bank id
                  $showSuccessPaymentMessage = true;
                  $cartItems = \Cart::session(auth()->id())->getContent();
                  foreach ($cartItems as $item) {
                      $order = new Order();
                      $order->total_amount = $item->getPriceSum();
                      $order->offer_id = $item->id;
                      $order->bank_transaction_id = $payment_status['id'];
                      $order->user_id = Auth::user()->id;
                      $order->save();
                      \Cart::session(auth()->id())->remove($item->id);

                  }
                  //save order in orders table with transaction id  = $payment_status['id']
                return view($this->module_view_folder . '.details',compact('offer'))-> with(['success' =>  'تم الدفغ بنجاح']);
            } else {
                $showFailPaymentMessage = true;
                 return view($this->module_view_folder . '.details',compact('offer'))-> with(['fail'  => 'فشلت عملية الدفع']);
            }



        }
        return view($this->module_view_folder . '.details',compact('offer'));
    }

    private function getPaymentStatus($id, $resourcepath)
    {
        $url = "https://test.oppwa.com/";
        $url .= $resourcepath;
        $url .= "?entityId=8a8294174b7ecb28014b9699220015ca";

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_HTTPHEADER, array(
            'Authorization:Bearer OGE4Mjk0MTc0YjdlY2IyODAxNGI5Njk5MjIwMDE1Y2N8c3k2S0pzVDg='));
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'GET');
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);// this should be set to true in production
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        $responseData = curl_exec($ch);
        if (curl_errno($ch)) {
            return curl_error($ch);
        }
        curl_close($ch);
        return json_decode($responseData, true);

    }


    /*

    public function addCustody(Request $request) {

        if ($request->isMethod('post')) {
            $custody = new Custody();
            if ($request->hasFile('photo')) {
                $catogry = $request->input('catogry');
                $cat = Catogry::updateOrCreate(
                                ['catogry' => $catogry], ['$catogry' => $catogry, 'user_id' => Auth::user()->id]);
                $classification = $request->input('classification');

                $classification = Classification::updateOrCreate(
                                ['classification' => $classification], ['$catogry' => $catogry, 'catogry_id' => $cat->id]);

                $custody->serial = $request->input('serial');
                $custody->type = $request->input('type');
                $custody->made_in = $request->input('made_in');
                $custody->made_date = $request->input('made_date');
                $custody->qty = $request->input('qty');
                $custody->exsist = $request->input('exsist');
                $custody->un_exsist = $request->input('un_exsist');
                $custody->good = $request->input('good');
                $custody->unity = $request->input('unity');
                $custody->receipien = $request->input('receipien');
                $custody->receivient = $request->input('receivient');
                $custody->recip_date = $request->input('recip_date');
                $custody->bad_date = $request->input('bad_date');
                $custody->description = $request->input('description');
                $custody->classification_id = $classification->id;
                $custody->photo = $request->file('photo')->getClientOriginalName();
                $request->file('photo')->move(public_path() . "\\images", $custody->photo);
                $custody->save();
            } else {

                $catogry = $request->input('catogry');
                $cat = Catogry::updateOrCreate(
                                ['catogry' => $catogry], ['$catogry' => $catogry, 'user_id' => Auth::user()->id]);
                $classification = $request->input('classification');

                $classification = Classification::updateOrCreate(
                                ['classification' => $classification], ['$catogry' => $catogry, 'catogry_id' => $cat->id]);

                $custody->serial = $request->input('serial');
                $custody->type = $request->input('type');
                $custody->made_in = $request->input('made_in');
                $custody->made_date = $request->input('made_date');
                $custody->qty = $request->input('qty');
                $custody->exsist = $request->input('exsist');
                $custody->un_exsist = $request->input('un_exsist');
                $custody->good = $request->input('good');
                $custody->unity = $request->input('unity');
                $custody->receipien = $request->input('receipien');
                $custody->receivient = $request->input('receivient');
                $custody->recip_date = $request->input('recip_date');
                $custody->bad_date = $request->input('bad_date');
                $custody->description = $request->input('description');
                $custody->classification_id = $classification->id;

                $custody->save();
            }

            return redirect('showCustody');
        }
        $cato = Catogry::all();
        $class = Classification::all();
        $custody = DB::table('custodies')->distinct('type')->groupBy('type')->get();
        $mad_in = DB::table('custodies')->distinct('made_in')->groupBy('made_in')->get();
        $unity = DB::table('custodies')->distinct('unity')->groupBy('unity')->get();
        return view('/Custody.addCustody', compact('cato', 'class', 'custody', 'mad_in', 'unity'));
    }



     */

}
