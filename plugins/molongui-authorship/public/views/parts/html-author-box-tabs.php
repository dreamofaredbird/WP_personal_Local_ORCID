<?php
$box_tabs = array
(
    'name' => 'mab-tabs-'.$random_id,
    'tabs' => array
    (
        'profile' => array
        (
            'id'       => 'mab-tab-profile-'.$random_id,
            'label'    => ( $settings['about_the_author'] ? $settings['about_the_author'] : __( 'About the author', MOLONGUI_AUTHORSHIP_TEXTDOMAIN ) ),
            'label_id' => 'molongui-author-box-string-about-the-author',
            'checked'  => true,
            'display'  => true,
        ),
        'related' => array
        (
            'id'       => 'mab-tab-related-'.$random_id,
            'label'    => ( $settings['related_posts'] ? $settings['related_posts'] : __( 'Related posts', MOLONGUI_AUTHORSHIP_TEXTDOMAIN ) ),
            'label_id' => 'molongui-author-box-string-related-posts',
            'checked'  => false,
            'display'  => true,
        ),
        'contact' => array
        (
            'id'       => 'mab-tab-contact-'.$random_id,
            'label_id' => 'molongui-author-box-string-contact',
            'checked'  => false,
            'display'  => false,
        ),
    ),
);
if ( isset( $settings['tabs_position'] ) and !empty( $settings['tabs_position'] ) ) $position = explode('-', $settings['tabs_position'] );
$nav_class  = '';
$nav_class .= ' molongui-author-box-tabs-'.$position[0].' molongui-author-box-tabs-'.$position[1];
$tab_class  = '';
$tab_class .= ( ( isset( $settings['tabs_border'] ) and !empty( $settings['tabs_border'] ) ) ? ' molongui-author-box-tab-border-'.$settings['tabs_border'] : '' );
$active_class = 'molongui-author-box-tab-active';
?>

<script type="text/javascript" language="JavaScript">

	function molonguiHandleTab(myRadio)
	{
        var mabId = myRadio.id.slice( myRadio.id.lastIndexOf('-')+1 );
		document.querySelector( '#mab-'+mabId+' .molongui-author-box-tabs nav label.molongui-author-box-tab.<?php echo $active_class; ?>' ).classList.remove( '<?php echo $active_class; ?>' );
		document.querySelector( 'label[for='+myRadio.id+']' ).classList.add( '<?php echo $active_class; ?>' );
	}

</script>

<?php
foreach ( $box_tabs['tabs'] as $box_tab ) :
    if ( !$box_tab['display'] ) continue; ?>
    <input type="radio" id="<?php echo $box_tab['id']; ?>" name="<?php echo $box_tabs['name']; ?>" onclick="molonguiHandleTab(this);" <?php echo ( $box_tab['checked'] ? 'checked' : '' ); ?>>
<?php endforeach; ?>

<nav class="<?php echo $nav_class; ?>" style="<?php //echo $nav_style; ?>">
    <?php foreach ( $box_tabs['tabs'] as $box_tab )
    {
        if ( !$box_tab['display'] ) continue;
        ?>
            <label for="<?php echo $box_tab['id']; ?>"
                   class="molongui-author-box-tab <?php echo $tab_class; echo ( $box_tab['checked'] ? ' '.$active_class : '' ); ?>"
                   style="<?php echo ( ( isset( $settings['tabs_text_color'] ) and !empty( $settings['tabs_text_color'] ) ) ? 'color:'.$settings['tabs_text_color'] : '' ); //echo $tab_style; echo ( $box_tab['checked'] ? $active_style : '' ); ?>">
                <span class="<?php echo $box_tab['label_id']; ?>"><?php echo $box_tab['label']; ?></span>
            </label>
        <?php
    }?>
</nav>