<?php

/**
 * HUUID
 *
 * Hard Universal Unique Identificator
 * Example: 8f1d77bs-ff771c5d-44fa-3d6e9a4c8d21a6b4-12ac7eb8
 *
 *
 * @author LestaD
 * @package net.lestad.huuid
 * @version 1.0.1
 */

namespace LestaD;

class HUUID
{
    
    /**
     * Create Hard Universal Unique Identificator for namespace
     * 
     * @param string any namespace
     * @return string HUUID string
     */
    public static function create($namespace = null)
    {
        // get one line string
        $nspc = str_replace([' ',"\t","\n","\r",'-'], '', $namespace);
        
        // hash
        $bnsp = sha1($nspc);
        // hash parts
        $dnsp = [substr($bnsp, 0, 20), substr($bnsp,20,20)];
        
        return sprintf('%08s-%04s%04s-%04s-%16s-%08s',
                        substr($dnsp[1], 6, 8), // first 8
                        mt_rand(0, 0x270f), // second 8
                        mt_rand(0, 0x270f), // -//-
                        mt_rand(0x000f, 0x0fff) | 0x1000, // version 1, %04s
                        substr(sha1($dnsp[0].mt_rand(0x0000,0xffff)),0, 16),
                        substr($dnsp[0], 12, 8)
                    );
        
    }
    
    /**
     * Returns corRect ID for using
     *
     *
     * @param string any namespace
     * @return string HUUID string
     */
    public static function rHUUID($namespace = null)
    {
        return sprintf('{%s}', strtoupper(self::create($namespace)));
    }
    
    
    /**
     * More Entropy
     *
     * use only for uniq id. Can't check
     *
     * @param string any namespace
     * @return string HUUID string
     */
    public static function eHUUID($namespace = null)
    {
        $bnsp = sha1($namespace);
        $huid = self::create($namespace);
        return sprintf('{%s-%s-%s}',
                    substr($bnsp, 8, 16),
                    $huid,
                    substr($bnsp, 20, 28));
        
    }
    
    
    /**
     * Checks for HUUID if it in namespace
     *
     * @param string HUUID
     * @param string namespace
     * @return bool is HUUID in namespace
     */
    public static function check($huuid, $namespace = null)
    {
        if (!self::isValid($huuid))
        {
            // not valid HUUID
            return false;
        }
        
        // get correct lines
        $hbin = str_replace(['{','}','-'], '', $huuid);
        $nspb = str_replace([' ',"\t","\n","\r",'-'], '', $namespace);
        
        // original parts of hash of namespace
        $bnsp = sha1($nspb);
        $dnsp = [substr($bnsp, 0, 20), substr($bnsp,20,20)];
        
        // parts of namespace from huuid
        $fprt = substr($hbin, 0, 8);
        $sprt = substr($hbin, 36, 44);
        
        return (
            ($fprt == substr($dnsp[1], 6, 8)) &&
            ($sprt == substr($dnsp[0], 12, 8))
        );
    }
    
    
    /**
     * Checks if string is valid HUUID
     * 
     * @param string HUUID
     * @return bool is huuid valid
     */
    public static function isValid($huuid)
    {
        return preg_match('/^\{?([0-9a-f]{16})?\-?[0-9a-f]{8}\-[0-9a-f]{8}\-?[0-9a-f]{4}\-?'.
                          '[0-9a-f]{16}\-?[0-9a-f]{8}?\-?([0-9a-f]{20})?\}?$/i', $huuid) === 1;
    }
    
}





