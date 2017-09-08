<?php

class Dinet_consultation
{
    function __construct()
    {
        add_action( 'init', array( $this, 'addConsultationPostType' ) );
        add_action( 'init', array( $this, 'addTaxonomyToConsultation' ) );
        add_action( 'init', array( $this, 'addDefaultConsultationType' ) );
        add_action( 'init', array( $this, 'addCustomFields' ) );

        add_action( 'save_post', array( $this, 'saveCustomField' ), 10, 3 );

        add_filter( 'wp_insert_post_data', array( $this, 'add_custom_title' ), 10, 2 );
    }

    function addConsultationPostType()
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

    function addTaxonomyToConsultation()
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
    }

    function addDefaultConsultationType()
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

    function addCustomFields()
    {
        add_meta_box(
            'consultationDate',
            'Date et heure',
            array( $this, 'displayDateMetabox' ),
            'consultation',
            'normal',
            'default'
        );
        add_meta_box(
            'consultationPatient',
            'Patient',
            array( $this, 'displayPatientMetabox' ),
            'consultation',
            'normal',
            'default'
        );
    }

    function displayDateMetabox( $post, $metabox )
    {
        $start = get_metadata( 'post', $post->ID, 'dinet_consultation_start', true);
        $end = get_metadata( 'post', $post->ID, 'dinet_consultation_end', true);
        include 'views/admin/dateMetabox.php';
    }

    function displayPatientMetabox( $post, $metabox )
    {
        include 'views/admin/patientMetabox.php';
    }

    function saveCustomField( $post_id, $post, $update )
    {
        if( $post->post_type !== 'consultation' )
            return;

        if( isset( $_POST['start'] ) )
        {
            update_post_meta( $post_id, 'dinet_consultation_start', $_POST['start'] );
        }
        if( isset( $_POST['end'] ) )
        {
            update_post_meta( $post_id, 'dinet_consultation_end', $_POST['end'] );
        }
        if( isset( $_POST['patient_id'] ) )
        {
            update_post_meta( $post_id, 'dinet_consultation_patient_id', $_POST['patient_id'] );
        }
    }

    function add_custom_title( $data, $postarr )
    {
        if( $data['post_type'] === 'consultation' )
        {
            $data['post_title'] = 'Consultation';
        }
        return $data;
    }
}
