<?php

namespace App\Services;

class ColorContrast
{
    /**
     * Determines if a given hex color is dark.
     *
     * This method calculates the perceived brightness (luminance) of a color
     * and compares it against a threshold to decide if a light or dark
     * font color would provide better contrast.
     *
     * @param  string  $hexColor  The hex color code (e.g., '#RRGGBB' or 'RRGGBB').
     * @return bool Returns true if the color is dark, false if it is light.
     */
    public static function isDark(string $hexColor): bool
    {
        // Remove the '#' character if it exists
        $hex = ltrim($hexColor, '#');

        // Convert shorthand hex (e.g., 'F0C') to full form (e.g., 'FF00CC')
        if (strlen($hex) === 3) {
            $hex = $hex[0].$hex[0].$hex[1].$hex[1].$hex[2].$hex[2];
        }

        // Convert hex to RGB
        $r = hexdec(substr($hex, 0, 2));
        $g = hexdec(substr($hex, 2, 2));
        $b = hexdec(substr($hex, 4, 2));

        /**
         * Calculate the luminance of the color.
         * The formula is a standard for calculating perceived brightness.
         * A value of 149 is a good threshold for readability. Colors with
         * luminance below this are considered "dark".
         */
        $luminance = (($r * 299) + ($g * 587) + ($b * 114)) / 1000;

        return $luminance < 149;
    }
}
