<?php require "../app/views/layouts/header.php"; ?>

<div class="auth-page">
    <div class="auth-box">

        <h2>Create Account ✨</h2>
        <p class="auth-subtitle">Join us and start shopping</p>

        <?php if (!empty($_SESSION['error'])) : ?>
            <div class="auth-error">
                <?= htmlspecialchars($_SESSION['error']); unset($_SESSION['error']); ?>
            </div>
        <?php endif; ?>

        <form method="POST" action="?page=register-process">

            <div class="auth-field">
                <input type="text" name="name" placeholder="Full name" required>
            </div>

            <div class="auth-field">
                <input type="email" name="email" placeholder="Email address" required>
            </div>

            <div class="auth-field">
                <input type="password" name="password" placeholder="Password" required>
            </div>

            <button type="submit" class="auth-btn">Create account</button>
        </form>

        <p class="auth-footer">
            Already have an account?
            <a href="?page=login">Login</a>
        </p>

    </div>
</div>

<?php require "../app/views/layouts/footer.php"; ?>
