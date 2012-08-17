represent.mcf.li is a "cool" little *hootenanny* for minecraftforum.net to allow
people with popular topics to embed the faces of the people that have +repped 
the topic. Especially useful for modders and the like.

represent is like a cute wordplay thing. rep as in reputation, represent as in 
representation of all the people that +repped and as in "represent the topics
you love with your face". and like how you can 
["rep" something](http://www.urbandictionary.com/define.php?term=rep)

"citricsquid represents...", "the following people represent optifine..."

## usage

1. Edit topic
2. Add [represent] to the end of the post (will work anywhere, but end is best)
3. Save the post
4. Visit the topic (and wait, depending on how much rep the post has)

Then after the processing\* is finished everyone that accesses the topic -- with
Javascript enabled -- will see a cute little wall of faces, of the people that 
+repped the topic.

[\*]"processing": 

Step 1. System authenticates with minecraftforum.net (loads cached auth data
        from database, hopefully)  
Step 2. System collects a list of all the people that +repped the topic  
Step 3. System adds all these people into the database  
Step 4. System checks with Minotar to see if the avatar exists (and isn't a 
        Steve avatar -- what fun is there in displaying Steve avatars?)  
Step 5. Done!  

Every 24 hours it will allow processing to happen which means more reps added!
Yay!


## code notes

The class used for logging in to minecraftforum.net is truly awful. Sorry :(

Built with [klein.php](https://raw.github.com/chriso/klein.php), using 
[Minotar](http://minotar.net) for the faces and mysql for the database. Maybe
it'd be better to use nosql for this because it doesn't really /need/ anything
specific to mysql, but for now I used mysql because I don't have much-o 
experience with anything else.

## BBCODE
```
<div style="display:none;" id="rep_box_signal"></div>
<script type="text/javascript">
jQuery(function(){
    var rep_box = jQuery('#rep_box_signal').parents('.post_block:first');

    if(jQuery.trim(jQuery(rep_box).find('.post_id').children('a').html()) == "#1") {
        var rep_box_id = rep_box.attr("id");
        var post_id = rep_box_id.split("post_id_")[1];
        var faces_url = "http://represent-mcf-li.dev/post/"+post_id;
        jQuery.ajax({
            url: faces_url,
            timeout: 1400,
            success: function(data){ 
                jQuery(rep_box).after(data); 
            },
            error: function(data){ 
                console.log(data); 
            }
        });
    }
    jQuery('#rep_box_signal').remove();
});
</script>
```

## TO DO

- Page displaying all the reputation a user has given
- Switch to a queue system (using redis) for processing posts and users?
- A list of "top +repped topics"