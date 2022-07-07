<div class='d-flex justify-content-center align-items-center my-5'>
    <button class="btn mx-5 btn-lg btn-light" onclick="location.href = 'friendlist';">
        My Friends
    </button>
    <button class="btn mx-5 btn-lg btn-light" onclick="location.href = 'pendingrequest';">
        Pending Requests
    </button>
    <button class="btn mx-5 btn-lg btn-light" onclick="location.href = 'friendsearch';">
        Find Friends
    </button>
</div>
<div class='d-flex justify-content-center align-items-center my-5'>
    <form method="GET">
        <input class="searching" type="text" placeholder="Firstname" name="search_first_name">
        <input class="searching" type="text" placeholder="Lastname" name="search_last_name">
        <button class="btn mx-5 btn-lg btn-light" type="submit">Search Results</button>
    </form>
</div>
<div>
    <h2 class='d-flex justify-content-center align-items-center my-5'>Find Friends</p>
</div>
</div>
<div class="d-flex justify-content-around">
    <div class="col-md-8">
        <div class="people-nearby ">
            <?php if (isset($result)): ?>
                <?php foreach (($result?:[]) as $item): ?>
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
                            </div>
                            </form >
                            <div class="col col-lg-2">
                                <form method="POST" action="<?= ($homepath) ?>/friendadd">
                                    <button name="friend_id" class="btn btn-secondary danger-button"
                                        value="<?= ($item['user_id']) ?>">add friend</button>
                                </form>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
            <?php endif; ?>
        </div>
    </div>
</div>