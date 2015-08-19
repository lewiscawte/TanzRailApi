<?php

class JsonBasicEncoder extends APIEncoder {

	public function __construct( $data ) {
		return json_encode( $data );
	}
}