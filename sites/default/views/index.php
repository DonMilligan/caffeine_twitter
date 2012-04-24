<? View::insert('includes/header'); ?>

<div class="main">
  <div class="content">
    <div class="content_resize">
      <div class="mainbar">
        <div class="article">
			<h1>Welcome to Caffeine <?= VERSION; ?></h1>
			
			<p>Caffeine is a simple PHP framework that combines modules through the use of routes and events to form an application.</p>
			
			<p><?= Html::a('Caffeine on Github', 'http://github.com/geekforbrains/caffeine', array('target' => '_blank')); ?></p>
			
			<p> Twitter post test here </p>
			
			<p><?= Html::a('Make a Tweet', 'twitter', array('target' => '_blank')); ?></p>
		</div>
		</div>
	</div>
  </div>
</div>
<? View::insert('includes/footer'); ?>
