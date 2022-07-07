<div class='d-flex justify-content-center align-items-center my-5'>
    <button class="btn mx-5 btn-lg btn-primary" id="friend_buttons" onclick="location.href = 'friendlist';">My
        Friends</button>
    <button class="btn mx-5 btn-lg btn-primary" id="friend_buttons" onclick="location.href = 'pendingrequest';">Pending
        Requests</button>
    <button class="btn mx-5 btn-lg btn-primary" id="friend_buttons" onclick="location.href = 'friendsearch';">Find
        Friends</button>
</div>
<div class="container d-flex justify-content-center">
    <div class="row container d-flex justify-content-center">
        <div class="col-md-8">
            <div class="people-nearby">
                <!-- PENDING AWAITING YOUR APPROVAL -->
                <div>
                    <h2 class='d-flex justify-content-center align-items-center my-5'>Pending Your Approval</p>
                </div>
                                <?php foreach (($result?:[]) as $item): ?>
                    <?php if ($item['requested'] == 0): ?>
                        <div class="nearby-user whitelines">
                            <div class="row  align-items-center">
                                <div class="col-md-2 col-sm-2">
                                    <img src="<?= ($item['image_URL']) ?>" alt="user" class="profile-photo-lg">
                                </div>
                                <div class="col-md-7 col-sm-7">
                                    <form action="<?= ($homepath) ?>/profile/<?= ($item['user_id']) ?>" method="get">
                                        <button type="submit" class="profile-link">
                                            <h5><?= ($item['first_name'])."
" ?>
                                                <?= ($item['last_name']) ?></h5>
                                        </button>
                                    </form>
                                </div>
                                <div class="col col-lg-2">
                                    <form action="<?= ($homepath) ?>/pendingrequest" method="post">
                                        <button type="submit" name="pending_request" value="<?= ($item['user_id']) ?>"
                                            class="btn btn-secondary">
                                            Confirm
                                        </button>

                                    </form>
                                    <form action="<?= ($homepath) ?>/rejectrequest" method="post">
                                        <button type="submit" name="rejected_request" value="<?= ($item['user_id']) ?>"
                                            class="btn btn-secondary">
                                            Reject
                                        </button>
                                    </form>

                                </div>
                            </div>
                        </div>
                    <?php endif; ?>
                <?php endforeach; ?>
                <!-- PENDING YOU SENT -->
                <div>
                    <h2 class='d-flex justify-content-center align-items-center my-5'>Requests You've Sent</p>
                </div>
                
                <?php foreach (($result?:[]) as $item): ?>
                    <?php if ($item['requested'] == 1): ?>
                        <div class="nearby-user whitelines">
                            <div class="row">
                                <div class="col-md-2 col-sm-2">
                                    <img src="<?= ($item['image_URL']) ?>" alt="user" class="profile-photo-lg">
                                </div>
                                <div class="col-md-7 col-sm-7">
                                    <form action="<?= ($homepath) ?>/profile/<?= ($item['user_id']) ?>" method="get">
                                        <button type="submit" class="profile-link">
                                            <h5><?= ($item['first_name'])."
" ?>
                                                <?= ($item['last_name']) ?></h5>
                                        </button>
                                    </form>
                                </div>
                                <div class="col col-lg-2">
                                    <form action="<?= ($homepath) ?>/cancelrequest" method="post">
                                        <button type="submit" name="cancel_request" value="<?= ($item['user_id']) ?>"
                                            class="btn btn-secondary">
                                            Cancel
                                        </button>
                                    </form>

                                </div>
                            </div>
                        </div>
                    <?php endif; ?>
                <?php endforeach; ?>
            </div>
        </div>
    </div>
</div>