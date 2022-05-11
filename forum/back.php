<?php
    class Noticia{
        public function getNoticias(){
            $json_file = file_get_contents("noticias.json");
            $json_str = json_decode($json_file);

            foreach($json_str as $registro){
                $this->titulo = $registro->titulo;
                $this->descricao = $registro->desc;
                $this->data = $registro->data;

                $this->setNoticias();
	    }
	    
	    if(count($json_str) == 0){
	    	echo "<p style='font-size: 6vh; color: black;'>Sem notícias</p>";
	    }
        }

        public function setNoticias(){
            echo
                "<div class='holder-post'>
                    <p class='nome-post'>$this->titulo</p>
                    <p class='ds-post'>$this->descricao</p>
                    <p class='data-post'>postado em $this->data".".</p>
                </div>"
            ;
        }
    }
    
    class update{
        public function getUpdates(){
            $json_file = file_get_contents("updates.json");
            $json_str = json_decode($json_file);

            foreach($json_str as $registro){
                $this->titulo = $registro->titulo;
                $this->descricao = $registro->desc;
                $this->data = $registro->data;

                $this->setUpdates();
	    }
	    
	    if(count($json_str) == 0){
	    	echo "<p style='font-size: 6vh; color: black;'>Sem atualizações</p>";
	    }
        }

        public function setUpdates(){
            echo
                "<div class='holder-post'>
                    <p class='nome-post'>$this->titulo</p>
                    <p class='ds-post'>$this->descricao</p>
                    <p class='data-post'>postado em $this->data".".</p>
                </div>"
            ;
        }
    }