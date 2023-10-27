<?php
require_once __DIR__ . "../../vendor/autoload.php";

namespace sirJuni\Framework\Components;

use Razorpay\Api\Api;

class PaymentGateway {
    private $api_key;
    private $api_secret;
    private $api;

    public function __construct($api_key, $api_secret, $success_handler = fn (resp) => header("location: success.php"), $failure_handler = fn (resp) => header("location: failure.php")) {
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

    public function getIntegrationCode() {
        // store all the code in HERE doc
        $code = <<<CODE
            <script src="https://checkout.razorpay.com/v1/checkout.js"></script>
            <script>
            var options = {
                "key": "<?= API_KEY; ?>", // Enter the Key ID generated from the Dashboard
                "amount": "<?= $price; ?>", // Amount is in currency subunits. Default currency is INR. Hence, 50000 refers to 50000 paise
                "currency": "INR",
                "name": "<?= COMPANY_NAME; ?>",
                "description": "Test Transaction",
                "image": "<?= COMPANY_LOGO_URL; ?>",
                "order_id": "<?= $order_id; ?>", //This is a sample Order ID. Pass the `id` obtained in the response of Step 1
                "callback_url": "<?= $callback_url; ?>",
                "prefill": {
                    "name": "<?= $username; ?>,
                    "email": "<?= $email; ?>",
                    "contact": "<?= $phone; ?>"
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
                alert(response.error.code);
                    alert(response.error.description);
                    alert(response.error.source);
                    alert(response.error.step);
                    alert(response.error.reason);
                    alert(response.error.metadata.order_id);
                    alert(response.error.metadata.payment_id);(response.error.step);
                    alert(response.error.reason);
                    alert(response.error.metadata.order_id);
                    alert(response.error.metadata.payment_id);
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