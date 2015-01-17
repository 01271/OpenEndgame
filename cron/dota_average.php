<?php

function schema_570() {return json_decode( file_get_contents( $_SERVER['DOCUMENT_ROOT'] . '/api/570_schema.json' ), true );}

$schema = schema_570();

$start = '';
$end = $start + 20;

$items = array_slice( ( $schema['items'] ), $start, $end );
foreach ( $schema['items'] as $item ) {

	$class = json_decode( get_data(), true );

}
