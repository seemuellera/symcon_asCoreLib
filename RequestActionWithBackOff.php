<?php

	// Version 1.0
	protected function RequestActionWithBackOff($variable, $value) {
		
		$retries = 4;
		$baseWait = 100;
		
		for ($i = 0; $i <= $retries; $i++) {
			
			$wait = $baseWait * $i;
			
			if ($wait > 0) {
				
				$this->LogMessage("Waiting for $wait milliseconds, retry $i of $retries", "DEBUG");
				IPS_Sleep($wait);
			}
			
			$result = RequestAction($variable, $value);
			
			// Return success if executed successfully
			if ($result) {
				
				return true;
			}
			else {
				
				$this->LogMessage("Switching Variable $variable to Value $value failed, but will be retried", "WARN");
			}
			
		}
		
		// return false as switching was not possible after all these times
		$this->LogMessage("Switching Variable $variable to Value $value failed after $retries retries. Aborting", "CRIT");
		return false;
	}
	
?>