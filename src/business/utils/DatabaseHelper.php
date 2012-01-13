<?php

/**
 *
 */
class DatabaseHelper
{
	/**
	 * @static
	 * @param $tableName
	 * @todo MySql specific.  Need to abstract.
	 */
	public static function createInsertAuditTrigger($tableName)
	{
		$dbName = Blocks::app()->config->databaseName;

		Blocks::app()->db->createCommand(
							'CREATE
							 TRIGGER `'.$dbName.'`.`auditinfoinsert_'.$tableName.'`
							 BEFORE INSERT ON `'.$dbName.'`.`{{'.$tableName.'}}`
							 FOR EACH ROW
							 SET NEW.date_created = UNIX_TIMESTAMP(),
								 NEW.date_updated = UNIX_TIMESTAMP(),
								 NEW.uid = UUID();
								 END;
								 SQL;'
					)->execute();
	}

	/**
	 * @static
	 * @param $tableName
	 * @todo MySql specific.  Need to abstract.
	 */
	public static function createUpdateAuditTrigger($tableName)
	{
		$dbName = Blocks::app()->config->databaseName;

		Blocks::app()->db->createCommand(
							'CREATE
							 TRIGGER `'.$dbName.'`.`auditinfoupdate_'.$tableName.'`
							 BEFORE UPDATE ON `'.$dbName.'`.`{{'.$tableName.'}}`
							 FOR EACH ROW
							 SET NEW.date_updated = UNIX_TIMESTAMP(),
								 NEW.date_created = OLD.date_created;
							 END;
							 SQL;'
					)->execute();
	}
}
