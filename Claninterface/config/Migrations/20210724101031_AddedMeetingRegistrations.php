<?php
use Migrations\AbstractMigration;

class AddedMeetingRegistrations extends AbstractMigration
{
    public function up()
    {


        $this->table('meetingregistrations')
            ->addColumn('player_id', 'integer', [
                'default' => null,
                'limit' => 11,
                'null' => true,
            ])
            ->addColumn('meeting_id', 'integer', [
                'default' => null,
                'limit' => 11,
                'null' => true,
            ])
            ->addColumn('status', 'integer', [
                'default' => null,
                'limit' => 11,
                'null' => true,
            ])
            ->addColumn('modified', 'timestamp', [
                'default' => null,
                'limit' => null,
                'null' => true,
            ])
            ->addColumn('created', 'timestamp', [
                'default' => null,
                'limit' => null,
                'null' => true,
            ])
            ->create();


    }

    public function down()
    {

        $this->table('meetingregistrations')->drop()->save();

    }
}
