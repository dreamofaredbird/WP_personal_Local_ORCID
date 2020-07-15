<?php

foreach( $author['posts'] as $related )
{
    ?>
    <li>
        <div class="molongui-author-box-related-entry" itemscope itemtype="http://schema.org/CreativeWork">
            <div class="molongui-display-none" itemprop="author" itemscope itemtype="http://schema.org/Person">
                <div itemprop="name"><?php echo $author['name']; ?></div>
                <div itemprop="url"><?php echo esc_url( $author['archive'] ); ?></div>
            </div>
            <div class="molongui-author-box-related-entry-title">
                <i class="m-a-icon-doc"></i>
                <a class="molongui-remove-text-underline" itemprop="url" href="<?php echo get_permalink( $related->ID ); ?>">
                    <span itemprop="headline"><?php echo $related->post_title; ?></span>
                </a>
            </div>
        </div>
    </li>
    <?php
}