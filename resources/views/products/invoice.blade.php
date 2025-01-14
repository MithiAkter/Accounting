<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Invoice</title>
    <style>
        /* Style your invoice as needed */
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 20px;
        }
        .container {
            width: 80%;
            margin: 0 auto;
        }
        h1 {
            text-align: center;
            margin-bottom: 20px;
        }
        .invoice-details {
            margin-bottom: 30px;
        }
        .invoice-details p {
            font-size: 16px;
        }
        .table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
        }
        .table th, .table td {
            border: 1px solid #ddd;
            padding: 8px;
            text-align: left;
        }
        .total {
            font-size: 18px;
            font-weight: bold;
            text-align: right;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>Invoice</h1>

        <div class="invoice-details">
            <p><strong>Customer:</strong> {{ $customer->name }}</p>
            <p><strong>Product:</strong> {{ $product->product_name }}</p>
            <p><strong>Quantity:</strong> {{ $buyProduct->product_qty }}</p>
            <p><strong>Total Price:</strong> ${{ number_format($product->per_unit_price * $buyProduct->product_qty, 2) }}</p>
            <p><strong>Paid:</strong> ${{ number_format($buyProduct->payment, 2) }}</p>
            <p><strong>Due Payment:</strong> ${{ number_format($buyProduct->due_payment, 2) }}</p>
        </div>

        <table class="table">
            <thead>
                <tr>
                    <th>Product</th>
                    <th>Quantity</th>
                    <th>Unit Price</th>
                    <th>Total Price</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td>{{ $product->product_name }}</td>
                    <td>{{ $buyProduct->product_qty }}</td>
                    <td>${{ number_format($product->per_unit_price, 2) }}</td>
                    <td>${{ number_format($product->per_unit_price * $buyProduct->product_qty, 2) }}</td>
                </tr>
            </tbody>
        </table>

        <div class="total">
            <p><strong>Total Due Payment:</strong> ${{ number_format($buyProduct->due_payment, 2) }}</p>
        </div>
    </div>
</body>
</html>
