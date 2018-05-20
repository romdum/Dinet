<?php

namespace Dinet\Patient;

class WeightHistoryRepository
{
	private $emptyResult = ['meta_key' => 0, 'meta_value' => 0];

	public function getWeightHistory( Patient $patient ): array
	{
		global $wpdb;
		$result = $wpdb->get_results( $this->getSql( $patient ), ARRAY_A );
		return isset( $result ) ? $result : [$this->emptyResult];
	}

	public function getFirst( Patient $patient ): array
	{
		global $wpdb;
		$result = $wpdb->get_row( $this->getSql( $patient, 'LIMIT 1' ), ARRAY_A );
		return isset( $result ) ? $result : $this->emptyResult;
	}

	private function getSql( Patient $patient, string $append = '' )
	{
		global $wpdb;
		return "
            SELECT SUBSTR(meta_key,1+LENGTH('dinetWeight_')) AS meta_key, meta_value 
            FROM {$wpdb->usermeta} 
            WHERE meta_key LIKE 'dinetWeight_%' 
            AND user_id = {$patient->getUserId()} 
            ORDER BY meta_key DESC
        	$append;
        ";
	}
}
