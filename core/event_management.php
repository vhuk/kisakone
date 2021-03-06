<?php
/**
 * Suomen Frisbeegolfliitto Kisakone
 * Copyright 2009-2010 Kisakone projektiryhmä
 * Copyright 2014-2015 Tuomo Tanskanen <tuomo@tanskanen.org>
 *
 * This file defines functions used for manageing events
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

require_once 'sfl/sfl_integration.php';
require_once 'data/player.php';
require_once 'data/club.php';
require_once 'data/event_queue.php';
require_once 'core/rules.php';


/** ****************************************************************************
 * Function for signing up a user to an event
 *
 * Returns null for success or an Error object in case the signup fails
 *
 * @param int $eventId
 * @param int $userId
 * @param int $classId
 * @param boolean TD override
 */
function SignUpUser($eventId, $userId, $classId, $tdOverride = false)
{
    $player = GetUserPlayer($userId);

    if (isset($player)) {
        $playerId = $player->id;

        // make sure we have lifted valid people off the list before taking new guys
        CheckQueueForPromotions($eventId);

        if ($tdOverride) {
            $can_signup_directly = true;
        }
        else {
            $quota_ok = CheckSignUpQuota($eventId, $playerId, $classId);
            $rulecheck = CheckEventRules($eventId, $classId, $playerId);

            if (is_string($rulecheck)) {
                if ($rulecheck == "reject") {
                    $retValue = new Error();
                    $retValue->title = "rule_registration_failed_header";
                    $retValue->description = translate("rule_registration_failed");
                    $retValue->IsMajor = true;
                    return $retValue;
                }

                // it is 'queue'
                $rules_ok = false;
            }
            else
                $rules_ok = $rulecheck;

            $can_signup_directly = $quota_ok && $rules_ok;
        }

        // Record the club at the time of the registration, otherwise the club
        // will update to the current club, which distorts the old history records
        return SetPlayerParticipation($playerId, $eventId, $classId, $can_signup_directly);
    }
    else {
        $retValue = new Error();
        $retValue->title = "error_invalid_argument";
        $retValue->description = translate("error_invalid_argument_description");
        $retValue->internalDescription = "Invalid user id, no corresponding player found";
        $retValue->function = "SignUpUser()";
        $retValue->IsMajor = true;
        $retValue->data = "User id: " . $userId;

        return $retValue;
    }
}


/** ****************************************************************************
 * Function for marking event participation fee payment
 *
 * Returns null for success or an Error object in case of an error
 *
 * @param int  $participationId
 * @param bool $newfee
 */
function MarkEventFeePayments($eventId, $payments)
{
    $errors = array();
    $retValue = null;

    foreach ($payments as $payment) {
        $outcome = MarkEventFeePayment($eventId, $payment['participationId'], $payment['payment']);
        if (is_a($outcome, 'Error')) {
            $errors[] = $outcome;
        }
    }
    if (count($errors)) {
        $retValue = $errors[0];
    }

    return $retValue;
}

/* ****************************************************************************
 * End of file
 * */
