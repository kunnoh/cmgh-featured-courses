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
		<a
			href="<?php echo esc_url(home_url('/course/' . ($course->slug ?: $course->course_id))); ?>"
			class="course-card"
		>
			<div class="course-content">
				<h3 class="course-title">
					<?php echo esc_html($course->title); ?>
				</h3>

				<!-- <p class="course-description">
					<?php echo esc_html($course->short_description); ?>
				</p> -->
			</div>
		</a>
    <?php endforeach; ?>
</div>
