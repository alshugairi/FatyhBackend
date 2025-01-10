<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Payment Successful</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background-color: #f8f9fa;
        }
        .success-container {
            margin-top: 5%;
            padding: 2rem;
            max-width: 600px;
            background: #fff;
            border-radius: 10px;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.15);
            text-align: center;
        }
        .success-icon {
            width: 80px;
            height: 80px;
            background-color: #28a745;
            color: white;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 auto 1rem;
            font-size: 3rem;
            animation: pop-up 0.5s ease forwards;
        }
        @keyframes pop-up {
            0% {
                transform: scale(0);
            }
            100% {
                transform: scale(1);
            }
        }
        .success-message {
            font-size: 1.5rem;
            font-weight: bold;
            color: #28a745;
        }
        .success-text {
            margin-top: 0.5rem;
            font-size: 1rem;
            color: #6c757d;
        }
        .back-home-btn {
            margin-top: 2rem;
        }
    </style>
</head>
<body>

<div class="container d-flex justify-content-center">
    <div class="success-container">
        <div class="success-icon">
            <i class="bi bi-check-lg"></i>
        </div>
        <div class="success-message">Payment Successful!</div>
        <p class="success-text">Thank you for your payment. Your transaction was completed successfully.</p>
        <a href="{{ route('home') }}" class="btn btn-success back-home-btn">Go to Homepage</a>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
<link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">
</body>
</html>
