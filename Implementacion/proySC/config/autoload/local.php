<?php
/**
 * Local Configuration Override
 *
 * This configuration override file is for overriding environment-specific and
 * security-sensitive configuration information. Copy this file without the
 * .dist extension at the end and populate values as needed.
 *
 * @NOTE: This file is ignored from Git by default with the .gitignore included
 * in ZendSkeletonApplication. This is a good practice, as it prevents sensitive
 * credentials from accidentally being committed into version control.
 */

return array(
    'db' => array(
        'driver'   => 'Pdo_Pgsql',
        'dsn'      => 'pgsql:host=10.0.2.2;port=8054;dbname=stock',
        'username' => 'postgres',
        'password' => 'postgres',
    ),
    'doctrine' => array(
        'connection' => array(
            'orm_default' => array(
                'driverClass' => 'Doctrine\DBAL\Driver\PDOPgSql\Driver',
                'params' => array(
                    'host'     => '10.0.2.2',
                    'port'     => '8054',
                    'user'     => 'postgres',
                    'password' => 'postgres',
                    'dbname'   => 'stock',
                ),
            ),
        ),
    ),
);