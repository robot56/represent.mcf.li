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
                    Minecraft reputation visualised! I will make a proper
                    explanation of this sometime.
                </p>
                <h3>How to use</h3>
                <p>
                    Edit your minecraftforum.net post to include the following
                    BBCode at the base of the post:
                </p>
                <p>
                    <code>[represent]</code>
                </p>
                <p>
                    Then refresh the page and wait a few moments while the faces
                    are generated.
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
                <h3>People</h3>
                <div class="faces">
                    <ul>
                        <li><img src="http://minotar.net/avatar/citricsquid/64" title="citricsquid: idea/developer"/></li>
                        <li><img src="http://minotar.net/avatar/PuyoDead/64" title="PuyoDead: art"/></li>
                        <li><img src="http://minotar.net/avatar/clone1018/64" title="Special mention: clone1018 for Minotar"/></li>
                    </ul>
                    <div class="clear"></div>
                </div>
            </div>
        </div>
    </div>
</body>
</html>