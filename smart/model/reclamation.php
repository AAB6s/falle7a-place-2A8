<?php
class Reclamation
{
    public string $text_rec ;
    
    public function __construct($text_rec)
    {
        $this->text_rec = $text_rec;
    }
    public function getText_rec() 
    {
        return $this->text_rec;
    }
    public function setText_rec($text_rec)
    {
        $this->text_rec = $text_rec;

        return $this;
    }
}
?>