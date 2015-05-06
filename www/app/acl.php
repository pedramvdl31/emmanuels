<?php

/*
|--------------------------------------------------------------------------
| ACL Resources, Roles, and Permissions
|--------------------------------------------------------------------------
|
| Below you may add resources and roles and define the permissions
| roles have on those resources.
|
*/

// Add Resources
Acl::addResource('admins');
Acl::addResource('apis');
Acl::addResource('companies');
Acl::addResource('deliveries');
Acl::addResource('delivery_rules');
Acl::addResource('invoices');
Acl::addResource('invoice_items');
Acl::addResource('inventories');
Acl::addResource('inventory_items');
Acl::addResource('resources');
Acl::addResource('schedules');
Acl::addResource('schedule_rules');
Acl::addResource('taxes');
Acl::addResource('users');
Acl::addResource('websites');

// Add Roles
Acl::addRole('Superadmins');
	// Give roles permissions on resources
	Acl::allow('Superadmins', 'admins', array());
	Acl::allow('Superadmins', 'apis', array());
	Acl::allow('Superadmins', 'companies', array());
	Acl::allow('Superadmins', 'deliveries', array());
	Acl::allow('Superadmins', 'delivery_rules', array());
	Acl::allow('Superadmins', 'invoices', array());
	Acl::allow('Superadmins', 'invoice_items', array());
	Acl::allow('Superadmins', 'inventories', array());
	Acl::allow('Superadmins', 'inventory_items', array());	
	Acl::allow('Superadmins', 'resources', array());
	Acl::allow('Superadmins', 'schedules', array());
	Acl::allow('Superadmins', 'schedule_rules', array());
	Acl::allow('Superadmins', 'taxes', array());
	Acl::allow('Superadmins', 'users', array());
	Acl::allow('Superadmins', 'websites', array());
Acl::addRole('Admins');
	// Give roles permissions on resources
	Acl::allow('Superadmins', 'admins', array());
	Acl::allow('Superadmins', 'apis', array());
	Acl::allow('Superadmins', 'companies', array());
	Acl::allow('Superadmins', 'deliveries', array());
	Acl::allow('Superadmins', 'delivery_rules', array());
	Acl::allow('Superadmins', 'invoices', array());
	Acl::allow('Superadmins', 'invoice_items', array());
	Acl::allow('Superadmins', 'inventories', array());
	Acl::allow('Superadmins', 'inventory_items', array());	
	Acl::allow('Superadmins', 'resources', array());
	Acl::allow('Superadmins', 'schedules', array());
	Acl::allow('Superadmins', 'schedule_rules', array());
	Acl::allow('Superadmins', 'taxes', array());
	Acl::allow('Superadmins', 'users', array());
	Acl::allow('Superadmins', 'websites', array());

Acl::addRole('Employees');
	// Give roles permissions on resources
	Acl::allow('Superadmins', 'admins', array());
	Acl::allow('Superadmins', 'apis', array());
	Acl::allow('Superadmins', 'companies', array());
	Acl::allow('Superadmins', 'invoices', array());
	Acl::allow('Superadmins', 'invoice_items', array());
	Acl::allow('Superadmins', 'inventories', array());
	Acl::allow('Superadmins', 'inventory_items', array());	
	Acl::allow('Superadmins', 'resources', array());
	Acl::allow('Superadmins', 'schedules', array());
	Acl::allow('Superadmins', 'taxes', array());
	Acl::allow('Superadmins', 'users', array());
	Acl::allow('Superadmins', 'websites', array());
Acl::addRole('Members');
Acl::addRole('Guests');



