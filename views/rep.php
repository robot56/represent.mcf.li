<style type="text/css">
    #rep_mcf_li_reputation_faces{
        min-height:32px;
        max-height:100px;
        margin-bottom:8px;
    }
    
    #rep_mcf_li_info{
        float:left;
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
        background-image:url('/assets/img/steve_32.png');
        display:block;
        float:left;
        height:32px;
        margin:2px;
        width:32px;
    }
</style>
<div id="rep_mcf_li_reputation_faces">
    <div id="rep_mcf_li_info">
        <a href="#">view all rep</a> <a href="#">add your face</a>
    </div>
    <ul id="rep_mcf_li_reputation_faces_ul">
    <?php 
        $users = select_value_from_array($this->users, "custom_head", "1");
        shuffle($users);
        foreach(array_slice($users, 0, 66) as $user) { 
    ?>
        <li class="rep_mcf_li_reputation_faces_li"><a href="http://www.minecraftforum.net/user/<?php echo $user["user_id"]; ?>-" title="<?php echo $user["display_name"]; ?>"><img src="http://minotar.net/avatar/<?php echo $user["minecraft_name"]; ?>/32.png"/></a></li>
    <?php } ?>
        <div style="clear:both;"></div>
    </ul>
    <div style="clear:both;"></div>
</div>