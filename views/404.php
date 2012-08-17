<?php require "template/header.php"; ?>
<body>
    <div class="container" id="side">
        <div class="row">
            <div class="span8">
                <h1>404 - Not found</h1>
                <p>
                    <?php echo $this->message; ?>
                </p>
                <p>
                    <a href="<?php echo APP_URL; ?>">&larr; return</a>
                </p>
        </div>
    </div>
</body>