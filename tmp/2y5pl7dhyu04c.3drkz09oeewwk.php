<div class="container">
    <form class="form-signin" method="POST" action="<?= ($homepath) ?>/register">
        <h2 class="form-signin-heading">Please sign in</h2>
        <?php if ($GET['error'] == 'unknown'): ?>
            <span style="color:red;">An error has occured when processing your registration.  We apologize for the inconvenience, pleas try again.
        <?php endif; ?><br>
        <label for="inputEmail" class="sr-only">Username</label>
        <input type="email" id="inputEmail" name="email" class="form-control" placeholder="Email" required=""
            autofocus="" />
            <?php if ($GET['email'] == 'unavailable'): ?>
                <span style="color:red;">There is already an account registered with this email address.</span><br>
            <?php endif; ?>
        <label for="inputPassword" class="sr-only">Password</label>
        <input type="password" id="inputPassword" name="password" class="form-control" placeholder="Password"
            required="" />
        <label for="inputPassword" class="sr-only">Re-Enter Password</label>
        <input type="password" id="inputPassword" name="vpassword" class="form-control" placeholder="Re-Enter Password"
            required="" />
            <label for="" class="sr-only">First Name</label>
            <input type="firstname" id="" name="firstname" class="form-control" placeholder="John" required="" />
            <label for="" class="sr-only">Last Name</label>
            <input type="lastname" id="" name="lastname" class="form-control" placeholder="Doe" required="" />
            <label for="" class="sr-only">Birthday</label>
            <input type="bday" id="" name="bday" class="form-control" placeholder="yyyy-mm-dd" required="" />
            <label for="" class="sr-only">About You</label>
            <input type="aboutme" id="" name="aboutme" class="form-control" placeholder="I am _ and i like" required="" />
            <label for="" class="sr-only">Profile Picture URL</label>
            <input type="url" id="" name="url" class="form-control" placeholder="image link" required="" />
        <button class="btn mx-5 btn-lg btn-light my-5" type="submit">
            Register
        </button>
    </form>
</div>