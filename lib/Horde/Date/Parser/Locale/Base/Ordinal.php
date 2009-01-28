<?php
class Horde_Date_Parser_Locale_Base_Ordinal extends Horde_Date_Parser_Tag
{
    public $ordinalRegex = '/^(\d*)(st|nd|rd|th)$/';
    public $ordinalDayRegex = '/^(\d*)(st|nd|rd|th)$/';

    public function scan($tokens)
    {
        foreach ($tokens as &$token) {
            if ($t = $this->scanForOrdinals($token)) {
                $token->tag($t);
            }
            if ($t = $this->scanForDays($token)) {
                $token->tag($t);
            }
        }

        return $tokens;
    }

    public function scanForOrdinals($token)
    {
        if (preg_match($this->ordinalRegex, $token->word, $matches)) {
            return new self((int)$matches[1]);
        }
        return null;
    }

    public function scanForDays($token)
    {
        if (preg_match($this->ordinalDayRegex, $token->word, $matches)) {
            if ($matches[1] <= 31) {
                /* @TODO FIXME - hardcoded class name */
                return new Horde_Date_Parser_Locale_Base_OrdinalDay((int)$m[1]);
            }
        }
        return null;
    }

    public function __toString()
    {
        return 'ordinal';
    }

}
