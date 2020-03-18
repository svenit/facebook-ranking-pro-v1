<?php

namespace App\Constants;

class SkillType
{
    /**
     * Sát thương vật lý
     */
    const ATTACK_STRENGTH = 'strength';

    /**
     * Sát thương pháp thuật
     */
    const ATTACK_INTELLIGENT = 'intelligent';

    /**
     * Sát thương chí mạng
     */
    const ATTACK_CRIT = 'crit';

    /**
     * Sát thương nửa máu
     */
    const ATTACK_HALF_HP = 'half-hp';

    /**
     * Hồi máu
     */
    const HEALTH_HP = 'health_points';

    /**
     * Giáp kháng công vật lý bị động
     */
    const ARMOR_STRENGTH = 'armor_strength';

    /**
     * Giáp kháng công pháp thuật bị động
     */
    const ARMOR_INTELLIGENT = 'armor_intelligent';

    /**
     * Gây sát thương vật lý + choáng
     */
    const STUN = 'strength-stun';

    /**
     * Gây sát thương phép thuật + đóng băng
     */
    const FREEZE = 'intelligent-freeze';

     /**
     * Gây sát thương + tăng nhanh nhẹn
     */
    const INCREAGILITY = 'strength-increagility';
    
}