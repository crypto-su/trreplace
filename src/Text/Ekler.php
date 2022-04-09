<?php
namespace App\Text;
class Ekler
{

    private $son_sesli, $son_harf, $isim, $sesli,
        $kalin_sesli = ['a', 'o', 'ı', 'u'],
        $ince_sesli = ['e', 'i', 'ü', 'ö'];

    public function __construct($isim = null, $tirnak = true)
    {
        mb_internal_encoding("UTF-8");
        $this->sesli = array_merge($this->kalin_sesli, $this->ince_sesli);

        if (!is_null($isim)) {
            $this->isim($isim, $tirnak);
        }

    }

    public function all($text){
        $all['birlikte'] = $this->isim($text)->birlikte();
        $all['aitlik'] = $this->isim($text)->aitlik($text);
        $all['yonelme'] = $this->isim($text)->yonelme($text);
        $all['belirtme'] = $this->isim($text)->belirtme($text);
        $all['bulunma'] = $this->isim($text)->bulunma($text);
        $all['ayrilma'] = $this->isim($text)->ayrilma($text);

        return $all;
    }

    public function isim($isim, $tirnak = true)
    {
        $tirnak = $tirnak ? "'" : '';

        $this->isim = $isim . $tirnak;
        $this->son_harf = mb_strtolower(mb_substr($isim, -1));

        preg_match_all('@[OoUuÖöAaOoEeıIiİÜü]@u', $isim, $f);
        $this->son_sesli = mb_strtolower(end($f[0]));

        return $this;
    }

    public function birlikte()
    {
        if (in_array($this->son_harf, $this->sesli)) {
            $this->y = 'y';
        }

        $harf = in_array($this->son_sesli, $this->kalin_sesli) ? 'a' : 'e';
        return $this->isim . $this->kaynastirma() . 'l' . $harf;
    }

    public function aitlik()
    {
        $harf = ['i' => 'i', 'e' => 'i', 'a' => 'ı', 'ı' => 'ı', 'ü' => 'ü', 'ö' => 'ü', 'u' => 'u', 'o' => 'u'];

        return $this->isim . $this->kaynastirma('n') . $harf[$this->son_sesli] . 'n';
    }

    public function yonelme()
    {
        $harf = in_array($this->son_sesli, $this->ince_sesli) ? 'e' : 'a';

        return $this->isim . $this->kaynastirma() . $harf;
    }

    public function belirtme()
    {
        $harf = ['i' => 'i', 'e' => 'i', 'a' => 'ı', 'ı' => 'ı', 'ü' => 'ü', 'ö' => 'ü', 'u' => 'u', 'o' => 'u'];

        return $this->isim . $this->kaynastirma() . $harf[$this->son_sesli];
    }

    public function bulunma()
    {
        $sessiz_harf = in_array($this->son_harf, ['ç', 'f', 'h', 'k', 's', 'ş', 't', 'p']) ? 't' : 'd';
        $sesli_harf = in_array($this->son_sesli, $this->ince_sesli) ? 'e' : 'a';
        return $this->isim . $sessiz_harf . $sesli_harf;
    }

    public function ayrilma()
    {
        return $this->bulunma() . 'n';
    }

    private function kaynastirma($harf = 'y')
    {
        return in_array($this->son_harf, $this->sesli) ? $harf : '';
    }

}
