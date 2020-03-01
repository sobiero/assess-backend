<?php
use Phalcon\DI\FactoryDefault;
use Phalcon\Db\Adapter\Pdo\Mysql as DbAdapter;

$di = new FactoryDefault();

$di['db'] = function () use ($config) {
    return new DbAdapter(
		[
        "host"     => $config->db->host,
        "username" => $config->db->username,
        "password" => $config->db->password,
        "dbname"   => $config->db->dbname,
		'port'     => $config->db->port,
		"options"  => [
						\PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES 'UTF8'"
					]
        ]
		);
};

$di['config'] = $config ;
