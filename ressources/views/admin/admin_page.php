		<main>
			<section class="patient_list">
				<header>
					<h2>Liste des patients</h2>
					<a href="<?= admin_url( 'user-new.php' ) ?>"><button type="button" name="button" class="button button-primary">Ajouter</button></a>
				</header>
				<table class="widefat striped">
					<thead>
						<th>Identifiant</th>
						<th>Nom</th>
						<th>Prénom</th>
						<th>Date de création</th>
						<th></th>
					</thead>
					<tbody>
						<?php foreach( get_users( ['role__not_in' => ['administrator']] ) as $user ):
							$Patient = new Dinet\Patient\Patient( $user->ID );
							?>
							<tr>
								<td><?= $Patient->get_login() ?></td>
								<td><?= $Patient->get_first_name() ?></td>
								<td><?= $Patient->get_last_name() ?></td>
								<td><?= $Patient->get_registered_date() ?></td>
								<td style="width:50px"><a href="<?= admin_url('admin.php?page=dinet_patient_record&patient_id='.$Patient->get_user_id()) ?>"><span class="dashicons dashicons-welcome-write-blog"></span></a></td>
							</tr>
						<?php endforeach; ?>
					</tbody>
				</table>
			</section>
		</main>
	</body>
</html>
