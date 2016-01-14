<?

$pwccrm_escaping = array(

	'attr' => function( $value ) {
		return esc_attr( $value . '?1=1&2=two' );
	}

);

