<?php
namespace sirJuni\Framework\Components;

require_once __DIR__ . "/../../vendor/autoload.php";

use Razorpay\Api\Api;

class PaymentGateway {
    private $api_key;
    private $api_secret;
    private $api;

    public function __construct($api_key, $api_secret) {
        $this->api_key = $api_key;
        $this->api_secret = $api_secret;

        // create an instance of razorpay API
        $this->api = new Api($this->api_key, $this->api_secret);
    }

    public function order($order_data) {
        if (array_key_exists('amount', $order_data) and array_key_exists('currency', $order_data)) {

            // create an order and return the response
            $order = $this->api->order->create($order_data);

            // return response
            return $order;
        }
        else {
            echo("Amount | Currency is missing from order data");
            exit();
        }
    }

    public function getIntegrationCode($context) {
        // store all the code in HERE doc
        extract($context);
        $code = <<<CODE
           <script src="https://checkout.razorpay.com/v1/checkout.js"></script>
            <script>
            var options = {
                "key": "$API_KEY",
                "amount": "$price;",
                "currency": "INR",
                "name": "$COMPANY_NAME",
                "description": "Test Transaction",
                "image": "$COMPANY_LOGO_URL",
                "order_id": "$order_id",
                "callback_url": "$success_callback_url",
                "prefill": {
                    "name": "$username",
                    "email": "$email",
                    "contact": "$phone"
                },
                "notes": {
                    "address": "Razorpay Corporate Office"
                },
                "theme": {
                    "color": "#3399cc"
                }
            };
            var rzp1 = new Razorpay(options);
            rzp1.on('payment.failed', function (response){
                document.location.href = "$failure_callback_url" + "?code=" + response.error.code + "&reason=" + response.error.reason + "&step=" + response.error.step + "&source=" + response.error.source + "&order_id=" + response.error.metadata.order_id + "&payment_id=" + response.error.metadata.payment_id;
            });
            document.getElementById('rzp-button1').onclick = function(e){
                rzp1.open();
                e.preventDefault();
            }
            </script>
        CODE;

        // return this code
        return $code;
    }
}
?>