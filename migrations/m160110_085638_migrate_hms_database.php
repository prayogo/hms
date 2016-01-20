<?php

use yii\db\Schema;
use yii\db\Migration;

define("INT_PRIMARY", 'INT NOT NULL AUTO_INCREMENT PRIMARY KEY');

class m160110_085638_migrate_hms_database extends Migration
{
    public function up()
    {
        $tableOptions = null;
        if ($this->db->driverName === 'mysql') {
            $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE=InnoDB';
        }

        //CREATE TABLE
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

        $this->createTable('{{%ps_discount}}', [
            'discountid' => INT_PRIMARY,
            'name' => 'VARCHAR(50)',
            'percent' => 'VARCHAR(50) NULL',
            'rate' => 'VARCHAR(50) NULL',
            'from_date' => 'DATE',
            'to_date' => 'DATE',
        ], $tableOptions);

        $this->createTable('{{%ps_customer}}', [
            'customerid' => INT_PRIMARY,
            'name' => 'VARCHAR(50)',
            'address' => 'VARCHAR(150)',
            'email' => 'VARCHAR(150)',
            'npwp' => 'VARCHAR(25)',
            'locationid' => 'VARCHAR(3) NOT NULL',
            'birthdate' => 'DATE',
            'comment' => 'VARCHAR(250)',
            'blacklist' => 'CHAR(1)',
        ], $tableOptions);

        $this->createTable('{{%ps_customeridentification}}', [
            'customerid' => 'INT NOT NULL',
            'identificationtypeid' => 'INT NOT NULL',
            'identificationno' => 'VARCHAR(50) NOT NULL',
        ], $tableOptions);
        $this->addPrimaryKey('ps_customeridentification_pk', 'ps_customeridentification', ['customerid', 'identificationtypeid', 'identificationno']);

        $this->createTable('{{%ps_customerphone}}', [
            'customerid' => 'INT NOT NULL',
            'phone' => 'VARCHAR(15) NOT NULL',
        ], $tableOptions);
        $this->addPrimaryKey('ps_customerphone_pk', 'ps_customerphone', ['customerid', 'phone']);

        $this->createTable('{{%ps_discountroomtype}}', [
            'discountid' => 'INT NOT NULL',
            'roomtypeid' => 'INT NOT NULL',
        ], $tableOptions);
        $this->addPrimaryKey('ps_discountroomtype_pk', 'ps_discountroomtype', ['discountid', 'roomtypeid']);

        $this->createTable('{{%ps_discountroom}}', [
            'discountid' => 'INT NOT NULL',
            'roomid' => 'INT NOT NULL',
        ], $tableOptions);
        $this->addPrimaryKey('ps_discountroom_pk', 'ps_discountroom', ['discountid', 'roomid']);

        $this->createTable('{{%ps_discountcustomer}}', [
            'discountid' => 'INT NOT NULL',
            'customerid' => 'INT NOT NULL',
        ], $tableOptions);
        $this->addPrimaryKey('ps_discountcustomer_pk', 'ps_discountroom', ['discountid', 'customerid']);

        $this->createTable('{{%ps_roomreservation}}', [
            'reservationid' => INT_PRIMARY,
            'customerid' => 'INT NOT NULL',
            'roomstatusid' => 'INT NOT NULL',
            'date' => 'DATETIME NOT NULL',
        ], $tableOptions);

        $this->createTable('{{%ps_roomreservationdetail}}', [
            'reservationdetailid' => INT_PRIMARY,
            'reservationid' => 'INT NOT NULL',
            'roomid' => 'INT NOT NULL',
            'rate' => 'INT NOT NULL',
            'start_date' => 'DATETIME NOT NULL',
            'end_date' => 'DATETIME NOT NULL',
        ], $tableOptions);

        $this->createTable('{{%ps_extraservice}}', [
            'extraserviceid' => INT_PRIMARY,
            'reservationid' => 'INT NOT NULL',
            'roomid' => 'INT NOT NULL',
            'date' => 'DATETIME',
        ], $tableOptions);

        $this->createTable('{{%ps_extraservicedetail}}', [
            'extraservicedetailid' => INT_PRIMARY,
            'extraserviceid' => 'INT NOT NULL',
            'serviceitemid' => 'INT NOT NULL',
            'rate' => 'INT NOT NULL',
            'quantity' => 'INT NOT NULL',
        ], $tableOptions);

        $this->createTable('{{%ps_discountreservation}}', [
            'discountid' => 'INT NOT NULL',
            'reservationid' => 'INT NOT NULL',
        ], $tableOptions);
        $this->addPrimaryKey('ps_discountreservation_pk', 'ps_discountreservation', ['discountid', 'reservationid']);

        //CREATE FOREIGN KEY
        $this->addForeignKey('ps_hotel_ibfk_1', 'ps_hotel', 'locationid', 'ps_location', 'locationid');

        $this->addForeignKey('ps_room_ibfk_1', 'ps_room', 'floorid', 'ps_floor', 'floorid');
        $this->addForeignKey('ps_room_ibfk_2', 'ps_room', 'roomtypeid', 'ps_roomtype', 'roomtypeid');
        $this->addForeignKey('ps_room_ibfk_3', 'ps_room', 'roomstatusid', 'ps_roomstatus', 'roomstatusid');

        $this->addForeignKey('ps_roomtypeequipment_ibfk_1', 'ps_roomtypeequipment', 'roomtypeid', 'ps_roomtype', 'roomtypeid');
        $this->addForeignKey('ps_roomtypeequipment_ibfk_2', 'ps_roomtypeequipment', 'equipmentid', 'ps_equipment', 'equipmentid');

        $this->addForeignKey('ps_discountroomtype_ibfk_1', 'ps_discountroomtype', 'discountid', 'ps_discount', 'discountid');
        $this->addForeignKey('ps_discountroomtype_ibfk_2', 'ps_discountroomtype', 'roomtypeid', 'ps_roomtype', 'roomtypeid');

        $this->addForeignKey('ps_discountroom_ibfk_1', 'ps_discountroom', 'discountid', 'ps_discount', 'discountid');
        $this->addForeignKey('ps_discountroom_ibfk_2', 'ps_discountroom', 'roomid', 'ps_room', 'roomid');

        $this->addForeignKey('ps_discountcustomer_ibfk_1', 'ps_discountcustomer', 'discountid', 'ps_discount', 'discountid');
        $this->addForeignKey('ps_discountcustomer_ibfk_2', 'ps_discountcustomer', 'customerid', 'ps_customer', 'customerid');

        $this->addForeignKey('ps_roomreservation_ibfk_1', 'ps_roomreservation', 'customerid', 'ps_customer', 'customerid');
        $this->addForeignKey('ps_roomreservation_ibfk_2', 'ps_roomreservation', 'roomstatusid', 'ps_roomstatus', 'roomstatusid');

        $this->addForeignKey('ps_roomreservationdetail_ibfk_1', 'ps_roomreservationdetail', 'reservationid', 'ps_roomreservation', 'reservationid');
        $this->addForeignKey('ps_roomreservationdetail_ibfk_2', 'ps_roomreservationdetail', 'roomid', 'ps_room', 'roomid');

        $this->addForeignKey('ps_extraservice_ibfk_1', 'ps_extraservice', 'reservationid', 'ps_roomreservation', 'reservationid');
        $this->addForeignKey('ps_extraservice_ibfk_2', 'ps_extraservice', 'roomid', 'ps_room', 'roomid');

        $this->addForeignKey('ps_extraservicedetail_ibfk_1', 'ps_extraservicedetail', 'extraserviceid', 'ps_extraservice', 'extraserviceid');
        $this->addForeignKey('ps_extraservicedetail_ibfk_2', 'ps_extraservicedetail', 'serviceitemid', 'ps_serviceitem', 'serviceitemid');

        $this->addForeignKey('ps_discountreservation_ibfk_1', 'ps_discountreservation', 'discountid', 'ps_discount', 'discountid');
        $this->addForeignKey('ps_discountreservation_ibfk_2', 'ps_discountreservation', 'reservationid', 'ps_roomreservation', 'reservationid');

        $this->addForeignKey('ps_customer_ibfk_1', 'ps_customer', 'locationid', 'ps_location', 'locationid');

        $this->addForeignKey('ps_customeridentification_ibfk_1', 'ps_customeridentification', 'customerid', 'ps_customer', 'customerid');
        $this->addForeignKey('ps_customeridentification_ibfk_2', 'ps_customeridentification', 'identificationtypeid', 'ps_identificationtype', 'identificationtypeid');

        $this->addForeignKey('ps_customerphone_ibfk_1', 'ps_customerphone', 'customerid', 'ps_customer', 'customerid');

    }

    public function down()
    {
        //DROP FOREIGN KEY
        $this->dropForeignKey('ps_hotel_ibfk_1', 'ps_hotel');
        $this->dropForeignKey('ps_room_ibfk_1', 'ps_room');
        $this->dropForeignKey('ps_room_ibfk_2', 'ps_room');
        $this->dropForeignKey('ps_room_ibfk_3', 'ps_room');
        $this->dropForeignKey('ps_roomtypeequipment_ibfk_1', 'ps_roomtypeequipment');
        $this->dropForeignKey('ps_roomtypeequipment_ibfk_2', 'ps_roomtypeequipment');
        $this->dropForeignKey('ps_discountroomtype_ibfk_1', 'ps_discountroomtype');
        $this->dropForeignKey('ps_discountroomtype_ibfk_2', 'ps_discountroomtype');
        $this->dropForeignKey('ps_discountroom_ibfk_1', 'ps_discountroom');
        $this->dropForeignKey('ps_discountroom_ibfk_2', 'ps_discountroom');
        $this->dropForeignKey('ps_discountcustomer_ibfk_1', 'ps_discountcustomer');
        $this->dropForeignKey('ps_discountcustomer_ibfk_2', 'ps_discountcustomer');
        $this->dropForeignKey('ps_roomreservation_ibfk_1', 'ps_roomreservation');
        $this->dropForeignKey('ps_roomreservation_ibfk_2', 'ps_roomreservation');
        $this->dropForeignKey('ps_roomreservationdetail_ibfk_1', 'ps_roomreservationdetail');
        $this->dropForeignKey('ps_roomreservationdetail_ibfk_2', 'ps_roomreservationdetail');
        $this->dropForeignKey('ps_extraservice_ibfk_1', 'ps_extraservice');
        $this->dropForeignKey('ps_extraservice_ibfk_2', 'ps_extraservice');
        $this->dropForeignKey('ps_extraservicedetail_ibfk_1', 'ps_extraservicedetail');
        $this->dropForeignKey('ps_extraservicedetail_ibfk_2', 'ps_extraservicedetail');
        $this->dropForeignKey('ps_discountreservation_ibfk_1', 'ps_discountreservation');
        $this->dropForeignKey('ps_discountreservation_ibfk_2', 'ps_discountreservation');
        $this->dropForeignKey('ps_customer_ibfk_1', 'ps_customer');
        $this->dropForeignKey('ps_customeridentification_ibfk_1', 'ps_customeridentification');
        $this->dropForeignKey('ps_customeridentification_ibfk_2', 'ps_customeridentification');
        $this->dropForeignKey('ps_customerphone_ibfk_1', 'ps_customerphone');

        //DROP TABLE
        $this->dropTable('{{%ps_hotel}}');
        $this->dropTable('{{%ps_room}}');
        $this->dropTable('{{%ps_roomtypeequipment}}');
        $this->dropTable('{{%ps_bank}}');
        $this->dropTable('{{%ps_contactperson}}');
        $this->dropTable('{{%ps_equipment}}');
        $this->dropTable('{{%ps_floor}}');
        $this->dropTable('{{%ps_identificationtype}}');
        $this->dropTable('{{%ps_location}}');
        $this->dropTable('{{%ps_roomstatus}}');
        $this->dropTable('{{%ps_roomtype}}');
        $this->dropTable('{{%ps_serviceitem}}');
        $this->dropTable('{{%ps_tax}}');
        $this->dropTable('{{%ps_user}}');
        $this->dropTable('{{%ps_discount}}');
        $this->dropTable('{{%ps_discountroomtype}}');
        $this->dropTable('{{%ps_discountroom}}');
        $this->dropTable('{{%ps_discountcustomer}}');
        $this->dropTable('{{%ps_customer}}');
        $this->dropTable('{{%ps_customeridentification}}');
        $this->dropTable('{{%ps_customerphone}}');

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
