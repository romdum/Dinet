<?php

namespace Dinet\Consultation;

use Dinet\Consultation\Controller\ConsultationCtrl;
use Dinet\Consultation\Controller\PostTypeCtrl;
use Dinet\Consultation\Controller\TaxonomyCtrl;

require_once 'Controller/PostTypeCtrl.php';
require_once 'Controller/TaxonomyCtrl.php';
require_once 'Controller/ConsultationCtrl.php';
require_once 'Model/Consultation.php';
require_once 'Repository/ConsultationRepository.php';
require_once 'UI.php';

const NAME = 'Consultation';
const SLUG = 'consultation';

class ConsultationModule
{
    function load()
    {
	    $ui = new UI();
        add_action( 'add_meta_boxes', array( $ui, 'addCustomFields' ), 10, 0 );
        add_filter( 'wp_insert_post_data', array( $ui, 'add_custom_title' ), 10, 2 );
        add_action( 'init', array( $ui, 'loadCSS' ) );
        add_filter( 'default_content', array( $ui, 'defaultContent' ), 10, 2 );

        $postType = new PostTypeCtrl();
        add_action( 'init', array( $postType, 'addConsultationPostType' ), 10, 0 );

        $taxonomy = new TaxonomyCtrl();
        add_action( 'init', array( $taxonomy, 'addTaxonomyToConsultation' ), 10, 0 );

        $consultation = new ConsultationCtrl();
        add_action( 'save_post', array( $consultation, 'save' ), 10, 2 );
    }
}
