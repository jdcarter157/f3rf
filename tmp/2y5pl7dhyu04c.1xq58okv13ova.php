<div class="d-flex flex-column justify-content-center">
    <div class="my-5 d-flex flex-column align-items-center">
        <h2>Make a Post</h2>
        <div class="jumbotron my-5 p-4">
            <h2>Whats On Your Mind?</h2>
            <br>
            <form action='<?= ($homepath) ?>/newsfeed' method="POST">
                <label for="feed">Post:
                </label>
                <div>
                    <textarea class="posting" row='10' col='70' id="feed" name="feed" minlength="1"
                        placeholder="enter post here"></textarea>
                </div>
                <br>
                <input type="submit" value="Submit" id="message_button">
            </form>
        </div>
        <h2>Current Feed</h2>
    </div>

    <?php foreach (($result?:[]) as $item): ?>
        <div class="container">
            <div class="d-flex justify-content-between">
                <img class="small-post-profile" src="<?= ($item['image_URL']) ?>">
                <div class="flex-fill">
                    <div class="d-flex flex-column container flex-fill">
                        <p class="post-author">
                           <strong><?= ($item['first_name']) ?></strong></a>
                        </p>
                        <p class="post-content"><?= ($item['content']) ?></p>
                        <p class="post-created">
                            <?= (date_format(date_create($item['created']), "m/d/Y"))."
" ?>
                        </p>
                        <?php if ($item['user_id']== $SESSION['id']): ?>
                            <form action='<?= ($homepath) ?>/removepost/<?= ($item["post_id"]) ?>' method='post'>
                            <input type="submit" value="delete" id="delete_post" name="delete_post">
                            </form>
                        <?php endif; ?>
                        <?php if ($item['user_id']== $SESSION['id']): ?>
                            <form action='<?= ($homepath) ?>/editpost/<?= ($item["post_id"]) ?>' method="post">
                           
                           
                            <div id="editpost" style="display: none">
                                <input type="text" id="edit" name="edit">
                                <input type="submit" value="submit changes" >
                                
                            </div>
                            <button type="reset" id="edit_text" name="edit_text" onclick="showTextbox()">Edit Post</button>

                            </form>
                          
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        </div>
    <?php endforeach; ?>
</div>
<script>
    function showTextbox() {
    var x = document.getElementById("editpost");
      if (x.style.display === "none") {
          x.style.display = "block";}
          else{x.style.display="none"}
        }
</script>