<?php

namespace Dinet\Monitoring;

use Dinet\Dinet;

class NewFoodController
{
	function __construct()
	{

	}

	function get_categories()
	{
		global $wpdb;
		return $wpdb->get_results( "SELECT DISTINCT `Groupe` FROM `". Dinet::$table_food ."`;", ARRAY_N );
	}

	function get_all_info()
	{
		return [
	        "designation" => "Désignation",
			"energy" => "Energie (kcal/100g)",
			"water" => "Eau (g/100g)",
			"protein" => "Protéines (g/100g)",
			"glucid" => "Glucides (g/100g)",
			"lipid" => "Lipides (g/100g)",
			"sugar" => "Sucres (g/100g)",
			"amidon" => "Amidons (g/100g)",
			"fiber" => "Fibres alimentaires (g/100g)",
			"saturedAG" => "AG saturés (g/100g)",
			"polyunsaturedAG" => "AG polyinsaturés (g/100g)",
			"monounsaturedAG" => "AG monoinsaturés (g/100g)",
			"omega3" => "Oméga 3 alpha-linolénique (g/100g)",
			"omega6" => "Oméga 6 linoléique (g/100g)",
			"omega9" => "Oméga 9 oléique (g/100g)",
			"epa" => "EPA (g/100g)",
			"dha" => "DHA (g/100g)",
			"cholesterol" => "Cholestérol (mg/100g)",
			"salt" => "Sel chlorure de sodium (g/100g)",
			"calcium" => "Calcium (mg/100g)",
			"cuivre" => "Cuivre (mg/100g)",
			"iron" => "Fer (mg/100g)",
			"magnesium" => "Magnésium (mg/100g)",
			"phosphore" => "Phosphore (mg/100g)",
			"potassium" => "Potassium (mg/100g)",
			"sodium" => "Sodium (mg/100g)",
			"zinc" => "Zinc (mg/100g)",
			"retinol" => "Rétinol (µg/100g)",
			"beta-carotene" => "Beta-Carotène (µg/100g)",
			"vitaminD" => "Vitamine D (µg/100g)",
			"vitaminE" => "Vitamine E (mg/100g)",
			"vitaminK1" => "Vitamine K1 (µg/100g)",
			"vitaminK2" => "Vitamine K2 (µg/100g)",
			"vitaminC" => "Vitamine C (mg/100g)",
			"vitaminB1" => "Vitamine B1 ou Thiamine (mg/100g)",
			"vitaminB2" => "Vitamine B2 ou Riboflavine (mg/100g)",
			"vitaminB3" => "Vitamine B3 ou PP ou Niacine (mg/100g)",
			"vitaminB5" => "Vitamine B5 ou Acide pantothénique (mg/100g)",
			"vitaminB6" => "Vitamine B6 (mg/100g)",
			"vitaminB9" => "Vitamine B9 ou Folates totaux (µg/100g)",
			"vitaminB12" => "Vitamine B12 (µg/100g)"
	    ];
	}

	public function post_add_food()
	{
		global $wpdb;

		$wpdb->insert(
			$wpdb->prefix . "dinet_food",
			array(
				"Groupe" => $_POST["category"],
				"Désignation" => $_POST["designation"],
				"Energie (kcal/100g)" => $_POST["energy"],
				"Eau (g/100g)" => $_POST["water"],
				"Protéines (g/100g)" => $_POST["protein"],
				"Glucides (g/100g)" => $_POST["glucid"],
				"Lipides (g/100g)" => $_POST["lipid"],
				"Sucres (g/100g)" => $_POST["sugar"],
				"Amidon (g/100g)" => $_POST["amidon"],
				"Fibres alimentaires (g/100g)" => $_POST["fiber"],
				"AG saturés (g/100g)" => $_POST["saturedAG"],
				"AG polyinsaturés (g/100g)" => $_POST["polyunsaturedAG"],
				"AG monoinsaturés (g/100g)" => $_POST["monounsaturedAG"],
				// "Oméga 9 oléique (g/100g)" => $_POST["omega9"],
				// "Oméga 6 linoléique (g/100g)" => $_POST["omega6"],
				// "Oméga 3 alpha-linolénique (g/100g)" => $_POST["omega3"],
				"EPA (g/100g)" => $_POST["epa"],
				"DHA (g/100g)" => $_POST["dha"],
				"Cholestérol (mg/100g)" => $_POST["cholesterol"],
				"Sel chlorure de sodium (g/100g)" => $_POST["salt"],
				"Calcium (mg/100g)" => $_POST["calcium"],
				"Cuivre (mg/100g)" => $_POST["cuivre"],
				"Fer (mg/100g)" => $_POST["iron"],
				"Magnésium (mg/100g)" => $_POST["magnesium"],
				"Phosphore (mg/100g)" => $_POST["phosphore"],
				"Potassium (mg/100g)" => $_POST["potassium"],
				"Sodium (mg/100g)" => $_POST["sodium"],
				"Zinc (mg/100g)" => $_POST["zinc"],
				"Rétinol (µg/100g)" => $_POST["retinol"],
				"Beta-Carotène (µg/100g)" => $_POST["beta-carotene"],
				"Vitamine D (µg/100g)" => $_POST["vitaminD"],
				"Vitamine E (mg/100g)" => $_POST["vitaminE"],
				"Vitamine K1 (µg/100g)" => $_POST["vitaminK1"],
				"Vitamine K2 (µg/100g)" => $_POST["vitaminK2"],
				"Vitamine C (mg/100g)" => $_POST["vitaminC"],
				"Vitamine B1 ou Thiamine (mg/100g)" => $_POST["vitaminB1"],
				"Vitamine B2 ou Riboflavine (mg/100g)" => $_POST["vitaminB2"],
				"Vitamine B3 ou PP ou Niacine (mg/100g)" => $_POST["vitaminB3"],
				"Vitamine B5 ou Acide pantothénique (mg/100g)" => $_POST["vitaminB5"],
				"Vitamine B6 (mg/100g)" => $_POST["vitaminB6"],
				"Vitamine B9 ou Folates totaux (µg/100g)" => $_POST["vitaminB9"],
				"Vitamine B12 (µg/100g)" => $_POST["vitaminB12"]
			)
		);

		wp_redirect( admin_url( "admin.php?page=dinet_admin_plugin" ) );
	}
}
