<?php 

namespace App\Extensions\Payments;

use Braintree_Transaction;

class BrainTreePayment
{
	public function payment($price, $paymentMethod)
	{
		$result = Braintree_Transaction::sale([
            'amount'            => $findSubs['price'],
            'paymentMethodNonce'=> $request->getParam('payment_method_nonce'),
            'options'           => [
                'submitForSettlement'   => true,
            ],
        ]);

        return $result;
	}

	public function recordPayment($userId, $subsId, $fail, $transId = null)
	{
		$payments = new \App\Models\Payments\Payment;

		$data = [
			'user_id'	=> $userId,
			'subs_id'	=> $subsId,
		];

		if ($fail = 1) {
			$payment = [
				'fail'	=> 1,
			];	
		} else {
			$payment = [
				'fail'			=> 0,
				'transaction_id'=> $transId
			];
		}

		$result = array_merge($data, $payment);

		$payments->updateOrCreate($result, 'user_id', $userId);
	}
}