<?php
View::insert('includes/header');
?>
<div class="main">
  <div class="content">
    <div class="content_resize">
      <div class="mainbar">
        <div class="article">
          <h2><span><?php echo count($posts);?></span> Responses</h2>
          <div class="clr"></div>
         <?php  foreach($posts as $tweet){
         			echo '<div class="comment"> <a href="#"><img src="images/userpic.gif" width="40" height="40" alt="" class="userpic" /></a>
           				 <p><a href="#">'.$tweet->name.'</a> Says:<br />
             			 '.date( "F j, Y, g:i a", $tweet->updated_at).'</p>
           				 <p>'.$tweet->tweet.'</p>
          				</div>'; } 
         ?>
        </div>
        <div class="article">
          <h2><span>Leave a</span> Tweet</h2>
          <div class="clr"></div>
          <?= Html::form()->open('twitter/tweet', 'post'); ?>
            <ol>
              <li>
                <label for="name">Name (required)</label><br />
                <input id="name" name="name" class="text" />
              </li>
              <li>
                <label for="email">Email Address (required)</label><br />
                <input id="email" name="email" class="text" />
              </li>
              <li>
                <label for="subject">Subject</label><br />
                <input id="subject" name="subject" class="text" />
              </li>
              <li>
                <label for="tweet">Your Tweet</label><br />
                <textarea id="tweet" name="tweet" rows="8" cols="50"></textarea>
              </li>
              <li><br />
                <input type="image" name="imageField" id="imageField" src="images/submit.gif" class="send" />
                <div class="clr"></div>
              </li>
            </ol>
          <?= Html::form()->close(); ?>
        </div>
      </div>
      <div class="clr"></div>
    </div>
  </div>
</div>
<?php
View::insert('includes/footer'); 
?>
