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
Acl::addResource('deliveryrules');
Acl::addResource('invoices');
Acl::addResource('invoiceitems');
Acl::addResource('inventories');
Acl::addResource('inventoryitems');
Acl::addResource('menus');
Acl::addResource('menuitems');
Acl::addResource('pages');
Acl::addResource('resources');
Acl::addResource('schedules');
Acl::addResource('schedulerules');
Acl::addResource('services');
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
	Acl::allow('Superadmins', 'deliveryrules', array());
	Acl::allow('Superadmins', 'invoices', array());
	Acl::allow('Superadmins', 'invoiceitems', array());
	Acl::allow('Superadmins', 'inventories', array());
	Acl::allow('Superadmins', 'inventoryitems', array());
	Acl::allow('Superadmins', 'menus', array());	
	Acl::allow('Superadmins', 'menuitems', array());	
	Acl::allow('Superadmins', 'pages', array());	
	Acl::allow('Superadmins', 'resources', array());
	Acl::allow('Superadmins', 'schedules', array());
	Acl::allow('Superadmins', 'schedulerules', array());
	Acl::allow('Superadmins', 'services', array());
	Acl::allow('Superadmins', 'taxes', array());
	Acl::allow('Superadmins', 'users', array());
	Acl::allow('Superadmins', 'websites', array());
Acl::addRole('Admins');
	// Give roles permissions on resources
	Acl::allow('Admins', 'admins', array());
	Acl::allow('Admins', 'apis', array());
	Acl::allow('Admins', 'companies', array());
	Acl::allow('Admins', 'deliveries', array());
	Acl::allow('Admins', 'deliveryrules', array());
	Acl::allow('Admins', 'invoices', array());
	Acl::allow('Admins', 'invoiceitems', array());
	Acl::allow('Admins', 'inventories', array());
	Acl::allow('Admins', 'inventoryitems', array());
	Acl::allow('Admins', 'menus', array());	
	Acl::allow('Admins', 'menuitems', array());
	Acl::allow('Admins', 'pages', array());
	Acl::allow('Admins', 'resources', array());
	Acl::allow('Admins', 'schedules', array());
	Acl::allow('Admins', 'schedulerules', array());
	Acl::allow('Admins', 'services', array());
	Acl::allow('Admins', 'taxes', array());
	Acl::allow('Admins', 'users', array());
	Acl::allow('Admins', 'websites', array());

Acl::addRole('Employees');
	// Give roles permissions on resources
	Acl::allow('Superadmins', 'admins', array());
	Acl::allow('Superadmins', 'apis', array());
	Acl::allow('Superadmins', 'companies', array());
	Acl::allow('Superadmins', 'invoices', array());
	Acl::allow('Superadmins', 'invoiceitems', array());
	Acl::allow('Superadmins', 'inventories', array());
	Acl::allow('Superadmins', 'inventoryitems', array());	
	Acl::allow('Superadmins', 'resources', array());
	Acl::allow('Superadmins', 'schedules', array());
	Acl::allow('Superadmins', 'taxes', array());
	Acl::allow('Superadmins', 'users', array());
	Acl::allow('Superadmins', 'websites', array());
Acl::addRole('Members');
Acl::addRole('Guests');



