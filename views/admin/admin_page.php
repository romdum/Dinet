<?php
	global $wpdb;
	$q = $wpdb->get_results("SELECT * FROM {$wpdb->prefix}users", ARRAY_A);
?>
		<main>
			<section class="aliment">
				<header>
					<h2>Gestion des aliments</h2>
				</header>
				<div>
					<a href="admin.php?page=dinet_add_food">Ajouter un aliment</a>
				</div>
			</section>
			<section class="client">
				<header>
					<h2>Gestion des clients</h2>
				</header>
				<div>
					Consulter la fiche de :
					<select class="customer_card" name="">
						<?php
						foreach($q as $key => $customer):
							$customer_lastname = get_metadata("user", $key+1, "last_name", true);
							$customer_firstname = get_metadata("user", $key+1, "first_name", true);
							// $customer_name = $customer_lastname === "" ? $customer["user_nicename"] : $customer_lastname + " " + $customer_firstname
							// $customer_name = $customer_name === false ? $customer["user_nicename"] : $customer_name + get_metadata("user", $key+1, "last_name", true);
						?>
							<option value="<?= $customer["user_nicename"] ?>"><?= $customer_lastname ?></option>
						<?php
						endforeach;

						?>
					</select>
				</div>
			</section>
		</main>
	</body>
</html>
