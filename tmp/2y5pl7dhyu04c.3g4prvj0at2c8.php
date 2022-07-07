<div class="container">
    <form class="form-signin" method="POST" action="<?= ($homepath) ?>/login">
        <h2 class="form-signin-heading">Please sign in</h2>
        <label for="inputEmail" class="sr-only">Username</label>
        <input type="email" id="inputEmail" name="email" class="form-control" placeholder="Email" required=""
            autofocus="" />
            <?php if ($GET['email'] == 'invalid'): ?>
                <span style="color:red;">Invalid Username, Try Again</span><br>
            <?php endif; ?>
        <label for="inputPassword" class="sr-only">Password</label>
        <input type="password" id="inputPassword" name="password" class="form-control" placeholder="Password"
            required="" />
            <?php if ($GET['password'] == 'invalid'): ?>
                <span style="color:red;">Invalid Password, Try Again.</span>
            <?php endif; ?>
        <button class="btn mx-5 btn-lg btn-light my-5"
        type="submit">
            Sign in
        </button>
    </form>
</div>