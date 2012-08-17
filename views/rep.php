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
</style>
<div id="rep_mcf_li_reputation_faces">
    <div id="rep_mcf_li_info">
        
    </div>
    <ul id="rep_mcf_li_reputation_faces_ul">
    <?php 
        $users = select_value_from_array($this->users, "custom_head", "1");
        shuffle($users);
        foreach(array_slice($users, 0, 66) as $user) { 
    ?>
        <li class="rep_mcf_li_reputation_faces_li"><a href="http://www.minecraftforum.net/user/<?php echo $user["user_id"]; ?>-" title="<?php echo $user["display_name"]; ?>"><img src="http://minotar.net/helm/<?php echo $user["minecraft_name"]; ?>/32.png"/></a></li>
    <?php } ?>
        <div style="clear:both;"></div>
    </ul>
    <div style="clear:both;"></div>
</div>