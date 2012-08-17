<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8" />
    <title>Username update &mdash; represent.mcf.li</title>
    <link rel="author" href="humans.txt" />
    <link rel="stylesheet" href="assets/css/bootstrap.css" type="text/css" />
    <link rel="stylesheet" href="assets/css/style.min.css" type="text/css" />
    <link href='http://fonts.googleapis.com/css?family=Lato:300,400' rel='stylesheet' type='text/css'>
    <script type="text/javascript">

    var _gaq = _gaq || [];
    _gaq.push(['_setAccount', 'UA-29439846-15']);
    _gaq.push(['_trackPageview']);

    (function() {
        var ga = document.createElement('script'); ga.type = 'text/javascript'; ga.async = true;
        ga.src = ('https:' == document.location.protocol ? 'https://ssl' : 'http://www') + '.google-analytics.com/ga.js';
        var s = document.getElementsByTagName('script')[0]; s.parentNode.insertBefore(ga, s);
    })();

    </script>
</head>
<body>
    <div class="container" id="side">
        <div class="row">
            <div class="span8">
                <?php if(isset($this->status)) { ?>
                <div class="alert alert-<?php echo $this->status['type']; ?>">
                    <?php echo $this->status['message']; ?>
                </div>
                <?php } ?>
                <h1>username update</h1>
                <p>
                    <strong>Step 1.</strong><br/>
                    Login to your minecraftforum.net account, go to your 
                    <a target="_blank" href="http://www.minecraftforum.net/index.php?app=core&module=usercp#field_11">profile settings</a>
                    and update the "Minecraft" profile field to match your 
                    minecraft.net username. <strong>note</strong> these names
                    are case sensitive, if your username is "citricsquid" you
                    must type "citricsquid", "CitricSquid" will not work.
                </p>
                <p>
                    <strong>Step 2.</strong><br/>
                    Enter your minecraftforum.net profile link in the box below
                    and click "update". Your profile link can be found by 
                    clicking "My Profile" under the settings drop down, or by
                    clicking your username in the navigation bar. A profile link
                    looks like this: <br/>
                    <code>http://www.minecraftforum.net/user/4-citricsquid/</code>
                </p>
                <h3>Profile link</h3>
                <form class="well" method="post" action="<?php echo APP_URL; ?>username">
                    <fieldset>
                    <div class="control-group">
                        <h3 style="padding-bottom:10px;">minecraftforum.net profile url</h3>
                        <div class="controls">
                            <input type="text" class="input-xxlarge" id="url" name="url" placeholder="http://www.minecraftforum.net/user/4-citricsquid/">
                        </div>
                    </div>
                    <button type="submit" class="btn btn-large">Update Username</button>
                    </fieldset>
                </form>
                <p>
                    <a href="<?php echo APP_URL; ?>">&larr; go back</a>
                </p>
            </div>
        </div>
    </div>
</body>