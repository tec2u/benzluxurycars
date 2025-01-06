<?php

namespace App\Http\Controllers;

use App\Models\Reservation;
use Illuminate\Http\Request;
use Srmklive\PayPal\Services\PayPal as PayPalClient;

class PaymentController extends Controller
{
    public function createPayment($data)
    {
        $provider = new PayPalClient;
        $provider->setApiCredentials(config('paypal'));
        $provider->getAccessToken();

        $order = $provider->createOrder([
            'intent' => 'CAPTURE',
            'purchase_units' => [
                [
                    'amount' => [
                        'currency_code' => 'USD',
                        'value' => floatval($data->total_price),
                    ],
                    'custom_id' => 'Pedido12345',
                ],
            ],
            'application_context' => [
                'brand_name' => 'Minha Loja', // Nome da sua loja
                'return_url' => route('confirmPayment', ['id' => $data->id]),
                'cancel_url' => route('home'),
            ],
        ]);
        // Retorne o link para o usuário completar o pagamento
        foreach ($order['links'] as $link) {
            if ($link['rel'] === 'approve') {
                $response = ['payment_link' => $link['href'], 'message' => 'success'];
                return $response;
            }
        }
        $response = ['message' => 'error'];
        return $response;
    }

    public function confirmPayment(Request $request, $id)
    {
        $provider = new PayPalClient;
        $provider->setApiCredentials(config('paypal'));
        $provider->getAccessToken();

        $capture = $provider->capturePaymentOrder($request->query('token'));
        $reservation = Reservation::find($id);
        if ($capture['status'] === 'COMPLETED') {
            $detail = 'Order payment completed successfully';
            $message = 'Success';
            $reservation->status = 'Paid';
            $reservation->payment_status = 'Paid';
            $reservation->save();
            return view('payment.payment_response', compact('detail', 'message'));
        } else {
            $reservation->status = 'Cancelled';
            $reservation->payment_status = 'Cancelled';
            $reservation->save();
            $detail = 'There was a problem trying to pay for the order';
            $message = 'Failed';
        }

        return view('payment.payment_response', compact('detail', 'message'));
    }
}
