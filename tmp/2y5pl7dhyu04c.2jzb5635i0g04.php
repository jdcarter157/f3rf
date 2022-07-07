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
    <form method="GET" action="<?= ($homepath) ?>/searchfriendlist">
        <input class="searching" type="text" placeholder="Firstname" name="search_first_name">
        <input class="searching" type="text" placeholder="Lastname" name="search_last_name">
        <button class="btn mx-5 btn-lg btn-light" type="submit">Search Results</button>
    </form>
</div>
<div>
    <h2 class='d-flex justify-content-center align-items-center my-5'>My Friends</p>
</div>


<div class="d-flex justify-content-around">
    <div class="col-md-8">
        <div class="people-nearby">
            <?php if (isset($result)): ?>
                <?php foreach (($result?:[]) as $item): ?>
                    <div class="whitelines nearby-user search-result-person">
                        <div class="row  align-items-center">
                            <div class="col-md-2 col-sm-2 text-center">
                                <img src="<?= ($item['image_URL']) ?>" alt="user" class="profile-photo-lg" />
                            </div>
                            <div class="col-md-7 col-sm-7">

                                <form action="<?= ($homepath) ?>/profile/<?= ($item['user_id']) ?>" method="get">
                                    <div class="d-flex justify-content-between"><button type="submit" class="profile-link">
                                        <h5><?= ($item['first_name'])."
" ?>
                                            <?= ($item['last_name']) ?></h5>
                                            
                                    </button>
                                    <p><?= ($item['about']) ?></p>
                                </div>
                                </form>

                            </div>
                            

                            <div class="col col-lg-2 text-right">
                                <form method="get" action="<?= ($homepath) ?>/dm/<?= ($item['user_id']) ?>">


                                    <button type="submit" class="btn btn-secondary message-button">
                                        Message

                                    </button>
                                </form>
                                <form method="post" action="<?= ($homepath) ?>/friendlist">
                                    <button type="submit" class="btn btn-secondary danger-button" name="remove_friend"
                                        value="<?= ($item['user_id']) ?>">
                                        Unfriend
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
            <?php endif; ?>
        </div>
    </div>
</div>