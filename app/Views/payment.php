<button id="rzp-button1" hidden></button>

<script src="https://checkout.razorpay.com/v1/checkout.js"></script>

<script>

    var options = {
        "key": "<?php echo $key_id ?>",
        "amount": <?php echo $order['amount'] ?>,
        "currency": "INR",
        "name": "AdventureShoppe",
        "description": "Transaction",
        "image": "<?php echo base_url() ?>public/logo.png",
        "order_id": "<?php echo $order['id'] ?>",
        "callback_url": "<?php echo base_url() ?>payment-status",
        "prefill": {
            "name": "<?php echo $customerdata['name'] ?>",
            "email": "<?php echo $customerdata['email'] ?>",
            "contact": "<?php echo $customerdata['number'] ?>"
        },
        "notes": {
            "address": "Razorpay Corporate Office",
            'user_id': "<?php echo $customerdata['user_id'] ?>",
            'order_id': "<?php echo $order['id'] ?>",
            'username': "<?php echo $customerdata['name'] ?>"
        },
        "theme": {
            "color": "#012652"
        },
        "modal": {
            "ondismiss": function () {
                var error_data = {
                    reason: "User dismissed the payment modal",
                    order_id: "<?php echo $order['id'] ?>"
                };
                var error_query = new URLSearchParams(error_data).toString();
                window.location.href = "<?php echo base_url() ?>payment-cancelled" + '/' + error_query;
            }
        },
        "handler": function (response) {
            var payment_data = {
                razorpay_payment_id: response.razorpay_payment_id,
                razorpay_order_id: response.razorpay_order_id,
                razorpay_signature: response.razorpay_signature,
                payment_method: response.method,
                order_id: "<?php echo $order['id'] ?>"
            };

            // Send a POST request to your server
            var xhr = new XMLHttpRequest();
            xhr.open("POST", "<?php echo base_url() ?>payment-status", true);
            xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");

            xhr.onload = function () {
                if (xhr.status === 200) {
                    try {
                        // Parse the response as JSON
                        var response = JSON.parse(xhr.responseText);

                        if (response.code === 200 && response.status === 'success') {
                            window.location.href = "<?php echo base_url() ?>success";
                        } else {
                            console.error("Error: ", response.message);
                        }
                    } catch (e) {
                        console.error("Invalid JSON response:", xhr.responseText);
                    }
                } else {

                    console.error("HTTP Error: ", xhr.status, xhr.statusText);
                }
            };


            xhr.onerror = function () {
                console.error("Request failed. Status: ", xhr.status);
            };

            var data = new URLSearchParams(payment_data).toString();
            xhr.send(data);

        }
    };

    var rzp1 = new Razorpay(options);

    rzp1.on('payment.failed', function (response) {
        var error_data = {
            code: response.error.code,
            description: response.error.description,
            source: response.error.source,
            step: response.error.step,
            reason: response.error.reason,
            order_id: response.error.metadata.order_id,
            payment_id: response.error.metadata.payment_id
        };

        var error_query = new URLSearchParams(error_data).toString();
        window.location.href = "<?php echo base_url() ?>payment-failed/" + error_query;
    });

    document.getElementById('rzp-button1').onclick = function (e) {
        rzp1.open();
        e.preventDefault();
    };

    document.getElementById('rzp-button1').click();



</script>