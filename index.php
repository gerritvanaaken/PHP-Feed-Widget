<?php
// Get functions;
require_once('lib/functions.php'); 
require_once('lib/simplepie.inc');

// Get Flick feed
$feed = new SimplePie('http://api.flickr.com/services/feeds/photos_public.gne?id=44285591@N04&lang=de-de&format=rss_200&limit=5','cache',300);
$feed->handle_content_type();

// Get Twitter feed
$tweets = new SimplePie('http://twitter.com/statuses/user_timeline/57088055.rss','cache',300);
$tweets->handle_content_type();
?>



<!-- Show Flickr Images -->
<div id="flickr">
  <ul>
  <?php for ($i = 0; $i < 5; $i++): ?>
    <li><?php $item = $feed->get_item($i); print $item->get_description(); ?></li>
  <?php endfor; ?>
  </ul>
</div>


<!-- Show Twitter messages -->
<div id="twitter">
  <ul>
  <?php foreach ($tweets->get_items() as $tweet): ?>
    <li>
      <strong><a class="permalink" href="<?php echo $tweet->get_permalink(); ?>"><?php echo reldate(strtotime($tweet->get_date())); ?></a></strong>
      <?php print preparetweet( $tweet->get_description() ); ?>
    </li>
    <?php endforeach; ?>
  </ul>
</div>
