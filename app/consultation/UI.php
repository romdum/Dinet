<?php

namespace Dinet\Consultation;

class UI
{
	public function __construct()
	{
		add_action( 'add_meta_boxes', array( $this, 'addCustomFields' ), 10, 0 );

		add_filter( 'wp_insert_post_data', array( $this, 'add_custom_title' ), 10, 2 );
	}

	public function addCustomFields()
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

	public function displayDateMetabox( $post, $metabox )
	{
		$start = get_metadata( 'post', $post->ID, 'dinet_consultation_start', true);
		$end = get_metadata( 'post', $post->ID, 'dinet_consultation_end', true);
		include '../ressources/views/admin/dateMetabox.php';
	}

	public function displayPatientMetabox( $post, $metabox )
	{
		include '../ressources/views/admin/patientMetabox.php';
	}

	public function add_custom_title( $data, $postarr )
	{
		if( $data['post_type'] === 'consultation' )
		{
			$data['post_title'] = 'Consultation';
		}
		return $data;
	}
}