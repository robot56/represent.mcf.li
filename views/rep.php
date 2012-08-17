<style type="text/css">
    #rep_mcf_li_reputation_faces{
        height:100px;
        margin-bottom:8px;
    }
    
    #rep_mcf_li_info{
        background-image:url('<?php echo APP_URL; ?>assets/img/love.png');
        float:left;
        height:100px;
        padding:10px;
        width:160px;
    }
    
    #rep_mcf_li_reputation_faces_ul{
        float:right;
        margin:0;
        padding:0;
        width:792px;
    }
    
    #rep_mcf_li_reputation_faces .rep_mcf_li_reputation_faces_li{
        background-image:url('<?php echo APP_URL; ?>assets/img/steve_32.png');
        display:block;
        float:left;
        height:32px;
        margin:2px;
        width:32px;
    }
    
    #rep_mcf_li_all_reputation{
        height:32px;
        margin:2px;
        width:98px;
    }
    
    #rep_mcf_li_all_reputation{
        background-color:#F39;
        color:#FFF;
        display:block;
        float:right;
        font-family: Verdana, Geneva, Tahoma, sans-serif;
        font-size:22px;
        height:28px;
        padding:2px 0;
        text-align:center;
        text-decoration:none;
        width:32px;
    }
    
    #rep_mcf_li_all_reputation:hover{
        background-color:#D2DCE1;
        color:#25272D;
    }
</style>
<div id="gotorep"></div>
<div id="rep_mcf_li_reputation_faces">
    <div id="rep_mcf_li_info">
        
    </div>
    <ul id="rep_mcf_li_reputation_faces_ul">
    <?php 
        $users = select_value_from_array($this->users, "custom_head", "1");
        $displayed_users = 0;
        shuffle($users);
        foreach(array_slice($users, 0, 65) as $user) {
            $displayed_users++;
    ?>
        <li class="rep_mcf_li_reputation_faces_li"><a href="http://www.minecraftforum.net/user/<?php echo $user["user_id"]; ?>-" title="<?php echo $user["display_name"]; ?>"><img src="http://minotar.net/helm/<?php echo $user["minecraft_name"]; ?>/32.png"/></a></li>
    <?php } ?>
    <?php if($displayed_users == 65) {?>
        <a id="rep_mcf_li_all_reputation" href="<?php echo APP_URL; ?>reputation/<?php echo $this->post_id; ?>" title="view all <?php echo count($users); ?> +reps">
            +
        </a>
    <?php } ?>
        <div style="clear:both;"></div>
    </ul>
    <div style="clear:both;"></div>
</div>