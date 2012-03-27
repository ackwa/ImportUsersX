<?php

	// Prompts options to user user during installation
	$output  = '<input type="checkbox" name="create_document" id="create_document" value="Yes" align="left"/>';
	$output .= '<label for="create_document">Create executing document (recommended)</label>';
	$output .= '<p><strong>Check that box to create document that executes the snippet</strong></p>';
	
	return $output;