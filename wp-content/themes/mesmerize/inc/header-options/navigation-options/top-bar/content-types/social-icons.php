<?php

add_filter("mesmerize_get_content_types", function ($types) {
    $types['social'] = esc_html__("Social Icons", 'mesmerize');

    return $types;
});

add_filter("mesmerize_get_content_types_options", function ($options) {
    $options['social'] = "mesmerize_top_bar_social_icons_fields_options";

    return $options;
});

function mesmerize_top_bar_social_icons_fields_options($area, $section, $priority, $prefix)
{

    mesmerize_add_kirki_field(array(
        'type'     => 'sectionseparator',
        'label'    => esc_html__('Social Icons', 'mesmerize'),
        'section'  => $section,
        'priority' => $priority,
        'settings' => "{$prefix}_social_fields_icons_separator",
    ));

    $group_choices = array(
        "{$prefix}_social_fields_colors_separator",
        "{$prefix}_social_icons_options_icon_color",
        "{$prefix}_social_icons_options_icon_hover_color",
        "{$prefix}_social_fields_icons_separator",
    );


    $default_icons = array(
        array(
            "icon" => "fa-facebook-official",
            "link" => "https://facebook.com",
        ),
        array(
            "icon" => "fa-twitter-square",
            "link" => "https://twitter.com",
        ),
        array(
            "icon" => "fa-instagram",
            "link" => "https://instagram.com",
        ),
        array(
            "icon" => "fa-google-plus-square",
            "link" => "https://plus.google.com",
        ),
    );


    for ($i = 0; $i < count($default_icons); $i++) {
        mesmerize_add_kirki_field(array(
            'type'     => 'checkbox',
            'label'    => sprintf(esc_html__('Show Icon %d', 'mesmerize'), ($i + 1)),
            'section'  => $section,
            'priority' => $priority,
            'settings' => "{$prefix}_social_icon_{$i}_enabled",
            'default'  => true,
        ));


        $active_callback = array(
            array(
                'setting'  => "{$prefix}_social_icon_{$i}_enabled",
                'operator' => '==',
                'value'    => true,
            ),
        );

        $group_choices[] = "{$prefix}_social_icon_{$i}_enabled";

        mesmerize_add_kirki_field(array(
            'type'            => 'font-awesome-icon-control',
            'settings'        => "{$prefix}_social_icon_{$i}_icon",
            'label'           => sprintf(esc_html__('Icon %d icon', 'mesmerize'), ($i + 1)),
            'section'         => $section,
            'priority'        => $priority,
            'default'         => $default_icons[$i]['icon'],
            'active_callback' => $active_callback,

        ));

        $group_choices[] = "{$prefix}_social_icon_{$i}_icon";

        mesmerize_add_kirki_field(array(
            'type'      => 'text',
            'settings'  => "{$prefix}_social_icon_{$i}_link",
            'label'     => sprintf(esc_html__('Field %d link', 'mesmerize'), ($i + 1)),
            'section'   => $section,
            'priority'  => $priority,
            'transport' => 'postMessage',
            'default'   => $default_icons[$i]['link'],
            'active_callback' => $active_callback
        ));

        $group_choices[] = "{$prefix}_social_icon_{$i}_link";
    }

    mesmerize_add_kirki_field(array(
        'type'            => 'sidebar-button-group',
        'settings'        => "{$prefix}_social_icons_group_button",
        'label'           => esc_html__('Social Icons Options', 'mesmerize'),
        'section'         => $section,
        'priority'        => $priority,
        "choices"         => $group_choices,
        'active_callback' => array(
            array(
                'setting'  => "{$prefix}_content",
                'operator' => '==',
                'value'    => 'social',
            ),
            array(
                'setting'  => "enable_top_bar",
                'operator' => '==',
                'value'    => true,
            ),
        ),
    ));
}


/*
    template functions
*/


add_action("mesmerize_header_top_bar_content_print", function ($areaName, $type) {
    if ($type == 'social') {
        mesmerize_print_area_social_icons('header_top_bar', $areaName, "top-bar-social-icons");
    }
}, 1, 2);

function mesmerize_default_icons()
{
    return array(
        array(
            "icon" => "fa-facebook-official",
            "link" => "https://facebook.com",
        ),
        array(
            "icon" => "fa-twitter-square",
            "link" => "https://twitter.com",
        ),
        array(
            "icon" => "fa-instagram",
            "link" => "https://instagram.com",
        ),
        array(
            "icon" => "fa-google-plus-square",
            "link" => "https://plus.google.com",
        ),
        array(
            "icon" => "fa-youtube-square",
            "link" => "https://www.youtube.com",
        ),
    );
}

function mesmerize_print_area_social_icons($prefix, $area, $class = "social-icons", $max = 4)
{


    $defaults = mesmerize_default_icons();

    $preview_atts = "";
    if (mesmerize_is_customize_preview()) {
        $setting      = "{$prefix}_{$area}_social_icon_0_enabled";
        $preview_atts = "data-focus-control='" . esc_attr($setting) . "'";
    }

    ?>
    <div data-type="group" <?php echo $preview_atts; ?> data-dynamic-mod="true" class="<?php echo esc_attr($class); ?>">
        <?php

        for ($i = 0; $i < min(count($defaults), $max); $i++) {

            $is_enabled = get_theme_mod("{$prefix}_{$area}_social_icon_{$i}_enabled", true);
            $icon       = get_theme_mod("{$prefix}_{$area}_social_icon_{$i}_icon", $defaults[$i]['icon']);
            $link       = get_theme_mod("{$prefix}_{$area}_social_icon_{$i}_link", "");

            $hidden_attr = "";

            if ( ! intval($is_enabled)) {
                $hidden_attr = "data-reiki-hidden='true'";
                continue;
            }

            if ( ! mesmerize_can_show_demo_content() && ! $link) {
                continue;
            }

            ?>

            <a target="_blank" <?php echo $hidden_attr ?> class="social-icon" href="<?php echo esc_url($link) ?>">
                <i class="fa <?php echo esc_attr($icon) ?>"></i>
            </a>

            <?php
        }
        ?>

    </div>

    <?php
}