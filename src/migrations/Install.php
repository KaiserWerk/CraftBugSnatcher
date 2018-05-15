<?php
/**
 * CraftBugSnatcher plugin for Craft CMS 3.x
 *
 * This handy plugin will catch occurring errors and exceptions, log them, and send out (optional) notifications via Email, Slack, Stride and SMS.
 *
 * @link      https://kaiserrobin.eu
 * @copyright Copyright (c) 2018 Robin Kaiser
 */

namespace kaiserwerk\craftbugsnatcher\migrations;

use kaiserwerk\craftbugsnatcher\CraftBugSnatcher;

use Craft;
use craft\config\DbConfig;
use craft\db\Migration;

/**
 * CraftBugSnatcher Install Migration
 *
 * If your plugin needs to create any custom database tables when it gets installed,
 * create a migrations/ folder within your plugin folder, and save an Install.php file
 * within it using the following template:
 *
 * If you need to perform any additional actions on install/uninstall, override the
 * safeUp() and safeDown() methods.
 *
 * @author    Robin Kaiser
 * @package   CraftBugSnatcher
 * @since     1.0.0
 */
class Install extends Migration
{
    // Public Properties
    // =========================================================================

    /**
     * @var string The database driver to use
     */
    public $driver;

    // Public Methods
    // =========================================================================

    /**
     * This method contains the logic to be executed when applying this migration.
     * This method differs from [[up()]] in that the DB logic implemented here will
     * be enclosed within a DB transaction.
     * Child classes may implement this method instead of [[up()]] if the DB logic
     * needs to be within a transaction.
     *
     * @return boolean return a false value to indicate the migration fails
     * and should not proceed further. All other return values mean the migration succeeds.
     */
    public function safeUp()
    {
        $this->driver = Craft::$app->getConfig()->getDb()->driver;
        if ($this->createTables()) {
            $this->createIndexes();
            $this->addForeignKeys();
            // Refresh the db schema caches
            Craft::$app->db->schema->refresh();
            $this->insertDefaultData();
        }

        return true;
    }

    /**
     * This method contains the logic to be executed when removing this migration.
     * This method differs from [[down()]] in that the DB logic implemented here will
     * be enclosed within a DB transaction.
     * Child classes may implement this method instead of [[down()]] if the DB logic
     * needs to be within a transaction.
     *
     * @return boolean return a false value to indicate the migration fails
     * and should not proceed further. All other return values mean the migration succeeds.
     */
    public function safeDown()
    {
        $this->driver = Craft::$app->getConfig()->getDb()->driver;
        $this->removeTables();

        return true;
    }

    // Protected Methods
    // =========================================================================

    /**
     * Creates the tables needed for the Records used by the plugin
     *
     * @return bool
     */
    protected function createTables()
    {
        $tablesCreated = false;

    // craftbugsnatcher_craftbugsnatcherrecord table
        $tableSchema = Craft::$app->db->schema->getTableSchema('{{%craftbugsnatcher_craftbugsnatcherrecord}}');
        if ($tableSchema === null) {
            $tablesCreated = true;
            $this->createTable(
                '{{%craftbugsnatcher_craftbugsnatcherrecord}}',
                [
                    'id' => $this->primaryKey(),
                    'dateCreated' => $this->dateTime()->notNull(),
                    'dateUpdated' => $this->dateTime()->notNull(),
                    'uid' => $this->uid(),
                // Custom columns in the table
                    'siteId' => $this->integer()->notNull(),
                    'some_field' => $this->string(255)->notNull()->defaultValue(''),
                ]
            );
        }

        return $tablesCreated;
    }

    /**
     * Creates the indexes needed for the Records used by the plugin
     *
     * @return void
     */
    protected function createIndexes()
    {
    // craftbugsnatcher_craftbugsnatcherrecord table
        $this->createIndex(
            $this->db->getIndexName(
                '{{%craftbugsnatcher_craftbugsnatcherrecord}}',
                'some_field',
                true
            ),
            '{{%craftbugsnatcher_craftbugsnatcherrecord}}',
            'some_field',
            true
        );
        // Additional commands depending on the db driver
        switch ($this->driver) {
            case DbConfig::DRIVER_MYSQL:
                break;
            case DbConfig::DRIVER_PGSQL:
                break;
        }
    }

    /**
     * Creates the foreign keys needed for the Records used by the plugin
     *
     * @return void
     */
    protected function addForeignKeys()
    {
    // craftbugsnatcher_craftbugsnatcherrecord table
        $this->addForeignKey(
            $this->db->getForeignKeyName('{{%craftbugsnatcher_craftbugsnatcherrecord}}', 'siteId'),
            '{{%craftbugsnatcher_craftbugsnatcherrecord}}',
            'siteId',
            '{{%sites}}',
            'id',
            'CASCADE',
            'CASCADE'
        );
    }

    /**
     * Populates the DB with the default data.
     *
     * @return void
     */
    protected function insertDefaultData()
    {
    }

    /**
     * Removes the tables needed for the Records used by the plugin
     *
     * @return void
     */
    protected function removeTables()
    {
    // craftbugsnatcher_craftbugsnatcherrecord table
        $this->dropTableIfExists('{{%craftbugsnatcher_craftbugsnatcherrecord}}');
    }
}
