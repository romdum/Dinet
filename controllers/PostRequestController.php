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

    function post_save_patient()
    {
        if( isset( $_POST['firstname'] ) && ! empty( $_POST['firstname'] ) )
		{
			update_user_meta( $_POST['user_id'], 'first_name', $_POST['firstname'] );
		}

        if( isset( $_POST['lastname'] ) && ! empty( $_POST['lastname'] ) )
		{
			update_user_meta( $_POST['user_id'], 'last_name', $_POST['lastname'] );
		}

        if( isset( $_POST['weight'] ) && ! empty( $_POST['weight'] ) )
		{
			update_user_meta( $_POST['user_id'], 'dinet_poids', $_POST['weight'] );
		}

        if( isset( $_POST['height'] ) && ! empty( $_POST['height'] ) )
		{
			$taille = htmlspecialchars( floatval( str_replace( ",", ".", $_POST["height"] ) ) );

			if ( $taille > 3 )
			{
				$taille = $taille / 100;
			}
			update_user_meta( $_POST['user_id'], 'dinet_taille', $_POST['height'] );
		}

		if( isset( $_POST['phone'] ) && ! empty( $_POST['phone'] ) )
		{
			update_user_meta( $_POST['user_id'], 'dinet_phone', $_POST['phone'] );
		}

		if( isset( $_POST['obs'] ) && ! empty( $_POST['obs'] ) )
		{
			update_user_meta( $_POST['user_id'], 'dinet_observation', $_POST['obs'] );
		}

		wp_redirect( admin_url( 'admin.php?page=dinet_patient_record&patient_id=' . $_POST['user_id'] ) );
    }
}
