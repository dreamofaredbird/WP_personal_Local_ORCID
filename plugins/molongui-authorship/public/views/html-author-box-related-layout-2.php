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

            <!-- Related entry thumb -->
            <div class="molongui-author-box-related-entry-thumb">
                <?php if ( has_post_thumbnail( $related->ID ) ) : ?>
                    <a href="<?php echo get_permalink( $related->ID ); ?>">
                        <?php echo get_the_post_thumbnail( $related->ID, 'thumbnail', $attr = array( 'itemprop' => 'thumbnailUrl' ) ) ?>
                    </a>
                <?php else : ?>
                    <img src="<?php echo MOLONGUI_AUTHORSHIP_URL.'public/img/related_placeholder.svg'; ?>" width="<?php echo get_option( 'thumbnail_size_w' ).'px'; ?>">
                <?php endif; ?>
            </div>

            <div class="">
                <!-- Related entry date -->
                <div class="molongui-author-box-related-entry-date" itemprop="datePublished">
                    <?php echo get_the_date( '', $related->ID ); ?>
                </div>

                <!-- Related entry title -->
                <div class="molongui-author-box-related-entry-title">
                    <a class="molongui-remove-text-underline" itemprop="url" href="<?php echo get_permalink( $related->ID ); ?>">
                        <span itemprop="headline"><?php echo $related->post_title; ?></span>
                    </a>
                </div>
            </div>

        </div>
    </li>
    <?php
}