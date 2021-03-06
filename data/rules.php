<?php
/**
 * Suomen Frisbeegolfliitto Kisakone
 * Copyright 2015 Tuomo Tanskanen <tuomo@tanskanen.org>
 *
 * Data access module for Registration Rules
 *
 * --
 *
 * This file is part of Kisakone.
 * Kisakone is free software: you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation, either version 3 of the License, or
 * (at your option) any later version.
 *
 * Kisakone is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU General Public License for more details.
 * You should have received a copy of the GNU General Public License
 * along with Kisakone.  If not, see <http://www.gnu.org/licenses/>.
 * */

require_once 'data/db.php';


function GetRuleTypes()
{
    return array('rating', 'country', /*'player',*/ 'status', 'co');
}


function GetRuleOps()
{
    return array('>', '>=', '<', '<=', '!=', '==');
}


function GetRuleActions()
{
    return array(/*'accept',*/ 'queue', 'reject');
}


function GetEventRules($eventid, $classid = -1)
{
    $eventid = esc_or_null($eventid, 'int');

    if ($classid === -1)
        $where_class = "";
    elseif ($classid == null || $classid == 0)
        $where_class = "AND Classification IS NULL";
    else
        $where_class = "AND Classification = " . esc_or_null($classid);

    return db_all("SELECT :RegistrationRules.id AS id, Event, Classification, Type, Op, Value, Action,
                            DATE_FORMAT(ValidUntil, '%Y-%m-%d %H:%i') AS ValidUntil, NOW() < ValidUntil AS Valid,
                            :Classification.Name AS ClassName
                        FROM :RegistrationRules
                        LEFT JOIN :Classification ON :RegistrationRules.Classification = :Classification.id
                        WHERE Event = $eventid
                        $where_class
                        ORDER BY Classification ASC, ValidUntil, id");
}


function DeleteEventRules($eventid)
{
    $eventid = esc_or_null($eventid, 'int');

    return db_exec("DELETE FROM :RegistrationRules WHERE Event = $eventid");
}


function SaveRule($ruleid, $eventid, $classid, $type, $op, $value, $action, $validuntil)
{
    $ruleid = esc_or_null($ruleid, 'int');
    $eventid = esc_or_null($eventid, 'int');
    $classid = esc_or_null($classid, 'int');
    $type = esc_or_null($type, 'string');
    $op = esc_or_null($op, 'string');
    $value = esc_or_null($value, 'string');
    $action = esc_or_null($action, 'string');
    $validuntil = esc_or_null($validuntil, 'string');

    return db_exec("INSERT INTO :RegistrationRules (id, Event, Classification, Type, Op, Value, Action, ValidUntil)
                        VALUES($ruleid, $eventid, $classid, $type, $op, $value, $action, $validuntil)
                        ON DUPLICATE KEY UPDATE Event = $eventid, Classification = $classid,
                        Type = $type, Op = $op, Value = $value, Action = $action, ValidUntil = $validuntil");
}
