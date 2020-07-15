<?php
return array
(
	'box' => array
	(
		'key'      => $this->plugin->db_prefix . '_' . 'box',
		'slug'     => $this->plugin->underscored_id . '_' . 'box',
		'label'    => __( 'Author box', $this->plugin->textdomain ),
		'callback' => array( new Molongui\Authorship\Admin\Admin( $this->plugin, $this->loader ), 'validate_box_tab' ),
		'sections' => array
		(
			array
			(
				'id'       => 'styling',
				'display'  => true,
				'label'    => __( 'Styling', $this->plugin->textdomain ),
				'desc'     => '',
				'callback' => 'render_description',
				'fields'  => array
				(
					array
					(
						'id'       => 'box_preview',
						'display'  => false,
						'label'    => __( 'Preview', '$this->plugin->textdomain' ),
						'desc'     => __( '', $this->plugin->textdomain ),
						'tip'      => __( 'This is how author boxes will be displayed in your site. Use the Customizer to make it look like you want.', $this->plugin->textdomain ),
						'type'     => 'html',
						'template' => $this->plugin->dir . 'admin/views/html-settings-box-preview.php',
					),
					array
					(
						'id'      => 'open_customizer',
						'display' => true,
						'label'   => __( 'Author box styles', $this->plugin->textdomain ),
						'desc'    => sprintf( __( 'All author box styling settings are available in the WordPress Customizer. Go there and customize your author box to your likings with %sfull live preview%s.', $this->plugin->textdomain ), '<span style="font-weight:bold; text-decoration:underline;">', '</span>' ),
						'tip'     => __( 'From plugin version 2.1.0 on, all styling settings are available in the WordPress Customizer. Click the button on the right to open it.', $this->plugin->textdomain ),
						'type'    => 'link',
						'args'    => array
						(
							'id'     => 'open_customizer_button',
							'url'    => Molongui\Authorship\Admin\Admin::get_customizer_link(),
							'target' => '_self',
							'class'  => 'button button-primary',
							'text'   => __( 'Open customizer', $this->plugin->textdomain ),
						),
					),
				),
			),
			array
			(
				'id'       => 'display',
				'display'  => true,
				'label'    => __( 'Display', $this->plugin->textdomain ),
				'desc'     => __( '', $this->plugin->textdomain ),
				'callback' => 'render_description',
				'fields'  => array
				(
					array
					(
						'id'      => 'display',
						'display' => true,
						'label'   => __( 'Default setting', $this->plugin->textdomain ),
						'desc'    => __( '', $this->plugin->textdomain ),
						'tip'     => __( 'Whether to show the author box by default. This setting might be overridden by author and post configuration.', $this->plugin->textdomain ),
						'premium' => '',
						'class'   => '',
						'type'    => 'select',
						'options' => array
						(
							array
							(
								'id'    => 'all',
								'label' => __( 'Show', $this->plugin->textdomain ),
								'value' => 'show',
							),
							array
							(
								'id'    => 'posts',
								'label' => __( 'Only on posts', $this->plugin->textdomain ),
								'value' => 'posts',
							),
							array
							(
								'id'    => 'pages',
								'label' => __( 'Only on pages', $this->plugin->textdomain ),
								'value' => 'pages',
							),
							array
							(
								'id'    => 'none',
								'label' => __( 'Hide', $this->plugin->textdomain ),
								'value' => 'hide',
							),
						),
					),
					array
					(
						'id'      => 'hide_on_category',
						'display' => true,
						'label'   => __( 'Hide on these post categories', $this->plugin->textdomain ),
						'desc'    => __( '', $this->plugin->textdomain ),
						'tip'     => __( 'Select the post categories on which the author box won\'t be displayed. This setting is overridden by post configuration.', $this->plugin->textdomain ),
						'premium' => $this->premium_setting_tip(),
						'class'   => '',
						'type'    => 'checkboxes',
						'options' => molongui_post_categories( true ),
					),
					array
					(
						'id'      => 'hide_if_no_bio',
						'display' => true,
						'label'   => __( 'Hide if no author biography', $this->plugin->textdomain ),
						'desc'    => __( '', $this->plugin->textdomain ),
						'tip'     => __( 'Whether to hide the author box if there is not biographical information to show.', $this->plugin->textdomain ),
						'premium' => '',
						'class'   => '',
						'type'    => 'select',
						'options' => array
						(
							array
							(
								'id'    => 'yes',
								'label' => __( 'Yes', $this->plugin->textdomain ),
								'value' => '1',
							),
							array
							(
								'id'    => 'no',
								'label' => __( 'No', $this->plugin->textdomain ),
								'value' => '0',
							),
						),
					),
					array
					(
						'id'      => 'order',
						'display' => true,
						'label'   => __( 'Order', $this->plugin->textdomain ),
						'desc'    => __( '', $this->plugin->textdomain ),
						'tip'     => __( 'Author box is added to post content in the configured position. Nonetheless, other plugins may also add their stuff, making the author box appear above/below it. Reduce the number below until the box goes up there where you like or increase it to make it go down. Be aware that setting this value below 10 might cause issues with your content.', $this->plugin->textdomain ),
						'premium' => '',
						'class'   => '',
						'type'    => 'number',
						'min'     => 1,
						'max'     => '',
						'step'    => 1,
					),
				),
			),
			array
			(
				'id'       => 'multiauthor_box',
				'display'  => true,
				'label'    => __( 'Multiauthor', $this->plugin->textdomain ),
				'desc'     => __( '', $this->plugin->textdomain ),
				'callback' => 'render_description',
				'fields'  => array
				(
					array
					(
						'id'      => 'multiauthor_box_layout',
						'display' => true,
						'label'   => __( 'Author box layout', $this->plugin->textdomain ),
						'desc'    => __( '', $this->plugin->textdomain ),
						'tip'     => __( 'How to show multiple author boxes.', $this->plugin->textdomain ),
						'premium' => '',
						'class'   => '',
						'type'    => 'select',
						'options' => array
						(
							array
							(
								'id'    => 'individual',
								'label' => __( 'As many author boxes as authors', $this->plugin->textdomain ),
								'value' => 'individual',
							),
							array
							(
								'id'    => 'default',
								'label' => __( 'All authors in one single box', $this->plugin->textdomain ),
								'value' => 'default',
							),
						),
					),
				),
			),
			array
			(
				'id'       => 'related_posts',
				'display'  => true,
				'label'    => __( 'Related posts', $this->plugin->textdomain ),
				'desc'     => __( '', $this->plugin->textdomain ),
				'callback' => 'render_description',
				'fields'   => array
				(
					array
					(
						'id'      => 'show_related',
						'display' => true,
						'label'   => __( 'Show related posts', $this->plugin->textdomain ),
						'desc'    => __( '', $this->plugin->textdomain ),
						'tip'     => __( 'Whether to show "related posts" link on the author box.', $this->plugin->textdomain ),
						'premium' => '',
						'class'   => '',
						'type'    => 'select',
						'options' => array
						(
							array
							(
								'id'    => 'yes',
								'label' => __( 'Yes', $this->plugin->textdomain ),
								'value' => '1',
							),
							array
							(
								'id'    => 'no',
								'label' => __( 'No', $this->plugin->textdomain ),
								'value' => '0',
							),
						),
					),
					array
					(
						'id'      => 'related_post_type',
						'display' => true,
						'label'   => __( 'Post types', $this->plugin->textdomain ),
						'desc'    => __( '', $this->plugin->textdomain ),
						'tip'     => __( 'Type of posts to show as related.', $this->plugin->textdomain ),
						'premium' => $this->premium_setting_tip(),
						'class'   => '',
						'type'    => 'checkboxes',
						'options' => molongui_supported_post_types( $this->plugin->id, 'all', true ),
					),
					array
					(
						'id'      => 'related_items',
						'display' => true,
						'label'   => __( 'Number of posts', $this->plugin->textdomain ),
						'desc'    => __( '', $this->plugin->textdomain ),
						'tip'     => __( 'Amount of related posts to show in the author box.', $this->plugin->textdomain ),
						'premium' => '',
						'class'   => '',
						'type'    => 'number',
						'min'     => 1,
						'max'     => '',
						'step'    => 1,
					),
					array
					(
						'id'      => 'related_orderby',
						'display' => true,
						'label'   => __( 'Order by', $this->plugin->textdomain ),
						'desc'    => __( '', $this->plugin->textdomain ),
						'tip'     => __( 'The criteria to sort related posts.', $this->plugin->textdomain ),
						'premium' => $this->premium_setting_tip(),
						'class'   => '',
						'type'    => 'select',
						'options' => array
						(
							array
							(
								'id'    => 'title',
								'label' => __( 'Title', $this->plugin->textdomain ),
								'value' => 'title',
							),
							array
							(
								'id'    => 'date',
								'label' => __( 'Date', $this->plugin->textdomain ),
								'value' => 'date',
							),
							array
							(
								'id'    => 'modified',
								'label' => __( 'Modified', $this->plugin->textdomain ),
								'value' => 'modified',
							),
							array
							(
								'id'    => 'comment_count',
								'label' => __( 'Comment count', $this->plugin->textdomain ),
								'value' => 'comment_count',
							),
							array
							(
								'id'    => 'rand',
								'label' => __( 'Random order', $this->plugin->textdomain ),
								'value' => 'rand',
							),
						),
					),
					array
					(
						'id'      => 'related_order',
						'display' => true,
						'label'   => __( 'Order', $this->plugin->textdomain ),
						'desc'    => __( '', $this->plugin->textdomain ),
						'tip'     => __( 'The order to sort related posts.', $this->plugin->textdomain ),
						'premium' => $this->premium_setting_tip(),
						'class'   => '',
						'type'    => 'select',
						'options' => array
						(
							array
							(
								'id'    => 'asc',
								'label' => __( 'Ascending order', $this->plugin->textdomain ),
								'value' => 'asc',
							),
							array
							(
								'id'    => 'desc',
								'label' => __( 'Descending order', $this->plugin->textdomain ),
								'value' => 'desc',
							),
						),
					),
				),
			),
			array
			(
				'id'       => 'social_networks',
				'display'  => true,
				'label'    => __( 'Social networks', $this->plugin->textdomain ),
				'desc'     => __( '', $this->plugin->textdomain ),
				'callback' => 'render_description',
				'fields'   => array
				(
					array
					(
						'id'      => 'show',
						'display' => true,
						'label'   => __( 'Social networks', $this->plugin->textdomain ),
						'desc'    => __( '', $this->plugin->textdomain ),
						'tip'     => __( 'There are many social networking websites out there and this plugin allows you to link to the most popular. Not to glut the edit page, choose the ones you want to be able to configure.', $this->plugin->textdomain ),
						'premium' => '',
						'class'   => '',
						'type'    => 'checkboxes',
						'options' => array
						(
							array
							(
								'id'    => 'facebook',
								'label' => 'Facebook',
							),
							array
							(
								'id'    => 'twitter',
								'label' => 'Twitter',
							),
							array
							(
								'id'    => 'linkedin',
								'label' => 'Linkedin',
							),
							array
							(
								'id'    => 'googleplus',
								'label' => 'Google+',
							),
							array
							(
								'id'    => 'youtube',
								'label' => 'Youtube',
							),
							array
							(
								'id'    => 'pinterest',
								'label' => 'Pinterest',
							),
							array
							(
								'id'    => 'tumblr',
								'label' => 'Tumblr',
							),
							array
							(
								'id'    => 'instagram',
								'label' => 'Instagram',
							),
							array
							(
								'id'    => 'slideshare',
								'label' => 'Slideshare',
							),
							array
							(
								'id'    => 'xing',
								'label' => 'Xing',
							),
							array
							(
								'id'    => 'renren',
								'label' => 'Renren',
							),
							array
							(
								'id'    => 'vk',
								'label' => 'Vk',
							),
							array
							(
								'id'    => 'flickr',
								'label' => 'Flickr',
							),
							array
							(
								'id'    => 'vine',
								'label' => 'Vine',
							),
							array
							(
								'id'    => 'meetup',
								'label' => 'Meetup',
							),
							array
							(
								'id'    => 'weibo',
								'label' => 'Sina Weibo',
							),
							array
							(
								'id'    => 'deviantart',
								'label' => 'Deviantart',
							),
							array
							(
								'id'    => 'stumbleupon',
								'label' => 'Stumbleupon',
							),
							array
							(
								'id'    => 'myspace',
								'label' => 'MySpace',
							),
							array
							(
								'id'    => 'yelp',
								'label' => 'Yelp',
							),
							array
							(
								'id'    => 'mixi',
								'label' => 'Mixi',
							),
							array
							(
								'id'    => 'soundcloud',
								'label' => 'SoundCloud',
							),
							array
							(
								'id'    => 'lastfm',
								'label' => 'Last.fm',
							),
							array
							(
								'id'    => 'foursquare',
								'label' => 'Foursquare',
							),
							array
							(
								'id'    => 'spotify',
								'label' => 'Spotify',
							),
							array
							(
								'id'    => 'vimeo',
								'label' => 'Vimeo',
							),
							array
							(
								'id'    => 'dailymotion',
								'label' => 'Dailymotion',
							),
							array
							(
								'id'    => 'reddit',
								'label' => 'Reddit',
							),
							array
							(
								'id'    => 'skype',
								'label' => 'Skype',
							),
							array
							(
								'id'    => 'livejournal',
								'label' => 'Live Journal',
							),
							array
							(
								'id'    => 'taringa',
								'label' => 'Taringa!',
							),
							array
							(
								'id'    => 'odnoklassniki',
								'label' => 'OK.ru',
							),
							array
							(
								'id'    => 'askfm',
								'label' => 'ASKfm',
							),
							array
							(
								'id'    => 'bebee',
								'label' => 'beBee',
							),
							array
							(
								'id'    => 'goodreads',
								'label' => 'Goodreads',
							),
							array
							(
								'id'    => 'periscope',
								'label' => 'Periscope',
							),
							array
							(
								'id'    => 'telegram',
								'label' => 'Telegram',
							),
							array
							(
								'id'    => 'livestream',
								'label' => 'Livestream',
							),
							array
							(
								'id'    => 'styleshare',
								'label' => 'StyleShare',
							),
							array
							(
								'id'    => 'reverbnation',
								'label' => 'Reverbnation',
							),
							array
							(
								'id'    => 'everplaces',
								'label' => 'Everplaces',
							),
							array
							(
								'id'    => 'eventbrite',
								'label' => 'Eventbrite',
							),
							array
							(
								'id'    => 'draugiemlv',
								'label' => 'Draugiem.lv',
							),
							array
							(
								'id'    => 'blogger',
								'label' => 'Blogger',
							),
							array
							(
								'id'    => 'patreon',
								'label' => 'Patreon',
							),
							array
							(
								'id'    => 'plurk',
								'label' => 'Plurk',
							),
							array
							(
								'id'    => 'buzzfeed',
								'label' => 'BuzzFeed',
							),
							array
							(
								'id'    => 'slides',
								'label' => 'Slides',
							),
							array
							(
								'id'    => 'deezer',
								'label' => 'Deezer',
							),
							array
							(
								'id'    => 'spreaker',
								'label' => 'Spreaker',
							),
							array
							(
								'id'    => 'runkeeper',
								'label' => 'Runkeeper',
							),
							array
							(
								'id'    => 'medium',
								'label' => 'Medium',
							),
							array
							(
								'id'    => 'speakerdeck',
								'label' => 'Speaker Deck',
							),
							array
							(
								'id'    => 'teespring',
								'label' => 'Teespring',
							),
							array
							(
								'id'    => 'kaggle',
								'label' => 'Kaggle',
							),
							array
							(
								'id'    => 'houzz',
								'label' => 'Houzz',
							),
							array
							(
								'id'    => 'gumtree',
								'label' => 'Gumtree',
							),
							array
							(
								'id'    => 'upwork',
								'label' => 'Upwork',
							),
							array
							(
								'id'    => 'superuser',
								'label' => 'SuperUser',
							),
							array
							(
								'id'    => 'bandcamp',
								'label' => 'Bandcamp',
							),
							array
							(
								'id'    => 'glassdoor',
								'label' => 'Glassdoor',
							),
							array
							(
								'id'    => 'toptal',
								'label' => 'TopTal',
							),
							array
							(
								'id'    => 'ifixit',
								'label' => 'I fix it',
							),
							array
							(
								'id'    => 'stitcher',
								'label' => 'Stitcher',
							),
							array
							(
								'id'    => 'storify',
								'label' => 'Storify',
							),
							array
							(
								'id'    => 'readthedocs',
								'label' => 'Read the docs',
							),
							array
							(
								'id'    => 'ello',
								'label' => 'Ello',
							),
							array
							(
								'id'    => 'tinder',
								'label' => 'Tinder',
							),
							array
							(
								'id'    => 'github',
								'label' => 'GitHub',
							),
							array
							(
								'id'    => 'stackoverflow',
								'label' => 'Stack Overflow',
							),
							array
							(
								'id'    => 'jsfiddle',
								'label' => 'JSFiddle',
							),
							array
							(
								'id'    => 'twitch',
								'label' => 'Twitch',
							),
							array
							(
								'id'    => 'whatsapp',
								'label' => 'WhatsApp',
							),
							array
							(
								'id'    => 'tripadvisor',
								'label' => 'Tripadvisor',
							),
							array
							(
								'id'    => 'wikipedia',
								'label' => 'Wikipedia',
							),
							array
							(
								'id'    => '500px',
								'label' => '500px',
							),
							array
							(
								'id'    => 'mixcloud',
								'label' => 'Mixcloud',
							),
							array
							(
								'id'    => 'viadeo',
								'label' => 'Viadeo',
							),
							array
							(
								'id'    => 'quora',
								'label' => 'Quora',
							),
							array
							(
								'id'    => 'etsy',
								'label' => 'Etsy',
							),
							array
							(
								'id'    => 'codepen',
								'label' => 'CodePen',
							),
							array
							(
								'id'    => 'coderwall',
								'label' => 'Coderwall',
							),
							array
							(
								'id'    => 'behance',
								'label' => 'Behance',
							),
							array
							(
								'id'    => 'coursera',
								'label' => 'Coursera',
							),
							array
							(
								'id'    => 'googleplay',
								'label' => 'Google Play',
							),
							array
							(
								'id'    => 'itunes',
								'label' => 'iTunes',
							),
							array
							(
								'id'    => 'angellist',
								'label' => 'AngelList',
							),
							array
							(
								'id'    => 'amazon',
								'label' => 'Amazon',
							),
							array
							(
								'id'    => 'ebay',
								'label' => 'eBay',
							),
							array
							(
								'id'    => 'paypal',
								'label' => 'Paypal',
							),
							array
							(
								'id'    => 'digg',
								'label' => 'Digg',
							),
							array
							(
								'id'    => 'dribbble',
								'label' => 'Dribbble',
							),
							array
							(
								'id'    => 'dropbox',
								'label' => 'Dropbox',
							),
							array
							(
								'id'    => 'scribd',
								'label' => 'Scribd',
							),
							array
							(
								'id'    => 'line',
								'label' => 'Line',
							),
							array
							(
								'id'    => 'lineat',
								'label' => 'Line@',
							),
							array
							(
								'id'    => 'researchgate',
								'label' => 'ResearchGate',
							),
							array
							(
								'id'    => 'academia',
								'label' => 'Academia.edu',
							),
							array
							(
								'id'    => 'untappd',
								'label' => 'Untappd',
							),
							array
							(
								'id'    => 'bookbub',
								'label' => 'BookBub',
							),
                            array
                            (
                                'id'    => 'rss',
                                'label' => 'RSS',
                            ),
                            array
                            (
                                'id'    => 'designernews',
                                'label' => 'Designer News',
                            ),
                            array
                            (
                                'id'    => 'applepodcasts',
                                'label' => 'Apple Podcasts',
                            ),
                            array
                            (
                                'id'    => 'overcast',
                                'label' => 'Overcast',
                            ),
                            array
                            (
                                'id'    => 'breaker',
                                'label' => 'Breaker',
                            ),
                            array
                            (
                                'id'    => 'castbox',
                                'label' => 'Castbox',
                            ),
                            array
                            (
                                'id'    => 'radiopublic',
                                'label' => 'Radio Public',
                            ),
                            array
                            (
                                'id'    => 'tunein',
                                'label' => 'Tune In',
                            ),
                            array
                            (
                                'id'    => 'scoutfm',
                                'label' => 'Scout FM',
                            ),
						),
					),
				),
			),
		),
	),
	'byline' => array
    (
        'key'      => $this->plugin->db_prefix.'_'.'byline',
        'slug'     => $this->plugin->underscored_id.'_'.'byline',
        'label'    => __( 'Byline', $this->plugin->textdomain ),
        'callback' => array( new Molongui\Authorship\Admin\Admin( $this->plugin, $this->loader ), 'validate_byline_tab' ),
        'sections' => array
        (
	        array
	        (
		        'id'       => 'byline_partial_integration',
		        'display'  => true,
		        'label'    => __( '', $this->plugin->textdomain ),
		        'desc'     => __( "The byline on a post gives the name of the writer. Molongui Authorship automatically updates any byline displayed on your site showing the author(s) you have added to each post. This automation may not always work or it can even cause unexpected issues with other plugins. That's why it is recommended to use the provided template tags instead.", $this->plugin->textdomain ),
		        'd_class'  => 'molongui-settings-section-notice molongui-settings-section-notice-warning w3-hide',
		        'callback' => 'render_description',
		        'fields'   => array(),
	        ),
	        array
	        (
		        'id'       => 'byline_full_integration',
		        'display'  => true,
		        'label'    => __( '', $this->plugin->textdomain ),
		        'desc'     => __( "Displaying fully customized and functional bylines can be achieved using the provided template tags. It requires some basic coding skills, but using template tags is the best way to go in order to avoid issues with other plugins. Some parameters can be provided to the template tags so bylines can be fully localized and customized with custom HTML code and CSS styles.", $this->plugin->textdomain ),
		        'd_class'  => 'molongui-settings-section-notice molongui-settings-section-notice-info w3-hide',
		        'callback' => 'render_description',
		        'fields'   => array(),
	        ),
	        array
	        (
		        'id'       => 'byline_integration',
		        'display'  => true,
		        'label'    => __( 'Integration', $this->plugin->textdomain ),
		        'desc'     => '',//__( "Molongui Authorship makes it easy to assign one or more authors to a post. Those authors can even be guest authors, so they get no access to wp-admin. Bylines are automatically updated everywhere to keep consistency, but they can only link to an author archive page. That's a WordPress limitation that we are trying to overcome. Nonetheles,  In order for those authors to appear in the byline on the frontend, you may need to make some small modifications to your theme.", $this->plugin->textdomain ),
		        'callback' => 'render_description',
		        'fields'   => array
		        (
			        array
			        (
				        'id'      => 'byline_automatic_integration',
				        'display' => true,
				        'label'   => __( 'Integration', $this->plugin->textdomain ),
				        'desc'    => __( '', $this->plugin->textdomain ),
				        'tip'     => __( 'Whether to automatically update byline everywhere on your site by default. Activating this option may cause issues with other plugins. It is recommended to use provided template tags instead. Check out the documentation.', $this->plugin->textdomain ),
				        'premium' => '',
				        'class'   => 'molongui-width-500',
				        'type'    => 'select',
				        'options' => array
				        (
					        array
					        (
						        'id'    => 'automatic',
						        'label' => __( 'I want the plugin to implement an automatic partial integration', $this->plugin->textdomain ),
						        'value' => '1',
					        ),
					        array
					        (
						        'id'    => 'template_tags',
						        'label' => __( 'I will integrate template tags to get a full integration', $this->plugin->textdomain ),
						        'value' => '0',
					        ),
				        ),
			        ),
			        array
			        (
				        'id'      => 'byline_full_integration_documentation',
				        'display' => true,
				        'label'   => __( 'Template tags documentation', $this->plugin->textdomain ),
				        'desc'    => sprintf( __( 'Using template tags requires you to make some small modifications to your theme. %sIf you are a skilled coder, you may want to take a look at "%stemplate-tags.php%s" file.', $this->plugin->textdomain ), '<br>', '<strong>', '</strong>' ),
				        'tip'     => __( 'Check out the documentation to know how to integrate the provided template tags into your child theme.', $this->plugin->textdomain ),
				        'type'    => 'link',
				        'args'    => array
				        (
					        'id'     => 'open_template_tags_documentation_button',
					        'url'    => MOLONGUI_AUTHORSHIP_FW_MOLONGUI_WEB.'docs/molongui-authorship/howto/how-to-incorporate-molongui-authorship-template-tags-into-your-theme/',
					        'target' => '_blank',
					        'class'  => 'button',
					        'text'   => __( 'Read documentation', $this->plugin->textdomain ),
				        ),
			        ),
		        ),
	        ),
	        array
	        (
		        'id'       => 'byline_modifiers',
		        'display'  => true,
		        'label'    => __( 'Display modifiers', $this->plugin->textdomain ),
		        'desc'     => __( '', $this->plugin->textdomain ),
		        'callback' => 'render_description',
		        'fields'   => array
		        (
			        array
			        (
				        'id'          => 'byline_modifier_before',
				        'display'     => true,
				        'label'       => __( 'Code to prepend to the byline', $this->plugin->textdomain ),
				        'desc'        => __( '', $this->plugin->textdomain ),
				        'tip'         => __( 'String to be prepended before the author name(s). Defaults to an empty string.', $this->plugin->textdomain ),
				        'premium'     => '',
				        'class'       => 'molongui-width-500',
				        'type'        => 'text',
				        'placeholder' => 'Written by ',
			        ),
			        array
			        (
				        'id'          => 'byline_modifier_after',
				        'display'     => true,
				        'label'       => __( 'Code to append to the byline', $this->plugin->textdomain ),
				        'desc'        => __( '', $this->plugin->textdomain ),
				        'tip'         => __( 'String to be appended after the author name(s). Defaults to an empty string.', $this->plugin->textdomain ),
				        'premium'     => '',
				        'class'       => 'molongui-width-500',
				        'type'        => 'text',
				        'placeholder' => '',
			        ),
		        ),
	        ),
	        array
	        (
		        'id'       => 'byline_multiauthor',
		        'display'  => true,
		        'label'    => __( 'Multiauthor', $this->plugin->textdomain ),
		        'desc'     => __( '', $this->plugin->textdomain ),
		        'callback' => 'render_description',
		        'fields'   => array
		        (
			        array
			        (
				        'id'      => 'byline_multiauthor_display',
				        'display' => true,
				        'label'   => __( 'How to handle multiple author names', $this->plugin->textdomain ),
				        'desc'    => __( '', $this->plugin->textdomain ),
				        'tip'     => __( 'How to display author name when there is more than one.', $this->plugin->textdomain ),
				        'premium' => '',
				        'class'   => 'molongui-width-500',
				        'type'    => 'select',
				        'options' => array
				        (
					        array
					        (
						        'id'    => 'byline_all',
						        'label' => __( 'Show all authors names', $this->plugin->textdomain ),
						        'value' => 'all',
					        ),
					        array
					        (
						        'id'    => 'byline_main',
						        'label' => __( 'Show just the name of the main author', $this->plugin->textdomain ),
						        'value' => 'main',
					        ),
					        array
					        (
						        'id'    => 'byline_1',
						        'label' => __( 'Show the name of main author and remaining authors count as number', $this->plugin->textdomain ),
						        'value' => '1',
					        ),
					        array
					        (
						        'id'    => 'byline_2',
						        'label' => __( 'Show the name of 2 authors and remaining authors count as number', $this->plugin->textdomain ),
						        'value' => '2',
					        ),
					        array
					        (
						        'id'    => 'byline_3',
						        'label' => __( 'Show the name of 3 authors and remaining authors count as number', $this->plugin->textdomain ),
						        'value' => '3',
					        ),
				        ),
			        ),
			        array
			        (
				        'id'          => 'byline_multiauthor_separator',
				        'display'     => true,
				        'label'       => __( 'Delimiter between author names', $this->plugin->textdomain ),
				        'desc'        => __( '', $this->plugin->textdomain ),
				        'tip'         => __( 'Delimiter that should appear between the authors. Defaults to a comma.', $this->plugin->textdomain ),
				        'premium'     => '',
				        'class'       => 'molongui-width-500',
				        'type'        => 'text',
				        'placeholder' => ',',
			        ),
			        array
			        (
				        'id'          => 'byline_multiauthor_last_separator',
				        'display'     => true,
				        'label'       => __( 'Delimiter between last two names', $this->plugin->textdomain ),
				        'desc'        => __( '', $this->plugin->textdomain ),
				        'tip'         => __( 'Delimiter that should appear between the last two authors. Defaults to "and"', $this->plugin->textdomain ),
				        'premium'     => '',
				        'class'       => 'molongui-width-500',
				        'type'        => 'text',
				        'placeholder' => 'and',
			        ),
			        array
			        (
				        'id'      => 'byline_multiauthor_link',
				        'display' => true,
				        'label'   => __( 'Byline link behavior', $this->plugin->textdomain ),
				        'desc'    => __( '', $this->plugin->textdomain ),
				        'tip'     => __( 'Default WordPress behaviour makes the byline a link to the author page. Despite showing more than one author, there can only be a link, so choose whether to disable that link when multiauthor or make it link to the main author page. Check documentation to know how to avoid this and make each author name a link to their page.', $this->plugin->textdomain ),
				        'premium' => '',
				        'class'   => 'molongui-width-500',
				        'type'    => 'select',
				        'options' => array
				        (
					        array
					        (
						        'id'    => 'magic',
						        'label' => __( "Make each name link to author's archive page &mdash; Might not always work! &mdash;", $this->plugin->textdomain ),
						        'value' => 'magic',
					        ),
					        array
					        (
						        'id'    => 'main',
						        'label' => __( "Make it point to the main author archive page", $this->plugin->textdomain ),
						        'value' => 'main',
					        ),
					        array
					        (
						        'id'    => 'disabled',
						        'label' => __( "Disable it. Don't link", $this->plugin->textdomain ),
						        'value' => 'disabled',
					        ),
				        ),
			        ),
		        ),
	        ),
        ),
    ),
	'authors' => array
	(
		'key'      => $this->plugin->db_prefix . '_' . 'authors',
		'slug'     => $this->plugin->underscored_id . '_' . 'authors',
		'label'    => __( 'Authors', $this->plugin->textdomain ),
		'callback' => array( new Molongui\Authorship\Admin\Admin( $this->plugin, $this->loader ), 'validate_authors_tab' ),
		'sections' => array
		(
			array
			(
				'id'       => 'guest_feature',
				'display'  => true,
				'label'    => __( 'Functionality', $this->plugin->textdomain ),
				'desc'     => __( '', $this->plugin->textdomain ),
				'callback' => 'render_description',
				'fields'   => array
				(
					array
					(
						'id'      => 'enable_guest_authors_feature',
						'display' => true,
						'label'   => __( 'Enable "guest authors" feature', $this->plugin->textdomain ),
						'desc'    => __( '', $this->plugin->textdomain ),
						'tip'     => __( 'Whether to enable guest authors feature.', $this->plugin->textdomain ),
						'premium' => '',
						'class'   => '',
						'type'    => 'select',
						'options' => array
						(
							array
							(
								'id'    => 'yes',
								'label' => __( 'Yes', $this->plugin->textdomain ),
								'value' => true,
							),
							array
							(
								'id'    => 'no',
								'label' => __( 'No', $this->plugin->textdomain ),
								'value' => false,
							),
						),
					),
				),
			),
			array
			(
				'id'       => 'search',
				'display'  => true,
				'label'    => __( 'Search results', $this->plugin->textdomain ),
				'desc'     => __( '', $this->plugin->textdomain ),
				'callback' => 'render_description',
				'fields'   => array
				(
					array
					(
						'id'      => 'enable_search_by_author',
						'display' => true,
						'label'   => __( 'Enable search by author', $this->plugin->textdomain ),
						'desc'    => __( '', $this->plugin->textdomain ),
						'tip'     => __( 'Whether to extend search functionality enabling search by author.', $this->plugin->textdomain ),
						'premium' => $this->premium_setting_tip(),
						'class'   => '',
						'type'    => 'select',
						'options' => array
						(
							array
							(
								'id'    => 'yes',
								'label' => __( 'Yes', $this->plugin->textdomain ),
								'value' => true,
							),
							array
							(
								'id'    => 'no',
								'label' => __( 'No', $this->plugin->textdomain ),
								'value' => false,
							),
						),
					),
					array
					(
						'id'      => 'include_guests_in_search',
						'display' => true,
						'label'   => __( 'Include guest authors in search', $this->plugin->textdomain ),
						'desc'    => __( '', $this->plugin->textdomain ),
						'tip'     => __( 'Whether to make guest authors searchable.', $this->plugin->textdomain ),
						'premium' => $this->premium_setting_tip(),
						'class'   => '',
						'type'    => 'select',
						'options' => array
						(
							array
							(
								'id'    => 'yes',
								'label' => __( 'Yes', $this->plugin->textdomain ),
								'value' => true,
							),
							array
							(
								'id'    => 'no',
								'label' => __( 'No', $this->plugin->textdomain ),
								'value' => false,
							),
						),
					),
				),
			),
			array
			(
				'id'       => 'admin_menu',
				'display'  => true,
				'label'    => __( 'Admin menu item', $this->plugin->textdomain ),
				'desc'     => __( '', $this->plugin->textdomain ),
				'callback' => 'render_description',
				'fields'   => array
				(
					array
					(
						'id'      => 'guest_menu_item_level',
						'display' => true,
						'label'   => __( 'Where to add "Guest authors" menu', $this->plugin->textdomain ),
						'desc'    => __( '', $this->plugin->textdomain ),
						'tip'     => __( 'Choose where to add the "Guest authors" link in the admin menu.', $this->plugin->textdomain ),
						'premium' => $this->premium_setting_tip(),
						'class'   => '',
						'type'    => 'select',
						'options' => array
						(
							array
							(
								'id'       => 'top_level',
								'label'    => __( 'Top level', $this->plugin->textdomain ),
								'value'    => 'top',
								'disabled' => false,
							),
							array
							(
								'id'       => 'users',
								'label'    => __( 'Users', $this->plugin->textdomain ),
								'value'    => 'users.php',
								'disabled' => !$this->plugin->is_premium,
							),
							array
							(
								'id'       => 'posts',
								'label'    => __( 'Posts', $this->plugin->textdomain ),
								'value'    => 'edit.php',
								'disabled' => !$this->plugin->is_premium,
							),
							array
							(
								'id'       => 'pages',
								'label'    => __( 'Pages', $this->plugin->textdomain ),
								'value'    => 'edit.php?post_type=page',
								'disabled' => !$this->plugin->is_premium,
							),
						),
					),
				),
			),
		),
	),
	'archives' => array
	(
		'key'      => $this->plugin->db_prefix . '_' . 'archives',
		'slug'     => $this->plugin->underscored_id . '_' . 'archives',
		'label'    => __( 'Author archives', $this->plugin->textdomain ),
		'callback' => array( new Molongui\Authorship\Admin\Admin( $this->plugin, $this->loader ), 'validate_archives_tab' ),
		'sections' => array
		(
			array
			(
				'id'       => 'guest_archives',
				'display'  => Molongui\Authorship\Admin\Admin::display_guest_archives_section(),
				'label'    => __( 'Guest authors', $this->plugin->textdomain ),
				'desc'     => __( '', $this->plugin->textdomain ),
				'callback' => 'render_description',
				'fields'   => array
				(
					array
					(
						'id'      => 'guest_archive_enabled',
						'display' => true,
						'label'   => ( !$this->plugin->is_premium ? __( 'Enable "guest author" archives', $this->plugin->textdomain ) : __( 'Disable "guest author" archives', $this->plugin->textdomain ) ),
						'desc'    => __( '', $this->plugin->textdomain ),
						'tip'     => __( 'Whether to enable the use of guest author archive pages. Disabling this option, author name link is disabled.', $this->plugin->textdomain ),
						'premium' => $this->premium_setting_tip(),
						'class'   => '',
						'type'    => 'select',
						'options' => array
						(
							array
							(
								'id'    => 'yes',
								'label' => __( 'Yes', $this->plugin->textdomain ),
								'value' => ( !$this->plugin->is_premium ? '1' : '0' ),
							),
							array
							(
								'id'    => 'no',
								'label' => __( 'No', $this->plugin->textdomain ),
								'value' => ( !$this->plugin->is_premium ? '0' : '1' ),
							),
						),
					),
					array
					(
						'id'      => 'guest_archive_include_pages',
						'display' => true,
						'label'   => __( 'Include pages on archive', $this->plugin->textdomain ),
						'desc'    => __( '', $this->plugin->textdomain ),
						'tip'     => __( "Whether to display 'pages' post type on author archives. By default, WordPress just displays 'posts'.", $this->plugin->textdomain ),
						'premium' => $this->premium_setting_tip(),
						'class'   => '',
						'type'    => 'select',
						'options' => array
						(
							array
							(
								'id'    => 'yes',
								'label' => __( 'Yes', $this->plugin->textdomain ),
								'value' => '1',
							),
							array
							(
								'id'    => 'no',
								'label' => __( 'No', $this->plugin->textdomain ),
								'value' => '0',
							),
						),
					),
					array
					(
						'id'      => 'guest_archive_include_cpts',
						'display' => true,
						'label'   => __( 'Include custom post types on archive', $this->plugin->textdomain ),
						'desc'    => __( '', $this->plugin->textdomain ),
						'tip'     => __( "Whether to display custom post types where the plugin functionality is extended to on author archives. By default, WordPress just displays 'posts'.", $this->plugin->textdomain ),
						'premium' => $this->premium_setting_tip(),
						'class'   => '',
						'type'    => 'select',
						'options' => array
						(
							array
							(
								'id'    => 'yes',
								'label' => __( 'Yes', $this->plugin->textdomain ),
								'value' => '1',
							),
							array
							(
								'id'    => 'no',
								'label' => __( 'No', $this->plugin->textdomain ),
								'value' => '0',
							),
						),
					),
					array
					(
						'id'          => 'guest_archive_tmpl',
						'display'     => true,
						'label'       => __( 'Template', $this->plugin->textdomain ),
						'desc'        => __( '', $this->plugin->textdomain ),
						'tip'         => __( 'Template to be used on guest author archive pages.', $this->plugin->textdomain ),
						'premium'     => $this->premium_setting_tip(),
						'class'       => '',
						'placeholder' => 'template_name.php',
						'type'        => 'text',
					),
					array
					(
						'id'          => 'guest_archive_permalink',
						'display'     => true,
						'label'       => __( 'Permalink', $this->plugin->textdomain ),
						'desc'        => __( '', $this->plugin->textdomain ),
						'tip'         => __( 'Permastruct to add after your installation URI and before the slug set below.', $this->plugin->textdomain ),
						'premium'     => $this->premium_setting_tip(),
						'class'       => '',
						'placeholder' => '',
						'type'        => 'text',
					),
					array
					(
						'id'          => 'guest_archive_base',
						'display'     => true,
						'label'       => __( 'Author base', $this->plugin->textdomain ),
						'desc'        => __( '', $this->plugin->textdomain ),
						'tip'         => __( 'Part of the permalink that identifies your author archive page.', $this->plugin->textdomain ),
						'premium'     => $this->premium_setting_tip(),
						'class'       => '',
						'placeholder' => 'author',
						'type'        => 'text',
					),
				),
			),
			array
			(
				'id'       => 'user_archives',
				'display'  => true,
				'label'    => __( 'Registered users', $this->plugin->textdomain ),
				'desc'     => __( '', $this->plugin->textdomain ),
				'callback' => 'render_description',
				'fields'   => array
				(
					array
					(
						'id'      => 'user_archive_enabled',
						'display' => true,
						'label'   => __( 'Disable user archives', $this->plugin->textdomain ),
						'desc'    => __( '', $this->plugin->textdomain ),
						'tip'     => __( 'Whether to disable author archive pages. Disabling this option, author name links are disabled too.', $this->plugin->textdomain ),
						'premium' => $this->premium_setting_tip(),
						'class'   => '',
						'type'    => 'select',
						'options' => array
						(
							array
							(
								'id'    => 'yes',
								'label' => __( 'Yes', $this->plugin->textdomain ),
								'value' => '0',
							),
							array
							(
								'id'    => 'no',
								'label' => __( 'No', $this->plugin->textdomain ),
								'value' => '1',
							),
						),
					),
					array
					(
						'id'      => 'user_archive_include_pages',
						'display' => true,
						'label'   => __( 'Include pages on archive', $this->plugin->textdomain ),
						'desc'    => __( '', $this->plugin->textdomain ),
						'tip'     => __( "Whether to display 'pages' post type on author archives. By default, WordPress just displays 'posts'.", $this->plugin->textdomain ),
						'premium' => $this->premium_setting_tip(),
						'class'   => '',
						'type'    => 'select',
						'options' => array
						(
							array
							(
								'id'    => 'yes',
								'label' => __( 'Yes', $this->plugin->textdomain ),
								'value' => '1',
							),
							array
							(
								'id'    => 'no',
								'label' => __( 'No', $this->plugin->textdomain ),
								'value' => '0',
							),
						),
					),
					array
					(
						'id'      => 'user_archive_include_cpts',
						'display' => true,
						'label'   => __( 'Include custom post types on archive', $this->plugin->textdomain ),
						'desc'    => __( '', $this->plugin->textdomain ),
						'tip'     => __( "Whether to display custom post types where the plugin functionality is extended to on author archives. By default, WordPress just displays 'posts'.", $this->plugin->textdomain ),
						'premium' => $this->premium_setting_tip(),
						'class'   => '',
						'type'    => 'select',
						'options' => array
						(
							array
							(
								'id'    => 'yes',
								'label' => __( 'Yes', $this->plugin->textdomain ),
								'value' => '1',
							),
							array
							(
								'id'    => 'no',
								'label' => __( 'No', $this->plugin->textdomain ),
								'value' => '0',
							),
						),
					),
					array
					(
						'id'          => 'user_archive_tmpl',
						'display'     => true,
						'label'       => __( 'Template', $this->plugin->textdomain ),
						'desc'        => __( '', $this->plugin->textdomain ),
						'tip'         => __( 'Template to be used on author archive pages.', $this->plugin->textdomain ),
						'premium'     => $this->premium_setting_tip(),
						'class'       => '',
						'placeholder' => 'template_name.php',
						'type'        => 'text',
					),
					array
					(
						'id'          => 'user_archive_base',
						'display'     => true,
						'label'       => __( 'Author base', $this->plugin->textdomain ),
						'desc'        => __( '', $this->plugin->textdomain ),
						'tip'         => __( 'Part of the permalink that identifies your author archive page.', $this->plugin->textdomain ),
						'premium'     => $this->premium_setting_tip(),
						'class'       => '',
						'placeholder' => 'author',
						'type'        => 'text',
					),
					array
					(
						'id'      => 'user_archive_redirect',
						'display' => true,
						'label'   => __( 'Redirect URL access to', $this->plugin->textdomain ),
						'desc'    => __( '', $this->plugin->textdomain ),
						'tip'     => __( 'Select the page the user will be redirected to if author archive page is introduced manually.', $this->plugin->textdomain ),
						'premium' => $this->premium_setting_tip(),
						'class'   => '',
						'type'    => 'dropdown_pages',
					),
					array
					(
						'id'      => 'user_archive_status',
						'display' => true,
						'label'   => __( 'Redirection status code', $this->plugin->textdomain ),
						'desc'    => __( '', $this->plugin->textdomain ),
						'tip'     => __( 'Select the status code the web server will return upon redirection.', $this->plugin->textdomain ),
						'premium' => $this->premium_setting_tip(),
						'class'   => '',
						'type'    => 'select',
						'options' => array
						(
							array
							(
								'id'    => '301',
								'label' => __( '301 - Moved Permanently', $this->plugin->textdomain ),
								'value' => '301',
							),
							array
							(
								'id'    => '307',
								'label' => __( '307 - Temporary Redirect', $this->plugin->textdomain ),
								'value' => '307',
							),
							array
							(
								'id'    => '308',
								'label' => __( '308 - Permanent Redirect', $this->plugin->textdomain ),
								'value' => '308',
							),
							array
							(
								'id'    => '403',
								'label' => __( '403 - Forbidden', $this->plugin->textdomain ),
								'value' => '403',
							),
							array
							(
								'id'    => '404',
								'label' => __( '404 - Not Found', $this->plugin->textdomain ),
								'value' => '404',
							),
						),
					),
				),
			),
		),
	),
	'advanced' => array
	(
		'sections' => array
		(
			array
			(
				'id'       => 'display_manipulation',
				'display'  => true,
				'label'    => __( 'Compatibility', $this->plugin->textdomain ),
				'desc'     => __( '', $this->plugin->textdomain ),
				'callback' => 'render_description',
				'fields'   => array
				(
					array
					(
						'id'          => 'hide_elements',
						'display'     => true,
						'label'       => __( 'Elements to hide', $this->plugin->textdomain ),
						'desc'        => __( '', $this->plugin->textdomain ),
						'tip'         => __( 'Comma-separated DOM elements IDs or Classes to hide from being displayed on the front-end.', $this->plugin->textdomain ),
						'premium'     => '',
						'class'       => '',
						'placeholder' => '',
						'type'        => 'text',
					),
				),
			),
			array
			(
				'id'       => 'nofollow',
				'display'  => true,
				'label'    => __( 'SEO', $this->plugin->textdomain ),
				'desc'     => __( '', $this->plugin->textdomain ),
				'callback' => 'render_description',
				'fields'   => array
				(
					array
					(
						'id'      => 'add_opengraph_meta',
						'display' => true,
						'label'   => __( 'Add Open Graph Author Tags', $this->plugin->textdomain ),
						'desc'    => __( '', $this->plugin->textdomain ),
						'tip'     => __( 'Whether to add Open Graph metadata for author details (useful for rich snippets).', $this->plugin->textdomain ),
						'premium' => '',
						'class'   => '',
						'type'    => 'select',
						'options' => array
						(
							array
							(
								'id'    => 'yes',
								'label' => __( 'Yes', $this->plugin->textdomain ),
								'value' => '1',
							),
							array
							(
								'id'    => 'no',
								'label' => __( 'No', $this->plugin->textdomain ),
								'value' => '0',
							),
						),
					),
					array
					(
						'id'      => 'add_google_meta',
						'display' => true,
						'label'   => __( 'Add Google Author Tags', $this->plugin->textdomain ),
						'desc'    => __( '', $this->plugin->textdomain ),
						'tip'     => __( 'Whether to add Google Authorship metadata for author details (useful for rich snippets).', $this->plugin->textdomain ),
						'premium' => '',
						'class'   => '',
						'type'    => 'select',
						'options' => array
						(
							array
							(
								'id'    => 'yes',
								'label' => __( 'Yes', $this->plugin->textdomain ),
								'value' => '1',
							),
							array
							(
								'id'    => 'no',
								'label' => __( 'No', $this->plugin->textdomain ),
								'value' => '0',
							),
						),
					),
					array
					(
						'id'      => 'add_facebook_meta',
						'display' => true,
						'label'   => __( 'Add Facebook Author Tags', $this->plugin->textdomain ),
						'desc'    => __( '', $this->plugin->textdomain ),
						'tip'     => __( 'Whether to add Facebook Authorship metadata for author details (useful for rich snippets).', $this->plugin->textdomain ),
						'premium' => '',
						'class'   => '',
						'type'    => 'select',
						'options' => array
						(
							array
							(
								'id'    => 'yes',
								'label' => __( 'Yes', $this->plugin->textdomain ),
								'value' => '1',
							),
							array
							(
								'id'    => 'no',
								'label' => __( 'No', $this->plugin->textdomain ),
								'value' => '0',
							),
						),
					),
					array
					(
						'id'      => 'add_nofollow',
						'display' => true,
						'label'   => __( "Add 'nofollow' attribute", $this->plugin->textdomain ),
						'desc'    => __( '', $this->plugin->textdomain ),
						'tip'     => __( 'Whether to add \'nofollow\' attribute to social networks links.', $this->plugin->textdomain ),
						'premium' => '',
						'class'   => '',
						'type'    => 'select',
						'options' => array
						(
							array
							(
								'id'    => 'yes',
								'label' => __( 'Yes', $this->plugin->textdomain ),
								'value' => '1',
							),
							array
							(
								'id'    => 'no',
								'label' => __( 'No', $this->plugin->textdomain ),
								'value' => '0',
							),
						),
					),
					array
					(
						'id'      => 'box_headline_tag',
						'display' => true,
						'label'   => __( 'Author box headline tag', $this->plugin->textdomain ),
						'desc'    => __( '', $this->plugin->textdomain ),
						'tip'     => __( 'Choose the correct HTML tag to use for the headline shown above the author box. Selecting a value inline with the structure of your page might improve SEO.', $this->plugin->textdomain ),
						'premium' => $this->premium_setting_tip(),
						'class'   => '',
						'type'    => 'select',
						'options' => array
						(
							array
							(
								'id'    => 'h1',
								'label' => __( 'h1', $this->plugin->textdomain ),
								'value' => 'h1',
							),
							array
							(
								'id'    => 'h2',
								'label' => __( 'h2', $this->plugin->textdomain ),
								'value' => 'h2',
							),
							array
							(
								'id'    => 'h3',
								'label' => __( 'h3', $this->plugin->textdomain ),
								'value' => 'h3',
							),
							array
							(
								'id'    => 'h4',
								'label' => __( 'h4', $this->plugin->textdomain ),
								'value' => 'h4',
							),
							array
							(
								'id'    => 'h5',
								'label' => __( 'h5', $this->plugin->textdomain ),
								'value' => 'h5',
							),
							array
							(
								'id'    => 'h6',
								'label' => __( 'h6', $this->plugin->textdomain ),
								'value' => 'h6',
							),
							array
							(
								'id'    => 'div',
								'label' => __( 'div', $this->plugin->textdomain ),
								'value' => 'div',
							),
							array
							(
								'id'    => 'p',
								'label' => __( 'p', $this->plugin->textdomain ),
								'value' => 'p',
							),
						),
					),
					array
					(
						'id'      => 'box_author_name_tag',
						'display' => true,
						'label'   => __( 'Author box author name tag', $this->plugin->textdomain ),
						'desc'    => __( '', $this->plugin->textdomain ),
						'tip'     => __( 'Choose the correct HTML tag to use for the author name shown within the author box. Selecting a value inline with the structure of your page might improve SEO.', $this->plugin->textdomain ),
						'premium' => $this->premium_setting_tip(),
						'class'   => '',
						'type'    => 'select',
						'options' => array
						(
							array
							(
								'id'    => 'h1',
								'label' => __( 'h1', $this->plugin->textdomain ),
								'value' => 'h1',
							),
							array
							(
								'id'    => 'h2',
								'label' => __( 'h2', $this->plugin->textdomain ),
								'value' => 'h2',
							),
							array
							(
								'id'    => 'h3',
								'label' => __( 'h3', $this->plugin->textdomain ),
								'value' => 'h3',
							),
							array
							(
								'id'    => 'h4',
								'label' => __( 'h4', $this->plugin->textdomain ),
								'value' => 'h4',
							),
							array
							(
								'id'    => 'h5',
								'label' => __( 'h5', $this->plugin->textdomain ),
								'value' => 'h5',
							),
							array
							(
								'id'    => 'h6',
								'label' => __( 'h6', $this->plugin->textdomain ),
								'value' => 'h6',
							),
							array
							(
								'id'    => 'div',
								'label' => __( 'div', $this->plugin->textdomain ),
								'value' => 'div',
							),
							array
							(
								'id'    => 'p',
								'label' => __( 'p', $this->plugin->textdomain ),
								'value' => 'p',
							),
						),
					),
				),
			),
		),
	),
);