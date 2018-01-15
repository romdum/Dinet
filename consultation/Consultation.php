<?php

namespace Dinet\Consultation;

require_once 'PostType.php';
require_once 'Taxonomy.php';
require_once 'UI.php';

class Consultation
{
    function __construct()
    {
	    new PostType();
	    new Taxonomy();
	    new UI();

        add_action( 'save_post', array( $this, 'saveCustomField' ), 10, 3 );
    }

    function saveCustomField( $post_id, $post, $update )
    {
        if( $post->post_type !== 'consultation' )
            return;

        if( isset( $_POST['start'] ) )
            update_post_meta( $post_id, 'dinet_consultation_start', $_POST['start'] );

        if( isset( $_POST['end'] ) )
            update_post_meta( $post_id, 'dinet_consultation_end', $_POST['end'] );

        if( isset( $_POST['patient_id'] ) )
            update_post_meta( $post_id, 'dinet_consultation_patient_id', $_POST['patient_id'] );
    }
}
