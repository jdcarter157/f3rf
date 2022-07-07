<div id="container" class="container mb-5 p-4">
    <div id="hh">
        <p>
            <?= ($msgWith[0]['first_name'])."
" ?>
            <?= ($msgWith[0]['last_name']) ?></p>

    </div>
    <div id="bdy">
        <?php foreach (($msg?:[]) as $item): ?>
            <?php if ($item['user_1']==$SESSION['id']): ?>
                
                    <div class="userSection">
                        <div class="messages user-message">
                            <?= ($item['msg_content'])."
" ?>
                            <div class="timestamp-user">
                                <small>
                                    Sent:
                                    <?= (date_format(date_create($item['sent']), "m/d/Y H:i:s")) ?></small>
                            </div>
                        </div>
                        <div class="seperator"></div>
                    </div>
                
                <?php else: ?>
                    <div class="replySection">
                        <div class="messages reply-message">
                            <?= ($item['msg_content'])."
" ?>
                            <div class="timestamp-reply">
                                <small>
                                    Received:
                                    <?= (date_format(date_create($item['sent']), "m/d/Y H:i:s")) ?></small>
                            </div>
                        </div>
                        <div class="seperator"></div>
                    </div>
                
            <?php endif; ?>
        <?php endforeach; ?>
    </div>
    <form method="post" action="<?= ($msgWith[0]['user_id']) ?>/dmSend/" id="user_inputs" class="mt-3">
        <input type="text" id="userInput" name="message" required autofocus>
        <input type="submit" id="send" value="Send">
    </form>

</div>
<script>
    chatwindow = document.querySelector('#bdy');
    chatwindow.scrollTo(0, chatwindow.scrollHeight);
</script>