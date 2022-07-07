<div class="userSection d-flex align-items-center justify-content-center">
    <div class="messages user-message">
        <div class="">
            <div class="livebox container d-flex flex-column">
                <div id="liveChatMessageBox" class="d-flex flex-column" style="overflow-y: auto; height: 75%; ">
                    <!--To be filled by script with web worker-->
                </div>
                <div id="liveChatUserMessageDiv">
                    <textarea id="liveChatUserMessageArea" cols="50" required></textarea>
                    <button id="liveChatUserMessageSend">Send message</button>
                </div>
                <script src="<?= ($homepath) ?>/script/liveChat.js"></script>
                <script>
                    let myChat = new Chat("<?= ($SESSION['id']) ?>");
                    //listener for page to send page content to myChat.sendMessage on button click
                    document.querySelector('#liveChatUserMessageSend').addEventListener('click', (e) => {
                        const msg = document.querySelector('#liveChatUserMessageArea');
                        myChat.sendMessages(msg.value);
                        msg.value = '';
                    });
                </script>
            </div>
        </div>
    </div>
</div>