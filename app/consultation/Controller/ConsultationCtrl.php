<?php

namespace Dinet\Consultation\Controller;

use Dinet\Consultation\Model\Consultation;
use Dinet\Consultation\Repository\ConsultationRepository;
use Dinet\UtilPath;
use WP_Post;

class ConsultationCtrl
{
    /** @var Consultation */
    private $consultation;

    /** @var ConsultationRepository */
    private $consultationRepository;

    public function __construct( Consultation $consultation = null )
    {
        $this->consultation = $consultation ?: new Consultation();
        $this->consultationRepository = new ConsultationRepository();
    }

    /**
     * @param int $post_id
     * @param WP_Post $post
     */
    public function save( $post_id, $post )
    {
        if( $post->post_type === 'consultation' )
        {
            if( isset( $_POST['start'] ) )
            {
                update_post_meta( $post_id, 'dinet_consultation_start', $_POST['start'] );
            }

            if( isset( $_POST['patient_id'] ) )
            {
                update_post_meta( $post_id, 'dinet_consultation_patient_id', $_POST['patient_id'] );
            }
            if( $post->post_status !== 'private' )
            {
                wp_update_post([ 'ID' => $post_id, 'post_status' => 'private' ]);
            }
        }
    }

    public function generatePdf()
    {
        $post = get_post( @$_GET['post'] );

        if( $post && $post->post_type === 'consultation' && @$_GET['download'] == '1' && @$_GET['action'] === 'edit' )
        {
            require_once UtilPath::getPluginPath( 'libs/dompdf/autoload.inc' );
            require_once UtilPath::getConsultationPath( 'Controller/PdfGenerator' );
            $pdfGenerator = new PdfGenerator();

            ob_start();
            include UtilPath::getViewsPath( 'consultation/pdfTemplate' );
            $html = ob_get_clean();

            $filename = 'consultation_';
            $username = get_user_by( 'ID', get_post_meta( $post->ID,  'dinet_consultation_patient_id', true ) )->display_name;
            $filename .= str_replace( ' ', '_', strtolower($username) );
            $date = str_replace( ['/', ':', ' '], '', get_post_meta( $post->ID,  'dinet_consultation_start', true ) );
            $filename .= empty( $date ) ? '' : '_' . substr($date, 0, 8);

            $pdfGenerator->generate( $html, $filename );
        }
    }
}