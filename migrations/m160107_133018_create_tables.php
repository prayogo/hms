<?php

use yii\db\Schema;
use yii\db\Migration;

class m160107_133018_create_tables extends Migration
{
    public function up()
    {

    }

    public function down()
    {
        echo "m160107_133018_create_tables cannot be reverted.\n";

        define(INT_PRIMARY, 'INT NOT NULL AUTO_INCREMENT PRIMARY KEY');

        $tableOptions = null;
        if ($this->db->driverName === 'mysql') {
            $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE=InnoDB';
        }

        $this->createTable('{{%ps_bank}}', [
            'bankid' => INT_PRIMARY,
            'name' => 'VARCHAR(50) NOT NULL',
            'accountno' => 'VARCHAR(20) NOT NULL',
            'branch' => 'VARCHAR(150) DEFAULT NULL',
        ], $tableOptions);

        $this->createTable('{{%ps_contactperson}}', [
            'contactpersonid' => INT_PRIMARY,
            'name' => 'VARCHAR(50) NOT NULL',
            'address' => 'VARCHAR(150) DEFAULT NULL',
            'email' => 'VARCHAR(150) DEFAULT NULL',
            'phone' => 'VARCHAR(20) NOT NULL',
            'phone2' => 'VARCHAR(20) DEFAULT NULL',
        ], $tableOptions);

        $this->createTable('{{%ps_equipment}}', [
            'equipmentid' => INT_PRIMARY,
            'name' => 'VARCHAR(50) NOT NULL',
        ], $tableOptions);

        $this->createTable('{{%ps_extraservice}}', [
            'extraserviceid' => INT_PRIMARY,
            'serviceitemid' => 'INT NOT NULL',
            'roomreservationid' => 'INT NOT NULL',
            'quantity' => 'INT NOT NULL',
            'date' => 'DATETIME NOT NULL',
            'rate' => 'INT NOT NULL',
        ], $tableOptions);

        $this->createTable('{{%ps_floor}}', [
            'floorid' => INT_PRIMARY,
            'name' => 'VARCHAR(50) NOT NULL',
        ], $tableOptions);

        $this->createTable('{{%ps_hotel}}', [
            'hotelid' => INT_PRIMARY,
            'name' => 'VARCHAR(50) NOT NULL',
            'address' => 'VARCHAR(150) NOT NULL',
            'city' => 'VARCHAR(50) NOT NULL',
            'state' => 'VARCHAR(150) NOT NULL',
            'locationid' => 'VARCHAR(3) NOT NULL',
            'email' => 'VARCHAR(150) NOT NULL',
            'phone1' => 'VARCHAR(15) NOT NULL',
            'phone2' => 'VARCHAR(15) DEFAULT NULL',
            'fax' => 'VARCHAR(15) DEFAULT NULL',
        ], $tableOptions);

        $this->createTable('{{%ps_identificationtype}}', [
            'identificationtypeid' => INT_PRIMARY,
            'name' => 'VARCHAR(50) NOT NULL',
        ], $tableOptions);

        $this->createTable('{{%ps_location}}', [
            'locationid' => 'VARCHAR(3) NOT NULL PRIMARY KEY',
            'iso2' => 'VARCHAR(2)',
            'name' => 'VARCHAR(50) NOT NULL',
        ], $tableOptions);

        $this->createTable('{{%ps_room}}', [
            'roomid' => INT_PRIMARY,
            'name' => 'VARCHAR(50) NOT NULL',
            'lockid' => 'VARCHAR(50)',
            'description' => 'VARCHAR(250)',
            'floorid' => 'INT NOT NULL',
            'roomtypeid' => 'INT NOT NULL',
            'roomstatusid' => 'INT NOT NULL',
        ], $tableOptions);

        $this->createTable('{{%ps_roomstatus}}', [
            'roomstatusid' => INT_PRIMARY,
            'name' => 'VARCHAR(50) NOT NULL',
            'color' => 'VARCHAR(15)',
        ], $tableOptions);

        $this->createTable('{{%ps_roomtype}}', [
            'roomtypeid' => INT_PRIMARY,
            'name' => 'VARCHAR(50) NOT NULL',
            'singleb' => 'INT NOT NULL DEFAULT 0',
            'doubleb' => 'INT NOT NULL DEFAULT 0',
            'extrab' => 'INT NOT NULL DEFAULT 0',
            'maxchild' => 'INT NOT NULL DEFAULT 0',
            'maxadult' => 'INT NOT NULL DEFAULT 0',
            'childcharge' => 'INT NOT NULL DEFAULT 0',
            'adultcharge' => 'INT NOT NULL DEFAULT 0',
            'description' => 'VARCHAR(250)',
            'rate' => 'INT NOT NULL DEFAULT 0',
            'weekendrate' => 'INT NOT NULL DEFAULT 0',
        ], $tableOptions);

        $this->createTable('{{%ps_roomtypeequipment}}', [
            'roomtypeid' => 'INT NOT NULL',
            'equipmentid' => 'INT NOT NULL',
        ], $tableOptions);
        $this->addPrimaryKey('ps_roomtypeequipment_pk', 'ps_roomtypeequipment', ['roomtypeid', 'equipmentid']);

        $this->createTable('{{%ps_serviceitem}}', [
            'serviceitemid' => INT_PRIMARY,
            'name' => 'VARCHAR(50) NOT NULL',
            'rate' => 'INT NOT NULL DEFAULT 0',
        ], $tableOptions);

        $this->createTable('{{%ps_tax}}', [
            'taxid' => INT_PRIMARY,
            'room' => 'INT NOT NULL DEFAULT 0',
            'meal' => 'INT NOT NULL DEFAULT 0',
            'product' => 'INT NOT NULL DEFAULT 0',
            'currency' => 'VARCHAR(5) NOT NULL',
        ], $tableOptions);

        $this->createTable('{{%ps_user}}', [
            'userid' => INT_PRIMARY,
            'username' => 'VARCHAR(20) NOT NULL',
            'fullname' => 'VARCHAR(150) NOT NULL',
            'displayname' => 'VARCHAR(50) NOT NULL',
            'password' => 'VARCHAR(150) NOT NULL',
            'phone' => 'VARCHAR(15) NOT NULL',
            'email' => 'VARCHAR(150) DEFAULT NULL',
            'active' => "CHAR(1) DEFAULT '0'",
            'admin' => "CHAR(1) DEFAULT '0'",
        ], $tableOptions);

        return true;
    }

    /*
    // Use safeUp/safeDown to run migration code within a transaction
    public function safeUp()
    {
    }

    public function safeDown()
    {
    }
    */
}
