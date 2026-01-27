<?php require "../app/views/layouts/header.php"; ?>

<div class="auth-page">

    <div class="auth-box">

        <h2>Welcome Back 👋</h2>
        <p class="auth-subtitle">Login to continue shopping</p>

        <?php if (!empty($_SESSION['error'])): ?>
            <div class="auth-error">
                <?= $_SESSION['error']; unset($_SESSION['error']); ?>
            </div>
        <?php endif; ?>

        <form method="POST" action="?page=login-process">

            <div class="auth-field">
                <input type="email" name="email" placeholder="Email address" required>
            </div>

            <div class="auth-field">
                <input type="password" name="password" placeholder="Password" required>
            </div>

            <button type="submit" class="auth-btn">Login</button>
        </form>

        <p class="auth-footer">
            Don’t have an account?
            <a href="?page=register">Create one</a>
        </p>

    </div>

</div>

<?php require "../app/views/layouts/footer.php"; ?>
