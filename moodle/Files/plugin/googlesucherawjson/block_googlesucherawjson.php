<?php

class block_googlesucherawjson extends block_base {
    
    function init() {

        global $CFG;
        $this->title = get_string('plugintitle', 'block_googlesucherawjson'); 
    }

    function has_config() {
        return true;
    }

    public function get_content() {
     
        if ($this->content !== null) {
            return $this->content;
        }

        $this->content = new stdClass;
        
   
    $suchID = 'Bitte hier suchID hinzufügen'; 
    $apiKey = 'Bitte hier apiKey hinzufügen'; 
    
    $suche = 'Moodle block'; 
    $E_nummer = 10; 
    
  
    $url = "https://www.googleapis.com/customsearch/v1?q=" . urlencode($suche) . "&cx=" . urlencode($suchID) . "&key=" . urlencode($apiKey) . "&num=" . $E_nummer;
    
    
    $ergebnis = file_get_contents($url);
    
    
    if ($ergebnis === false) {
        $this->content->text .= 'Keine Ergebnise gefunden';
    } else {
        
        $this->content->text .= html_writer::div($ergebnis, 'E-json');
    }
  
        return $this->content;
    }

    public function instance_allow_multiple() {
        return true;
    }
}

