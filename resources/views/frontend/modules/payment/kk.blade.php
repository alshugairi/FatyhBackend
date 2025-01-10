<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Process Payment</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
    <script src="https://checkout.kashier.io/js/kashier-checkout.js"></script>
</head>
<body class="bg-gray-100">
<div class="min-h-screen flex items-center justify-center">
    <div class="bg-white p-8 rounded-lg shadow-md w-96">
        <h1 class="text-2xl font-bold mb-6 text-center">Complete Payment</h1>
        <div class="mb-4 text-center">
            <p class="text-gray-600">Amount: $300</p>
            <p class="text-gray-600">Order ID: 300</p>
        </div>
        <button id="payButton"
                class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded w-full">
            Pay Now
        </button>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        document.getElementById('payButton').addEventListener('click', function() {
            Kashier.init({
                merchantId: "MID-30169-606",
                amount: "300",
                currency: "USD",
                orderId: "300",
                displayLang: "en",
                merchantRedirect: "{{ route('payment.kashier.callback', 300) }}",
                allowedMethods: ["card", "wallet"],
                sandbox: true, // Set to false in production
                callback: function(response) {
                    if (response.status === "SUCCESS") {
                        window.location.href = "{{ route('payment.kashier.callback', 300) }}?" +
                            "paymentStatus=" + response.status +
                            "&merchantOrderId=" + response.orderId +
                            "&paymentId=" + response.paymentId +
                            "&signature=" + response.signature;
                    } else {
                        alert("Payment failed: " + response.errors.join(", "));
                    }
                }
            });
        });
    });
</script>
</body>
</html>
