<?php if ((isset($analytic_visits) OR isset($analytic_views)) AND $theme_options->pyrocms_analytics_graph == 'yes'): ?>
<script type="text/javascript">

$(function($) {
		var visits = <?php echo isset($analytic_visits) ? $analytic_visits : 0; ?>;
		var views = <?php echo isset($analytic_views) ? $analytic_views : 0; ?>;

		$.plot($('#analytics'), [{ label: 'Visits', data: visits },{ label: 'Page views', data: views }], {
			lines: { show: true },
			points: { show: true },
			grid: { hoverable: true, backgroundColor: '#fefefe' },
			series: {
				lines: { show: true, lineWidth: 1 },
				shadowSize: 0
			},
			xaxis: { mode: "time" },
			yaxis: { min: 0},
			selection: { mode: "x" }
		});
		
		function showTooltip(x, y, contents) {
			$('<div id="tooltip">' + contents + '</div>').css( {
				position: 'absolute',
				display: 'none',
				top: y + 5,
				left: x + 5,
				border: '1px solid #ed8e28',
				'border-radius': '3px',
				'-moz-border-radius': '3px',
				'-webkit-border-radius': '3px',
				padding: '2px 5px 2px 5px',
				color: '#ffffff',
				background: '#efa92e',
				opacity: 0.80
			}).appendTo("body").fadeIn(200);
		}
	 
		var previousPoint = null;
		
		$("#analytics").bind("plothover", function (event, pos, item) {
			$("#x").text(pos.x.toFixed(2));
			$("#y").text(pos.y.toFixed(2));
	 
				if (item) {
					if (previousPoint != item.dataIndex) {
						previousPoint = item.dataIndex;
						
						$("#tooltip").remove();
						var x = item.datapoint[0],
							y = item.datapoint[1];
						
						showTooltip(item.pageX, item.pageY,
									item.series.label + " : " + y);
					}
				}
				else {
					$("#tooltip").remove();
					previousPoint = null;            
				}
		});
	
	});
</script>

<div id="analyticsWrapper">
	<div id="analytics"></div>
</div>

<?php endif; ?>
<!-- End Analytics -->
	
<!-- Dashboard Widgets -->
{pyro:widgets:area slug="dashboard"}
	
	<!-- Begin Recent Comments -->
	<?php if (isset($recent_comments) AND is_array($recent_comments) AND $theme_options->pyrocms_recent_comments == 'yes') : ?>
	<div class="one_full">
		
		<section class="title">
			<h4><?php echo lang('comments.recent_comments') ?></h4>
			<span class="toggle">toggle</span>
		</section>
		
		<section class="item">
			<ul>
				<li>
					<a href="<?php echo site_url('admin/comments'); ?>"></a>
				</li>
				<?php foreach ($recent_comments AS $rant) : ?>
					<li>
						<p><?php echo sprintf(lang('comments.list_comment'), $rant->name, $rant->item); ?> <em><?php echo $rant->comment; ?></em></p>
					</li>
				<?php endforeach; ?>
			</ul>
		</section>
		
	<?php endif; ?>
	</div>
	<!-- End Recent Comments -->

	<?php /*
	
	----------------------------------------------------------------------------------------------------
	Do we really need quick links? User's are smart enough to click the top menu! This is just clutter!
	------------------------------------------------------------
	
	<!-- Begin Quick Links -->
	<?php if ($theme_options->pyrocms_quick_links == 'yes') : ?>
	<div class="one_half">
		
		<section class="title">
			<h4><?php echo lang('cp_admin_quick_links') ?></h4>
		</section>
		
		<section class="item <?php echo isset($rss_items); ?>">
			<ul>
				<?php if(array_key_exists('comments', $this->permissions) OR $this->user->group == 'admin'): ?>
				<li>
					<?php echo image('icons/comments.png'); ?>
					<a href="<?php echo site_url('admin/comments') ?>"><?php echo lang('cp_manage_comments'); ?></a>
				</li>
				<?php endif; ?>
				
				<?php if(array_key_exists('pages', $this->permissions) OR $this->user->group == 'admin'): ?>
				<li>
					<?php echo image('icons/pages.png'); ?>
					<a href="<?php echo site_url('admin/pages') ?>"><?php echo lang('cp_manage_pages'); ?></a>
				</li>
				<?php endif; ?>
				
				<?php if(array_key_exists('files', $this->permissions) OR $this->user->group == 'admin'): ?>
				<li>
					<?php echo image('icons/folder_open.png'); ?>
					<a href="<?php echo site_url('admin/files') ?>"><?php echo lang('cp_manage_files'); ?></a>
				</li>
				<?php endif; ?>
				
				<?php if(array_key_exists('users', $this->permissions) OR $this->user->group == 'admin'): ?>
				<li class="clearfix">
					<?php echo image('icons/user.png'); ?>
					<a href="<?php echo site_url('admin/users') ?>"><?php echo lang('cp_manage_users'); ?></a>
				</li>
				<?php endif; ?>
			</ul>
		</section>
		
	<?php endif; ?>
	</div>
	<!-- End Quick Links -->
	
	*/ ?>

	<!-- Begin RSS Feed -->
	<?php if ( isset($rss_items) AND $theme_options->pyrocms_news_feed == 'yes') : ?>
	<div id="feed" class="one_full">
		
		<section class="title">
			<h4><?php echo lang('cp_news_feed_title'); ?></h4>
			<span class="toggle">toggle</span>
		</section>
		
		<section class="item">
			<ul>
				<?php foreach($rss_items as $rss_item): ?>
				<li>
					<h4><?php echo anchor($rss_item->get_permalink(), $rss_item->get_title(), 'target="_blank"'); ?></h4>
						
					<?php
						$item_date	= strtotime($rss_item->get_date());
						$item_month = date('M', $item_date);
						$item_day	= date('j', $item_date);
					?>
						
					<div class="date">
						<span><?php echo $item_month ?></span>
						<?php echo $item_day; ?>
					</div>
											
					<p class='item_body'><?php echo $rss_item->get_description(); ?></p>
				</li>
				<?php endforeach; ?>
			</ul>
		</section>
		
	<?php endif; ?>
	</div>
	<!-- End RSS Feed -->