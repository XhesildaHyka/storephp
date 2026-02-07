<?php require "../app/views/layouts/header.php"; ?>

<h2>📦 Checkout</h2>

<form method="POST" action="?page=checkout-process" class="checkout-form">

    <label>Phone number</label>
    <input type="text" name="phone" required placeholder="e.g. +355 69 123 4567">

    <label>Delivery address</label>
    <textarea name="address" required placeholder="Street, city, zip code"></textarea>

    <button type="submit" class="btn-primary btn-block">
        ✅ Place Order
    </button>

</form>

<?php require "../app/views/layouts/footer.php"; ?>
