=== Starbox Voting ===
Contributors: jigen.he
Tags: popularity, voting, Post
Donate link:
Requires at least: 2.0
Tested up to: 2.7
Stable tag: 0.2

This plugin adds voting functionality for posts. visitors can vote for the post and against.

== Description ==


This plugin adds voting functionality for posts. visitors can vote for the post and against.

The Plugin HomePage on right is wrong , i' sorry to that, and you can see how it works click <a href="http://www.sealedbox.cn/starbox/">Starbox Voting HomePage</a>

Now there are English And Chinese Language ,If you like this plugin , and translate it to another language, please <a href="http://www.sealedbox.cn/starbox/">let me konw</a>. 

<h4>Change Log</h4>

1.1: Add plugins init setting , set display image as default image.

1.2: Repaire ajax Request ,no response .

1.3  Add so Style to choose In `Setting > Starbox`

1.4  You can set style by yourself In `Setting > Starbox`

1.5  Change error: no effect when change style in backend<br />
     Add ghosing effect when mouse hover the stars<br />
     Change Style Setting Page style.<br />

1.6  Language Support

== Installation ==

1. Upload the folder `starbox` to the `/wp-content/plugins/` directory
2. Activate the plugin through the 'Plugins' menu in WordPress
3. You will need to insert the code (`<?php if(function_exists('starbox_voting')){starbox_voting(get_the_ID());} ?>`) into the WordPress loop.
4. You can also insert the code (`<?php if(function_exists('starbox_voting')){starbox_voting(get_the_ID());} ?>`) into the Post (single.php) or Pages (page.php).
5. You can customize the plugin options via the Wordpress Dashboard (`Options > Starbox` in Wordpress versions prior to 2.3, `Settings > Starbox` in Wordpress versions after 2.5)


== Requirements ==

1. A working Wordpress install

2. WordPress theme must contain a call to the `get_header()` function

3. WordPress theme must contain the Wordpress loop

Most Wordpress installs have these, so you need not worry about these.

In addition, one must have JavaScript enabled in their browsers in order to vote.

== Customizing ==

If the plugin cannot write to the database, you can try manually executing the below SQL queries (you can use phpMyAdmin to do this):

        CREATE TABLE `wp_starboxvoting` (
                                  `id` int(11) NOT NULL auto_increment,
                                  `object_id` int(11) NOT NULL,
                                  `ip` varchar(64) character set latin1 NOT NULL,
                                  `vote` int(11) NOT NULL,
                                  PRIMARY KEY  (`id`)
                                ) ENGINE=MyISAM DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;


== Screenshots ==

1. Front Page Display Style

2. Starbox Voting Style