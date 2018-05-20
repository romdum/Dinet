<?php

namespace Dinet\Consultation\Controller;

use Dinet\UtilPath;
use Dompdf\Css\Stylesheet;
use Dompdf\Dompdf;
use Dompdf\Options;

require_once UtilPath::getPluginPath( 'libs/dompdf/autoload.inc' );

class PdfGenerator
{
    public function generate( string $html, string $filename = 'document.pdf' )
    {
        // instantiate and use the dompdf class
        $dompdf = new Dompdf();
        $dompdfOptions = new Options();
        $dompdfCss = new Stylesheet( $dompdf );
        $dompdfCss->load_css_file('https://stackpath.bootstrapcdn.com/bootstrap/4.1.1/css/bootstrap.min.css' );

        $dompdfOptions->setIsHtml5ParserEnabled( true );
        $dompdf->setOptions( $dompdfOptions );
        $dompdf->setCss( $dompdfCss );

        $dompdf->loadHtml( self::cleanContent( $html ) );

        // (Optional) Setup the paper size and orientation
        $dompdf->setPaper('A4' );

        // Render the HTML as PDF
        $dompdf->render();

        // Output the generated PDF to Browser
        $dompdf->stream( $filename );
    }

    public static function cleanContent($html)
    {
        $html = str_replace( '&nbsp;', '<br>', $html);
        return $html;
    }

}