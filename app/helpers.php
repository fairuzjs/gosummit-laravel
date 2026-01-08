<?php

if (!function_exists('mask_email')) {
    /**
     * Mask email address for privacy
     * Example: john.doe@example.com -> j***e@e*****e.com
     *
     * @param string $email
     * @return string
     */
    function mask_email($email)
    {
        if (empty($email)) {
            return '';
        }

        $parts = explode('@', $email);
        
        if (count($parts) !== 2) {
            return $email;
        }

        $name = $parts[0];
        $domain = $parts[1];

        // Mask name part (keep first and last character)
        if (strlen($name) > 2) {
            $maskedName = $name[0] . str_repeat('*', min(strlen($name) - 2, 3)) . substr($name, -1);
        } else {
            $maskedName = $name[0] . '*';
        }

        // List of domains to exclude from masking
        $excludedDomains = ['gmail.com', 'googlemail.com', 'example.com'];
        
        // Check if domain should be excluded from masking
        if (in_array(strtolower($domain), $excludedDomains)) {
            return $maskedName . '@' . $domain;
        }

        // Mask domain part
        $domainParts = explode('.', $domain);
        $maskedDomainParts = [];
        
        foreach ($domainParts as $part) {
            if (strlen($part) > 2) {
                $maskedDomainParts[] = $part[0] . str_repeat('*', min(strlen($part) - 2, 3)) . substr($part, -1);
            } else {
                $maskedDomainParts[] = $part;
            }
        }
        
        $maskedDomain = implode('.', $maskedDomainParts);

        return $maskedName . '@' . $maskedDomain;
    }
}
