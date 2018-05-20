<?php

namespace Dinet\Consultation;

use Dinet\Util;
use Dinet\UtilPath;

class UI
{
    public function loadCss()
    {
        wp_register_style( 'dinet_consultation_css', UtilPath::getCssPath( 'consultation.min' ) );
        wp_enqueue_style( 'dinet_consultation_css' );
    }

	public function addCustomFields()
	{
		add_meta_box(
			'consultationExtraInfo',
			__( 'Informations supplémentaires' ),
			array( $this, 'displayDateMetabox' ),
			'consultation',
			'normal',
			'default'
		);
	}

	public function displayDateMetabox( $post, $metabox )
	{
		$start = get_metadata( 'post', $post->ID, 'dinet_consultation_start', true);
		include UtilPath::getViewsPath( 'consultation/dateMetabox' );
        $patientId = get_metadata( 'post', $post->ID, 'dinet_consultation_patient_id', true);
        include UtilPath::getViewsPath( 'consultation/patientMetabox' );
	}

	public function add_custom_title( $data, $postarr )
    {
        if( $data['post_type'] === 'consultation' && $data['post_title'] === '' )
        {
            $data['post_title'] = 'Consultation du ' . date( 'd/m/Y');
        }
        return $data;
    }

    public function defaultContent( $content, $post)
    {
        if( $post->post_type === 'consultation')
        {
            ob_start();
            include UtilPath::getViewsPath( 'consultation/defaultContent' );
            $content = ob_get_clean();
        }
        return $content;
    }

    public function addDownloadBtn()
    {
        global $post;
        if( $post->post_type === 'consultation' )
        {
            echo '<a href="?post=' . $post->ID . '&action=edit&download=1" class="button">Télécharger</a>';
        }
    }
}