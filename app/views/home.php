<?php
use App\services\Helpers;
$helper = new Helpers;
$helper->renderView('app/views/header.php',[]);
?>

<div class="container">
	<p>Lorem ipsum, dolor sit amet consectetur adipisicing elit. Repellat eligendi quaerat cumque molestiae enim est voluptatibus inventore ullam? Ullam optio aut autem alias tempora laboriosam magnam voluptatem iste, excepturi commodi praesentium quae ducimus, quis placeat nam culpa molestias officiis dolorum quasi omnis nostrum eos soluta cum? Quibusdam eveniet quos animi, pariatur aut cumque commodi praesentium assumenda minima tenetur quidem optio!</p>
	<p>Lorem ipsum dolor sit amet consectetur adipisicing elit. Illo sint, laborum mollitia quia, molestiae, fugiat reiciendis necessitatibus cumque placeat tenetur amet vitae maxime. Sit natus ab, quos ipsa vel sed ipsam possimus in quibusdam odio. Quidem perspiciatis, nisi maxime asperiores incidunt dicta debitis? Sequi dolorum praesentium officia perspiciatis ipsa, minima exercitationem. Iste nam officia qui doloremque dignissimos inventore natus ipsam commodi quasi exercitationem, perferendis dolor, aliquam omnis animi cumque nemo voluptatem aspernatur ipsum consequuntur cum corporis suscipit asperiores fuga. Eos non perferendis quae reiciendis saepe dolore id adipisci optio aspernatur! Animi similique eligendi quibusdam, a, repellat odio dolore neque deleniti pariatur dolorem quod illum nobis, repudiandae consequuntur fuga numquam dolorum laborum impedit. Quis voluptate sequi facere harum delectus dolorum natus.</p>
</div>

<div class="container" id="latestPosts">
	<h3>Derniers Posts !</h3>
	<?php foreach ($lastThreePosts as $post) {
		$title = htmlspecialchars($post->getTitle());
		// Suppress accents with this font.
		$title = preg_replace('/[\p{M}]/u', '', Normalizer::normalize($title, Normalizer::FORM_D));
		$created_at = htmlspecialchars($post->getFrenchCreationDate());
		$chapo = htmlspecialchars($post->getChapo());
		$imageData = $post->getImageData();
		$imageType = $post->getImageType();
		$helper->renderView('app/views/post-frame.php',array(
			'post' =>$post,
			'title' =>$title,
			'created_at' =>$created_at,
			'chapo' =>$chapo,
			'imageData' =>$imageData,
			'imageType' =>$imageType
		));
	}?>
</div> 

<div class="container" id="CV">
	<h3>Curriculum Vitae</h3>
	<a href="cv.pdf" download>Download CV (PDF)</a>
</div>

<div class="container" id="contact">
	<h3>Formulaire de contact</h3>
	<p>Lorem ipsum dolor, sit amet consectetur adipisicing elit. Dolorum corporis magnam et sequi temporibus, ratione necessitatibus, molestiae commodi ipsam labore vero, itaque optio! Perferendis maiores inventore fuga iste eos quos!</p>
	<?php $helper->renderView('app/views/contact.php',[]); ?>
</div>

<?php $helper->renderView('app/views/footer.php',[]); ?>
