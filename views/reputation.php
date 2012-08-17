<?php require "template/header.php"; ?>
<body>
    <div class="container" id="side">
        <div class="row">
            <div class="span6">
                <h1>Reputation for <a href="http://www.minecraftforum.net/index.php?app=forums&module=forums&section=findpost&pid=<?php echo $this->post_id; ?>">this post</a></h1>
                <p>
                    The following users have +repped. If you're listed here but
                    your Minecraft avatar is wrong please read the
                    <a href="<?php echo APP_URL; ?>">FAQ</a>. Click to view
                    their minecraftforum.net profile, hover for their username.
                </p>
                <?php if(count($this->users) >= 1) { ?>
                <div class="faces">
                    <ul>
                        <?php foreach($this->users as $user) { ?>
                        <li><a href="http://www.minecraftforum.net/user/<?php echo $user["user_id"]; ?>-/"><img src="http://minotar.net/helm/<?php echo $user["custom_head"] == 1 ? $user["minecraft_name"] : "samuel"; ?>/64" title="<?php echo $user["minecraft_name"]; ?>"/></a></li>
                        <?php } ?>
                    </ul>
                    <div class="clear"></div>
                </div>
                <?php } else { ?>
                <p>
                    <strong>Error</strong> no reputation is found for this post 
                    yet, it takes up to 2 hours to update so hang tight honey
                    bunch!
                </p>
                <?php } ?>
                <p>
                    <a href="<?php echo APP_URL; ?>">&larr; represent homepage</a>
                </p>
            </div>
        </div>
    </div>
</body>