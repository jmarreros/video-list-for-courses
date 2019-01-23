<?php

/**
 * Provide a public-facing view for the list courses
 *
 * This file is used to markup the list of courses
 *
 * @link       https://decodecms.com
 * @since      1.0.0
 *
 * @package    Video_List_For_Courses
 * @subpackage Video_List_For_Courses/public/partials
 */

require_once VLFC_DIR . 'helpers/functions.php';
?>

<div class="vlfc-courses-container">
    <?php foreach( $courses as $course ) : ?>
        <a href="<?= $course->linkpage ?>" class="vlfc-course">
            <div class="vlf-img">

                <?php if ( $course->label ): ?>
                    <span class="vlf-label <?= $course->label ?>"><?= $course->label ?></span>
                <?php endif; ?>

                <img src="<?= $course->image ?>" alt="<?= $course->title ?>" width="250" height="250" />
            </div>
            <div class="vlf-text">
                <h2><?= $course->title ?></h2>
                <p><?= $course->description ?></p>
            </div>
        </a>
    <?php endforeach; ?>
</div>

