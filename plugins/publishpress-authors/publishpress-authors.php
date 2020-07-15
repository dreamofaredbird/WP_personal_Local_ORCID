<?php
/**
 * PublishPress Authors plugin bootstrap file.
 *
 * @link        https://publishpress.com/multiple-authors/
 * @package     MultipleAuthors
 * @author      PublishPress <help@publishpress.com>
 * @copyright   Copyright (C) 2018 PublishPress. All rights reserved.
 * @license     GPLv2 or later
 * @since       1.0.0
 *
 * @publishpress-authors
 * Plugin Name: PublishPress Authors
 * Plugin URI:  https://publishpress.com/
 * Version: 3.2.2
 * Description: Add support for multiple authors
 * Author:      PublishPress
 * Author URI:  https://publishpress.com
 *
 * Based on Co-Authors Plus
 *  - Author: Mohammad Jangda, Daniel Bachhuber, Automattic
 *  - Copyright: 2008-2015 Shared and distributed between  Mohammad Jangda, Daniel Bachhuber, Weston Ruter
 */

use MultipleAuthors\Factory;

/*
 * Before loading we need to check if PressPermit 2.7.23 or prior is installed. It doesn't check if the interface
 * Pimple\ServiceProviderInterface is loaded before loading it, triggering a fatal error. This plugin loads before it.
 */
if ( ! function_exists('is_plugin_active')) {
    require_once ABSPATH . '/wp-admin/includes/plugin.php';
}
if (is_plugin_active('presspermit-pro/presspermit-pro.php')) {
    $presspermitVersions = get_option('presspermitpro_version');

    if (version_compare($presspermitVersions['version'], '2.7.23', '<=')) {
        if ( ! strpos(urldecode($_SERVER['REQUEST_URI']), 'deactivate')) {
            add_action('all_admin_notices', function () {
                $msg = sprintf(
                    __('Error: %1$s is not compatible with PressPermit Pro v2.7.23 or prior. Sorry, but we recommend updating PressPermit.',
                        'publishpress-authors'),
                    'PublishPress Authors'
                );

                echo "<div class='notice notice-error is-dismissible' style='color:black'><p>" . $msg . '</p></div>';
            }, 5);

            return;
        }
    }
}

if ( ! defined('PP_AUTHORS_LOADED')) {
    require_once __DIR__ . '/includes.php';

    global $multiple_authors_addon;

    if (defined('WP_CLI') && WP_CLI) {
        WP_CLI::add_command('publishpress-authors', 'MultipleAuthors\\WP_Cli');
    }

    // Init the legacy plugin instance
    $legacyPlugin = Factory::getLegacyPlugin();

    $multiple_authors_addon = new \MultipleAuthors\Plugin();

    register_activation_hook(PP_AUTHORS_FILE, function () {
        require_once __DIR__ . '/activation.php';
    });

    if ( ! function_exists('wp_notify_postauthor')) {
        /**
         * Notify a co-author of a comment/trackback/pingback to one of their posts.
         * This is a modified version of the core function in wp-includes/pluggable.php that
         * supports notifs to multiple co-authors. Unfortunately, this is the best way to do it :(
         *
         * @param int $comment_id Comment ID
         * @param string $comment_type Optional. The comment type either 'comment' (default), 'trackback', or 'pingback'
         *
         * @return bool False if user email does not exist. True on completion.
         * @since 2.6.2
         *
         */
        function wp_notify_postauthor($comment_id, $comment_type = '')
        {
            $comment   = get_comment($comment_id);
            $post      = get_post($comment->comment_post_ID);
            $coauthors = get_multiple_authors($post->ID);
            foreach ($coauthors as $author) {
                // The comment was left by the co-author
                if ($comment->user_id == $author->ID) {
                    return false;
                }

                // The co-author moderated a comment on his own post
                if ($author->ID == get_current_user_id()) {
                    return false;
                }

                // If there's no email to send the comment to
                if ('' == $author->user_email) {
                    return false;
                }

                $comment_author_domain = @gethostbyaddr($comment->comment_author_IP);

                // The blogname option is escaped with esc_html on the way into the database in sanitize_option
                // we want to reverse this for the plain text arena of emails.
                $blogname = wp_specialchars_decode(get_option('blogname'), ENT_QUOTES);

                if (empty($comment_type)) {
                    $comment_type = 'comment';
                }

                if ('comment' == $comment_type) {
                    $notify_message = sprintf(__('New comment on your post "%s"'), $post->post_title) . "\r\n";
                    /* translators: 1: comment author, 2: author IP, 3: author domain */
                    $notify_message .= sprintf(__('Author : %1$s (IP: %2$s , %3$s)'), $comment->comment_author,
                            $comment->comment_author_IP, $comment_author_domain) . "\r\n";
                    $notify_message .= sprintf(__('E-mail : %s'), $comment->comment_author_email) . "\r\n";
                    $notify_message .= sprintf(__('URL    : %s'), $comment->comment_author_url) . "\r\n";
                    $notify_message .= sprintf(__('Whois  : http://whois.arin.net/rest/ip/%s'),
                            $comment->comment_author_IP) . "\r\n";
                    $notify_message .= __('Comment: ') . "\r\n" . $comment->comment_content . "\r\n\r\n";
                    $notify_message .= __('You can see all comments on this post here: ') . "\r\n";
                    /* translators: 1: blog name, 2: post title */
                    $subject = sprintf(__('[%1$s] Comment: "%2$s"'), $blogname, $post->post_title);
                } elseif ('trackback' == $comment_type) {
                    $notify_message = sprintf(__('New trackback on your post "%s"'), $post->post_title) . "\r\n";
                    /* translators: 1: website name, 2: author IP, 3: author domain */
                    $notify_message .= sprintf(__('Website: %1$s (IP: %2$s , %3$s)'), $comment->comment_author,
                            $comment->comment_author_IP, $comment_author_domain) . "\r\n";
                    $notify_message .= sprintf(__('URL    : %s'), $comment->comment_author_url) . "\r\n";
                    $notify_message .= __('Excerpt: ') . "\r\n" . $comment->comment_content . "\r\n\r\n";
                    $notify_message .= __('You can see all trackbacks on this post here: ') . "\r\n";
                    /* translators: 1: blog name, 2: post title */
                    $subject = sprintf(__('[%1$s] Trackback: "%2$s"'), $blogname, $post->post_title);
                } elseif ('pingback' == $comment_type) {
                    $notify_message = sprintf(__('New pingback on your post "%s"'), $post->post_title) . "\r\n";
                    /* translators: 1: comment author, 2: author IP, 3: author domain */
                    $notify_message .= sprintf(__('Website: %1$s (IP: %2$s , %3$s)'), $comment->comment_author,
                            $comment->comment_author_IP, $comment_author_domain) . "\r\n";
                    $notify_message .= sprintf(__('URL    : %s'), $comment->comment_author_url) . "\r\n";
                    $notify_message .= __('Excerpt: ') . "\r\n" . sprintf('[...] %s [...]',
                            $comment->comment_content) . "\r\n\r\n";
                    $notify_message .= __('You can see all pingbacks on this post here: ') . "\r\n";
                    /* translators: 1: blog name, 2: post title */
                    $subject = sprintf(__('[%1$s] Pingback: "%2$s"'), $blogname, $post->post_title);
                }
                $notify_message .= get_permalink($comment->comment_post_ID) . "#comments\r\n\r\n";
                $notify_message .= sprintf(__('Permalink: %s'),
                        get_permalink($comment->comment_post_ID) . '#comment-' . $comment_id) . "\r\n";
                if (EMPTY_TRASH_DAYS) {
                    $notify_message .= sprintf(__('Trash it: %s'),
                            admin_url("comment.php?action=trash&c=$comment_id")) . "\r\n";
                } else {
                    $notify_message .= sprintf(__('Delete it: %s'),
                            admin_url("comment.php?action=delete&c=$comment_id")) . "\r\n";
                }
                $notify_message .= sprintf(__('Spam it: %s'),
                        admin_url("comment.php?action=spam&c=$comment_id")) . "\r\n";

                $wp_email = 'wordpress@' . preg_replace('#^www\.#', '', strtolower($_SERVER['SERVER_NAME']));

                if ('' == $comment->comment_author) {
                    $from = "From: \"$blogname\" <$wp_email>";
                    if ('' != $comment->comment_author_email) {
                        $reply_to = "Reply-To: $comment->comment_author_email";
                    }
                } else {
                    $from = "From: \"$comment->comment_author\" <$wp_email>";
                    if ('' != $comment->comment_author_email) {
                        $reply_to = "Reply-To: \"$comment->comment_author_email\" <$comment->comment_author_email>";
                    }
                }

                $message_headers = "$from\n"
                                   . 'Content-Type: text/plain; charset="' . get_option('blog_charset') . "\"\n";

                if (isset($reply_to)) {
                    $message_headers .= $reply_to . "\n";
                }

                $notify_message  = apply_filters('comment_notification_text', $notify_message, $comment_id);
                $subject         = apply_filters('comment_notification_subject', $subject, $comment_id);
                $message_headers = apply_filters('comment_notification_headers', $message_headers, $comment_id);

                @wp_mail($author->user_email, $subject, $notify_message, $message_headers);
            }

            return true;
        }
    }

    if ( ! function_exists('cap_filter_comment_moderation_email_recipients')) {
        /**
         * Filter array of moderation notification email addresses
         *
         * @param array $recipients
         * @param int $comment_id
         *
         * @return array
         */
        function cap_filter_comment_moderation_email_recipients($recipients, $comment_id)
        {
            $comment = get_comment($comment_id);
            $post_id = $comment->comment_post_ID;

            if (isset($post_id)) {
                $coauthors        = get_multiple_authors($post_id);
                $extra_recipients = [];
                foreach ($coauthors as $user) {
                    if ( ! empty($user->user_email)) {
                        $extra_recipients[] = $user->user_email;
                    }
                }

                return array_unique(array_merge($recipients, $extra_recipients));
            }

            return $recipients;
        }
    }

    if ( ! function_exists('cap_get_coauthor_terms_for_post')) {
        /**
         * Retrieve a list of coauthor terms for a single post.
         *
         * Grabs a correctly ordered list of authors for a single post, appropriately
         * cached because it requires `wp_get_object_terms()` to succeed.
         *
         * @param int $post_id ID of the post for which to retrieve authors.
         *
         * @return array Array of coauthor WP_Term objects
         */
        function cap_get_coauthor_terms_for_post($post_id)
        {
            global $multiple_authors_addon;

            return $multiple_authors_addon->get_coauthor_terms_for_post($post_id);
        }
    }
}
