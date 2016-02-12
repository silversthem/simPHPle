<?php
/*
* Example routes
* Ticket routes
*/
return array(
	'Module' => 'tickets'
	'Controller' => 'Ticket',
	'Action' => 'exec',
	'first_pattern' => 'tickets{a}',
	'GET' => array('id' => '[0-9]+'), // conditions for all get
	'pattern' => array(
		array('pattern' => 'tickets/'), // see first page
		array('pattern' => 'tickets/{page}','action' => Query('OnShow','page'),'GET' => array('page' => '[0-9]+')), // see a page
		array('pattern' => 'tickets/add','action' => Action('onAdd')), // add a ticket
		array('pattern' => 'tickets/edit/{id}','action' => Query('onEdit','id')), //  edits it
		array('pattern' => 'tickets/delete{id}','action' => Query('onDelete','id')), // deletes it
		array('pattern' => 'tickets/see/{id}','action' => Query('onShowTicket','id')) // see a ticket
	)
);
?>
