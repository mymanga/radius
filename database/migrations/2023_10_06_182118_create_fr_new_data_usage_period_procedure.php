<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateFrNewDataUsagePeriodProcedure extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        DB::unprepared('
            DROP PROCEDURE IF EXISTS fr_new_data_usage_period;
            CREATE PROCEDURE fr_new_data_usage_period ()
            SQL SECURITY INVOKER
            BEGIN
                DECLARE v_start DATETIME;
                DECLARE v_end DATETIME;

                DECLARE EXIT HANDLER FOR SQLEXCEPTION
                BEGIN
                    ROLLBACK;
                    RESIGNAL;
                END;

                SELECT IFNULL(DATE_ADD(MAX(period_end), INTERVAL 1 SECOND), FROM_UNIXTIME(0)) INTO v_start FROM data_usage_by_period;
                SELECT NOW() INTO v_end;

                START TRANSACTION;

                -- Add the data usage for the sessions that were active in the current
                -- period to the table. Include all sessions that finished since the start
                -- of this period as well as those still ongoing.
                INSERT INTO data_usage_by_period (username, period_start, period_end, acctinputoctets, acctoutputoctets)
                SELECT *
                FROM (
                    SELECT
                        username,
                        v_start,
                        v_end,
                        SUM(acctinputoctets) AS acctinputoctets,
                        SUM(acctoutputoctets) AS acctoutputoctets
                    FROM ((
                        SELECT
                            username, acctinputoctets, acctoutputoctets
                        FROM
                            radacct
                        WHERE
                            acctstoptime > v_start
                    ) UNION ALL (
                        SELECT
                            username, acctinputoctets, acctoutputoctets
                        FROM
                            radacct
                        WHERE
                            acctstoptime IS NULL
                    )) AS a
                    GROUP BY
                        username
                ) AS s
                ON DUPLICATE KEY UPDATE
                    acctinputoctets = data_usage_by_period.acctinputoctets + s.acctinputoctets,
                    acctoutputoctets = data_usage_by_period.acctoutputoctets + s.acctoutputoctets,
                    period_end = v_end;

                -- Create an open-ended "next period" for all ongoing sessions and carry a
                -- negative value of their data usage to avoid double-accounting when we
                -- process the next period. Their current data usage has already been
                -- allocated to the current and possibly previous periods.
                INSERT INTO data_usage_by_period (username, period_start, period_end, acctinputoctets, acctoutputoctets)
                SELECT *
                FROM (
                    SELECT
                        username,
                        DATE_ADD(v_end, INTERVAL 1 SECOND),
                        NULL,
                        0 - SUM(acctinputoctets),
                        0 - SUM(acctoutputoctets)
                    FROM
                        radacct
                    WHERE
                        acctstoptime IS NULL
                    GROUP BY
                        username
                ) AS s;

                COMMIT;

            END
        ');
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        DB::unprepared('DROP PROCEDURE IF EXISTS fr_new_data_usage_period');
    }
}
