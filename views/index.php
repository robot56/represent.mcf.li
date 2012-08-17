<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8" />
    <title>Reputation &mdash; mcf.li</title>
    <link rel="author" href="humans.txt" />
    <link rel="stylesheet" href="assets/css/bootstrap.css" type="text/css" />
    <link rel="stylesheet" href="assets/css/style.css" type="text/css" />
    <link href='http://fonts.googleapis.com/css?family=Lato:300,400' rel='stylesheet' type='text/css'>
</head>
<body>
    <div class="container" id="side">
        <div class="row">
            <div class="span8">
                <h1>represent</h1>
                <p>
                    Minecraft Forum reputation visualised! The faces of the 
                    people that have given reputation to a post.
                </p>
                <h3>How to use</h3>
                <p>
                    Edit your minecraftforum.net post to include the represent
                    BBCode at the bottom (<code>[represent]</code>) and then 
                    refresh the page and wait a few moments while the faces are 
                    generated. <strong>Only</strong> include the BBCode in the
                    opening post of a topic, do not use it for replies.
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
                    <a href="http://github.com/citricsquid/represent.mcf.li">github.com/citricsquid</a>,
                    any improvements are welcome.
                </p>
                <h3>FAQ</h3>
                <p>
                    <strong>Q: My face doesn't show up?</strong><br/>
                    A: The reputation faces update every 24 hours, if you have
                    +repped a post you must wait up to 24 hours for your face
                    to show. If you use the default skin your face will not be 
                    displayed in the topic.
                </p>
                <p>
                    <strong>Q: How do you determine my Minecraft name?</strong><br/>
                    A: By default your Minecraftforum.net username is used, to 
                    update your Minecraft name <a href="#">go here</a>.
                </p>
                <h3>People</h3>
                <div class="faces">
                    <ul>
                        <li><img src="http://minotar.net/avatar/citricsquid/64" title="citricsquid: idea/developer"/></li>
                        <li><img src="http://minotar.net/avatar/PuyoDead/64" title="PuyoDead: art (soon)"/></li>
                        <li><img src="http://minotar.net/avatar/clone1018/64" title="Special mention: clone1018 for Minotar"/></li>
                    </ul>
                    <div class="clear"></div>
                </div>
            </div>
        </div>
    </div>
</body>
</html>