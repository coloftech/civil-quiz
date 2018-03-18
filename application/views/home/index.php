
<div class="col-md-9 post-content">
	<div class="item2" id="post-announce">
	</div>
	<div class="item2" id="post-sticky">
	</div>
	<?php 
	if (isset($posts)) {
		# code...
		if (is_array($posts)) {
			# code...
			foreach ($posts as $key) {
				# code...

									$listallcat = $this->post_model->listpostcategory($key->page_id);

									if (is_array($listallcat)) {
										# code...

										$total = count($listallcat);
										$cat = '';
										foreach ($listallcat as $key2) {
										$name = $this->post_model->categoryname_by_id($key2->category_id);
										$cat[] = $name;
										}
									}
									if(count($cat) > 0){
										if (is_array($cat)) {
											# code...
										$post_category = implode(', ',$cat);
										}else{

										$post_category = $cat;
										}


									}else{ $post_category='';}
				?>
		<div class="item">
		<?php if(!empty($key->imgs)){

		echo '<div class="col-md-3 featured-img-s"><a href="'.site_url('ref=home&com=read_post&q=').$key->slug.'"><img src="'.urldecode($key->imgs).'"></a></div>';
			}else{?>
		<div class="col-md-3 featured-img-s"><a href="<?=site_url('ref=home&com=read_post&q=');?><?=$key->slug;?>"><img src="<?=base_url();?>public/images/blank.jpg"></a></div>
		<?php } ?>
		<div class="col-md-9 post-desc-home">
		<a href="<?=site_url('ref=home&com=read_post&q=');?><?=$key->slug;?>" class="post-title-home"><?=$key->title;?></a>
		<div class="only-desc"><?php echo $this->mglobal->limitext(urldecode($key->content));?></div>
		<ul class="user">By <li><a href="">User</a></li>
<?php
$date = $key->date_created;
$date = date('F, Y', strtotime($date));
?>
		<li><a href=""><?=$date;?></a></li>
		<li class="category">
		<?php if (is_array($cat)): ?>
			
		<?php foreach ($cat as $key3): ?>
			<a href=""><?=$key3;?></a>
		<?php endforeach ?>
		<?php endif ?>

		</li>
		</ul>
		<br>
		<a href="<?=site_url('ref=home&com=read_post&q=');?><?=$key->slug;?>" class="btn btn-success detail">Details</a>
		<a href="" class="btn btn-info detail-ex"><i class="fa fa-comment"></i>&nbsp;0</a>
		<a href="" class="btn btn-default detail-ex"><i class="fa fa-eye"></i>&nbsp;<?php $page = '-index.php-h-p-'.$key->slug; echo $this->pagecounter->visit_total($page);?></a>
		</div>

		</div>

		<div class="breaker-full"></div>
			<?php
			}
		}
		echo isset($links) ? $links : '<span class="btn alert-info">No post yet.</span>';
	}

	?>
</div>


<div class="col-md-3 post-sidebar">
	<div class="item">
	<span class="title">Recent post</span>
		<ul>
		<?php if (isset($posts)): ?>
			
		<?php
		if(is_array($posts)){

		 foreach ($posts as $key2) {
		 	echo "<li><a href='".site_url('ref=home&com=read_post&q='.$key->slug)."'> $key2->title </a><i>($key->year)</i></li>";
		
		}

			} 
			?>

		<?php endif ?>
		</ul>
	</div>
	<div class="item">
		<span class="title">
			Ads
		</span>
	</div>

	<div class="item">
	<span class="title">Calendar</span>
		<ul>
		<li><a href=""></a></li>
		<li><a href=""></a></li>
		</ul>
	</div>
</div>