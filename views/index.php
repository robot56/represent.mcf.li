<?php require "template/header.php"; ?>
<body>
    <div class="container" id="side">
        <div class="row">
            <div class="span8">
                <h1>represent</h1>
                <p>
                    Minecraft Forum reputation visualised! The faces of the 
                    people that have given reputation to a post.
                </p>
                <p>
                    An example of the system in use can be found in the topic 
                    for
                    <a href="http://www.minecraftforum.net/topic/657949-/#rep_post_8603570">defscape by d3fin3d</a>.
                    Alternatively <a href="<?php echo APP_URL; ?>assets/img/represent_screenshot.PNG">here is a screenshot</a>.
                </p>
                <h3>How to use</h3>
                <p>
                    Edit your minecraftforum.net post to include the represent
                    BBCode at the bottom (<code>[represent]</code>) and then 
                    wait a few moments while the faces are generated. 
                    <strong>Only</strong> include the BBCode in the opening post 
                    of a topic, it will not work in a topic reply.
                </p>
                <h3>How does it work</h3>
                <p>
                    The system loads the reputation for the post and looks for
                    Minecraft users with the same names as the people that gave
                    reputation. Javascript is used to fetch and display the 
                    faces which are displayed using the fantastic 
                    <a href="http://minotar.net">Minotar</a>. If there are over 
                    66 faces to serve then the selection is limited to a random
                    66.
                </p>
                <p>
                    The site is built using <a href="https://github.com/chriso/klein.php">klein.php</a>, 
                    you can find the source code on
                    <a href="http://github.com/minecraftforum/represent.mcf.li">github.com/minecraftforum</a>,
                    any improvements are welcome.
                </p>
                <h3>FAQ</h3>
                <p>
                    <strong>Q: Which topics can I use this in?</strong><br/>
                    A: Theoretically any, however we would prefer if you only
                    use it for "content" topics. For example, a topic for a mod,
                    texture pack, map, skin, language pack, server, video, list 
                    of cool eeds or directory of clans is "content", whereas a
                    topic asking for support or discussing the latest update is 
                    not. If you're not sure if your topic is allowed then ask in
                    the 
                    <a href="http://www.minecraftforum.net/topic/1430735-represent-reputation-faces-for-topics/">represent minecraftforum.net topic</a>.
                </p>
                <p>
                    <strong>Q: My face doesn't show up?</strong><br/>
                    A: The reputation faces update every 24 hours, if you have
                    +repped a post you must wait up to 2 hours for your face
                    to show. Also if you use the default skin your face will not be 
                    displayed in the topic.
                </p>
                <p>
                    <strong>Q: How do you determine my Minecraft name?</strong><br/>
                    A: By default your Minecraftforum.net username is used, to 
                    update your Minecraft name <a href="<?php echo APP_URL; ?>username">go here</a>.
                </p>
                <p>
                    <strong>Q: I need help!</strong><br/>
                    A: Further help can be found in the 
                    <a href="http://www.minecraftforum.net/topic/1430735-represent-reputation-faces-for-topics/">represent minecraftforum.net topic</a>.
                </p>
                <h3>People</h3>
                <p>
                    The people that made this possible:
                </p>
                <div class="faces">
                    <ul>
                        <li><a href="http://twitter.com/citricsquid"><img src="http://minotar.net/avatar/citricsquid/64" title="citricsquid: idea/developer"/></a></li>
                        <li><a href="http://www.minecraftforum.net/user/32-puyodead/"><img src="http://minotar.net/avatar/PuyoDead/64" title="PuyoDead: art"/></a></li>
                        <li><a href="http://twitter.com/clone1018"><img src="http://minotar.net/avatar/clone1018/64" title="Special mention: clone1018 for Minotar"/></a></li>
                    </ul>
                    <div class="clear"></div>
                </div>
            </div>
        </div>
    </div>
</body>
</html>