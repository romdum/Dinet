<?php

namespace Dinet\Consultation;

class PostType
{
	public function __construct()
	{
		add_action( 'init', array( $this, 'addConsultationPostType' ) );
	}

	public function addConsultationPostType()
	{
		register_post_type( 'consultation',
			[
				'labels' => [
					'name' => __('Consultations'),
					'singular_name' => __('Consultation'),
					'all_items' => 'Toutes les consultations',
					'add_new_item' => 'Ajouter une consultation',
					'edit_item' => 'Éditer la consultation',
					'new_item' => 'Nouvelle consultation',
					'view_item' => 'Voir la consultation',
					'search_items' => 'Rechercher parmi les consultations',
					'not_found' => 'Pas de consultation trouvée',
					'not_found_in_trash'=> 'Pas de consultation dans la corbeille'
				],
				'capability_type' => 'post',
				'supports' => [
					'editor',
				],
				'public' => true,
				'exclude_from_search' => true,
				'publicly_queryable' => false,
				'has_archive' => false
			] );
	}
}