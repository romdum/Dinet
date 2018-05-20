<?php

namespace Dinet\Consultation\Controller;

class TaxonomyCtrl
{
	public function addTaxonomyToConsultation()
	{
		register_taxonomy( 'consultation_type', 'consultation', [
				'hierarchical' => true,
				'labels' => [
					'name' => 'Type',
					'singular_name' => 'Types',
					'all_items' => 'Tous les types',
					'edit_item' => 'Éditer le type',
					'view_item' => 'Voir le type',
					'update_item' => 'Mettre à jour le type',
					'add_new_item' => 'Ajouter un type',
					'new_item_name' => 'Nouveau type',
					'search_items' => 'Rechercher parmi les types',
					'popular_items' => 'Types les plus utilisées'
				],
				'query_var' => true,
				'rewrite' => true]
		);

		register_taxonomy_for_object_type( 'consultation_type', 'consultation' );

		$this->addDefaultConsultationType();
	}

	public function addDefaultConsultationType()
	{
		$terms = [
			["taxonomy" => "consultation_type", "name" => "Premier rendez-vous", "description" => "Premier rendez-vous", "slug" => "firstmeeting" ],
			["taxonomy" => "consultation_type", "name" => "Suivi régulier", "description" => "Suivi régulier", "slug" => "suivi" ],
		];

		foreach( $terms as $term )
		{
			wp_insert_term(
				$term["name"],
				$term["taxonomy"],
				[ 'description'=> $term["description"], 'slug' => $term["slug"]]
			);
		}
	}

}