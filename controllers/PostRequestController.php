<?php

class PostRequestController
{
    /**
	 * POST request called when users update they info
	 */
	function post_add_info()
	{
		if ( isset( $_POST["taille"] ) )
		{
			$taille = htmlspecialchars( floatval( str_replace( ",", ".", $_POST["taille"] ) ) );

			if ( $taille > 3 )
			{
				$taille = $taille / 100;
			}
		}
		$poids = isset( $_POST["poids"] ) ? htmlspecialchars( $_POST["poids"] ) : 0;

		if ( $taille != 0 )
		{
			update_user_meta( get_current_user_id(), "dinet_taille", $taille );
		}
		if ( $poids != 0 )
		{
			update_user_meta( get_current_user_id(), "dinet_poids", $poids );
		}

		wp_redirect( admin_url( "admin.php?page=dinet_plugin" ) );
	}
}
