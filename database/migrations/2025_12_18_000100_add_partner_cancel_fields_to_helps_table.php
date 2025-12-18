<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddPartnerCancelFieldsToHelpsTable extends Migration
{
    public function up()
    {
        Schema::table('helps', function (Blueprint $table) {
            $table->timestamp('partner_cancel_requested_at')->nullable()->after('partner_current_lng');
            $table->text('partner_cancel_reason')->nullable()->after('partner_cancel_requested_at');
            $table->string('partner_cancel_prev_status')->nullable()->after('partner_cancel_reason');
        });
    }

    public function down()
    {
        Schema::table('helps', function (Blueprint $table) {
            $table->dropColumn(['partner_cancel_requested_at', 'partner_cancel_reason', 'partner_cancel_prev_status']);
        });
    }
}
