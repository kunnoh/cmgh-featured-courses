<?php
/**
 * PHP file to use when rendering the block type on the server to show on the front end.
 *
 * The following variables are exposed to the file:
 *     $attributes (array): The block attributes.
 *     $content (string): The block default content.
 *     $block (WP_Block): The block instance.
 *
 * @see https://github.com/WordPress/gutenberg/blob/trunk/docs/reference-guides/block-api/block-metadata.md#render
 */
$limit = isset($attributes['limit']) ? (int) $attributes['limit'] : 6;

global $wpdb;

$courses = $wpdb->get_results($wpdb->prepare("
    SELECT
        c.course_id,
        c.title,
        c.slug,
        c.short_description,
        c.cover_image_url,
        c.duration_hours,
        c.price,
        cat.name AS category_name
    FROM cmgh_course c
    INNER JOIN cmgh_category cat
        ON c.category_id = cat.category_id
    WHERE c.is_active = 1
    ORDER BY c.created_at DESC
    LIMIT %d
", $limit));

if (empty($courses)) {
    echo '<p class="no-courses">No featured courses available at the moment.</p>';
    return;
}
?>

<div <?php echo get_block_wrapper_attributes(['class' => 'cmgh-course-grid']); ?>>
    <?php foreach ($courses as $course) : ?>
        <div class="course-card">
            <?php if (!empty($course->cover_image_url)) : ?>
                <img 
                    src="<?php echo esc_url($course->cover_image_url); ?>" 
                    alt="<?php echo esc_attr($course->title); ?>"
                    class="course-image"
                >
            <?php endif; ?>

            <div class="course-content">
                <span class="course-category">
                    <?php echo esc_html($course->category_name); ?>
                </span>
                
                <h3 class="course-title">
                    <?php echo esc_html($course->title); ?>
                </h3>
                
                <p class="course-description">
                    <?php echo esc_html($course->short_description); ?>
                </p>
                
                <div class="course-meta">
                    <span class="duration">
                        <?php echo esc_html($course->duration_hours); ?> Hours
                    </span>
                    <span class="price">
                        $<?php echo number_format((float)$course->price, 2); ?>
                    </span>
                </div>
                
                <a 
                    href="<?php echo esc_url(home_url('/course/' . $course->slug)); ?>" 
                    class="btn course-btn"
                >
                    View Course
                </a>
            </div>
        </div>
    <?php endforeach; ?>
</div>
