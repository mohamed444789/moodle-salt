<?php 
class block_googlesucheadvanced extends block_base {
    
    function init() {
        $this->title = get_string('pluginname', 'block_googlesucheadvanced');
    }

    function has_config() {
        return true;
    }

    public function get_content() {
        if ($this->content !== null) {
            return $this->content;
        }

        $this->content = new stdClass;
        
        $mform = new \block_googlesucheadvanced\form\googleform();

        if ($mform->is_cancelled()) {
            $this->content->text = get_string('formcancelled', 'block_googlesucheadvanced');
        } elseif ($fromform = $mform->get_data()) {
            $suche = $fromform->name;
            $E_nummer= 10; 

           
            $suchID = 'Bitte hier suchID hinzufügen'; 
            $apiKey = 'Bitte hier apiKey hinzufügen'; 

            // Prepare the URL for the API request
            $url = "https://www.googleapis.com/customsearch/v1?q=" . urlencode($suche) . "&cx=" . urlencode($suchID) . "&key=" . urlencode($apiKey) . "&num=" . $E_nummer;

            
            $ergebnis = file_get_contents($url);

           
            if ($ergebnis === false) {
                $this->content->text = 'Keine Ergebnise';
            } else {
                // Decode the JSON response
                $antwort = json_decode($ergebnis);

              
                if (isset($antwort->items)) {
                    foreach ($antwort->items as $item) {
                        $this->content->text .= "<a href='" . $item->link . "'>" . $item->title . "</a><br>";
                        $this->content->text .= $item->snippet . "<br><br>";
                    }
                } else {
                    $this->content->text = "Keine Ergebnise";
                }
            }
        } else {
            $this->content->text = $mform->render();
        }

        return $this->content;
    }

   
    public function instance_allow_multiple() {
        return true;
    }
}
