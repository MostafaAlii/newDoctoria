<!-- resources/views/payment.blade.php -->
<!DOCTYPE html>
<html>
<head>
    <title>Fawry Payment Test</title>
</head>
<body>
    <h1>Fawry Payment Test</h1>
    <form action="{{route('fawry')}}" method="POST">
        @csrf
        <label for="merchantRefNum">Merchant Ref Num:</label>
        <input type="text" name="merchantRefNum" id="merchantRefNum" required><br><br>

        <label for="customerProfileId">Customer Profile ID:</label>
        <input type="text" name="customerProfileId" id="customerProfileId" required><br><br>

        <label for="amount">Amount:</label>
        <input type="text" name="amount" id="amount" required><br><br>

        <label for="customerMobile">Customer Mobile:</label>
        <input type="text" name="customerMobile" id="customerMobile" required><br><br>

        <label for="customerEmail">Customer Email:</label>
        <input type="email" name="customerEmail" id="customerEmail" required><br><br>

        <label for="description">Description:</label>
        <input type="text" name="description" id="description" required><br><br>

        <label for="cardNumber">Card Number:</label>
        <input type="text" name="cardNumber" id="cardNumber" required><br><br>

        <label for="expiryYear">Expiry Year:</label>
        <input type="text" name="expiryYear" id="expiryYear" required><br><br>

        <label for="expiryMonth">Expiry Month:</label>
        <input type="text" name="expiryMonth" id="expiryMonth" required><br><br>

        <label for="cvv">CVV:</label>
        <input type="text" name="cvv" id="cvv" required><br><br>

        <button type="submit">Pay</button>
    </form>
</body>
</html>