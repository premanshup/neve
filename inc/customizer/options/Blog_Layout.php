<?php
/**
 * Blog layout section.
 *
 * Author:          Andrei Baicus <andrei@themeisle.com>
 * Created on:      20/08/2018
 * @package Neve\Customizer\Options
 */

namespace Neve\Customizer\Options;

use Neve\Customizer\Base_Customizer;
use Neve\Customizer\Types\Control;
use Neve\Customizer\Types\Section;

class Blog_Layout extends Base_Customizer {
	/**
	 * Function that should be extended to add customizer controls.
	 *
	 * @return void
	 */
	public function add_controls() {
		$this->section_blog();
		$this->control_blog_layout();
		$this->control_excerpt();
		$this->control_pagination_type();
		$this->control_hide_categories();
	}

	/**
	 * Add customize section
	 */
	private function section_blog() {
		$this->add_section(
			new Section(
				'neve_blog_archive_layout',
				array(
					'priority' => 35,
					'title'    => esc_html__( 'Blog / Archive', 'neve' ),
					'panel'    => 'neve_layout',
				)
			)
		);
	}

	/**
	 * Add blog layout controls
	 */
	private function control_blog_layout() {
		$this->add_control(
			new Control(
				'neve_blog_archive_layout',
				array(
					'default'           => 'default',
					'sanitize_callback' => array( $this, 'sanitize_blog_layout' ),
				),
				array(
					'label'       => esc_html__( 'Blog', 'hestia-pro' ) . ' ' . esc_html__( 'Layout', 'hestia-pro' ),
					'section'     => 'neve_blog_archive_layout',
					'priority'    => 25,
					'choices'     => array(
						'default'     => array(
							'url' => 'data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAAJYAAABqAgMAAAAjP0ATAAAACVBMVEX///8+yP/V1dXG9YqxAAAAS0lEQVRYw2NgGAXDE4RCQMDAKONahQ5WUKBs1AujXqDEC6NgiANRSDyH0EwZRvJZ1UCBslEvjHqBZl4YBYMUjNb1o14Y9cIoGH4AALJWvPSk+QsLAAAAAElFTkSuQmCC',
						),
						'alternative' => array(
							'url' => 'data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAAJYAAABqAgMAAAAjP0ATAAAACVBMVEX///8+yP/V1dXG9YqxAAAAPklEQVR42mNgGAXDE4RCQMDAKONahQ5WUKBs1AujXqDEC6NgtOAazTKjXhgtuEbBaME1mutHvTBacI0C4gEAenW95O4Ccg4AAAAASUVORK5CYII=',
						),
						'grid'        => array(
							'url' => 'data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAAJYAAABqCAMAAABpj1iyAAAACVBMVEUAyv/V1dX////o4eoDAAAAfUlEQVR42u3ZoQ0AMAgAQej+Q3cDCI6QQyNOvKGNt3KwsLCwsLB2sKKc4V6/iIWFhYWFhYWFhXWN5cQ4xcpyhos9K8tZytKW5CWvLclLXltYWFhYWFj+Ez0kYWFhYWFhYWFhYTkxrrGyHC/N2pK85LUleclrCwsLCwvrMOsDUDxdDThzw38AAAAASUVORK5CYII=',
						),
					),
					'subcontrols' => array(
						'alternative' => array(),
						'default'     => array(),
						'grid'        => array(
							'neve_grid_layout',
						),
					),
				),
				'Neve\Customizer\Controls\Radio_Image'
			)
		);

		$this->add_control(
			new Control(
				'neve_grid_layout',
				array(
					'sanitize_callback' => 'absint',
					'default'           => '1',
				),
				array(
					'priority'    => 30,
					'section'     => 'neve_blog_archive_layout',
					'label'       => esc_html__( 'Grid Layout', 'neve' ),
					'choices'     => array(
						'1' => esc_html__( '1 Column', 'neve' ),
						'2' => esc_html__( '2 Columns', 'neve' ),
						'3' => esc_html__( '3 Columns', 'neve' ),
						'4' => esc_html__( '4 Columns', 'neve' ),
					),
					'subcontrols' => array(
						'1' => array(),
						'2' => array(
							'neve_enable_masonry',
						),
						'3' => array(
							'neve_enable_masonry',
						),
						'4' => array(
							'neve_enable_masonry',
						),
					),
					'parent'      => 'neve_blog_archive_layout',
				),
				'Neve\Customizer\Controls\Reactive_Select'
			)
		);

		$this->add_control(
			new Control(
				'neve_enable_masonry',
				array(
					'sanitize_callback' => 'neve_sanitize_checkbox',
					'default'           => false,
				),
				array(
					'type'     => 'checkbox',
					'priority' => 35,
					'section'  => 'neve_blog_archive_layout',
					'label'    => esc_html__( 'Enable Masonry', 'neve' ),
				)
			)
		);
	}

	/**
	 * Add excerpt control
	 */
	private function control_excerpt() {
		$this->add_control( new Control(
				'neve_post_excerpt',
				array(
					'sanitize_callback' => 'neve_sanitize_range_value',
					'transport'         => $this->selective_refresh,
					'default'           => 40,
				),
				array(
					'label'      => esc_html__( 'Excerpt Length', 'neve' ),
					'section'    => 'neve_blog_archive_layout',
					'type'       => 'range-value',
					'input_attr' => array(
						'min'  => 5,
						'max'  => 100,
						'step' => 5,
					),
					'priority'   => 40,
				),
				'Neve\Customizer\Controls\Range'
			)
		);
	}

	/**
	 * Add infinite scroll control
	 */
	private function control_pagination_type() {
		$this->add_control(
			new Control(
				'neve_pagination_type',
				array(
					'default'           => 'number',
					'sanitize_callback' => array( $this, 'sanitize_pagination_type' ),
				),
				array(
					'label'    => esc_html__( 'Post Pagination', 'neve' ),
					'section'  => 'neve_blog_archive_layout',
					'priority' => 45,
					'type'     => 'select',
					'choices'  => array(
						'number'   => esc_html__( 'Number', 'neve' ),
						'infinite' => esc_html__( 'Infinite Scroll', 'neve' ),
					),
				)
			)
		);
	}

	/**
	 * Add categories toggle control
	 */
	private function control_hide_categories() {
		$this->add_control(
			new Control(
				'neve_hide_categories',
				array(
					'sanitize_callback' => 'neve_sanitize_checkbox',
					'default'           => false,
				),
				array(
					'type'     => 'checkbox',
					'priority' => 50,
					'section'  => 'neve_blog_archive_layout',
					'label'    => esc_html__( 'Hide Categories', 'neve' ),
				)
			)
		);
	}

	/**
	 * Sanitize the container layout value
	 *
	 * @param string $value value from the control.
	 *
	 * @return bool
	 */
	public function sanitize_blog_layout( $value ) {
		$allowed_values = array( 'default', 'alternative', 'grid' );
		if ( ! in_array( $value, $allowed_values ) ) {
			return 'default';
		}

		return esc_html( $value );
	}

	/**
	 * Sanitize the pagination type
	 *
	 * @param string $value value from the control.
	 *
	 * @return bool
	 */
	public function sanitize_pagination_type( $value ) {
		$allowed_values = array( 'number', 'infinite' );
		if ( ! in_array( $value, $allowed_values ) ) {
			return 'number';
		}

		return esc_html( $value );
	}
}